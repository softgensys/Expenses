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
include('user_header.php');

    
?>
<h2><?php echo $label?> EXPENSES</h2><br></br>
<a href="expenses.php">Back</a><br></br>

<form method="post">
    <table>
        <tr>
            <td>Category</td>
            <td><?php echo getCategory($category_id) ?></td>
        </tr>
       
        <tr>
            <td>Item</td>
            <td><input type="text" name="item" required value="<?php echo $item?>"></td>
        </tr>
       
        <tr>
            <td>Amount</td>
            <td><input type="text" name="price" required value="<?php echo $price?>"></td>
        </tr>
       
        <tr>
            <td>Details</td>
            <td><input type="text" name="details" required value="<?php echo $details?>"></td>
        </tr>
       
        <tr>
            <td>Exp. Date</td>
            <td><input type="date" name="expenses_date" required value="<?php echo $expenses_date?>"></td>
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