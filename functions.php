<?php

$con = new mysqli("localhost","uniserve","Ag147258@","data_uniserve");

function redirect($resp){
    if($resp == ''){
        echo "<script>location.href='?s'</script>";
    }
    else{
        echo "<script>location.href='?e'</script>";
    }
}

?>