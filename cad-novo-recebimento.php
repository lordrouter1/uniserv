<?php include ('header.php'); ?>

<?php
if (isset($_POST['cmd']))
{
    $cmd = $_POST['cmd'];

    if ($cmd == "add")
    {
        $con->autocommit(false);
        
        $qError = false;
        $cotacao = str_replace('R$ ','',str_replace(',','.',$_POST['cotacoa_vlr_euro']));
        $vlr_real = $_POST['vlr_euro']*$cotacao;

        var_dump($_POST);
        
        $con->query('INSERT INTO `tbl_recebimentos`(`id_cliente`, `cotacao_euro`, `data_cotacao_euro`, `moeda_selecionada`, `valor_recebimento`, `valor_real`, `parcelamento`, `valor_entrada`, `valor_total`, `tipoEntrada`) VALUES (
            "'.$_POST['cliente'].'",
            "'.$cotacao.'",
            "'.date('Y-m-d').'",
            "'.($_POST['moeda']=="1"?"Real":"Euro").'",
            "'.($_POST['moeda']=="2"?str_replace(',','.',$_POST['vlr_euro']):$vlr_real).'",
            "'.($vlr_real).'",
            "'.$_POST['condicoes_parc'].'",
            "'.$_POST['vlr_entrada'].'",
            "'.($_POST['tipoValor']=='1'?$_POST['vlr_entrada']:($vlr_real/100)*$_POST['vlr_entrada']).'",
            "'.$_POST['tipoValor'].'"
        )');
        if($con->error != ""){
            $qError = true;
            var_dump($con->error);
        }

        $last_id = $con->insert_id;

        for($i = 0; $i < $_POST['condicoes_parc']; $i++){
            $con->query('INSERT INTO `tbl_parcelas_recebimentos`(`id_recebimento`, `des_parcela`, `valor_parcela`, `valor_pago_parcela`, `ind_pago`, `caminho_arquivo_comprovante`, `nome_arquivo_comprovante`,`data_parcela`) VALUES (
                "'.$last_id.'",
                "0",
                "'.$_POST['valor_parc'][$i].'",
                "0",
                "0",
                "",
                "",
                "'.($_POST[$i.'_data']!=""?$_POST[$i.'_data']:date("Y-m-d")).'"
            )');
            if($con->error != ""){
                $qError = true;
                var_dump($con->error);
            }
        }

        if(!$qError){
            $con->commit();
            echo "<script>location.href='cad-novo-recebimento.php?s'</script>";
        }
        else{
            $con->rollback();
        }
    }
    elseif ($cmd == "edt")
    {
        if($_FILES['arquivo']['name'] != ""){
            $uploaddir = 'upload/';
            $uploadfile = $uploaddir.basename($_FILES['arquivo']['name']);
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile);
        }
        else{
            $uploadfile = "";
        }
        $con->query('update tbl_parcelas_recebimentos set valor_parcela = "'.$_POST['valor_parc'].'", ind_pago = "'.($_POST['ind_pago']=='on'?1:0).'", data_parcela = "'.$_POST['data'].'", caminho_arquivo_comprovante = "'.$uploadfile.'" where id_parcela = '.$_POST['id']);
        redirect($con->error);
    }
}

?>

<script src="cad-novo-recebimento.js"></script>

<!-- cabeçalho da página -->
<div class="app-page-title">

    <div class="page-title-wrapper">

        <div class="page-title-heading">

            <div class="page-title-icon">
                <i class="fas fa-newspaper icon-gradient bg-happy-itmeo"></i>
            </div>
            <div>
                <span>Cadastro de Recebimentos</span>
                <div class="page-title-subheading">
                    Campo para adição, remoção e edição de recebimentos
                </div>
            </div>

        </div>
        <div class="page-title-actions">

            <button class="btn-shadow mr-3 btn btn-dark" id="btn-modal" type="button" data-toggle="modal" data-target="#mdl-cliente">
            <i class="fas fa-plus"></i>
            </button>

            <div class="d-inline-block dropdown">
                <button class="btn-shadow dropdown-toggle btn btn-info" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="fa fa-business-time fa-w-20"></i>
                    </span>
                    Ações
                </button>
                <div class="dropdown-menu dropdown-menu-right" tabindex="-1" role="menu" x_placement="bottom-end">
                    <ul class="nav flex-column">
                        <li class="nav-item">

                            <a class="nav-link text-dark" onclick="imprimir()">
                                Imprimir
                            </a>
                            <a class="nav-link text-dark" target="_blank" href="exp.php?tbl=ordemServico">
                                Exportar
                            </a>
                        
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- fim cabeçalho-->

<!-- conteúdo -->
<div class="content">

    <div class="row">
        <div class="col">
            
            <div class="card main-card mb-3">
                <div class="card-body">

                    <h5 class="card-title">Recebimentos </h5>
                        
                     <div class="alert alert-warning nao_encontrado"><center>Nenhum resultado encontrado</center></div>      
                         <table style="display: none;" class="table table-hover tabela_result">
                        <thead  >
                            
                            <tr>
                                <th style="width:2%">ID</th>
                                <th>Cliente</th>
                            </tr>
                        </thead>
                        <tbody id="body_busca_1" >
                            
                        </tbody>
                    </table>
                        
                              
                        
                    <input type="text" class="mb-2 form-control w-25 pesquisa_cliente" placeholder="Pesquisar" id="campoPesquisa">
                             
                    <div  class="div-cliente-re"> 
                                                   
                    </div>

                    <table class="table mb-0 table-striped table-hover" id="tablePrint">
                        <thead >
                            <tr>
                                <th style="width:2%">ID</th>
                                <th>Cliente</th>
                                <th style="width:14%">Moeda</th>
                                <th style="width:14%">Valor parcela</th>
                                <th style="width:14%">Vencimento</th>
                                <th style="width:6%">Status</th>
                                <th class="noPrint"></th>
                                <th class="noPrint"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $resp = $con->query('select c.*,a.moeda_selecionada,b.razaoSocial_nome as cliente from tbl_parcelas_recebimentos c
                                    left join tbl_recebimentos a on a.id_recebimento = c.id_recebimento
                                    left join tbl_clientes b on b.id = a.id_cliente
                                ');

                                if($resp->num_rows > 0){
                                    while ($row = $resp->fetch_assoc())
                                    {
                                        echo '
                                            <tr>
                                                <td>'.str_pad($row['id_parcela'], 3, "0", STR_PAD_LEFT).'</td>
                                                <td>'.$row['cliente'].'</td>
                                                <td>'.$row['moeda_selecionada'].'</td>
                                                <td>'.$row['valor_parcela'].'</td>
                                                <td>'.date('d / m / Y',strtotime($row['data_parcela'])).'</td>
                                                <td>'.($row['ind_pago']=='0'?'Em aberto':'Pago').'</td>
                                                <td class="noPrint text-center"><a href="?edt=' . $row['id_parcela'] . '" class="btn"><i class="fas fa-user-edit icon-gradient bg-happy-itmeo"></i></a></td>
                                        ';

                                        if($row['caminho_arquivo_comprovante'] != ""){
                                            echo '<td class="noPrint text-center"><a target="_blank" href="' . $row['caminho_arquivo_comprovante'] . '" class="btn"><i class="far fa-file-image icon-gradient bg-happy-itmeo"></i></a></td>';
                                        }
                                        else{
                                            echo "<td></td>";
                                        }

                                        echo '
                                            </tr>
                                        ';
                                    }
                                }

                            ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

</div>
<!-- fim conteúdo -->



<?php include ('footer.php'); ?>


 <!-- modal_result -->
<div    class="modal show modal_result" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-xg">
  <div class="modal-content">
<div class="content">
     
        <div class="row">
        <div class="col">
            
            <div class="card main-card mb-3">
                <div class="card-body">
<div class="alert alert-warning nao_encontrado"><center>Nenhum resultado encontrado</center></div>

                    <div style="float: right;">
                    <button class="btn-shadow mr-3 btn btn-dark" id="btn-modal" type="button" data-toggle="modal" data-target="#mdl-cliente">
            <i class="fas fa-plus"><br></i>
            </button>

              <button class="btn-shadow mr-3 btn btn-danger modal_result_fechar" type="button" data-toggle="modal"  >
                  Sair
            </button>
        </div>

                   <br>
                    <h5 class="card-title">Recebimentos</h5>
                          
                          <div class="modal-header">
            </div>
            <div class="modal-body receb_calendar">
               
            </div>
               




                 <!-- campo adicionado por roney -->
                 <!-- modal parcela -->
 
     
        
            
         
    
 
<!-- modal parcelas -->


             <!-- campo adicionado por roney -->








              <table class="table mb-0 table-striped table-hover" id="tablePrint">
    <thead >
        <tr>
            <th style="width:2%">ID</th>
            <th>Cliente</th>
            <th style="width:14%">Serviço</th>
            <th style="width:14%">Moeda</th>
            <th style="width:14%">Valor Real</th>
            <th style="width:14%">Data Cotação</th>
            <th style="width:14%">Ações</th>
            <th style="width:14%">Status</th>
             
            <th class="noPrint"></th>
            <th class="noPrint"></th> 
        </tr>
    </thead>
    <tbody  id="result_modal">


  
         </tbody>
     </table>

</div>
</div>
</div>
</div>
</div>      
             
            </div>
             
        </div>
    </div>
</div>

 
<!-- fim modal_result -->









<!-- modal_result_receb -->
<div  class="modal show modal_result_receb" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-xg">
  <div class="modal-content">
 


<div class="content">

    <div class="row">
        <div class="col">
            
            <div class="card main-card mb-3">
                <div class="card-body">
                   <div style="float: right;">
                    <button class="btn-shadow mr-3 btn btn-dark" id="btn-modal" type="button" data-toggle="modal" data-target="#mdl-cliente">
            <i class="fas fa-plus"><br></i>
            </button>

              <button class="btn-shadow mr-3 btn btn-danger modal_result_receb_fechar" type="button" data-toggle="modal"  >
                  Sair
            </button>

            <button class="btn-shadow mr-3 btn btn-success modal_result_receb_fechar" type="button" data-toggle="modal"  onclick="imprimir_relatorio()" >
                  imprimir
            </button>




        </div>     
                  <div id="relatorio_receb">
                      

                 
                   <div style="clear:both;"></div>
                    <h5 class="card-title">Recebimentos Parcelados </h5>
                    <br><br>




                
              
              <table class="table mb-0 table-striped table-hover" id="tablePrint">
    <thead >
        <tr>
            
            <th style="width:2%">ID_Parcela</th>             
            <th style="width:14%">Valor da parcela</th>
            <th style="width:14%">Valor pago</th>
            <th style="width:14%">Data parcela</th>
            <th style="width:14%">Moeda</th>
            <th style="width:14%">Status</th>
            <th style="width:14%">Açoes</th>

             
            <th class="noPrint"></th>
            <th class="noPrint"></th> 
        </tr>
    </thead>
    <tbody  id="result_modal_parc">


         </tbody>
     </table>
        
       <br><br>

<div class="app-page-title">
                  
            <div  class="valor_tot_real">
                <span>Total em reais </span> <span class="tot_real"> 0 </span>
                
            </div>
            <div style="clear: both;"></div>

             <div class="valor_tot_euro estilo_campo_valor">
                <span>Total em euros </span > <span class="tot_euro"> 0</span>
                
            </div>
             
         
         
        
    
  

   
 


</div>
  
















      </div>

</div>
</div>
</div>
</div>
</div>


      
             
            </div>
             
        </div>
    </div>
</div>

 
<!-- fim modal_result_receb -->





<!-- modal status -->
<div  class="modal show modal_status_result" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-xg">
  <div class="modal-content">
 


<div class="content">

    <div class="row">
        <div class="col">
            
            <div class="card main-card mb-3">
                <div class="card-body">
                   <div style="float: right;">
                    <button class="btn-shadow mr-3 btn btn-dark" id="btn-modal" type="button" data-toggle="modal" data-target="#mdl-cliente">
            <i class="fas fa-plus"><br></i>
            </button>

              <button class="btn-shadow mr-3 btn btn-danger modal_status_fechar" type="button" data-toggle="modal"  >
                  Sair
            </button>

            <button class="btn-shadow mr-3 btn btn-success modal_result_receb_fechar" type="button" data-toggle="modal"  onclick="imprimir_relatorio_p()" >
                  imprimir
            </button>




        </div>     
                  <div id="relatorio_receb " class="r">
                      

                 
                   <div style="clear:both;"></div>
                    <h5 class="card-title">Transações Pago </h5>
                    <br><br>




                
              
              <table class="table mb-0 table-striped table-hover" id="tablePrint">
    <thead >
        <tr>
            
            <th style="width:2%">ID_Parcela</th>             
            <th style="width:14%">Valor da parcela</th>
            <th style="width:14%">Valor pago</th>
            <th style="width:14%">Data parcela</th>
            <th style="width:14%">Moeda</th>
            <th style="width:14%">Status</th>
             

             
            <th class="noPrint"></th>
            <th class="noPrint"></th> 
        </tr>
    </thead>
    <tbody  id="result_modal_status">


         </tbody>
     </table>
        
       <br><br>

<div class="app-page-title">
                  
            <div  class="valor_tot_real">
                <span>Total em reais </span> <span class="tot_status_real"> 0 </span>
                
            </div>
            <div style="clear: both;"></div>

             <div class="valor_tot_euro estilo_campo_valor">
                <span>Total em euros </span > <span class="tot_status_euro"> 0</span>
                
            </div>
             
         
         
        
    
  

   
 


</div>
  
















      </div>

</div>
</div>
</div>
</div>
</div>


      
             
            </div>
             
        </div>
    </div>
</div>

 
<!-- fim modal status -->

<!-- modal -->
<div class="modal show" tabindex="-1" role="dialog" id="mdl-cliente">
    <div class="modal-dialog modal-xg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar novo recebimento</h5>
                <button type="button" class="close" onclick="location.href='?'" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- action="cad-grava-recebimento.php" -->
                <form  id="form" method="post" enctype="multipart/form-data" >

                    <input type="hidden" value="add" name="cmd">

                    <div class="row mb-3">
                        <div class="col">
                            <label for="cliente">Cliente<span class="ml-2 text-danger">*</span></label>
                            <select class="form-control select2modalCliente" name="cliente" id="cliente" required>
                                <?php
                                    $resp = $con->query('select id, razaoSocial_nome from tbl_clientes where tipoCliente="on"');
                                    while ($row = $resp->fetch_assoc())
                                    {
                                        $selected = $ordemServico['cliente'] == $row['id'] ? 'selected' : '';
                                        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['razaoSocial_nome'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <label for="cotacoa_vlr_euro">Cotação Euro €</label>
                             <input type="text"  value="<?php echo $EuroCotacao;?>" onchange="CalcularEuroParaReal()" class="form-control mb-3 estrangeiroInput" name="cotacoa_vlr_euro" id="cotacoa_vlr_euro" <?=$row['estrangeiro'] != 0 ? 'required' : '' ?>>
                        </div>

                        <div class="col-3">
                            <label for="moeda">Moeda</label>
                            <select name="moeda" id="moeda" class="form-control" onclick="CalcularEuroParaReal()">
                                <option value="1">Real</option>
                                <option value="2" selected>Euro</option>
                            </select>
                        </div>
						
						<div class="col-3">
                            <label for="vlr_euro">Valor<span class="ml-2 text-danger">*</span></label>
                             <input type="text" onchange="CalcularEuroParaReal()" value="<?php echo isset($row['logradouro'])?$row['logradouro']:0; ?>" class="form-control mb-3 estrangeiroInput" name="vlr_euro" id="vlr_euro" <?=$row['estrangeiro'] != 0 ? 'required' : '' ?>>
                             
                        </div>
						<div class="col-3 simboloReal">
                            <label for="vlr_real">Valor Real</label>
                             <input type="text" disabled value="R$ 0,00" class="form-control mb-3 estrangeiroInput" name="vlr_real" id="vlr_real" <?=$row['estrangeiro'] != 0 ? 'required' : '' ?>>
                             
                        </div>
                        
                        
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <label for="parcelamento">Parecelamento</label>
                            <select class="form-control mb-3" name="parcelamento" id="parcelamento" onchange="HabilitarCamposParcelasGrid()">
                                <option value="0" selected >Não</option>
                                <option value="1" >Sim</option>
                            <select>                       		
                        </div>

                        <div class="col-2">
                            <label for="tipoValor">Tipo</label>
                            <select name="tipoValor" id="tipoValor" class="form-control" onchange="CalcularParcelas()" disabled>
                                <option value="1">Valor</option>
                                <option value="2">%</option>
                            </select>
                        </div>
									
						<div class="col-3">
                            <label for="vlr_entrada">Entrada</label>
                             <input type="text"  value="0,00" disabled="true"  onchange="CalcularParcelas()" class="form-control mb-3 estrangeiroInput" name="vlr_entrada" id="vlr_entrada" <?=$row['estrangeiro'] != 0 ? 'required' : '' ?>>
                             
                        </div>

                        <div class="col">
                            <label for="vlr_total">Valor Total</label>
                             <input type="text"  value="0,00"  class="form-control mb-3" name="vlr_total" id="vlr_total" readonly>
                             
                        </div>

                    </div>
                    <div class="row">	
						
						<div class="col-4">
                            <label for="condicoes_parc">Condições</label>
                            <select name="condicoes_parc" disabled="true"  onchange="CalcularParcelas()" value="00" id="condicoes_parc" class="form-control mb-2 estarngeiroInput" > <!-- onchange="listarCidades()" -->
                                         <option value="00" >Selecione</option>
										<option value="01" >Entrada + 1 Parcela</option>
                                        <option value="02">Entrada + 2 Parcelas</option>
                                        <option value="03">Entrada + 3 Parcelas</option>
                                        <option value="04">Entrada + 4 Parcelas</option>
										<option value="05">Entrada + 5 Parcelas</option>
										<option value="06">Entrada + 6 Parcelas</option>
										<option value="07">Entrada + 7 Parcelas</option>
										<option value="08">Entrada + 8 Parcelas</option>
										<option value="09">Entrada + 9 Parcelas</option>
										<option value="10">Entrada + 10 Parcelas</option>
										<option value="11">Entrada + 11 Parcelas</option>
                                        <option value="12">Entrada + 12 Parcelas</option>
                            </select>
						
							
                        </div>
						
						
						
			
									
                    </div>
					
					<div class="divider mb-3"></div>

                    <div class="row">
                        <div class="col" id="linhaProdutos">
                            
                        </div>
                    </div> 

                    <input id="needs-validation" class="d-none"  type="submit" value="enviar">
					
                </form>
                <script>
                    $(document).ready(function(){
                        $("#cpfResponsavel").mask('000.000.000-00', {reverse: true});
                        $("#telefoneEmpresa").mask('(99) 99999-9999');
                        $("#telefoneWhatsapp").mask('(99) 99999-9999');
                        $("#cep").mask('99999-999');
						$("#vlr_euro").mask('9999,99');
						//$("#vlr_real").mask('R$ 9999,99');
						$("#vlr_entrada").mask('9999,99');
						$("#cotacoa_vlr_euro").mask('R$ 9999,99');
					});
				</script>
				
				<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
				<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            </div>
            <div class="modal-footer">
                <p class="text-start"><span class="ml-2 text-danger">*</span> Campos obrigatórios</p>
                <button type="button" class="btn btn-secondary" onclick="location.href='?'">Cancelar</button>
                <button type="button" class="btn btn-primary" id='submit_btn' onclick="$('#form').submit()">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- fim modal -->

<!-- modal parcela -->
<div class="modal show" tabindex="-1" role="dialog" id="mdl-parcela">
    <div class="modal-dialog modal-xg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="form-parcela">
                    <?php
                        if(isset($_GET['edt'])){
                            $resp = $con->query('select * from tbl_parcelas_recebimentos where id_parcela = '.$_GET['edt']);
                            $parcela = $resp->fetch_assoc();
                        }
                    ?>

                    <input type="hidden" value="edt" name="cmd">
                    <input type="hidden" value="<?=$_GET['edt']?>" name="id">
                    <div class="row">
                        <div class="col d-flex">
                            <input class="form-control" name="valor_parc" value="<?=$parcela['valor_parcela']?>" type="number" step="0.01">
                        </div>
                        <div class="col-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ind_pago" id="ind_pago" <?=$parcela['ind_pago']==0?'':'checked';?>>
                                <label class="form-check-label" for="" >Pago</label> 
                            </div>  
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" id="data"  name="data" value="<?=$parcela['data_parcela']?>">
                        </div>  
                        <div class="col"> 
                            <input  class="form-control-file"  type="file" name="arquivo" id="arquivo">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <p class="text-start"><span class="ml-2 text-danger">*</span> Campos obrigatórios</p>
                <button type="button" class="btn btn-secondary" onclick="location.href='?'">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="$('#form-parcela').submit()">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal parcelas -->

<div id="toast-container" class="toast-top-center">
    <div id="toast-success" class="toast toast-success" aria-live="polite" style="opacity: 0.899999;display:none;">
        <div class="toast-title">Sucesso!</div>
    </div>
    <div id="toast-error" class="toast toast-error hidden" aria-live="polite" style="opacity: 0.899999;display:none;">
        <div class="toast-title">Erro!</div>
    </div>
    <?php
if (isset($_GET['s'])) echo "<script>loadToast(true);</script>";
else if (isset($_GET['e'])) echo "<script>loadToast(false);</script>";
?>
</div>
 
<?php if (isset($_GET['edt'])) echo "<script>$('#mdl-parcela').modal()</script>"; ?>











                    


 
