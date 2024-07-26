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
include('user_header.php');

$res= mysqli_query($con,"Select exp.*,cat.name from expenses exp,category cat where exp.category_id=cat.id and exp.added_by='".$_SESSION['UNAME']."'
  order by exp.expenses_date desc");
    
?>
<h2>EXPENSES</h2><br></br>
<a href="manage_expenses.php">Add Expenses</a><br></br>
<?php 
if (mysqli_num_rows($res)>0) {

?>
<table border="1">
    <tr>        
        <td>Exp ID</td>
        <td>Category</td>
        <td>Item</td>
        <td>Amount</td>
        <td>Details</td>
        <td>Expenses Date</td>
        <td>Added On</td>
        <td>Added By</td>
    </tr>
    
    <?php
    
    while($row=mysqli_fetch_assoc($res)){
    ?>
    <tr>        
        <td><?php echo $row['id'];?></td>
        <td><?php echo $row['name'];?></td>
        <td><?php echo $row['item'];?></td>
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