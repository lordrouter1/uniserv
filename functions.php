<?php
if(true){
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
}

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

if(isset($_SESSION['id'])){
    if(!isset($_COOKIE['empresa'])){
        $resp = $con->query('select id from tbl_configuracao where id in (select valor from tbl_usuarioMeta where meta = "habilitar_empresa" and usuario = '.$_SESSION['id'].')')->fetch_assoc();
        setcookie('empresa',$resp['id']);
        $_COOKIE['empresa'] = $resp['id'];
    }

    require_once('core/lib/juno/class.php');
    $resp = $con->query('select token,pagamentoStatus from tbl_configuracao where id = '.$_COOKIE['empresa'])->fetch_assoc();
    if($resp['pagamentoStatus'] == '1'){
        $juno->loadRecipientToken($resp['token']);
    }
}

function cadProdImp($data,$con){
    $cfopSaida = '';
    $cfop = $con->query('select id from tbl_cfop where cfop = "'.(explode(' - ',$data['cfop'])[0]).'"')->fetch_assoc()['id'];
    $cfopSaida = explode(' - ',$data['cfop'])[0];
    $cst = $con->query('select id from tbl_cst where codigo = "'.$data['cst'].'"')->fetch_assoc()['id'];

    $cest = $con->query('select id from tbl_ncm_cest where replace(cest,".","") = "'.$data['cest'].'"')->fetch_assoc()['id'];

    if($cest == ""){
        $con->query('INSERT into tbl_ncm_cest(cest,ncm) values ("'.$data['cest'].'","'.$data['ncm'].'")');
        $cest = $con->insert_id;
        var_dump($con->error);
    }

    $con->query('INSERT into tbl_classificacaoFiscal(ncm,cfop,cest,cst,origem) value (
        "'.$data['ncm'].'",
        "'.($cfop | 0).'",
        "'.$cest.'",
        "'.($cst | 0).'",
        "'.$data['origem'].'"
    )');
    $data['classFisc'] = $con->insert_id;
    var_dump($con->error);

    $con->query('INSERT into tbl_produtos(referencia,nome,valor,unidadeEstoque,grupo,tipoProduto,fornecedor,usoConsumo,comercializavel,classificacaoFiscal,codBarras,estoque) values (
        "'.$data['referencia'].'",
        "'.$data['nome'].'",
        "'.($data['valor'] | 0).'",
        "'.$data['unEstoque'].'",
        "'.$data['grupo'].'",
        "'.$data['tipoDeProduto'].'",
        "'.$data['fornecedor'].'",
        "'.$data['usoConsumo'].'",
        "'.$data['comercializavel'].'",
        "'.$data['classFisc'].'",
        "'.$data['barras'].'",
        "'.$data['estoque'].'"
    )');
    $idProd = $con->insert_id;
    var_dump($con->error);

    if($data['referencia'] == '')
        $con->query('update tbl_produtos set referencia = "'.$idProd.'" where id = '.$idProd);
    if($data['barras'] == '')
        $con->query('update tbl_produtos set codBarras = "'.str_pad($idProd,13,0,STR_PAD_LEFT).'" where id = '.$idProd);
    var_dump($con->error);

    $con->query('INSERT INTO `tbl_impXmlLog`(`cfop_entrada`, `cfop_saida`, `quantia`, `referencia`, `idProduto`, `nNota`, `sNota`,`emissaoNota`,`importacaoNota`,`fornecedor`,`chave`) VALUES (
        "'.$data['cfopEntrada'].'",
        "'.($cfopSaida | 0).'",
        "'.$data['estoque'].'",
        "'.$data['referencia'].'",
        "'.$idProd.'",
        "'.$data['notaId'].'",
        "'.$data['notaSerie'].'",
        "'.date('y-m-d',strtotime($data['dataNota'])).'",
        "'.date('y-m-d').'",
        "'.$data['fornecedor'].'",
        "'.$data['chaveNFe'].'"
    )');
    $idXml = $con->insert_id;
    var_dump($con->error);

    $con->query('INSERT into tbl_estoque(quantia,produto,local,xml,operacao,data,motivo) values(
        "'.$data['estoque'].'",
        "'.$idProd.'",
        "'.$_COOKIE['lEstoque'].'",
        "'.$idXml.'",
        "e",
        "'.date('Y-m-d').'",
        "Importação automática"
    )');
    var_dump($con->error);
    return $con->error == ''? true:false;
}

function addProdImp($data,$con){
    $data['estoque'] = str_replace(',','.',str_replace('.','',$data['estoque']));
    $prodId = explode(' - ',$data['produto'])[0];

    if($data['valVenda'] == '')
        $query = 'update tbl_produtos set estoque = estoque + '.$data['estoque'].' where id = '.$prodId;
    else{
        $query = 'update tbl_produtos set estoque = estoque + '.$data['estoque'].', valor = '.$data['valVenda'].' where id = '.$prodId;
    }

    $con->query($query);
    var_dump($con->error);

    $con->query('INSERT INTO `tbl_impXmlLog`(`idProduto`, `quantia`, `referencia`, `nNota`, `sNota`,`emissaoNota`,`importacaoNota`,`fornecedor`,`chave`,`produtoDeEntrada`) VALUES (
        "'.$prodId.'",
        "'.$data['estoque'].'",
        "'.$data['referencia'].'",
        "'.$data['notaId'].'",
        "'.$data['notaSerie'].'",
        "'.date('y-m-d',strtotime($data['dataNota'])).'",
        "'.date('y-m-d').'",
        "'.$data['fornecedor'].'",
        "'.$data['chaveNFe'].'",
        "'.$data['produtoDeEntrada'].'"
    )');
    $idXml = $con->insert_id;
    var_dump($con->error);

    $con->query('INSERT into tbl_estoque(quantia,produto,local,xml,operacao,data,motivo) values(
        "'.$data['estoque'].'",
        "'.$prodId.'",
        "'.$_COOKIE['lEstoque'].'",
        "'.$idXml.'",
        "e",
        "'.date('Y-m-d').'",
        "Importação automática"
    )');
    var_dump($con->error);

    return $con->erro == ''?true:false;
}

?>
