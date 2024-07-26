<?php
include('header.php');
CheckUser();
$msg="";
$pay_modeid="";
$pay_mode="";
//$address="";
$type="";

$label="Add";
$readon='required';
if(isset($_GET['id']) && $_GET['id']>0){

    $label="Edit";
    $readon='readonly';
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $res=mysqli_query($con,"Select * from payment where pay_mode_id='$id'");
        $row=mysqli_fetch_assoc($res);
        $pay_modeid=$row['pay_mode_id'];
        $pay_mode=$row['pay_mode'];
        
    }
}

if(isset($_POST['submit'])){
    $paymodeid=get_safe_value($_POST['pay_mode_id']);    
    $paymode=get_safe_value($_POST['pay_mode']);        
    $type="add";     
    $sub_sql="";
    if (isset($_GET['id']) && $_GET['id']>0) {
        $type="edit";
        $sub_sql=" and pay_mode_id!= '$id'";
    }
    $res=mysqli_query($con,"select * from payment where pay_mode='$paymode' $sub_sql");
        if (mysqli_num_rows($res)>0) {
            
            $msg= "This Payment Mode:$prname Is Already Exists!";
        }
        else{

            $sql="insert into payment(pay_mode_id,pay_mode) values('$paymodeid','$paymode')";
            if (isset($_GET['id']) && $_GET['id']>0) {
                $sql="update payment set pay_mode='$paymode' where pay_mode_id=$id";
            }
            mysqli_query($con,$sql);
            redirect("pay_mode.php");
        
        }
    
    
}


    
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label?> PAYMENT MODE</h2>
                    <a href="pay_mode.php">Back</a><br></br>
                    <div class="card">
                        <div class="card-body card-block">                           

                                <form method="post">
                                <div class="form-group">
                                    <label class="control-label mb-1">Payment Mode Id</label>
                                    <input type="text" name="pay_mode_id" class="form-control" value="<?php echo $pay_modeid?>" <?php echo $readon?> >
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Payment Mode Name</label>
                                    <input type="text" name="pay_mode" class="form-control" required value="<?php echo $pay_mode?>">
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