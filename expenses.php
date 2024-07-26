<?php
include('header.php');
CheckUser();
$trans_type = "";
//$NetBalance=0;


if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0){
    
     $id=get_safe_value($_GET['id']);
    $res1= mysqli_query($con,"Select * from expenses where id=$id");
    if ($row1=mysqli_fetch_assoc($res1)>0) {
        
        mysqli_query($con,"delete from expenses where id=$id");
        echo "Data Deleted For expenses Id:$id!";
    }
    else{
        echo "No Such Data Found For Id:$id!";
    }
    
}

function getNetBalance(){
    global $con;
    $query="";
    
    $NetBalance = 0; // Initialize the variable to avoid undefined variable issues
    if(!isset($_POST['trans_type'])){
    $query = "SELECT 
                 (SELECT SUM(CASE WHEN trans_type = 'Income' THEN price ELSE 0 END) 
                  - SUM(CASE WHEN trans_type = 'Expense' THEN price ELSE 0 END)
                  FROM expenses exp 
                  JOIN category cat ON exp.category_id = cat.id
                  JOIN branch br ON exp.branch_id = br.branch_id 
                  WHERE exp.added_by = '".$_SESSION['UNAME']."') AS NetBalance";
    }
    elseif(isset($_POST['trans_type']) && $_POST['trans_type']==0){
        $query = "SELECT 
                     (SELECT SUM(CASE WHEN trans_type = 'Income' THEN price ELSE 0 END) 
                      - SUM(CASE WHEN trans_type = 'Expense' THEN price ELSE 0 END)
                      FROM expenses exp 
                      JOIN category cat ON exp.category_id = cat.id
                      JOIN branch br ON exp.branch_id = br.branch_id 
                      WHERE exp.added_by = '".$_SESSION['UNAME']."') AS NetBalance";
        }
    elseif (isset($_POST['trans_type']) && $_POST['trans_type'] == 'Income'){    
        $query = "SELECT 
                     (SELECT SUM(CASE WHEN trans_type = 'Income' THEN price ELSE 0 END)                       
                      FROM expenses exp 
                      JOIN category cat ON exp.category_id = cat.id
                      JOIN branch br ON exp.branch_id = br.branch_id 
                      WHERE exp.added_by = '".$_SESSION['UNAME']."') AS NetBalance";
        }
    
    elseif (isset($_POST['trans_type']) && $_POST['trans_type'] == 'Expense'){    
        $query = "SELECT 
                     (SELECT SUM(CASE WHEN trans_type = 'Expense' THEN price ELSE 0 END)                       
                      FROM expenses exp 
                      JOIN category cat ON exp.category_id = cat.id
                      JOIN branch br ON exp.branch_id = br.branch_id 
                      WHERE exp.added_by = '".$_SESSION['UNAME']."') AS NetBalance";
        }
    
    $res1 = mysqli_query($con, $query);
    
    if ($res1 && mysqli_num_rows($res1) > 0) {
        $row = mysqli_fetch_assoc($res1);
        $NetBalance = $row['NetBalance'];
    }
    
    return $NetBalance;
}

?>


  <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 id="netBalance">INCOME/EXPENSES</h2><br/><br/>
                        <div class="row form-group">
                                    <div class="col col-md-4">                                        
                                    </div>
                                    
                                    <form id="trans_type_form" method="post" action="">
                                    <div class="col col-md-3">
                                        <label for="trans_type" class="form-control-label"><b>Type</b></label>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <select name="trans_type" id="trans_type" class="form-control">
                                            <option value="0">Select Income/Expense</option>
                                            <option value="Income" <?php if (isset($_POST['trans_type']) && $_POST['trans_type'] == 'Income') echo 'selected'; ?>>Income</option>
                                            <option value="Expense" <?php if (isset($_POST['trans_type']) && $_POST['trans_type'] == 'Expense') echo 'selected'; ?>>Expense</option>
                                        </select>
                                    </div>
                                </form>
                                </div>
                                <br/>
                        <?php $i=1; ?>
                        <label><b>Add</b> </label> <a href="manage_expenses.php?expinc=Income" class="btn btn-success">Income</a>  <b>/</b> <a href="manage_expenses.php?expinc=Expense" class="btn btn-danger">Expense</a> <br></br>
                        <div class="table-responsive table--no-card m-b-30">
                            <table id="myTable" class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Inc/Exp ID</th>
                                        <th>Branch</th>
                                        <th>Type</th>
                                        <th>Party</th>
                                        <th>Inc./Exp. Head</th>
                                        <th>Amount</th>
                                        <th>Details</th>
                                        <th>Action</th>
                                        <th>Inc/Exp Date</th>
                                        <th>Added On</th>
                                        <th>Added By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                // Get the selected trans_type value
                $trans_type = isset($_POST['trans_type']) ? $_POST['trans_type'] : '';

                // Build the query with the selected trans_type filter
                $query = "SELECT exp.*, cat.name,br.branch 
                          FROM expenses exp, category cat, branch br  
                          WHERE exp.category_id = cat.id 
                          AND exp.added_by = '".$_SESSION['UNAME']."'";

                if ($trans_type && $trans_type != '0') {
                    $query .= " AND trans_type = '$trans_type'";
                }

                $query .= " ORDER BY exp.expenses_date DESC";

                $res = mysqli_query($con, $query);
                $i = 1;
                if ($res && mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['branch']; ?></td>
                            <td style="color: <?php echo ($row['trans_type'] == 'Income') ? 'green' : (($row['trans_type'] == 'Expense') ? 'red' : 'black'); ?>;">
                                <b><?php echo $row['trans_type']; ?></b>
                            </td>
                            <td><?php echo $row['party_id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td class="details"><?php echo $row['details']; ?></td>
                            <td>
                                <a href="manage_expenses.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="?type=delete&id=<?php echo $row['id']; ?>">Delete</a>
                            </td>
                            <td><?php echo $row['expenses_date']; ?></td>
                            <td><?php echo $row['added_on']; ?></td>
                            <td><?php echo $row['added_by']; ?></td>
                        </tr>
                        <?php 
                        $i++;
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="
                                border-left: 3px solid black;
                                border-bottom: 3px solid black;
                                border-right: 3px solid black;
                            "><b>TOTAL:</b></td>
                            <td style="color: <?php                             
                            $netBalance = getNetBalance();
                            if ($netBalance > 0 && $trans_type == 'Income') {
                                echo 'green';
                            }elseif ($netBalance > 0 && $trans_type =='') {
                                echo 'green';
                            }elseif ($netBalance < 0 && $trans_type == '') {
                                echo 'red';
                            } elseif ($netBalance > 0 && $trans_type == 'Expense') {
                                echo 'red';  // Example color for this specific condition
                            } else {
                                echo 'black';
                            }
                        ?>">
                            <b><?php echo getNetBalance(); ?></b>
                            </td>
                            <td></td>
                            <td></td><td></td><td></td><td></td>
                    </tr>
                    <?php
                } else {
                    ?>
                    <tr>
                        <td colspan="12">No Data Found</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        
        $('#trans_type').change(function() {
            $('#trans_type_form').submit();
        });
    });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('expenses.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('netBalance').innerText = data.NetBalance;
                })
                .catch(error => console.error('Error fetching balance:', error));
        });
    </script>
<?php
include('footer.php');


?>