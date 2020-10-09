<?
require_once('functions.php');
require_once('core/lib/nfe/class.php');

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

$nota = new Nfe($con);

file_put_contents('upload/nota.xml',$nota->gerarXML());
$nota->assinarXML();
$nota->enviarLote();
var_dump($nota->consultarRecibo());

var_dump("fim");
?>