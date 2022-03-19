<?php
    if(!isset($_SESSION["ID"])&&$_SESSION["STATUS"]!="ACTIEF"){
        echo "<script> alert('U heeft geen toegang tot deze pagina.'); location.href='../index.php';</script>";
    }
    unset($_SESSION["ID"]);
    unset($_SESSION["USER_ID"]);
    unset($_SESSION["USER_NAME"]);
    unset($_SESSION["STATUS"]);
    unset($_SESSION["E-MAIL"]);
    unset($_SESSION["ROL"]);
    // Sesssion beëindigen
    session_destroy();
    // Databaseverbinding sluiten
    $conn = null;
    echo "<script>location.href='".$_SERVER["PHP_SELF"]."'</script>";
?>