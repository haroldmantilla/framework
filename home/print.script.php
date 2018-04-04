<?php
    session_start();
    $_SESSION['chit'] = $_POST['chit'];
    header("Location: generate_pdf.php");
?>
