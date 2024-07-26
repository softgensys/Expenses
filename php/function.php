<?php
function prx($data){
    echo '<pre>';
    print_r($data);
    die();
}
function get_safe_value($data){
    if ($data) {
        global $con;
        return mysqli_real_escape_string($con,$data);
    }
}
function redirect($link){
    ?>
    <script>
        window.location.href="<?php echo $link?>";
    </script>

    <?php
}

function CheckUser(){
    if(isset($_SESSION['UID']) && $_SESSION['UID']!=null && $_SESSION['UID']!=''){

    }
    else{
        redirect('index.php');
    }
}

function getCategory($category_id='',$page=''){
    global $con;
    $html="";
    $res1= mysqli_query($con,"Select * from category order by name asc");

    $fun="required";
    if($page=='reports'){
        //$fun= "onchange=change_cat()";
        $fun="";
    }

    $html.='<select $fun name="category_id" id="category_id">';

    $html.='<option value="">Select Category</option>';
    
        while ($row=mysqli_fetch_assoc($res1)) {
            if ($category_id>0 && $category_id== $row['id']) {
                
                $html.='<option value="'.$row['id'].'" Selected>'.$row['name'].'</option>';
            }
            
            $html.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }

    $html.='</select>';
        return $html;

}

function getDashboardExpense($type, $trans_type){
    global $con;
    $sub_sql = "";
    $today = date('Y-m-d');

    // Building the sub_sql based on type and trans_type
    if ($type == 'today') {
        $sub_sql = "WHERE expenses_date = '$today'";
    } elseif ($type == 'yesterday') {
        $yesterday = date('Y-m-d', strtotime("yesterday"));
        $sub_sql = "WHERE expenses_date = '$yesterday'";
    } elseif ($type == 'week' || $type == 'month' || $type == 'year') {
        $from = date('Y-m-d', strtotime("-1 $type"));
        $sub_sql = "WHERE expenses_date BETWEEN '$from' AND '$today'";
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
        $link = "&nbsp;<a href='dashboard_reports.php?from=" . ($from ?? '') . "&to=" . ($to ?? '') . "'  style='font-size: 1rem;
    color: chartreuse;'>Details</a>";
    }
    return $p . $link;
}




function getDashboardExpense1($type){
    global $con;
    $sub_sql = "";
    $today = date('Y-m-d');

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
    } else{
        $sub_sql="";
        $from='';
        $to='';
    }

    $query = "SELECT SUM(price) AS price FROM expenses $sub_sql";
    $res = mysqli_query($con, $query);

    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $p=0;
        $link="";
        if ($row['price']>0) {
            # code...
            $p= $row['price'];
            
            $link="&nbsp;<a href='dashboard_reports.php?from=".$from."&to=".$to.">Details</a>";
            return $p.$link;
        }else{
            return $p.$link;
        }
    } else {
        return 0; // Return 0 or handle error appropriately if query fails
    }
}




?>