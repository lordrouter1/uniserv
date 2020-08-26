<?php

session_start();

require_once('con.php');

if($_SESSION['usuario'] != null && $_SESSION['senha'] != null && $_SESSION['id'] != null){
    $con->set_charset("utf8");
    $resp = $con->query('select id from tbl_usuario where usuario = "'.$_SESSION['usuario'].'" and senha = "'.$_SESSION['senha'].'" and id = "'.$_SESSION['id'].'"');
    if($resp->num_rows <> 1){
        echo '<script>location.href="login.php?e"</script>';
    }
}
else{
    echo '<script>location.href="login.php"</script>';
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
