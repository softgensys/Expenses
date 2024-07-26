<?php
include('header.php');
CheckUser();
$msg="";
$category_id="";
$item="";
$price="";
$details="";
$added_on="";
$expenses_date=date('Y-m-d');

$added_by=$_SESSION['UNAME'];
$label="Add";
if(isset($_GET['id']) && $_GET['id']>0){

    $label="Edit";
    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $res=mysqli_query($con,"Select * from expenses where id=$id");
        if (mysqli_num_rows($res)==0) {
            redirect('expenses.php');
        }
        $row=mysqli_fetch_assoc($res);
        $category_id=$row['category_id'];
        $item=$row['item'];
        $price=$row['price'];
        $details=$row['details'];
        $expenses_date=$row['expenses_date'];
        if ($row['added_by']!=$_SESSION['UNAME']) {
            redirect('expenses.php');
        }
     
    }
}

if(isset($_POST['submit'])){
    $category_id=get_safe_value($_POST['category_id']);    
    $item=get_safe_value($_POST['item']);    
    $price=get_safe_value($_POST['price']);    
    $details=get_safe_value($_POST['details']);    
    $expenses_date=get_safe_value($_POST['expenses_date']);    
    $added_on=date('Y-m-d h:i:s');
    
   
    $type="add";     
    $sub_sql="";
    if (isset($_GET['id']) && $_GET['id']>0) {
        $type="edit";
        $sub_sql=" and id!= $id";
    }
   
            $sql="INSERT INTO expenses (category_id, item, price, 
            details, added_on, expenses_date, added_by) values('$category_id','$item','$price','$details'
            ,'$added_on','$expenses_date','$added_by')";
            if (isset($_GET['id']) && $_GET['id']>0) {
                $sql="update expenses set category_id='$category_id',item='$item',price='$price',details='$details',
                expenses_date='$expenses_date' where id=$id";
            }
            mysqli_query($con,$sql);
            redirect("expenses.php");
        
    
    
}

?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label?> EXPENSES</h2>
                    <a href="expenses.php">Back</a><br /><br />
                    <div class="card">
                        <div class="card-body card-block">
                            <form method="post">

                                <div class="form-group">
                                    <label class="control-label mb-1">Expense Head</label>
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
                                    <label class="control-label mb-1">Expense Date</label>
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

<?php
include('footer.php');


?>