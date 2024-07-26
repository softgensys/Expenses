<?php
include('header.php');
CheckUser();

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

$res= mysqli_query($con,"Select exp.*,cat.name from expenses exp,category cat where exp.category_id=cat.id and exp.added_by='".$_SESSION['UNAME']."'
  order by exp.expenses_date desc");
    
?>
<?php 
if (mysqli_num_rows($res)>0) {

?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                    <h2>EXPENSES</h2>
                    <a href="manage_expenses.php">Add Expenses</a><br></br>
                    <div class="table-responsive table--no-card m-b-30">

                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                            <tr>
                                <th>Exp ID</th>
                                <th>Exp. Head</th>
                                <!-- <th>Item</th> -->
                                <th>Amount</th>
                                <th>Details</th>
                                <th>Expenses Date</th>
                                <th>Added On</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
    while($row=mysqli_fetch_assoc($res)){
    ?>
                            <tr>
                                <td><?php echo $row['id'];?></td>
                                <td><?php echo $row['name'];?></td>
                                <!-- <td><?php echo $row['item'];?></td> -->
                                <td><?php echo $row['price'];?></td>
                                <td><?php echo $row['details'];?></td>
                                <td><?php echo $row['expenses_date'];?></td>
                                <td><?php echo $row['added_on'];?></td>
                                <td><?php echo $row['added_by'];?></td>
                                <td>
                                    <a href="manage_expenses.php?id=<?php echo $row['id'];?>">Edit</a>
                                    <a href="?type=delete&id=<?php echo $row['id'];?>">Delete</a>

                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                        <?php 
    }
    else{
        echo "No Data Found";
    }
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');


?>