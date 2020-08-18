<?
require_once('../../con.php');

if($_POST['valVenda'] == '')
    $query = 'update tbl_produtos set estoque = estoque + '.$_POST['estoque'].' where id = '.explode(' - ',$_POST['produto'])[0];
else{
    $query = 'update tbl_produtos set estoque = estoque + '.$_POST['estoque'].', valor = '.$_POST['venda'].' where id = '.explode(' - ',$_POST['produto'])[0];
}

$con->query($query);

$con->query('INSERT INTO `tbl_impXmlLog`(`quantia`, `referencia`, `nNota`, `sNota`,`emissaoNota`,`importacaoNota`,`fornecedor`,`chave`) VALUES (
    "'.$_POST['estoque'].'",
    "'.$_POST['referencia'].'",
    "'.$_POST['notaId'].'",
    "'.$_POST['notaSerie'].'",
    "'.date('y-m-d',strtotime($_POST['dataNota'])).'",
    "'.date('y-m-d').'",
    "'.$_POST['fornecedor'].'",
    "'.$_POST['chaveNFe'].'"
)');

var_dump($con->error);

echo $con->erro == ''?true:false;
?>