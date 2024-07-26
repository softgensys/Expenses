<?php
include('header.php');
CheckUser();
$msg="";
$branch="";
$address="";

$label="Add";
if(isset($_GET['id']) && $_GET['id']>0){

    $label="Edit";
    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $res=mysqli_query($con,"Select * from branch where branch_id=$id");
        $row=mysqli_fetch_assoc($res);
        $branch=$row['branch'];
        $address=$row['address1'];
    }
}

if(isset($_POST['submit'])){
    $brname=get_safe_value($_POST['branch']);    
    $bradd=get_safe_value($_POST['address1']);    
    $type="add";     
    $sub_sql="";
    if (isset($_GET['id']) && $_GET['id']>0) {
        $type="edit";
        $sub_sql=" and branch_id!= $id";
    }
    $res=mysqli_query($con,"select * from branch where branch='$brname' $sub_sql");
        if (mysqli_num_rows($res)>0) {
            
            $msg= "This Branch:$brname Is Already Exists!";
        }
        else{

            $sql="insert into branch(branch,address1) values('$brname','$bradd')";
            if (isset($_GET['id']) && $_GET['id']>0) {
                $sql="update branch set branch='$brname',address1='$bradd' where branch_id=$id";
            }
            mysqli_query($con,$sql);
            redirect("branch.php");
        
        }
    
    
}


    
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label?> BRANCH</h2>
                    <a href="branch.php">Back</a><br></br>
                    <div class="card">
                        <div class="card-body card-block">                           

                                <form method="post">
                                <div class="form-group">
                                    <label class="control-label mb-1">Branch</label>
                                    <input type="text" name="branch" class="form-control" required value="<?php echo $branch?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Address</label>
                                    <input type="text" name="address1" class="form-control" required value="<?php echo $address?>">
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