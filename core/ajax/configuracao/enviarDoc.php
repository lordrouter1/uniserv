<?
    require_once('../../../functions.php');

    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            echo json_encode($con->query('select status from tbl_documentos where id = '.$_GET['id'])->fetch_assoc());
        break;
        case 'POST':
            $ret = [];
            foreach(array_keys($_POST) as $key){
                $loc = '../../../upload/'.$key.'.jpeg';
                
                $img = fopen( $loc, 'wb' ); 
                $data = explode(',',$_POST[$key]);
                fwrite($img, base64_decode( $data[ 1 ] ) );
                fclose( $img );
                
                $resp = $juno->enviarDocumentos($loc,$key)->approvalStatus;
                $con->query('insert into tbl_documentos(doc,status) values("'.$key.'","'.$resp.'")');
            }
            echo true;
        break;
    }
?>