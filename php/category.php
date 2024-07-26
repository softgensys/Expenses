<?php
include('header.php');
CheckUser();

if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0){
    
     $id=get_safe_value($_GET['id']);
    $res1= mysqli_query($con,"Select * from category where id=$id");
    if ($row1=mysqli_fetch_assoc($res1)>0) {
        
        mysqli_query($con,"delete from category where id=$id");
        echo "Data Deleted For Category Id:$id!";
    }
    else{
        echo "No Such Data Found For Id:$id!";
    }
    
}
include('user_header.php');

$res= mysqli_query($con,"Select * from category order by id desc");
    
?>
<h2>CATEGORY</h2><br></br>
<a href="manage_category.php">Add Category</a><br></br>
<?php 
if (mysqli_num_rows($res)>0) {

?>
<table border="1">
    <tr>        
        <td>CATEGORY ID</td>
        <td>CATEGORY NAME</td>
    </tr>
    
    <?php
    
    while($row=mysqli_fetch_assoc($res)){
    ?>
    <tr>        
        <td><?php echo $row['id'];?></td>
        <td><?php echo $row['name'];?></td>
        <td>
            <a href="manage_category.php?id=<?php echo $row['id'];?>">Edit</a>
            <a href="?type=delete&id=<?php echo $row['id'];?>">Delete</a>
            
        </td>
    </tr>
    <?php } ?>
</table>


<?php 
    }
    else{
        echo "No Data Found";
    }
?>
<?php
include('footer.php');


?>