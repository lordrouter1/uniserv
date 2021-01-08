 var clienteId = document.querySelector('.cliente-id');
 var divCliente = document.querySelector('.div-cliente');
 var oculta_select = document.querySelector('.oculta_select')
 

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

 