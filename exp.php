<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

if(isset($_GET['tbl'])){
    $con = new mysqli("localhost","uniserve","Ag147258@","data_uniserve");
    
    header('Content-Type: application/csv');
    $f = fopen('php://output', 'a');

    switch($_GET['tbl']){
        case 'clientes':
            header('Content-Disposition: attachment; filename="clientes.csv";');
            $resp = $con->query('select * from tbl_clientes where tipoCliente = "on"');
            foreach($resp->fetch_all() as $row){
                fwrite($f, implode(";",$row)."\n");
            }
            break;
        
        case 'fornecedores':
            header('Content-Disposition: attachment; filename="clientes.csv";');
            $resp = $con->query('select * from tbl_clientes where tipoFornecedor = "on"');
            foreach($resp->fetch_all() as $row){
                fwrite($f, implode(";",$row)."\n");
            }
            break;
        
        case 'funcionarios':
            header('Content-Disposition: attachment; filename="clientes.csv";');
            $resp = $con->query('select * from tbl_clientes where tipoFuncionario = "on" or tipoTecnico = "on"');
            foreach($resp->fetch_all() as $row){
                fwrite($f, implode(";",$row)."\n");
            }
            break;
        
        case 'servicos':
            header('Content-Disposition: attachment; filename="servicos.csv";');
            $resp = $con->query('select * from tbl_servicos');
            foreach($resp->fetch_all() as $row){
                fwrite($f, implode(";",$row)."\n");
            }
            break;
        case 'addServicos':
            header('Content-Disposition: attachment; filename="servicos.csv";');
            $resp = $con->query('select * from tbl_clienteServicos');
            foreach($resp->fetch_all() as $row){
                fwrite($f, implode(";",$row)."\n");
            }
            break;
    }

    return;
}

?>