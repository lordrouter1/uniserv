<link href="./main.css" rel="stylesheet">
<?php

include('functions.php');

$resp = $con->query('select * from tbl_contratos where id = '.$_GET['id'])->fetch_assoc();
?>
<table class="table">
</table>