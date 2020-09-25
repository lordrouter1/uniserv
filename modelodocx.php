<?php 
require 'assets/vendor/autoload.php';

$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/contratoTemplates/contrato_m1.docx');

$templateProcessor->setValue('razaoSocial', 'Alan Cleber Borim Associados e LTDA');
 
$templateProcessor->saveAs('MyWordFile.docx');

?>

