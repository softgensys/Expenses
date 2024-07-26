<?php
include('header.php');
CheckUser();
include('user_header.php');
?>
<h2>DASHBOARD</h2>.<br/>


<table>
    <tr>
        <td>Todays's Expenses</td>
        <td>
            <?php echo getDashboardExpense('today') ?>
        </td>
    </tr>
    <tr>
        <td>Yesterdays's Expenses</td>
        <td>
        <?php echo getDashboardExpense('yesterday') ?>
        </td>
    </tr>
    <tr>
        <td>This Week Expenses</td>
        <td>
        <?php echo getDashboardExpense('week') ?>
        </td>
    </tr>
    <tr>
        <td>This Month Expenses</td>
        <td>
        <?php echo getDashboardExpense('month') ?>
        </td>
    </tr>
    <tr>
        <td>This Year Expenses</td>
        <td>
        <?php echo getDashboardExpense('year') ?>
        </td>
    </tr>
    <tr>
        <td>Total Expenses</td>
        <td>
        <?php echo getDashboardExpense('total') ?>
        </td>
    </tr>
</table>

<?php
include('footer.php');
?>