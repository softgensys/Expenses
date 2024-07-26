<?php
include('header.php');
CheckUser();


include('user_header.php');
$cat_id='';
$sub_sql="";
$from="";
$to="";

if (isset($_GET['category_id']) && $_GET['category_id']>0) {
    $cat_id= get_safe_value($_GET['category_id']);
    $sub_sql=" and cat.id=$cat_id";
}
if (isset($_GET['from'])) {
    $from=get_safe_value($_GET['from']);

}
if (isset($_GET['to'])) {
    $to=get_safe_value($_GET['to']);
}

if ($from!='' && $to!='') {
    $sub_sql.=" and exp.expenses_date between '$from' and '$to'";
}


$res= mysqli_query($con,"Select sum(exp.price) as price,cat.name from expenses exp,category cat where exp.category_id=cat.id
$sub_sql group by cat.name");
  
?>
<h2>REPORTS</h2><br></br>

<form method="get">
    From&nbsp;<input type="date" name="from">
    &nbsp;&nbsp;&nbsp;&nbsp;
    To&nbsp;<input type="date" name="to">
    <?php echo getCategory($cat_id,'reports')?>
    <input type="submit" name="submit" value="Submit">
    <a href="reports.php">Reset</a>
</form>

</br></br>
<table border="1">
    <tr>        
        
        <th>Category</th>        
        <th>Amount</th>
        
    </tr>
    <?php
        $final_price=0;
        while ($row=mysqli_fetch_assoc($res)) {
        $final_price= $final_price+$row['price'];
            ?>
    <tr>
        <td><?php echo $row['name']?></td>
        <td><?php echo $row['price']?></td>
    </tr>   

    <?php } ?>
    <tr>
        <th>Total</th>
        <th><?php echo $final_price?></th>
    </tr>   

</table>


<?php
include('footer.php');
?>