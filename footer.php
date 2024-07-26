</div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
   
    <script src="vendor/animsition/animsition.min.js"></script>
  

    <!-- Main JS-->
    <script src="js/main.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
  $(document).ready( function () {
    $('#myTable'). DataTable();
  });
</script>


<!-- end document-->
<script>
    function change_cat(){
        var category_id=document.getElementById('category_id').value;
        //console.log(category_id);
        window.location.href='?category_id='+category_id;
    }
</script>
</body>

</html>