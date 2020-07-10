<?php

session_start();

if($_SESSION['usuario'] != null && $_SESSION['senha'] != null && $_SESSION['id'] != null){
    $con = new mysqli("localhost",'indexerpcom_catavento','HD,[98i3(3oC',"indexerpcom_catavento");
    $resp = $con->query('select id from tbl_usuario where usuario = "'.$_SESSION['usuario'].'" and senha = "'.$_SESSION['senha'].'" and id = "'.$_SESSION['id'].'"');
    if($resp->num_rows <> 1){
        echo '<script>location.href="login.php?e"</script>';
    }
}
else{
    echo '<script>location.href="login.php?e"</script>';
}

function redirect($resp){
    if($resp == ''){
        echo "<script>location.href='?s'</script>";
    }
    else{
        echo "<script>location.href='?e'</script>";
    }
}

?>
