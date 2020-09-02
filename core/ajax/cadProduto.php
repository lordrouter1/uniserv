<?
require_once('../../con.php');
$cfopSaida = '';

$cfop = $con->query('select id from tbl_cfop where cfop = "'.(explode(' - ',$_POST['cfop'])[0]).'"')->fetch_assoc()['id'];
$cfopSaida = explode(' - ',$_POST['cfop'])[0];
$cst = $con->query('select id from tbl_cst where codigo = "'.$_POST['cst'].'"')->fetch_assoc()['id'];

$cest = $con->query('select id from tbl_ncm_cest where replace(cest,".","") = "'.$_POST['cest'].'"')->fetch_assoc()['id'];

if($cest == ""){
    $con->query('INSERT into tbl_ncm_cest(cest,ncm) values ("'.$_POST['cest'].'","'.$_POST['ncm'].'")');
    $cest = $con->insert_id;
}

$con->query('INSERT into tbl_classificacaoFiscal(ncm,cfop,cest,cst,origem) value (
    "'.$_POST['ncm'].'",
    "'.($cfop | 0).'",
    "'.$cest.'",
    "'.($cst | 0).'",
    "'.$_POST['origem'].'"
)');
$_POST['classFisc'] = $con->insert_id;

$con->query('INSERT into tbl_produtos(referencia,nome,valor,unidadeEstoque,grupo,tipoProduto,fornecedor,usoConsumo,comercializavel,classificacaoFiscal,codBarras,estoque) values (
    "'.$_POST['referencia'].'",
    "'.$_POST['nome'].'",
    "'.($_POST['valor'] | 0).'",
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

if($_POST['referencia'] == '')
    $con->query('update tbl_produtos set referencia = "'.$idProd.'" where id = '.$idProd);
if($_POST['barras'] == '')
    $con->query('update tbl_produtos set codBarras = "'.str_pad($idProd,13,0,STR_PAD_LEFT).'" where id = '.$idProd);


$con->query('INSERT INTO `tbl_impXmlLog`(`cfop_entrada`, `cfop_saida`, `quantia`, `referencia`, `idProduto`, `nNota`, `sNota`,`emissaoNota`,`importacaoNota`,`fornecedor`,`chave`) VALUES (
    "'.$_POST['cfopEntrada'].'",
    "'.($cfopSaida | 0).'",
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

$con->query('INSERT into tbl_estoque(quantia,produto,local,xml,operacao,data,motivo) values(
    "'.$_POST['estoque'].'",
    "'.$idProd.'",
    "'.$_COOKIE['lEstoque'].'",
    "'.$idXml.'",
    "e",
    "'.date('Y-m-d').'",
    "Importação automática"
)');

echo $con->error == ''? true:false;

?>