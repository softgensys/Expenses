<?php
include('header.php');
CheckUser();
$trans_type = "";
$title = 'Dashboard';

if (isset($_POST['trans_type'])) {
    $trans_type = get_safe_value($_POST['trans_type']);
    echo "This is " . $trans_type;
}
?>

<!-- MAIN CONTENT-->
<!-- Main CSS-->
<link href="css/theme.css" rel="stylesheet" media="all">
<title>Dashboard</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#trans_type').change(function() {        
        $('#trans_type_form').submit();
    });
});
</script>

<div class="main-content">
    <div class="section__content section__content--p30">
        <h2>DASHBOARD</h2><br/>
        <div class="row form-group">
            <div class="col col-md-4"></div>
            <form id="trans_type_form" method="post" action="">
                <div class="col col-md-3">
                    <label for="trans_type" class="form-control-label"><b>Type</b></label>
                </div>
                <div class="col-12 col-md-12">
                    <select name="trans_type" id="trans_type" class="form-control">
                        <option value="0">Select Income/Expense</option>
                        <option value="Income" <?php if ($trans_type == 'Income') echo 'selected'; ?>>Income</option>
                        <option value="Expense" <?php if ($trans_type == 'Expense') echo 'selected'; ?>>Expense</option>
                    </select>
                </div>
            
        </div><br/>
        <div class="container-fluid">
            <div class="row m-t-25">
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="text">
                                    <h2><?php echo getDashboardExpenseToday('today', $trans_type); ?></h2>
                                    <span>Today's Inc./Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="text">
                                    <h2><?php echo getDashboardExpenseToday('yesterday', $trans_type); ?></h2>
                                    <span>Yesterday's Inc./Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="text">
                                    <h2><?php echo getDashboardExpenseToday('week', $trans_type); ?></h2>
                                    <span>Week's Inc./Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="text">
                                    <h2><?php echo getDashboardExpenseToday('month', $trans_type); ?></h2>
                                    <span>Month's Inc./Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="text">
                                    <h2><?php echo getDashboardExpenseToday('year', $trans_type); ?></h2>
                                    <span>Year's Inc./Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="text">
                                    <h2><?php echo getDashboardExpenseToday('total', $trans_type); ?></h2>
                                    <span>My Total Inc./Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"></div>
        </div>
        </form>
    </div>
</div>
<!-- END MAIN CONTENT-->

<?php
include('footer.php');
function getDashboardExpenseToday($type, $trans_type){
    global $con;
    $sub_sql = "";
    $today = date('Y-m-d');
    $from="";
    $to="";

    // Building the sub_sql based on type and trans_type
    if ($type == 'today') {
        $sub_sql = "WHERE expenses_date = '$today'";
        $from=$today;
        $to=$today;
    } elseif ($type == 'yesterday') {
        $yesterday = date('Y-m-d', strtotime("yesterday"));
        $sub_sql = "WHERE expenses_date = '$yesterday'";
        $from=$yesterday;
        $to=$yesterday;
    } elseif ($type == 'week' || $type == 'month' || $type == 'year') {
        $from = date('Y-m-d', strtotime("-1 $type"));
        $sub_sql = "WHERE expenses_date BETWEEN '$from' AND '$today'";
        $to=$today;
    }else{
        $sub_sql="";
        $from='';
        $to='';
    }

    // Adding trans_type condition if it's set
    if($trans_type != '' && $trans_type != '0') {
        if ($sub_sql == "") {
            $sub_sql = "WHERE trans_type = '$trans_type'";
        } else {
            $sub_sql .= " AND trans_type = '$trans_type'";
        }
    }

    if ($type == 'total' && $trans_type != '' && $trans_type != '0') {
        $sub_sql = "WHERE trans_type = '$trans_type'";
    }

    $query = "SELECT SUM(price) AS price FROM expenses $sub_sql";
    
    $res = mysqli_query($con, $query);
    if (!$res) {
        die("Error in query: " . mysqli_error($con));
    }
    
    $row = mysqli_fetch_assoc($res);
    $p = 0;
    $link = "";
    if ($row['price'] > 0) {
        $p = $row['price'];
        $link = "&nbsp;<a href='dashboard_reports.php?from=" . ($from ?? '') . "&to=" . ($to ?? '') . "&trans_type=" . ($trans_type ?? '') . "'  style='font-size: 1rem;
        color: chartreuse;'>Details</a>";
    }
    return $p . $link;
}


?>