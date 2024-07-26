<?php
include('header.php');
CheckUser();


$cat_id='';
$sub_sql="";
$from="";
$to="";
$trans_type="";


if (isset($_GET['trans_type']) && $_GET['trans_type']>0) {
    $trans_type= get_safe_value($_GET['trans_type']);
    $sub_sql=" and exp.trans_type='$trans_type'";
}

if (isset($_GET['trans_type']) && $_GET['trans_type']>0 && isset($_GET['category_id']) && $_GET['category_id']>0) {    
    $trans_type= get_safe_value($_GET['trans_type']);
    $cat_id= get_safe_value($_GET['category_id']);
    $sub_sql=" and exp.trans_type=$trans_type and cat.id=$cat_id";
}

if (isset($_GET['trans_type']) && $_GET['trans_type']>0 && isset($_GET['category_id']) && $_GET['category_id']>0
    && $from!='' && $to!='')
 {    
    $trans_type= get_safe_value($_GET['trans_type']);
    $cat_id= get_safe_value($_GET['category_id']);
    $sub_sql=" and exp.trans_type=$trans_type and cat.id=$cat_id and exp.expenses_date between '$from' and '$to'";
}


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


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2>REPORTS</h2><br></br>
                    <div class="card">
                        <div class="card-body card-block">                           

                            <form method="get">
                            
                            <div class="form-group row">
                            <div class="col-md-10">
                                
                                </div>
                                <div class="col-md-2">
                                <a href="reports.php" class="btn btn-danger">Reset</a>
                                </div>
                            </div>

                            <div class="row form-group">
                                    <div class="col col-md-5">                                        
                                    </div>
                                                                        
                                    <div class="col col-md-6">
                                        <label for="trans_type" class="form-control-label"><b>Type</b></label>
                                    </div>
                                    <div class="col col-md-2">                                        
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select name="trans_type" id="trans_type" class="form-control">
                                            <option value="0">Select Income/Expense</option>
                                            <option value="Income" <?php if (isset($_GET['trans_type']) && $_GET['trans_type'] == 'Income') echo 'selected'; ?>>Income</option>
                                            <option value="Expense" <?php if (isset($_GET['trans_type']) && $_GET['trans_type'] == 'Expense') echo 'selected'; ?>>Expense</option>
                                        </select>
                                    </div>                                
                            </div>

                            <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="control-label mb-1">From</label>
                                        <input type="date" name="from" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label mb-1">To</label>
                                        <input type="date" name="to" class="form-control">
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Expense Head</label>
                                <?php echo getCategory($cat_id) ?>
                            </div>
                            <div class="form-group row">  
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <input type="submit" name="submit" class="btn btn-lg btn-info btn-block" value="Submit">
                                    </div>
                                </div>
                                
                            </div>
                            </div>                                                                
                            </form>

</br></br>
<div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
    <tr>        
        
        <th>Expense Head</th>        
        <th>Amount</th>
        
    </tr>
    </thead>
    <tbody>
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
        </tbody>
</table>
        </div>
        </div>
        </div>
        </div>
        </div>



<?php
include('footer.php');
?>
?>