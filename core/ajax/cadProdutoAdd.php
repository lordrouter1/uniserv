<?
require_once('../../con.php');

$_POST['estoque'] = str_replace(',','.',str_replace('.','',$_POST['estoque']));
$prodId = explode(' - ',$_POST['produto'])[0];

if($_POST['valVenda'] == '')
    $query = 'update tbl_produtos set estoque = estoque + '.$_POST['estoque'].' where id = '.$prodId;
else{
    $query = 'update tbl_produtos set estoque = estoque + '.$_POST['estoque'].', valor = '.$_POST['valVenda'].' where id = '.$prodId;
}

$con->query($query);

$con->query('INSERT INTO `tbl_impXmlLog`(`idProduto`, `quantia`, `referencia`, `nNota`, `sNota`,`emissaoNota`,`importacaoNota`,`fornecedor`,`chave`) VALUES (
    "'.$prodId.'",
    "'.$_POST['estoque'].'",
    "'.$_POST['referencia'].'",
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
    "'.$prodId.'",
    "'.$_POST['localestoque'].'",
    "'.$idXml.'",
    "e",
    "'.date('Y-m-d').'",
    "Importação automática"
)');

echo $con->erro == ''?true:false;
?>