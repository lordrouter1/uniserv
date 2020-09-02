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

        <form method="post">
            <h3 class="mb-3">Pagamentos</h3>

            <div class="divider"></div>

            <div class="row mb-4">
                <div class="col-3"><strong><span><label for="habilitar">Habilitar</label></span></strong></div>
                <div class="col"><input type="checkbox" name="habilitar" id="habilitar"></div>
            </div>

            <h3>Empresa</h3>
            <div class="divider"></div>

            <div class="row mb-3">
                <div class="col-3"><strong>Área</strong></div>
                <div class="col">
                    <select name="" id="" class="form-control w-25"></select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3"><strong>Tipo</strong></div>
                <div class="col">
                    <select name="" id="" class="form-control w-25"></select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-3"><strong>Descrição</strong></div>
                <div class="col">
                    <select name="" id="" class="form-control w-25"></select>
                </div>
            </div>

            <h3 class="mt-4">Banco</h3>
            <div class="divider"></div>

            <div class="row mb-3">
                <div class="col-3"><strong>Banco</strong></div>
                <div class="col">
                    <select name="" id="" class="form-control w-25"></select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3"><strong>Agência</strong></div>
                <div class="col">
                    <input type="text" name="" id="" class="form-control w-25">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3"><strong>Conta</strong></div>
                <div class="col">
                    <input type="text" name="" id="" class="form-control w-25">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3"><strong>Nome</strong></div>
                <div class="col">
                    <input type="text" name="" id="" class="form-control w-25">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3"><strong>Documento</strong></div>
                <div class="col">
                    <input type="text" name="" id="" class="form-control w-25">
                </div>
            </div>

            <div class="row mb-3 mt-4">
                <div class="col">
                    <input class="btn btn-primary" type="submit" value="Salvar">
                </div>
            </div>
        </form>

    </div>
</div>