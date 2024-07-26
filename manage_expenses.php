<?php
include('header.php');
CheckUser();
$msg="";
$category_id="";
$branch_id="";
$item="";
$price="";
$details="";
$added_on="";
$trans_type="";
$party_id="";
$expenses_date=date('Y-m-d');

$added_by=$_SESSION['UNAME'];
$label="Add";
$expinc='Expense';
$selectedValue=$expinc;
$expinchead='EXPENSE';
$fun="";
$voucher_no =0;


if (isset($_GET['expinc']) && $_GET['expinc']=='Income') {
    $expinc='Income';
    $expinchead='INCOME';
}

if(isset($_GET['id']) && $_GET['id']>0){

    $label="Edit";
    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $res=mysqli_query($con,"Select * from expenses where id=$id");
        if (mysqli_num_rows($res)==0) {
            // redirect('expenses.php');
        }
        $row=mysqli_fetch_assoc($res);
        $category_id=$row['category_id'];
        $branch_id=$row['branch_id'];
        $trans_type=$row['trans_type'];
        $item=$row['item'];
        $price=$row['price'];
        $details=$row['details'];
        $party_id=$row['party_id'];
        $expenses_date=$row['expenses_date'];
        if ($row['added_by']!=$_SESSION['UNAME']) {
            //redirect('expenses.php');
        }
     
    }
}

// Function to get the next voucher number
function getVoucherNo($trans_type) {
    global $con;
    $get_vouch_no = null;

    // Define the financial year prefix
    $current_year = date("Y");
    $next_year = date("Y", strtotime("+1 year"));
    $financial_year_prefix = substr($current_year, 2, 2) . substr($next_year, 2, 2);

    $res2 = mysqli_query($con, "SELECT next_no FROM voucher_gen WHERE type = '$trans_type' AND next_no LIKE '$financial_year_prefix%' ORDER BY next_no LIMIT 1");
    if ($res2 && mysqli_num_rows($res2) > 0) {
        $row = mysqli_fetch_assoc($res2);
        if ($row['next_no'] > 0) {
            $get_vouch_no = $row['next_no'];
            $next_no = $get_vouch_no + 1;

            $update_res = mysqli_query($con, "UPDATE voucher_gen SET next_no = $next_no WHERE type = '$trans_type' AND next_no = $get_vouch_no");
            if (!$update_res) {
                die("Error updating voucher number: " . mysqli_error($con));
            }
        }
    } else {
        die("Error fetching voucher number: Document Series Exhausted or " . mysqli_error($con));
    }

    return $get_vouch_no;
}
if(isset($_POST['submit'])){
    $category_id=get_safe_value($_POST['category_id']);    
    $branch_id=get_safe_value($_POST['branch_id']);    
    $trans_type=get_safe_value($_POST['trans_type']);    
    $voucher_no=getVoucherNo($trans_type);
    $item=get_safe_value($_POST['item']);    
    $price=get_safe_value($_POST['price']);    
    $details=get_safe_value($_POST['details']);    
    $party_id=get_safe_value($_POST['party_id']);    
    $expenses_date=get_safe_value($_POST['expenses_date']);    
    $added_on=date('Y-m-d h:i:s');
    
   
    $type="add";     
    $sub_sql="";
    if (isset($_GET['id']) && $_GET['id']>0) {
        $type="edit";
        $sub_sql=" and id!= $id";
    }
   
            $sql="INSERT INTO expenses (id,category_id, item, price, 
            details,party_id,trans_type,branch_id, added_on, expenses_date, added_by) values('$voucher_no','$category_id','$item','$price','$details','$party_id'
            ,'$trans_type','$branch_id','$added_on','$expenses_date','$added_by')";
            if (isset($_GET['id']) && $_GET['id']>0) {
                $sql="update expenses set category_id='$category_id',item='$item',price='$price',details='$details',party_id='$party_id',
                ,branch_id='$branch_id',expenses_date='$expenses_date' where id=$id";
            }
            mysqli_query($con,$sql);
            redirect("expenses.php");
        
    
    
}

function getBranch($branch_id=''){
    global $con;
    $html="";
    $res1= mysqli_query($con,"Select * from branch order by branch asc");    
    
    $html.='<option value="">Select Branch</option>';
        while ($row=mysqli_fetch_assoc($res1)) {
            if ($branch_id>0 && $branch_id== $row['branch_id']) {
                
                $html.='<option value="'.$row['branch_id'].'" Selected>'.$row['branch'].'</option>';
            }
            
            $html.='<option value="'.$row['branch_id'].'">'.$row['branch'].'</option>';
        }

   
        return $html;

}


// function VoucherNoInc($trans_type){
//     global $con;
    
// }

function getParty($party_id=''){
    global $con;
    $html="";
    $res1= mysqli_query($con,"Select * from party order by party_name asc");    
    
    $html.='<option value="">Select Party</option>';
        while ($row=mysqli_fetch_assoc($res1)) {
            if ($party_id>0 && $party_id== $row['party_id']) {
                
                $html.='<option value="'.$row['party_id'].'" Selected>'.$row['party_name'].'</option>';
            }
            
            $html.='<option value="'.$row['party_id'].'">'.$row['party_name'].'</option>';
        }

   
        return $html;

}


?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label?> <?php echo $expinchead?></h2>
                    <a href="expenses.php">Back</a><br /><br />
                    <div class="card">
                        <div class="card-body card-block">
                            <form method="post">

                                <div class="row form-group">
                                    <div class="col col-md-4">                                        
                                    </div>
                                    <div class="col col-md-1">
                                        <label for="transtype" class="form-control-label"><b>Type</b></label>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <select name="trans_type" id="trans_type" class="form-control">
                                            <option value="0">Select Income/Expense</option>
                                            <option value="Income" <?php echo ($expinc == 'Income') ? 'selected' : ''; ?>>Income</option>
                                            <option value="Expense" <?php echo ($expinc == 'Expense') ? 'selected' : ''; ?>>Expense</option>
                                        </select>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="branch_id" class="control-label mb-1">Branch</label>
                                    <select name="branch_id" id="branch_id" class="form-control">
                                        <?php echo getBranch($branch_id) ?>        
                                        </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="party_id" class="control-label mb-1">Party</label>
                                    <select name="party_id" id="party_id" class="form-control">
                                        <?php echo getParty($party_id) ?>        
                                        </select>
                                </div>
                                

                                <div class="form-group">
                                    <label class="control-label mb-1"><?php echo $expinc?> Head</label>
                                    <?php echo getCategory($category_id) ?>
                                </div>
                                
                                <!-- <div class="form-group">
                                    <label class="control-label mb-1">Item</label>
                                    <input type="text" name="item" class="form-control" required value="<?php echo $item?>">
                                </div>
                                 -->
                              
                                <div class="form-group">
                                    <label class="control-label mb-1">Amount</label>
                                    <input type="text" name="price" class="form-control" required value="<?php echo $price?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label mb-1">Details</label>
                                    <input type="text" name="details" class="form-control" required value="<?php echo $details?>">
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="control-label mb-1"><?php echo $expinc?> Date</label>
                                    <input type="date" name="expenses_date" class="form-control" required
                                            value="<?php echo $expenses_date?>">
                                </div>
                                
                                <div class="form-group">                                    
                                    <input type="submit" name="submit" class="btn btn-lg btn-info btn-block" value="submit">
                                </div>
                                                               
                                
                            </form>

                            <div id="msg"  class="message"><?php echo $msg?>
                            </div>
                 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#branch_id').select2();
    });
</script>
<script>
    $(document).ready(function() {
        $('#party_id').select2();
    });
</script>
<?php
include('footer.php');


?>