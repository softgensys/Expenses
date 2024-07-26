<?php
include('header.php');
CheckUser();


include('user_header.php');

$sub_sql="";
$from="";
$to="";

if (isset($_GET['from'])) {
    $from=get_safe_value($_GET['from']);

}
if (isset($_GET['to'])) {
    $to=get_safe_value($_GET['to']);
}
if ($from!='' && $to!='') {
    $sub_sql.=" and exp.expenses_date between '$from' and '$to'";
}


$res= mysqli_query($con,"Select exp.price,cat.name,exp.item,exp.expenses_date,exp.details
 from expenses exp,category cat where exp.category_id=cat.id $sub_sql");
  
?>
<h2>DASHBOARD REPORTS</h2><br></br>

<form method="get">
    From: <?php echo $from ?>
    TO: <?php echo $to ?>
</form>

</br></br>
<table border="1">
    <tr>        
        <th>Sr. No.</th>        
        <th>Category</th>        
        <th>Item</th>        
        <th>Detail</th>        
        <th>Amount</th>
        <th>Exp. Date</th>        
        
    </tr>
    <?php
        $final_price=0;
        $i=1;
        while ($row=mysqli_fetch_assoc($res)) {
            
        $final_price= $final_price+$row['price'];
            ?>
    <tr>
        <td><?php echo $i++?></td>
        <td><?php echo $row['name']?></td>
        <td><?php echo $row['item']?></td>
        <td><?php echo $row['details']?></td>
        <td><?php echo $row['price']?></td>
        <td><?php echo $row['expenses_date']?></td>
    </tr>   

    <?php } ?>
    <tr>
        <th></th>
        <th></th>
        

        <th>Total</th>
        <th><?php echo $final_price?></th>
    </tr>   

</table>


<?php
include('footer.php');
?>