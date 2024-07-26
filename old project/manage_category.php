<?php
include('header.php');
CheckUser();
$msg="";
$category="";

$label="Add";
if(isset($_GET['id']) && $_GET['id']>0){

    $label="Edit";
    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $res=mysqli_query($con,"Select * from category where id=$id");
        $row=mysqli_fetch_assoc($res);
        $category=$row['name'];
    }
}

if(isset($_POST['submit'])){
    $name=get_safe_value($_POST['name']);    
    $type="add";     
    $sub_sql="";
    if (isset($_GET['id']) && $_GET['id']>0) {
        $type="edit";
        $sub_sql=" and id!= $id";
    }
    $res=mysqli_query($con,"select * from category where name='$name' $sub_sql");
        if (mysqli_num_rows($res)>0) {
            
            $msg= "This Category:$name Is Already Exists!";
        }
        else{

            $sql="insert into category(name) values('$name')";
            if (isset($_GET['id']) && $_GET['id']>0) {
                $sql="update category set name='$name' where id=$id";
            }
            mysqli_query($con,$sql);
            redirect("category.php");
        
        }
    
    
}


    
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label?> EXPENSE HEAD</h2>
                    <a href="category.php">Back</a><br></br>
                    <div class="card">
                        <div class="card-body card-block">                           

                                <form method="post">
                                <div class="form-group">
                                    <label class="control-label mb-1">Expense Head Name</label>
                                    <input type="text" name="name" class="form-control" required value="<?php echo $category?>">
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