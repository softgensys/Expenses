<?php
include('header.php');
CheckUser();
$msg="";
$partyid="";
$party="";
$address="";
$type="";
$op_bal=0.00;

$label="Add";
$readon='required';
if(isset($_GET['id']) && $_GET['id']>0){

    $label="Edit";
    $readon='readonly';
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $res=mysqli_query($con,"Select * from party where party_id='$id'");
        $row=mysqli_fetch_assoc($res);
        $partyid=$row['party_id'];
        $party=$row['party_name'];
        $op_bal=$row['op_bal'];
        $address=$row['address1'];
    }
}

if(isset($_POST['submit'])){
    $prid=get_safe_value($_POST['party_id']);    
    $prname=get_safe_value($_POST['party_name']);    
    $pradd=get_safe_value($_POST['address1']);    
    $op_bal=$_POST['op_bal'];    
    $type="add";     
    $sub_sql="";
    if (isset($_GET['id']) && $_GET['id']>0) {
        $type="";
        $sub_sql=" and party_id!= '$id'";
    }
    $res=mysqli_query($con,"select * from party where party_name='$prname' $sub_sql");
    
        if (mysqli_num_rows($res)>0) {
            
            $msg= "This Party:$prname Is Already Exists!";
        }
        else{

            $sql="insert into party(party_id,party_name,op_bal,address1) values('$prid','$prname',$op_bal,'$pradd')";
            if (isset($_GET['id']) && $_GET['id']>0) {
                $sql="update party set party_name='$prname',op_bal=$op_bal,address1='$pradd' where party_id='$id'";
                
            }
            mysqli_query($con,$sql);
            redirect("party.php");
        
        }
    
    
}


    
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label?> PARTY</h2>
                    <a href="party.php">Back</a><br></br>
                    <div class="card">
                        <div class="card-body card-block">                           

                                <form method="post">
                                <div class="form-group">
                                    <label class="control-label mb-1">Party Id</label>
                                    <input type="text" name="party_id" class="form-control" value="<?php echo $partyid?>" <?php echo $readon?> >
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Party Name</label>
                                    <input type="text" name="party_name" class="form-control" required value="<?php echo $party?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">OPENING BAL.</label>
                                    <input type="text" name="op_bal" class="form-control" value="<?php echo $op_bal?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Address</label>
                                    <input type="text" name="address1" class="form-control" value="<?php echo $address?>">
                                </div>
                                   
                                <div class="form-group">                                    
                                    <input type="submit" name="submit" class="btn btn-lg btn-info btn-block" value="submit">
                                </div>
                                                                   
                                </form>

                                <div id="msg"  class="message"><?php echo $msg?>
                            </div>
                 

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