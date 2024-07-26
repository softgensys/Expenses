<?php
include('header.php');
CheckUser();

if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0){
    
     $id=get_safe_value($_GET['id']);
    $res1= mysqli_query($con,"Select * from branch where branch_id=$id");
    if ($row1=mysqli_fetch_assoc($res1)>0) {
        
        mysqli_query($con,"delete from branch where branch_id=$id");
        echo "Data Deleted For Branch Id:$id!";
    }
    else{
        echo "No Such Data Found For Id:$id!";
    }
    
}

$res= mysqli_query($con,"Select * from branch order by branch_id desc");
    
?>
<?php 
if (mysqli_num_rows($res)>=0) {

?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                <h2>BRANCH</h2>
                <a href="manage_branch.php">Add Branch</a><br></br>
                    <div class="table-responsive table--no-card m-b-30">

                        <table class="table table-borderless table-striped table-earning">
                            <thead>

    <tr>
        <th>Branch Id</th>        
        <th>Branch</th>
        <th>Address</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    
    while($row=mysqli_fetch_assoc($res)){
    ?>
    <tr>        
        <td><?php echo $row['branch_id'];?></td>
        <td><?php echo $row['branch'];?></td>
        <td><?php echo $row['address1'];?></td>
        <td>
            <a href="manage_branch.php?id=<?php echo $row['branch_id'];?>">Edit</a>
            <a href="?type=delete&id=<?php echo $row['branch_id'];?>">Delete</a>
            
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