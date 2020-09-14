<?
    require_once('../../../functions.php');
    require_once('../../lib/juno/class.php');

    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            echo json_encode($con->query('select * from tbl_banco where empresa = '.$_GET['id'])->fetch_assoc());
        break;
        case 'POST':
            if($_POST['habilitar'] == 'true'){
                /*$query = 'insert into tbl_banco(banco,agencia,conta,responsavel,documento,empresa) values(
                    "'.$_POST['banco'].'",
                    "'.$_POST['agencia'].'",
                    "'.$_POST['conta'].'",
                    "'.$_POST['responsavel'].'",
                    "'.$_POST['documento'].'",
                    "'.$_POST['empresa'].'"
                )';*/
                //var_dump('ativar empresa '.$_POST['empresa']);
                #$con->query($query);
                #echo $con->error == ""? true:false;
                $token = $con->query('select token from tbl_configuracao where id = '.$_POST['empresa'])->fetch_assoc();
                var_dump($token['token']);
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
                    
                    var_dump($juno->account($conta));
                    
                }else{

                }
            }
            else{
                $query = 'update tbl_banco set
                    banco = "'.$_POST['banco'].'",
                    agencia = "'.$_POST['agencia'].'",
                    conta = "'.$_POST['conta'].'",
                    responsavel = "'.$_POST['responsavel'].'",
                    documento = "'.$_POST['documento'].'"
                    where empresa = '.$_POST['empresa'].'
                ';
                var_dump('desativar empresa '.$_POST['empresa']);
                #$con->query($query);
                #echo $con->error == ""? true:false;
            }
        break;
    }
?>