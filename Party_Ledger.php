<?php
include('header.php');
CheckUser();

$cat_id = '';
$sub_sql = "";
$from = "";
$to = "";
$trans_type = "";
$party_id = "";
$res = null;

if (isset($_GET['from'])) {
    $from = get_safe_value($_GET['from']);
}
if (isset($_GET['to'])) {
    $to = get_safe_value($_GET['to']);
}

if (isset($_GET['party_id']) && $_GET['party_id'] != '' && $from != '' && $to != '') {
    $party_id = get_safe_value($_GET['party_id']);
}

function getParty($party_id = ''){
    global $con;
    $html = "";
    $res1 = mysqli_query($con, "SELECT * FROM party ORDER BY party_name ASC");    

    $html .= '<option value="">Select Party</option>';
    while ($row = mysqli_fetch_assoc($res1)) {
        if ($party_id != '' && $party_id == $row['party_id']) {
            $html .= '<option value="'.$row['party_id'].'" Selected>'.$row['party_name'].'</option>';
        } else {
            $html .= '<option value="'.$row['party_id'].'">'.$row['party_name'].'</option>';
        }
    }
    return $html;
}

if ($party_id != '' && $from != '' && $to != '') {
    // Calculate net balance before the 'from' date
    $net_balance_query = "
        SELECT 
            p.op_bal + IFNULL(SUM(CASE WHEN e.trans_type = 'Income' THEN e.price ELSE 0 END), 0) -
            IFNULL(SUM(CASE WHEN e.trans_type = 'Expense' THEN e.price ELSE 0 END), 0) AS net_balance
        FROM 
            party p 
        LEFT JOIN 
            expenses e ON p.party_id = e.party_id AND e.expenses_date < '".$from."'
        WHERE 
            p.party_id = '".$party_id."'
    ";
    $net_balance_result = mysqli_query($con, $net_balance_query);
    $net_balance_row = mysqli_fetch_assoc($net_balance_result);
    $net_balance = $net_balance_row['net_balance'];

    // Main query to fetch transactions
    $transactions_query = "
        SELECT 
            e.id, 
            e.expenses_date, 
            e.details, 
            CASE WHEN e.trans_type = 'Income' THEN e.price ELSE 0 END AS Income, 
            CASE WHEN e.trans_type = 'Expense' THEN e.price ELSE 0 END AS Expense, 
            e.op_bal 
        FROM 
            (SELECT 
                '' AS id, 
                '' AS expenses_date, 
                'Opening balance as on ".$from."' AS details,
                0 AS price, 
                NULL AS trans_type, 
                ".$net_balance." AS op_bal, 
                p.party_id 
            FROM 
                party p 
            WHERE 
                p.party_id = '".$party_id."'
            UNION ALL 
            SELECT 
                e.id, 
                e.expenses_date, 
                e.details, 
                e.price, 
                e.trans_type, 
                NULL AS op_bal,
                e.party_id 
            FROM 
                expenses e 
            WHERE 
                e.party_id = '".$party_id."'
                AND e.expenses_date BETWEEN '".$from."' AND '".$to."'
            ) e 
        LEFT JOIN 
            party p ON p.party_id = e.party_id 
        ORDER BY 
            e.expenses_date, e.id
    ";

    $res = mysqli_query($con, $transactions_query);
}
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2>PARTY LEDGER</h2><br></br>
                    <div class="card">
                        <div class="card-body card-block">                           

                            <form method="get">
                            
                            <div class="form-group row">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <a href="reports.php" class="btn btn-danger">Reset</a>
                                </div>
                            </div>

                            <div class="row form-group justify-content-center">
                                    <div class="col-md-2 text-right">
                                        <label for="party_id" class="control-label mb-1"><b>Party</b></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">                                    
                                            <select name="party_id" id="party_id" class="form-control">
                                                <?php echo getParty($party_id) ?>        
                                            </select>
                                        </div>
                                    </div>                                
                                </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="control-label mb-1">From</label>
                                    <input type="date" name="from" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label mb-1">To</label>
                                    <input type="date" name="to" class="form-control" required>
                                </div>
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

                            <br><br>
                            <?php if ($res): ?>
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>Voucher No.</th>
                                                <th>Voucher Date</th>
                                                <th>Details</th>
                                                <th>Income</th>
                                                <th>Expense</th>
                                                <th>Op. Bal.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $running_balance = 0;

                                        while ($row = mysqli_fetch_assoc($res)) { 
                                            if ($row['op_bal'] !== null) {
                                                $running_balance = $row['op_bal'];

                                            } else {
                                                $running_balance += $row['Income'];
                                                $running_balance -= $row['Expense'];
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id']?></td>
                                                <td><?php echo $row['expenses_date']?></td>
                                                <td><?php echo $row['details']?></td>
                                                <td><?php echo $row['Income']?></td>
                                                <td><?php echo $row['Expense']?></td>
                                                <td style="color:<?php                             
                                                    $netBalance = $running_balance;
                                                    if ($netBalance > 0) {
                                                        echo 'green';
                                                    }elseif ($netBalance < 0) {
                                                        echo 'red';
                                                    }else {
                                                        echo 'black';
                                                    }
                                                ?>"><?php echo $running_balance?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th>Total</th>
                                             <th></th>
                                            <th></th>
                                            <th>
                                                <?php 
                                                // Calculate total income and expenses for the period
                                                $total_income_res = mysqli_query($con, "
                                                    SELECT SUM(price) AS Total_Income
                                                    FROM expenses
                                                    WHERE party_id = '" . $party_id . "'
                                                    AND trans_type = 'Income'
                                                    AND expenses_date BETWEEN '" . $from . "' AND '" . $to . "'
                                                ");
                                                $total_income = mysqli_fetch_assoc($total_income_res)['Total_Income'];
                                                echo $total_income;
                                                ?>
                                            </th>
                                            <th>
                                                <?php 
                                                $total_expense_res = mysqli_query($con, "
                                                    SELECT SUM(price) AS Total_Expense
                                                    FROM expenses
                                                    WHERE party_id = '" . $party_id . "'
                                                    AND trans_type = 'Expense'
                                                    AND expenses_date BETWEEN '" . $from . "' AND '" . $to . "'
                                                ");
                                                $total_expense = mysqli_fetch_assoc($total_expense_res)['Total_Expense'];
                                                echo $total_expense;
                                                ?>
                                            </th>
                                            <th style="color:<?php                             
                                                    $netBalance = $running_balance;
                                                    if ($netBalance > 0) {
                                                        echo 'green';
                                                    }elseif ($netBalance < 0) {
                                                        echo 'red';
                                                    }else {
                                                        echo 'black';
                                                    }
                                                ?>"><?php echo $running_balance ?></th>
                                        </tr>   
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p>Please select a party and date range to generate the report.</p>
                            <?php endif; ?>
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
