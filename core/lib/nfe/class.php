<?

class Nfe
{

    private $nfe;

    function __construct($debug=true){
        $this->nfe = new Make();
    }

    public function gerarXML(){
        
        // cabeçalho da nota
        $taginfNFe = array(
            'versao' => '4.00', // versão do layout
            'Id' => null, // ID da nota, passar null para gerar automaticamente
            'pk_nItem' => null // deixar sempre como null
        );

        // informações da nota
        $tagide = array(
            'cUF' => 35, // código da unidade federativa 
            'cNF' => '80070008', // numero aleatório gerado para cada nfe
            'natOp' => 'VENDA', // natureza da operação: venda, compra, transferência, devolução, importação, consignação, remessa
            'mod' => 55, // modelo da nota: 55 para NFe e 65 para NFCe
            'serie' => 1, // série da nota
            'nNF' => 1, // número da nota
            'dhEmi' => '2018-07-27T20:48:00-02:00', // data e hora da emissão 
            'dhSaiEnt' => '2018-07-27T20:48:00-02:00', // data e hora da entrada ou saida
            'tpNF' => 1, // tipo da nota: 1 para saida e 0 para entrada
            'idDest' => 1, // id do destino
            'cMunFG' => 3506003, //código IBGE da cidade de emissão
            'tpImp' => 1, // tipo de impressão
            'tpEmis' => 1, // tipo de emissão: 1 = Emissão normal (não em contingência), 2 = Contingência FS-IA, com impressão do DANFE em formulário de segurança, 3 = Contingência SCAN (Sistema de Contingência do Ambiente Nacional), 4 = Contingência DPEC (Declaração Prévia da Emissão em Contingência), 5 = Contingência FS-DA, com impressão do DANFE em formulário de segurança, 6 = Contingência SVC-AN (SEFAZ Virtual de Contingência do AN), 7 = Contingência SVC-RS (SEFAZ Virtual de Contingência do RS)   
            'cDV' => 2, // digito verificador
            'tpAmb' => 2, // Se deixar o tpAmb como 2 você emitirá a nota em ambiente de homologação(teste) e as notas fiscais aqui não tem valor fiscal
            'finNFe' => 1, // finalidade da NFe: 1 normal, 2 suplementar, 3 ajuste, 4 devolução 
            'indFinal' => 0, // consumidor final: 0 para não, 1 para sim
            'indPres' =>  0, // indica presença do consumidor no local da compra: 0 não se aplica, 1 operação presencial, 2 operação pela internet, 3 operação por televenda, 4 operação com entrega a domicilio, 5 presencial, mas fora do estabelecimento, 9 outros
            'procEmi' => '0',
            'verProc' => 1
        );

        // informação do emitente
        $tagemit = array(
            'xNome' => 'b-cup estampas', // nome do cliente
            'IE' => '35090217000114', // inscrição estadual do cliente
            'CRT' => 1, // código de regime tributário: 1 para simples, 2 pra excesso sublime de receita bruta, 3 regime normal
            'CNPJ' => '35090217000114' // CNPJ da empresa
        );

        // informação de endereço do destinatário
        $tagenderDest = array(
            'xLgr' => '', // nome da rua do destinatário
            'nro' => '', // número da casa do destinatário
            'xBairro' => '', // nome do bairro
            'cMun' => '', // código do município no IBGE
            'xMun' => '', // nome do município
            'UF' => '', // unidade federativa
            'CEP' => '', // CEP
            'cPais' => '', // código do pais
            'xPais' => '' // nome do pais
        );

        # -- início dos produtos -- #

        // informação sobre o produto N
        $tagprod = array(
            'item' => 1, // contador de itens
            'cEAN' => 'SEM GTIN', // código de barras
            'cEANTrib' => 'SEM GTIN', // código de barras
            'cProd' => '0001', // código do produto
            'xProd' => 'produto de teste', // nome do produto
            'NCM' => '84669330', // NCM do produto 
            'CFOP' => '5102', // CFOP do produto
            'uCom' => 'PÇ', // unidade comercial
            'qCom' => '1.0000', // quantidade comercial
            'vUnCom' => '10.99', // valor unitário
            'vProd' => '10.99', // valor total do produto
            'uTrib' => 'PÇ', // unidade tibutável 
            'qTrib' => '1.0000', // quantidade tributável
            'vUnTrib' => '10.99', // valor unitário tributável
            'indTot' => 1
        );

        // imposto do produto N
        $tagimposto = array(
            'item' => 1, // id do item N
            'vTotTrib' => 10.99, // valor tota a ser tributado
        );

        // ICMS do produto N
        $tagICMS = array(
            'item' => 1, // id do item N
            'orig' => 0, // origem do produto
            'CST' => '00', // CST do produto
            'modBC' => 0, // 
            'vBC' => '0.20', // valor de base de calculo
            'pICMS' => '18.0000', // porcentagem de icms do produto
            'vICMS' => '0.04' // valor do icms do produto
        );

        // IPI do produto N
        $tagIPI = array(
            'item' => 1, // id do item N
            'cEnq' => 999, // código do ipi
            'CST' => '50', // código do CST
            'vIPI' => 0, // valor do IPI
            'vBC' => 0, // valor da base de cálculo
            'pIPI' => 0, //
        );

        // PIS do produto N
        $tagPIS = array(
            'item' => 1, // id do item N
            'CST' => '07', // código do CST
            'vBC' => 0, // valor da base de cálculo
            'pPIS' => 0, //
            'vPIS' => 0, // valor do PIS
        );

        // COFINS ST do produto N
        $tagCOFINS = array(
            'item' => 1, // id do item N
            'CST' => '01', // código do CST
            'vBC' => 0, // valor da base de cálculo
            'pCOFINS' => 0, //
            'vCOFINS' => 0, // valor do COFINS
            'qBCProd' => 0, //
            'vAliqProd' => 0
        );

        # -- fim produtos -- #

        // ICMS total
        $tagICMSTot = array(
            'vBC' => '0.20', // valor da base de calculos
            'vICMS' => '', // valor total do ICMS
            'vICMSDeson' => '', //
            'vBCST' => '', // valor da base de calculo do ST
            'vST' => '', // valor ST
            'vProd' => '', // valor do produto
            'vFrete' => '', // valor do frete
            'vSeg' => '', // valor do seguro
            'vDesc' => '', // valor do desconto
            'vII' => '', // valor do II
            'vIPI' => '', // valor do IPI
            'vPIS' => '', // valor do PIS
            'vCOFINS' => '', // valor do COFINS
            'vOutro' => '', // valor do outros
            'vNF' => '', // valor final da NF total de produtos mais total de impostos
            'vTotTrib' => '' // valor total tributavel
        );

        // Informações do transporte
        $tagtransp = array(
            'modFrete' => 1 // modalidade do frete: 0 frete remetente, 1 frete destinatário, 2 frete terceiros, 3 próprio remetente, 4 próprio destinatário, 9 sem transporte
        )

        // informações do volume do item N
        $tagvol = array(
            'item' => 1, // código do produto N
            'qVol' => 2, // quantidade do volume
            'esp' => 'caixa', //
            'marca' => 'OLX', //
            'nVol' => '11111', //
            'pesoL' => 10.00, // peso liquido do produto
            'pesoB' => 11.00, // peso bruto do produto
        );

        // informações da fatura
        $tagfat = array(
            'nFat' => '002', // numero da fatura
            'vOrig' => 100, // valor original da fatura
            'vLiq' => 100 // valor liquido da fatura
        );

        // informações de parcelas
        $tagdup = array(
            'nDup' => '001', // número da parcela
            'dVenc' => date('Y-m-d'), // data do vencimento da parcela
            'vDup' => 11.03, // valor da parcela
        );

        // informação do troco
        $tagpag = array(
            'vTroco' = 0 // valor do troco
        );

        // informação do pagamento
        $tagdetPag = array(
            'indPAg' => 0, // indicador da forma de pagamento: 0 para pagamento à vista, 1 para pagamento percelado
            'tPag' => '01', // tipo de pagamento: 01 para dinheiro, 02 por cheque, 03 por cartão de crédito, 04 para débito, 05 para crédito loja, 10 para vale alimentação, 11 para vale refeição, 12 para vale presente, 13 para vale combustivel, 15 para boleto, 90 sem pagamento, 99 outros
            'vPag' => 10.99, // valor do pagamento
        );

    }

}

?>