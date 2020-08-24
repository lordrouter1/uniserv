<?
require_once('../../con.php');
$cfopSaida = '';
if($_POST['classFisc'] == ''){
    $cfop = $con->query('select id from tbl_cfop where cfop = "'.(explode(' - ',$_POST['cfop'])[0]).'"')->fetch_assoc()['id'];
    $cfopSaida = explode(' - ',$_POST['cfop'])[0];
    $cst = $con->query('select id from tbl_cst where codigo = "'.$_POST['cst'].'"')->fetch_assoc()['id'];
    
    $cest = $con->query('select id from tbl_ncm_cest where replace(cest,".","") = "'.$_POST['cest'].'"')->fetch_assoc()['id'];
    if($cest == ""){
        $con->query('INSERT into tbl_ncm_cest(cest,ncm) values ("'.$_POST['cest'].'","'.$_POST['ncm'].'")');
        $cest = $con->insert_id;
    }
   
    $con->query('INSERT into tbl_classificacaoFiscal(nome,ncm,cfop,cest,cst,origem) value (
        "'.(explode(' - ',$_POST['cfop'])[0]).' - '.$_POST['ncm'].'",
        "'.$_POST['ncm'].'",
        "'.$cfop.'",
        "'.$cest.'",
        "'.$cst.'",
        "'.$_POST['origem'].'"
    )');

    $_POST['classFisc'] = $con->insert_id;

}
else{
    $cfopSaida = $con->query('select B.cfop as cfopSaida from tbl_classificacaoFiscal as A inner join tbl_cfop B on B.id = A.cfop where A.id = '.$_POST['classFisc'])->fetch_assoc()['cfopSaida'];
}

$con->query('INSERT into tbl_produtos(referencia,nome,valor,unidadeEstoque,grupo,tipoProduto,fornecedor,usoConsumo,comercializavel,classificacaoFiscal,codBarras,estoque) values (
    "'.$_POST['referencia'].'",
    "'.$_POST['nome'].'",
    "'.$_POST['valor'].'",
    "'.$_POST['unEstoque'].'",
    "'.$_POST['grupo'].'",
    "'.$_POST['tipoDeProduto'].'",
    "'.$_POST['fornecedor'].'",
    "'.$_POST['usoConsumo'].'",
    "'.$_POST['comercializavel'].'",
    "'.$_POST['classFisc'].'",
    "'.$_POST['barras'].'",
    "'.$_POST['estoque'].'"
)');
$idProd = $con->insert_id;

$con->query('INSERT INTO `tbl_impXmlLog`(`cfop_entrada`, `cfop_saida`, `quantia`, `referencia`, `idProduto`, `nNota`, `sNota`,`emissaoNota`,`importacaoNota`,`fornecedor`,`chave`) VALUES (
    "'.$_POST['cfopEntrada'].'",
    "'.$cfopSaida.'",
    "'.$_POST['estoque'].'",
    "'.$_POST['referencia'].'",
    "'.$idProd.'",
    "'.$_POST['notaId'].'",
    "'.$_POST['notaSerie'].'",
    "'.date('y-m-d',strtotime($_POST['dataNota'])).'",
    "'.date('y-m-d').'",
    "'.$_POST['fornecedor'].'",
    "'.$_POST['chaveNFe'].'"
)');
$idXml = $con->insert_id;

$con->query('INSERT into tbl_estoque(quantia,produto,local,xml) values(
    "'.$_POST['estoque'].'",
    "'.$idProd.'",
    "'.$_POST['localestoque'].'",
    "'.$idXml.'"
)');



echo $con->error == ''? true:false;

?>