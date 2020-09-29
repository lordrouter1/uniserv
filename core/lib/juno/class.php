<?php

/*
    sandbox

    public $clientId = "fnkLj1Luh3nJwM4v";
    public $clientSecret = "1yW@M+lI,-dxmmnLUzaxo5,NP;Zv(If^";

    producao

    private $clientId = "LHTz7QUBe1lUMqjT";
    private $clientSecret = "acjPK@]I)_:SgEAV,Nxk%b6!mOiqj{E=";


*/

class Juno
{
    private $clientId = "LHTz7QUBe1lUMqjT";
    private $clientSecret = "acjPK@]I)_:SgEAV,Nxk%b6!mOiqj{E=";
    
    private $token = "";
    private $expires = "";
    public $recipientToken = "";
    private $masterToken = "1230E4ECA4E796BFC7BA89AD3B1B3A0D6FB01B240CEA521166D7A9A0568EBCF2";

    private $curl;
    private $url = "https://api.juno.com.br/api-integration/";

    private $taxa = 2.8;

    function __construct()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $this->loadKey();
        //$this->loadResourceToken();
    }

    /*private function loadResourceToken()
    {
        $resp = mysql_query('select resourceToken from config_site');
        
        if(mysql_num_rows($resp))
        {
            $this->resourceToken = mysql_fetch_assoc($resp)['resrouceToken'];
            return true;
        }
        else
        {
            $this->resourceToken = "";
            return false;
        }
    }*/

    public function loadRecipientToken($token){
        $this->recipientToken = $token;
    }

    private function loadKey()
    {
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_URL, "https://api.juno.com.br/authorization-server/oauth/token");
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic ".base64_encode($this->clientId.":".$this->clientSecret)
        ));
        curl_setopt($this->curl, CURLOPT_POSTFIELDS,"grant_type=client_credentials");

        $resp = json_decode(curl_exec($this->curl));

        $this->token = $resp->access_token;
        $this->expires = $resp->expires_in;

        $this->isTokenVal();
    }

    private function isTokenVal()
    {
        $now = intval(substr(date("U"),5,5));

        /*if($now >= $this->expires)
        {
            //$this->loadKey();
        }*/
    }

    public function getBusinessAreas()
    {
        $this->isTokenVal();

        curl_setopt($this->curl, CURLOPT_URL, $this->url."data/business-areas");
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$this->masterToken
        ));

        $resp = json_decode(curl_exec($this->curl));

        return $resp->_embedded->businessAreas;
    }

    public function getCompanyTypes()
    {
        $this->isTokenVal();

        curl_setopt($this->curl, CURLOPT_URL, $this->url."data/company-types");
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$this->masterToken
        ));

        $resp = json_decode(curl_exec($this->curl));

        return $resp->companyTypes;
    }

    /* ========== CONTA ========== */

    /*
    "type" => "PAYMENT",
    "name" => "b-cup estampas",
    "document" => "02694062040",
    "email" => "juliobenin@yahoo.com.br",
    "birthDate" => "1996-03-24",
    "phone" => "54999994316",
    "businessArea" => "1000",
    "linesOfBusiness" => "Descrição da empresa",
    "companyType" => "MEI",
    "address" => array(
        "street" => "rua marechal floriano",
        "number" => "1380",
        "complement" => "",
        "neighborhood" => "planalto",
        "city" => "Guaporé",
        "state" => "RS",
        "postCode" => "99200000"
    ),
    "bankAccount" => array(
        "bankNumber" => "748",
        "agencyNumber" => "0136",
        "accountNumber" => "81828-3",
        "accountComplementNumber" => "",
        "accountType" => "SAVINGS",
        "accountHolder" => array(
            "name" => "julio cesar benin krinhardt",
            "document" => "02694062040"
        )
    )
    */
    public function account($account)
    {
        $this->isTokenVal();

        curl_setopt($this->curl, CURLOPT_URL, $this->url."digital-accounts");
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$this->masterToken,
        ));
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($account));

        $temp = curl_exec($this->curl);
        $this->recipientToken = $temp['resourceToken'];
        $resp = json_decode($temp);

        return $resp;
    }

    public function consulta($cliente)
    {
        $this->isTokenVal();

        curl_setopt($this->curl, CURLOPT_URL, $this->url."digital-accounts");
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$cliente,
        ));

        $temp = curl_exec($this->curl);
        $resp = json_decode($temp);

        return $resp;
    }

    public function balanco()
    {
        $this->isTokenVal();

        curl_setopt($this->curl, CURLOPT_URL, $this->url."balance");
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$this->recipientToken,
        ));

        $temp = curl_exec($this->curl);
        $resp = json_decode($temp);

        return $resp->balance;
    }

    public function atualizarContaDigital($data){
        $this->isTokenVal();

        curl_setopt($this->curl, CURLOPT_URL, $this->url."digital-accounts");
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$this->recipientToken,
        ));

        var_dump(
            array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->token,
                "X-Api-Version: 2",
                "X-Resource-Token: ".$this->recipientToken,
            )
        );

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));

        $temp = curl_exec($this->curl);
        $resp = json_decode($temp);

        return $resp;
    }
    
    public function listDocumentos($token){
    		curl_setopt($this->curl, CURLOPT_URL, $this->url."documents");
            curl_setopt($this->curl, CURLOPT_POST, 0);
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->token,
                "X-Api-Version: 2",
                "X-Resource-Token: ".$token,
            ));

        $temp = curl_exec($this->curl);
        $resp = json_decode($temp);
        
        $ret = array();
        foreach($resp->_embedded->documents as $item){
					$ret[$item->id] = $item->description;
				}
        
        return $ret;
    }
    
    public function enviarDocumentos($img,$docID){
    		curl_setopt($this->curl, CURLOPT_URL, $this->url."documents/".$docID."/files");
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: multipart/form-data",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$this->recipientToken,
        ));
        
        $files = [
        	'files' => new \CurlFile($img,'img/jpeg',$docID.".jpeg")
        ];
        
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $files);

				#var_dump(curl_getinfo($this->curl));

        $temp = curl_exec($this->curl);
        $resp = json_decode($temp);
        
        return $resp;
    }

    public function consultarDocumentos($docID,$token=false){
        $recipientToken = ($token)?$token:$this->recipientToken;

        curl_setopt($this->curl, CURLOPT_URL, $this->url."documents/".$docID);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$recipientToken,
        ));

        $temp = curl_exec($this->curl);
        $resp = json_decode($temp);
        
        return $resp;
    }

    /* ========== Pagamento ========== */

    /*
        "charge" => array(
            "description" => "string",
            "totalAmount" => 0.01,
            "dueDate" => "yyyy-MM-dd",
            "installments" => 0,
            "maxOverdueDays" => 0,
            "fine" => 0,
            "interest" => "0.00",
            "discountAmount" => "0.00",
            "discountDays" => -1,
            "paymentTypes" => array(
                "BOLETO",
                "CREDIT_CARD"
            ),
            "split" => array()

        ),
        "billing" => array(
            "name" => "string",
            "document" => "string"
        )
    */
    public function criarCobrancas($pagamento){
        $this->isTokenVal();

        $pagamento['charge']['split'] = array(
            array(
                "recipientToken" => $this->masterToken, #empresa
                "percentage" => $this->taxa,
            ),
            array(
                "recipientToken" => $this->recipientToken, # usuario
                "percentage" => 100-$this->taxa,
                "amountRemainder" => true,
                "chargeFee" => true
            )
        );

        curl_setopt($this->curl, CURLOPT_URL, $this->url."charges");
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->token,
            "X-Api-Version: 2",
            "X-Resource-Token: ".$this->recipientToken,
        ));

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($pagamento));

        $temp = curl_exec($this->curl);
        $resp = json_decode($temp);

        return $resp;
    }

}

$juno = new Juno();

#$image = file_get_contents("img.png");
#$resp = $juno->enviarDocumentos($image,"doc_CF891066125DA606");

#$resp = $juno->listDocumentos();
#var_dump($resp);


