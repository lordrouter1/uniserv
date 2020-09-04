<?

    $resp = $con->query('select * from tbl_configuracao where id = 1')->fetch_assoc();
    /*var_dump(array(
        "type" => "PAYMENT",
        "name" => $resp['razao_social'],
        "document" => ereg_replace('[\./-]','',$resp['cnpj']),
        "email" => $resp['email'],
        "phone" => $resp['telefone'],
        "businessArea" => "",
        "linesOfBusiness" => "",
        "companyType" => "",
        "address" => array(
            "street" => $resp['endereco'],
            "number" => $resp['numero'],
            "complement" => $resp['complemento'],
            "neighborhood" => $resp['bairro'],
            "city" => $resp['cidade'],
            "state" => $resp['estado'],
            "postCode" => str_replace('-','',$resp['cep'])
        ),
        "bankAccount" => array(
            "bankNumber" => "",
            "agencyNumber" => "",
            "accountNumber" => "",
            "accountComplementNumber" => "",
            "accountType" => "SAVINGS",
            "accountHolder" => array(
                "name" => "",
                "document" => ""
            )
        )
    ));*/
?>

<div class="row shadow bg-white rounded">
    <div class="col shadow p-2 pl-4">

        <h3 class="mb-3">Pagamentos</h3>

        <div class="divider"></div>

        <div class="row mb-3">
            <div class="col-2 text-right"><strong><span><label for="habilitar">Habilitar</label></span></strong></div>
            <div class="col"><input type="checkbox" name="habilitar" id="habilitar"></div>
        </div>

        <div class="row mb-4">
            <div class="col-2 text-right"><strong>Empresa</strong></div>
            <div class="col">
                <select class="form-control w-25" onchange="getEmpresa(this)">
                    <option selected disabled>Selecione</option>
                    <?
                        $resp = $con->query('select id,razao_social from tbl_configuracao');
                        while($row = $resp->fetch_assoc()){
                            echo '<option value="'.$row['id'].'">'.$row['razao_social'].'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>

        <h3>Empresa</h3>
        <div class="divider"></div>

        
        <form method="post" id="compEmpresa">
            <input type="hidden" name="empresa" id="compEmpresaID" value="">

            <div class="row mb-3">
                <div class="col-2 text-right"><strong>Área de atuação</strong></div>
                <div class="col">
                    <select name="area" id="area" class="form-control w-25">
                        <option selected disabled>Selecione</option>
                        <?
                            foreach($juno->getBusinessAreas() as $item){
                                echo '<option value="'.$item->code.'">'.$item->category.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-2 text-right"><strong>Tipo de companhia</strong></div>
                <div class="col">
                    <select name="tipo" id="tipo" class="form-control w-25">
                        <option selected disabled>Selecione</option>
                        <?
                            foreach($juno->getCompanyTypes() as $item){
                                echo '<option value="'.$item.'">'.$item.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-2 text-right"><strong>Descrição</strong></div>
                <div class="col">
                    <input type="text" name="descricao" id="descricao" class="form-control w-50" maxlength="200">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-2 text-right">
                    <input class="btn btn-success" type="submit" value="Salvar">
                </div>
            </div>
        </form>

        <h3 class="mt-4">Banco</h3>
        <div class="divider"></div>

        <form id="bancoEmpresa">
            <input type="hidden" name="empresa" id="bancoEmpresaID" value="">

            <div class="row mb-3">
                <div class="col-2 text-right"><strong>Banco</strong></div>
                <div class="col">
                    <select name="banco" id="banco" class="form-control w-25">
                    
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-2 text-right"><strong>Número da agência</strong></div>
                <div class="col">
                    <input type="text" name="agencia" id="agencia" class="form-control w-25" maxlength="8">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-2 text-right"><strong>Número da conta</strong></div>
                <div class="col">
                    <input type="text" name="conta" id="conta" class="form-control w-25" maxlength="10">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-2 text-right"><strong>Nome do responsável</strong></div>
                <div class="col">
                    <input type="text" name="responsavel" id="responsavel" class="form-control w-25" maxlength="120">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-2 text-right"><strong>Documento do responsável</strong></div>
                <div class="col">
                    <input type="text" name="documento" id="documento" class="form-control w-25" maxlength="60">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-2 text-right">
                    <input class="btn btn-success" type="submit" value="Salvar">
                </div>
            </div>
        </form>

    </div>
</div>