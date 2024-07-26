<?php
include('header.php');
CheckUser();


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

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                <h2>DASHBOARD REPORTS</h2>
                <div class="card">
                <div class="card-body card-block">    
                <form method="get">
                <div class="form-group row">
            <label class="col-form-label col-auto mb-1">From:</label>
            <div class="col-auto">
                <input type="text" name="from" class="form-control-plaintext" required readonly value="<?php echo $from ?>">
            </div>
            <label class="col-form-label col-auto mb-1">To:</label>
            <div class="col-auto">
                <input type="text" name="to" class="form-control-plaintext" required readonly value="<?php echo $to ?>">
            </div>
        </div>
                </form>
</div>
</div>            
            <div class="table-responsive table--no-card m-b-30">
                    <table class="table table-borderless table-striped table-earning">
                            <thead>

    <tr>        
        <th>Sr. No.</th>        
        <th>Expense Head</th>        
        <!-- <th>Item</th>         -->
        <th>Detail</th>        
        <th>Amount</th>
        <th>Exp. Date</th>        
        
    </tr>
    </thead>
    <tbody>
    <?php
        $final_price=0;
        $i=1;
        while ($row=mysqli_fetch_assoc($res)) {
            
        $final_price= $final_price+$row['price'];
            ?>
    <tr>
        <td><?php echo $i++?></td>
        <td><?php echo $row['name']?></td>
        <!-- <td><?php echo $row['item']?></td> -->
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
    </tbody>
</table>


<?php
include('footer.php');
?>