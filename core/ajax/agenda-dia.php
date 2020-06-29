<?php
    if(isset($_GET['dia'])){
        $adicionar = $_GET['ano'].'-'.$_GET['mes'].'-'.$_GET['dia'];
    }
    else{
        $adicionar = $nAno.'-'.$nMes.'-'.$nDia;
    }
?>
<button class="btn btn-info mb-2" type="button" data-toggle="modal" data-target="#mdl-cliente">
    <i class="far fa-calendar-plus mr-3"></i>
    <span class="float-right">Adicionar</span>
</button>
<div id="tabelaDia" class="border">
    <table class="table table-bordered">
        <tbody>   
            <?php
                for($i = 1; $i < 25; $i++){
                    $meioDia = $i == 12 ? 'class="bg-light"':'';
                    
                    echo '
                        <tr '.$meioDia.'>
                            <td style="width:10%">'.$i.':00</td>
                            <td></td>
                        </tr>
                    ';
                }
            ?>
        </tbody>
    </table>
</div>