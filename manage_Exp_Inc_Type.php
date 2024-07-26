<?php
$typeexpinc='';
$html="";


function Changetypeexpinc(){

    if (isset($_POST['type'])) {
        $typeexpinc = $_POST['type'];
        $_SESSION['type'] = $typeexpinc;
        echo "Type updated to: " . htmlspecialchars($typeexpinc);
        exit(); // Exit after handling the AJAX request
        } elseif (isset($_SESSION['type'])) {
        $typeexpinc = $_SESSION['type']; // Retrieve from session if available
    }
    return $typeexpinc;
}


?>