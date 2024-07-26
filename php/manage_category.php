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
include('user_header.php');

    
?>
<h2><?php echo $label?> CATEGORY</h2><br></br>
<a href="category.php">Back</a><br></br>

<form method="post">
    <table>
        <tr>
            <td>Category Name</td>
            <td><input type="text" name="name" required value="<?php echo $category?>"></td>
        </tr>
       
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="submit"></td>
        </tr>
    </table>
</form>

<?php
echo $msg; ?>
<?php
include('footer.php');


?>