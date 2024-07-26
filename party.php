<?php
include('header.php');
CheckUser();

if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0){
    
     $id=get_safe_value($_GET['id']);
    $res1= mysqli_query($con,"Select * from party where party_id='$id'");
    if ($row1=mysqli_fetch_assoc($res1)>0) {
        
        mysqli_query($con,"delete from party where party_id='$id'");
        echo "Data Deleted For Party Id:$id!";
    }
    else{
        echo "No Such Data Found For Id:$id!";
    }
    
}

$res= mysqli_query($con,"Select * from party order by party_id desc");
    
?>
<?php 
if (mysqli_num_rows($res)>=0) {

?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                <h2>PARTY</h2>
                <a href="manage_party.php">Add Party</a><br></br>
                    <div class="table-responsive table--no-card m-b-30">

                        <table class="table table-borderless table-striped table-earning">
                            <thead>

    <tr>
        <th>Party Id</th>        
        <th>Party Name</th>
        <th>Op.Bal.</th>
        <th>Address</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    
    while($row=mysqli_fetch_assoc($res)){
    ?>
    <tr>        
        <td><?php echo $row['party_id'];?></td>
        <td><?php echo $row['party_name'];?></td>
        <td><?php echo $row['op_bal'];?></td>
        <td><?php echo $row['address1'];?></td>
        <td>
            <a href="manage_party.php?id=<?php echo $row['party_id'];?>">Edit</a>
            <a href="?type=delete&id=<?php echo $row['party_id'];?>">Delete</a>
            
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>


<?php 
    }
    else{
        echo "No Data Found";
    }
?>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
include('footer.php');


?>