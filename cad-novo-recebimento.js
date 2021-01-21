$(document).on("click", "#submit_btn", function (e) {
    //Prevent Instant Click 

    rvlr_euro = $('#vlr_euro').val();
    rvlr_euro = rvlr_euro.replace("€", "");	
	rvlr_euro = rvlr_euro.replace(",", "."); 
	if (rvlr_euro == ''){
		rvlr_euro =0;
	}
	if ($("#cliente").val() == null){
		
	$("#cliente").effect( "shake" );
	
	 const Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 3000,
	  timerProgressBar: true,
	  didOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer)
		toast.addEventListener('mouseleave', Swal.resumeTimer)
	  }
	})

	Toast.fire({
	  icon: 'error',
	  title: 'Selecione um cliente para salvar!'
	})
	  return false;
	}
	
	if (rvlr_euro == 0){
		
	$("#vlr_euro").effect( "shake" );
	
	 const Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 3000,
	  timerProgressBar: true,
	  didOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer)
		toast.addEventListener('mouseleave', Swal.resumeTimer)
	  }
	})

	Toast.fire({
	  icon: 'error',
	  title: 'Informe o valor em euro!'
	})
	  return false;
	}
});

    $('#cliente').select2({
        theme: "bootstrap",
        enabled: true,
        dropdownParent: $("#mdl-cliente")
    });

   async function imprimir(){
        const divPrint = document.getElementById('tablePrint');
        newWin = window.open('');
        newWin.document.write('<link href="./main.css" rel="stylesheet">');
        newWin.document.write('<link href="./assets/css/print.css" rel="stylesheet">');
        newWin.document.write('<button class="btn m-2 bg-primary noPrint" onclick="window.print();window.close()"><i class="fa fa-print text-white"></i></button><br><br><h5 class="mb-3">Clientes de Recebimentos</h5>');
        newWin.document.write(divPrint.outerHTML);
        //await new Promise(r => setTimeout(r, 150));
        //newWin.print();
        //newWin.close();
    }
	
	function HabilitarCamposParcelasGrid(){
		iparcelamento = $('#parcelamento').val(); 
		if (iparcelamento == 0) {
			LimpaParcelasDoGrid();
			$("#vlr_entrada").val("R$ 0,00");
			$("#vlr_entrada").prop( "disabled", true );
			$("#condicoes_parc").prop( "disabled", true );
			$("#condicoes_parc").val("00").change();
            $('#tipoValor').prop('disabled',true);
			
		} else{
			$( "#vlr_entrada" ).prop( "disabled", false );
			$( "#condicoes_parc" ).prop( "disabled", false );
            $('#tipoValor').prop('disabled',false);	
			
		}
	}
	
	function LimpaParcelasDoGrid(){
		$("#parcelas_listadas_grid_1").remove(); 
		$("#parcelas_listadas_grid_2").remove(); 
		$("#parcelas_listadas_grid_3").remove(); 
		$("#parcelas_listadas_grid_4").remove(); 
		$("#parcelas_listadas_grid_5").remove(); 
		$("#parcelas_listadas_grid_6").remove(); 
		$("#parcelas_listadas_grid_7").remove(); 
		$("#parcelas_listadas_grid_8").remove(); 
		$("#parcelas_listadas_grid_9").remove(); 
		$("#parcelas_listadas_grid_10").remove(); 
		$("#parcelas_listadas_grid_11").remove(); 
		$("#parcelas_listadas_grid_12").remove(); 		
	}
	
	function CalcularEuroParaReal(){
        rvlr_euro = $('#vlr_euro').val();
        
        rvlr_euro = rvlr_euro.replace("€", "");	
        rvlr_euro = rvlr_euro.replace(",", ".");	
        rcotacoa_vlr_euro = $('#cotacoa_vlr_euro').val();
        rcotacoa_vlr_euro = rcotacoa_vlr_euro.replace("R$", "");	
        rcotacoa_vlr_euro = rcotacoa_vlr_euro.replace(",", ".");

        // checa se o total será em real ou euro
        rValorReal = $("#moeda").val()==1?parseFloat(rvlr_euro):parseFloat(rvlr_euro) * parseFloat(rcotacoa_vlr_euro);
     


        if($("#moeda").val()==2){
            console.log($('.simboloEuro'));
            $('.simboloEuro').hide();
            $('.simboloReal').show();
                console.log('euro')

        }
        else{
            console.log($('.simboloEuro'));
            $('.simboloEuro').show();
            $('.simboloReal').hide();
            
            
           
          
        }


        var n = rValorReal.toFixed(2);
        //alert(n);
        //rValorReal = rValorReal.toFixedDown(2);
        n = n.toString();
        n = n.replace(".", ",");

        //document.getElementById('vlr_real').value = rValorReal; 	
        $("#vlr_real").val("R$ "+n);
        //alert(rValorReal);
        
        if($('#parcelamento').val() == 1){
            CalcularParcelas();
        }
    }	



        
        
    function CalcularParcelas(){
     var valor_tot = 0;


        rvlr_real = $('#moeda').val()==1?$('#vlr_real').val():$('#vlr_euro').val();
           
  
        rvlr_real = rvlr_real.replace("R$", "");	
        rvlr_real = rvlr_real.replace(",", ".");		
        
        rvlr_entrada = $('#vlr_entrada').val();
        rvlr_entrada = rvlr_entrada.replace("R$", "");	
        rvlr_entrada = rvlr_entrada.replace(",", ".");
        
        // calcula parcelas por valor
        if($('#tipoValor').val() == 1){
            var rValorMenosEntrada = (rvlr_real-rvlr_entrada);
               
               
            

            
            if (rValorMenosEntrada < 1) {
                
                $("#vlr_entrada").effect( "shake" );
            
                    const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'error',
                title: 'Entrada não pode ser maior que o valor!'
                })
                LimpaParcelasDoGrid();
                return false;
            
                
            }	


            rcondicoes_parc = $('#condicoes_parc').val();

            rValorPorParcela = (rvlr_real-rvlr_entrada) / rcondicoes_parc;
            var n = rValorPorParcela.toFixed(2);
            var TotalDasCondicoes = (n * rcondicoes_parc);
            TotalDasCondicoes = TotalDasCondicoes.toFixed(2);
            //alert(TotalDasCondicoes);
            var DiferencaQueSobrouNasParcelas = ((rvlr_real-rvlr_entrada) - TotalDasCondicoes);
            DiferencaQueSobrouNasParcelas = DiferencaQueSobrouNasParcelas.toFixed(2);
            //alert(DiferencaQueSobrouNasParcelas);
        //	var PrimeiraParcela = (n  (DiferencaQueSobrouNasParcelas));
            
            if (DiferencaQueSobrouNasParcelas <= 0){
                
                DiferencaQueSobrouNasParcelas = Math.abs(DiferencaQueSobrouNasParcelas) ;
                DiferencaQueSobrouNasParcelas = (n  - DiferencaQueSobrouNasParcelas);
                var Novo = DiferencaQueSobrouNasParcelas.toFixed(2);
                //alert(Novo);
            } else{
                
                if (DiferencaQueSobrouNasParcelas >0 ){
                    //  alert(n);
                DiferencaQueSobrouNasParcelas = (parseFloat(n)  + parseFloat(DiferencaQueSobrouNasParcelas));
            //alert(DiferencaQueSobrouNasParcelas);
                        
                var Novo = DiferencaQueSobrouNasParcelas.toFixed(2);
                // alert(Novo);
                }
            }
                   
                        
           if($("#moeda").val()==2){
              
          $('#vlr_total').val(rValorMenosEntrada.toLocaleString('de-DE',{style:'currency',currency:'EUR'}));
             
        }
        else{
           $('#vlr_total').val(rValorMenosEntrada.toLocaleString('pt-BR',{style:'currency',currency:'BRL'}));
                       
          
        }



          
         // restaValor =  valor_tot - rvlr_entrada ;           
            
         // valorPorcentagemParcela = rValorMenosEntrada / rcondicoes_parc;








       // console.log('linha 406 ->' + valorPorcentagemParcela)

        }
        /* -- calcula parcelas por porcentagem -- */
        else{
               
               
            rcondicoes_parc = $('#condicoes_parc').val();
             valor_r = $("#vlr_euro").val();
             valor_tot = parseFloat(valor_r);
                sobraP  =  (valor_tot/100) * rvlr_entrada;
                sobraPorcentagem =  valor_tot - sobraP;
                
             
             if(isNaN(sobraPorcentagem)){
                    
             $('#vlr_total').val((rvlr_real/100)*rvlr_entrada);

             }  else{  
                
                if($("#moeda").val()==2){
              
          $('#vlr_total').val(sobraPorcentagem.toLocaleString('de-DE',{style:'currency',currency:'EUR'}));
             










        }
        else{
           $('#vlr_total').val(sobraPorcentagem.toLocaleString('pt-BR',{style:'currency',currency:'BRL'}));         
                  
        }

                 
             }

                        
            rValorPorParcela = sobraPorcentagem / rcondicoes_parc;

             
                   
            Novo = rValorPorParcela.toFixed(2);

             
             
        }
        
        
        n = Novo.toString();    
               
          
        n = n.toString();
        n = n.replace(".", ",");
        rValorPorParcela = n;
   
              
               
        if($('#tipoValor').val() == 1){

            restaValor =  rvlr_real - rvlr_entrada ;           
            
            valorVParcela = restaValor / rcondicoes_parc;   
            novo = valorVParcela.toFixed(2)
             n = novo.toString();
             valorPorcentagemParcela = n.replace(".",",");   
         
                  

        }else{

              

            restaPorcentagem = (valor_tot/100) * rvlr_entrada;
            result_p = valor_tot - restaPorcentagem;          
            valorVParcela = result_p / rcondicoes_parc;
             novo = valorVParcela.toFixed(2)
             n = novo.toString();
             valorPorcentagemParcela = n.replace(".",",");  

             console.log('pequei valor das parcelas 484 ->'+valorPorcentagemParcela)

        }
             

        porcentagem = rvlr_real/100;
        

        
          
        
        LimpaParcelasDoGrid(); 


        
        for (var i = 0; i < rcondicoes_parc; i++) {
            if (i == 0) { 
                //DiferencaQueSobrouNasParcelas = 0;
                 
                $('#linhaProdutos').append(`
                    <div name="parcelas_listadas_grid_`+(i+1)+`" id="parcelas_listadas_grid_`+(i+1)+`" >
                        <div class="row mb-2">
                            <div class="col">
                                <input type="hidden" name="`+(i+1)+`" value="`+(i+1)+`">
                                <input type="text" class="form-control" name="`+(i+1)+`_parc" value="Parcela `+(i+1)+`" readonly>
                            </div>

                            
                                <input type="hidden" name="procentagem[]" value="`+valorPorcentagemParcela+`" placeholder="%" class="form-control" onchange="calculaValor(this,1,`+porcentagem+`)">
                             
                            
                            <div class="col-2 d-flex">
                                <i class="mb-auto mt-auto mr-2 fas fa-euro-sign simboloEuro" style="display:none"></i>
                                <i class="mb-auto mt-auto mr-2 fas fa-dollar-sign simboloReal"></i>
                                <input class="form-control" name="valor_parc[]"   type="number" step="0.01" onchange="calculaValor(this,2,`+porcentagem+`)" value="`+valorPorcentagemParcela+`" placeholder="`+valorPorcentagemParcela+`">  
                            </div>
                            <div class="col-2">
                                <input type="date" class="form-control" id="`+(i+1)+`_data"  name="data[] " value="5">
                            </div>  
                        </div>
                    </div>
                `);
            } else{

                $('#linhaProdutos').append(`
                    <div name="parcelas_listadas_grid_`+(i+1)+`" id="parcelas_listadas_grid_`+(i+1)+`" > 
                        <div class="row mb-2">
                            <div class="col"> 
                                <input type="hidden" name="`+(i+1)+`" value="`+(i+1)+`"> 
                                <input type="text" class="form-control" name="`+(i+1)+`_parc" value="Parcela `+(i+1)+`" readonly>
                            </div>


                             
                                <input type="hidden" name="procentagem[]" value="`+valorPorcentagemParcela+`" placeholder="%" class="form-control" onchange="calculaValor(this,1,`+porcentagem+`)">
                             
                             
                            <div class="col-2 d-flex">
                                <i class="mb-auto mt-auto mr-2 fas fa-euro-sign simboloEuro" style="display:none"></i>
                                <i class="mb-auto mt-auto mr-2 fas fa-dollar-sign simboloReal"></i>
                                <input class="form-control" name="valor_parc[]"  type="number" step="0.01" onchange="calculaValor(this,2,`+porcentagem+`)" placeholder="`+valorPorcentagemParcela+`" value="`+valorPorcentagemParcela+`">
                            </div>
                            <div class="col-2">
                                <input type="date" class="form-control" id="data[]"  name="data[] "  >
                            </div>  
                        </div>
                    </div>
                `);
            
            
            }
            
        }
    }




	
    function myFunction() {
	 
        // swal("Cadastro incompleto!", "Selecione o cliente para gravar!", "warning");
        //alert('teste');
        
        $("#cliente").effect( "shake" );
        
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        })

        Toast.fire({
            icon: 'error',
            title: 'Selecione um cliente para salvar!'
        })

	 
    }

    function calculaValor(input,tipo,porcentagem){
        if(tipo == 1){
            alvo = $(input).parent().parent().find('input[name="valor_parc[]"]');
            $(alvo).val($(input).val()*porcentagem);
        }
        else{
            alvo = $(input).parent().parent().find('input[name="procentagem[]"]');
            $(alvo).val($(input).val()/porcentagem);
        }
    }
	
    $(document).ready(function(){
        $("#campoPesquisa").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#body_busca_2 tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $('.select2modalCliente').select2({
            theme: "bootstrap",
            enabled: true,
            dropdownParent: $("#mdl-cliente")
        });
    });