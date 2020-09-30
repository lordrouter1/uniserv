<?php include('header.php'); ?>

<?
    $resp = $con->query('select pagamentoStatus from tbl_configuracao where id = '.$_COOKIE['empresa']);
    $flag = $resp->num_rows > 0;
    if($flag && $resp->fetch_assoc()['pagamentoStatus'] == '1'):
?>
<div class="card mb-3 widget-content w-25 bg-success">
    <div class="text-white">
        <div class="widget-content-left">
            <div class="widget-heading"><h4><strong>Total a receber</strong></h4></div>
            
        </div>
        <div class="">
            <a href="#"><div class="widget-numbers text-white"><span>R$ <?=$juno->balanco();?></span></div></a>
        </div>
    </div>
</div>
<?endif;?>


<?php include('footer.php');?>
