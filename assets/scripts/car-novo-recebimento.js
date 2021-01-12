 var clienteId = document.querySelector('.cliente-id');
 var divCliente = document.querySelector('.div-cliente');
 var oculta_select = document.querySelector('.oculta_select')
 var resultado_item = document.querySelector(".resultado_item")
 var modal_result = document.querySelector('.modal_result')
 var modal_result_receb = document.querySelector('.modal_result_receb')
 var modal_result_receb_fechar = document.querySelector('.modal_result_receb_fechar')
 var modal_result_fechar = document.querySelector('.modal_result_fechar')
 var nao_encontrado = document.querySelector('.nao_encontrado')
 var pesquisa_cliente = document.querySelector('.pesquisa_cliente')
var div_cliente_re = document.querySelector('.div-cliente-re')
var body_busca_2 = document.querySelector('#body_busca_2');
var body_busca_1 = document.querySelector('#body_busca_1');
var tabela_result= document.querySelector('.tabela_result');
var receb_calendar = document.querySelector('.receb_calendar')
var consulta_data = document.getElementById('consulta_data')
var nao_encontrado = document.querySelector('.nao_encontrado')

 clienteId.addEventListener('keyup',function(){
    
     


    if(clienteId.value ==''){
         
        $('.oculta_select').show(100)


        divCliente.style.display = 'none'
        oculta_select.style.display = 'block'

    }else{           
                    
                    $('.oculta_select').hide(100)
                    

        

         
    
 

$.ajax({

    type:'GET',
url:"ajax.php",

data:{nome:clienteId.value},
dataType:"json",
success:function(json){

    console.log(json)
    
    var div = document.createElement('div');

    divCliente.innerHTML ='';
        
    
        json.forEach(function(index,item){
            divCliente.style.display = 'block'
             

            divCliente.innerHTML += ` <div onclick="addCliente('${index.razaoSocial_nome}','${index.id}')" class='div-cliente-banco'>${index.razaoSocial_nome}</div>`; 
      
          });

    }
      



});

     
}
      
  })



  function addCliente(nome,id){

    clienteId.value = nome;
    divCliente.style.display = 'none'


    
console.log(document.querySelector('.cliente-id-evia').value = id )
  }

 


  function verDados(id){
    console.log(modal_result)
    modal_result.style.display = 'block'
   let result_modal = document.querySelector('#result_modal');
   result_modal.innerHTML = '';
   

   $.ajax({

    type:'GET',
url:"ajax.php",

data:{id_cliente:id},
dataType:"json",
success:function(json){

    
      
  json.forEach(function(result_jason){
     
    
  let date_cotacao = result_jason.data_cotacao_euro.split('-')
 
   
  //console.log(length.result_jason)
 $//{date[2]+'/'+date[1]+'/'+date[0]}
    

 
 receb_calendar.innerHTML = `                     
                    
 <div class="row">
       
          
     <div class="col-lg-3">
      
         <input type="date" class="form-control data_1" id="data"  name="data_1"  ">
     </div>  
     <div class="col-lg-3">
          
         <input type="date" class="form-control data_2" id="data"  name="data_2" ">
     </div> 

      <input onclick="c_data(${result_jason.id})" type='submit' value='consultar' >
     
 </div>
 `



 





     
    result_modal.innerHTML += `
           
   
    
    
    <tr>
    <td>${result_jason.id}</td>
    <td>${result_jason.razaoSocial_nome}</td>
    <td>${result_jason.moeda_selecionada}</td>
    
    <td>${result_jason.valor_real}</td>
    <td>${date_cotacao[2]+'/'+date_cotacao[1]+'/'+date_cotacao[0]}</td>
     
     
     
    <td  class="noPrint text-center">
      <i class="fas fa-user-edit icon-gradient bg-happy-itmeo btn" onclick="result_consult(${result_jason.id_recebimento})"></i>ver</td>
    `
  })   
        
    }
});
     
  }

  
function c_data(id_recebimento){
  
 let data_1 = document.querySelector('.data_1').value
 let data_2 = document.querySelector('.data_2').value

 if(data_1 == "" || data_2 == ""){

  confirm('os campos devem estar preenchidos')

 }else{

   

   $.ajax({

    type:'GET',
url:"ajax.php",

data:{id_receb_cliente:id_recebimento,data_01:data_1,data_02:data_2},
dataType:"json",
success:function(json){
    modal_result_receb_fechar.addEventListener('click',function(){
modal_result_receb.style.display = 'none'
        modal_result.style.display = 'none'
       nao_encontrado.style.display = 'none'
       result_modal_parc.innerHTML ='';

        
   })

    
    modal_result_receb.style.display = 'block'

    let result_modal_parc = document.querySelector('#result_modal_parc');
    
     result_modal.innerHTML = '';         

    divCliente.innerHTML ='';
     let l =1;
    
        json.forEach(function(jason,item){
             jason.forEach(function(result_jason){

              console.log(result_jason)
                
               let date_parcela = result_jason.data_parcela.split('-')  
             
            result_modal_parc.innerHTML += `   
            
  <tr>
 
<td>${result_jason.id_parcela}</td>
<td>${result_jason.valor_parcela}</td>
<td>${result_jason.valor_pago_parcela}</td>
<td>${date_parcela[2]+'/'+date_parcela[1]+'/'+date_parcela[0]}</td>
<td>${(result_jason.ind_pago) == '0' ?'Em aberto' : 'Pago'}</td>    
<td class="noPrint text-center">
<a href="?edt=${result_jason.id_parcela}" class="btn">
<i class="fas fa-user-edit icon-gradient bg-happy-itmeo"></i>pagar</a></td>
`





             })       
           
             
        

           

      
          });

    },error:function(falha){
          
      

        $('.nao_encontrado').hide(300)  

        $('.nao_encontrado').show(300)
      
        console.log('nao encontrado')


       
    }        



});





















 }

  
  
}


  
  modal_result_fechar.addEventListener('click',function(){

    modal_result.style.display = 'none'
    nao_encontrado.style.display = 'none'
         
    
    

  })


  



 function result_consult(id_recebimento){

console.log(id_recebimento)

    $.ajax({

        type:'GET',
    url:"ajax.php",
    
    data:{id_receb:id_recebimento},
    dataType:"json",
    success:function(json){
        modal_result_receb_fechar.addEventListener('click',function(){
            modal_result_receb.style.display = 'none'
            modal_result.style.display = 'none'
            nao_encontrado.style.display = 'none'
            result_modal_parc.innerHTML ='';

            
        })


        modal_result_receb.style.display = 'block'

        let result_modal_parc = document.querySelector('#result_modal_parc');
        
          result_modal.innerHTML = '';         
    
        divCliente.innerHTML ='';
         let l =1;
        
            json.forEach(function(result_jason,item){
                 
            

                let date_parcela = result_jason.data_parcela.split('-')  
                 
                result_modal_parc.innerHTML += `       
                 
                
    
    <tr>
     
    <td>${result_jason.id_parcela}</td>
    <td>${result_jason.valor_parcela}</td>
    <td>${result_jason.valor_pago_parcela}</td>
    <td>${date_parcela[2]+'/'+date_parcela[1]+'/'+date_parcela[0]}</td>
    <td>${(result_jason.ind_pago) == '0' ?'Em aberto' : 'Pago'}</td>    
    <td class="noPrint text-center">
    <a href="?edt=${result_jason.id_parcela}" class="btn">
    <i class="fas fa-user-edit icon-gradient bg-happy-itmeo"></i>pagar</a></td>
    `
console.log(result_jason)
          
              });
    
        },error:function(falha){
            $('.nao_encontrado').hide(300)  

            $('.nao_encontrado').show(300)
           // nao_encontrado.style.display = 'block'


           
        }        
    
    
    
    });

     
 }










 pesquisa_cliente.addEventListener('keyup',function(){       
        
    
    
         
    if(pesquisa_cliente.value ==''){
        tabela_result.style.display = 'none'
        $('.div-cliente-re').hide(300)
        body_busca_1.innerHTML = '';
        $('#body_busca_2 ').show(300)  
        $('.nao_encontrado').hide(300) 
        
        $('#body_busca_1').hide(300)
        divCliente.style.display = 'none'
        oculta_select.style.display = 'block'

    }else{           
                    
                   
 

$.ajax({

    type:'GET',
url:"ajax.php",

data:{nome:pesquisa_cliente.value},
dataType:"json",
success:function(json){
   
     
    
    var div = document.createElement('div');

    div_cliente_re.innerHTML ='';
        
    
        json.forEach(function(index,item){
           // div_cliente_re.style.display = 'block'
            $('.div-cliente-re').show(100)

            div_cliente_re.innerHTML += ` <div onclick="buscaCliente('${index.id}')" class='div-cliente-banco'>${index.razaoSocial_nome}</div>`; 
               
      

          });

    }
      



});

    }

     
 

     
      
  })


  function buscaCliente(id_cliente_resul){

  
    
   

   

 $.ajax({

    type:'GET',
url:"ajax.php",

data:{id_cliente_resul:id_cliente_resul},
dataType:"json",
success:function(json){
 $('.div-cliente-re').hide(500)
    
      
  json.forEach(function(result_jason){
     $('#body_busca_2 ').hide(500)
     $('#body_busca_1 ').show(500)
      
     
     tabela_result.style.display = 'block';
       body_busca_1.innerHTML = `
           
   
    
    
    <tr  >
    <td >${result_jason.id}</td>
    <td>${result_jason.razaoSocial_nome}</td>
    <td><i style="cursor: pointer;"
  onclick="verDados(${result_jason.id})" 
   class="fas fa-user-edit icon-gradient bg-happy-itmeo clickA"></i>  ver</td>
    
    </tr> 
     
     
    
    `
  })   
        
    },error:function(){
                      
        
        $('.nao_encontrado').show(300)

    }
});
     
  }



  
  modal_result_fechar.addEventListener('click',function(){

    modal_result.style.display = 'none'
    nao_encontrado.style.display = 'none'
            
     
    

  })




 







 
 