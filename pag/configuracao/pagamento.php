<?
    $resp = $con->query('select * from tbl_configuracao where id = 1')->fetch_assoc();
    var_dump(array(
        "type" => "PAYMENT",
        "name" => $resp['razao_social'],
        "document" => ereg_replace('[\./-]','',$resp['cnpj']),
        "email" => $resp['email'],
        "birthDate" => "",
        "phone" => $resp['telefone'],
        "businessArea" => "", /* Falta */
        "linesOfBusiness" => "", /* Falta */
        "companyType" => "", /* Falta */
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
            "bankNumber" => "", /* Falta */
            "agencyNumber" => "", /* Falta */
            "accountNumber" => "", /* Falta */
            "accountComplementNumber" => "",
            "accountType" => "SAVINGS",
            "accountHolder" => array(
                "name" => "", /* Falta */
                "document" => "" /* Falta */
            )
        )
    ));
?>

<div class="row">
    <div class="col shadow p-2 pl-4">

        <h3 class="mb-3">Pagamentos</h3>

        <div class="divider"></div>

        <div class="row">
            <div class="col-3"><strong><span><label for="habilitar">Habilitar</label></span></strong></div>
            <div class="col"><input type="checkbox" name="habilitar" id="habilitar"></div>
        </div>

        <div class="divider"></div>

        <div class="row">
            <div class="col-3"></div>
            <div class="col"></div>
        </div>

        <div class="row">
            <div class="col-3"></div>
            <div class="col"></div>
        </div>

        <div class="row">
            <div class="col-3"></div>
            <div class="col"></div>
        </div>

        <div class="row">

        </div>

    </div>
</div>