
<?
require_once('../functions.php');

$arq = fopen('ProdutosAthena.csv','r');

while($row = fgetcsv($arq,10000,';')){
    #grupo
    $nGrupo = explode(' - ',$row[2])[1];
    $nSubgrupo = explode(' - ',$row[3])[1];

    #cliente
    $nCliente = explode(' - ',$row[4])[1];

    #unidade
    $nUn = $row[6];
    
    #fiscal
    $ncm = $row[5];
    $tributacao = explode(' - ',$row[9])[0];

    #produto
    $nome = $row[1];
    $status = $row[8]=='Ativo'?1:0;
    $dataCadastro = $row[11]; 
    switch($row[7]){
        case 'Semi-acabado':
            $tipoProduto = 1;
        break;
        case 'Acabado':
            $tipoProduto = 0;
        break;
        case 'Materia Prima':
            $tipoProduto = 2;
        break;
    }

    # grupo
    $resp = $con->query('select id from tbl_grupo where nome = "'.$nGrupo.'" and grupo = 0');
    if($resp->num_rows < 1){
        $con->query('insert into tbl_grupo(nome) value("'.$nGrupo.'")');
        $grupo = $con->insert_id;
    }
    else{
        $grupo = $resp->fetch_assoc()['id'];
    }

    $resp = $con->query('select id from tbl_grupo where nome = "'.$nSubgrupo.'" and grupo = '.$grupo);
    if($resp->num_rows < 1){
        $con->query('insert into tbl_grupo(nome,grupo) value("'.$nSubgrupo.'","'.$grupo.'")');
        $subgrupo = $con->insert_id;
    }
    else{
        $subgrupo = $resp->fetch_assoc()['id'];
    }

    # cliente
    $resp = $con->query('select id from tbl_clientes where razaoSocial_nome = "'.$nCliente.'"');
    if($resp->num_rows < 1){
        $con->query('insert into tbl_clientes(tipoPessoa,razaoSocial_nome,tipoCliente,tipoFornecedor,tipoFuncionario,tipoTecnico,status) value("PF","'.$nCliente.'",0,1,0,0,1)');
        $cliente = $con->insert_id;
    }
    else{
        $cliente = $resp->fetch_assoc()['id'];
    }

    # unidade
    $resp = $con->query('select id from tbl_unidades where simbolo = "'.$nUn.'"');
    if($resp->num_rows < 1){
        $con->query('insert into tbl_unidades(nome,simbolo,status) value("'.$nUn.'","'.$nUn.'",1)');
        $un = $con->insert_id;
    }
    else{
        $un = $resp->fetch_assoc()['id'];
    }

    # fiscal
    $con->query('insert into tbl_classificacaoFiscal(ncm,origem) value("'.$ncm.'","'.$tributacao.'")');
    $fiscal = $con->insert_id;
    
    $con->query('insert into tbl_produtos(nome,status,unidadeEstoque,grupo,subgrupo,fornecedor,usoConsumo,comercializavel,classificacaoFiscal,codBarras,dataCadastro,tipoProduto)values(
        "'.$nome.'",
        "'.$status.'",
        "'.$un.'",
        "'.$grupo.'",
        "'.$subgrupo.'",
        "'.$cliente.'",
        "0",
        "0",
        "'.$fiscal.'",
        "",
        "'.date('Y-m-d',strtotime($dataCadastro)).'",
        "'.$tipoProduto.'"
    )');
    var_dump($con->error);


    
    echo "<br>";
}

?>