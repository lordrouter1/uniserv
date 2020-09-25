<?php
if(false){
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
}

session_start();

require_once('_con.php');

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

if(isset($_SESSION['id'])){
    if(!isset($_COOKIE['empresa'])){
        $resp = $con->query('select id from tbl_configuracao where id in (select valor from tbl_usuarioMeta where meta = "habilitar_empresa" and usuario = '.$_SESSION['id'].')')->fetch_assoc();
        setcookie('empresa',$resp['id']);
        $_COOKIE['empresa'] = $resp['id'];
    }

    
    /*$resp = $con->query('select token,pagamentoStatus from tbl_configuracao where id = '.$_COOKIE['empresa'])->fetch_assoc();
    require_once('core/lib/juno/class.php');
    if($resp['pagamentoStatus'] == '1'){
        $juno->loadRecipientToken($resp['token']);
    }*/
}

?>
