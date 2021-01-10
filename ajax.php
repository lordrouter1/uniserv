<?php
   
   require 'bancoPDO.php';
    $array = array();    
      
    

    if(isset($_GET['nome']) && !empty($_GET['nome'])){
 $nome = $_GET['nome']; 


    $mysql = "SELECT id,razaoSocial_nome FROM tbl_clientes  WHERE tipoCliente='on'  AND razaoSocial_nome  LIKE '$nome%' order by razaoSocial_nome asc  ";

     
     
     $mysql = $pdo->query($mysql);

     if($mysql->rowCount() > 0){

        $array = $mysql->fetchAll();      
                
              
             echo json_encode($array);       
        


     }

    }  


   if(isset($_GET['id_cliente_resul']) && !empty($_GET['id_cliente_resul'])){
 $id_cliente = $_GET['id_cliente_resul']; 


    $mysql = "SELECT tbl_clientes.id,tbl_clientes.razaoSocial_nome FROM tbl_clientes INNER JOIN tbl_recebimentos ON tbl_recebimentos.id_cliente = tbl_clientes.id WHERE tbl_recebimentos.id_cliente = '$id_cliente' GROUP BY tbl_clientes.id  ";

     
     
     $mysql = $pdo->query($mysql);

     if($mysql->rowCount() > 0){

        $array = $mysql->fetchAll();      
                
              
             echo json_encode($array);       
          
       


     }

    }  













     if(isset($_GET['id_cliente']) && !empty($_GET['id_cliente'])){
 $id_cliente = $_GET['id_cliente']; 


    $mysql = "SELECT tbl_clientes.razaoSocial_nome,tbl_clientes.id,tbl_recebimentos.id_cliente,tbl_recebimentos.valor_real,tbl_recebimentos.moeda_selecionada,tbl_recebimentos.id_recebimento,tbl_recebimentos.data_cotacao_euro FROM tbl_clientes INNER JOIN tbl_recebimentos ON tbl_clientes.id =  tbl_recebimentos.id_cliente WHERE tbl_recebimentos.id_cliente = '$id_cliente' ORDER BY tbl_recebimentos.id_recebimento DESC ";

     
     
     $mysql = $pdo->query($mysql);

     if($mysql->rowCount() > 0){

        $array = $mysql->fetchAll();      
                
              
             echo json_encode($array);       
        


     }

    }  

    

  

  if(isset($_GET['id_receb']) && !empty($_GET['id_receb'])){
 $id_receb = $_GET['id_receb']; 

 $array = array();
    $mysql = "SELECT * FROM tbl_parcelas_recebimentos  WHERE id_recebimento = '$id_receb'";

     
     
     $mysql = $pdo->query($mysql);

     if($mysql->rowCount() > 0){

        $array = $mysql->fetchAll();      
                
              
             echo json_encode($array);       
     

     }  

    } 
     

   
    
  









 

 ?>