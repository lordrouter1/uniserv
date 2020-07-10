<?php
    session_start();
    
    if($_POST['cmd'] == "acessar"){
        $con = new mysqli("localhost","uniserve","Ag147258@","data_uniserve");
        $resp = $con->query('select * from tbl_usuario where usuario = "'.$_POST['usuario'].'" and senha = "'.md5($_POST['senha']).'"');
        if($resp->num_rows == 1){
            $usr = $resp->fetch_assoc();
            $_SESSION['usuario'] = $_POST['usuario'];
            $_SESSION['nome'] = $usr['nome'];
            $_SESSION['senha'] = md5($_POST['senha']);
            $_SESSION['id'] = $usr['id'];
            $_SESSION['perm'] = $usr['permissao'];
            $_SESSION['cargo'] = $usr['cargo'];
            echo "<script>location.href='index.php'</script>";
        }
        else{
            echo "<script>location.href='?e'</script>";
        }
    }
    elseif($_GET['exit']){
        $_SESSION['usuario'] = null;
        $_SESSION['nome'] = null;
        $_SESSION['senha'] = null;
        $_SESSION['id'] = null;
        $_SESSION['perm'] = null;
        $_SESSION['cargo'] = null;
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sistema de gerenciamento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">

    <script src="assets/scripts/jquery.js"></script>
    <script src="assets/scripts/jquery.mask.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="./assets/scripts/comp.js"></script>

    <link href="./main.css" rel="stylesheet">
    <link rel="stylesheet" href="./comp.css">
    <link rel="stylesheet" href="assets/fafaicons/css/all.min.css">
</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="content d-flex h-100">
            <div class="login-area bg-dark p-2 rounded m-auto shadow">
                <form method="post">
                    <div class="row">
                        <div class="col text-center">
                            <h4><strong class="text-white">Login</strong></h4>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <input type="hidden" name="cmd" value="acessar">
                            <input type="text" class="form-control" name="usuario" placeholder="Usuário">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <input type="password" class="form-control" name="senha" placeholder="Senha">
                            <?php if(isset($_GET['e'])):?>
                                <div class="alert alert-danger mt-2">
                                    <strong>Erro!</strong> usuário ou senha inválidos.
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button class="btn btn-secondary w-50 float-right">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>