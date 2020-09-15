<?
    require_once('../../../functions.php');
    require_once('../../lib/juno/class.php');

    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            echo json_encode($con->query('select pagamentoStatus from tbl_configuracao where empresa = '.$_GET['empresa'])->fetch_assoc());
        break;
        case 'POST':
            if($_POST['habilitar'] == 'true'){
                $token = $con->query('select token from tbl_configuracao where id = '.$_POST['empresa'])->fetch_assoc();
                if($token['token'] == '0'){
                    $empresa = $con->query('select * from tbl_configuracao where id = '.$_POST['empresa'])->fetch_assoc();
                    $banco = $con->query('select * from tbl_banco where empresa = '.$_POST['empresa'])->fetch_assoc();
                    
                    $conta = array(
                        "type" => "PAYMENT",
                        "name" => $empresa['razao_social'],
                        "document" => ereg_replace('[\./-]','',$empresa['cnpj']),
                        "email" => $empresa['email'],
                        "phone" => ereg_replace('[\.\(\)]','',$empresa['telefone']),
                        "businessArea" => $empresa['area'],
                        "linesOfBusiness" => $empresa['descricao'],
                        "companyType" => $empresa['tipo'],
                        "address" => array(
                            "street" => $empresa['endereco'],
                            "number" => $empresa['numero'],
                            "complement" => $empresa['complemento'],
                            "neighborhood" => $empresa['bairro'],
                            "city" => $empresa['cidade'],
                            "state" => $empresa['estado'],
                            "postCode" => str_replace('-','',$empresa['cep'])
                        ),
                        "bankAccount" => array(
                            "bankNumber" => $banco['banco'],
                            "agencyNumber" => $banco['agencia'],
                            "accountNumber" => str_replace('-','',$banco['conta']),
                            "accountComplementNumber" => "",
                            "accountType" => "SAVINGS",
                            "accountHolder" => array(
                                "name" => $banco['responsavel'],
                                "document" => ereg_replace('[\./-]','',$banco['documento'])
                            )
                        ),
                        "legalRepresentative" => array(
                            "name" => $empresa['respLegal'],
                            "document" => $empresa['docResp'],
                            "birthDate" => $empresa['dataResp']
                        )
                    );
                    
                    $jResp = $juno->account($conta);

                    var_dump($jResp);

                    if(isset($jResp->resourceToken)){
                        $con->query('update tbl_configuracao set pagamentoStatus = 1, token = "'.$jResp->resourceToken.'" where id = '.$_POST['empresa']);
                        echo 'true';
                    }else{
                        echo 'false';
                    }
                    
                }else{
                    $con->query('update tbl_configuracao set pagamentoStatus = 1 where id = '.$_POST['empresa']);
                    echo $con->error == ''?'true':'false';
                }
            }
            else{
                $con->query('update tbl_configuracao set pagamentoStatus = 0 where id = '.$_POST['empresa']);
                echo $con->error == ""? 'true':'false';
            }
        break;
    }
?>