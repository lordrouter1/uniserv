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

  
     

   
    
  









 

 ?>