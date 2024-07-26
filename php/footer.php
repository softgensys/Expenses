<br></br><br></br>
<div>   

    @Copyright
    <?php 
     echo date('M/Y');
    ?>
</div>
<script>
    function change_cat(){
        var category_id=document.getElementById('category_id').value;
        //console.log(category_id);
        window.location.href='?category_id='+category_id;
    }
</script>
</html>