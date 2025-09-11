<?php 

class ServiceExportCSV{
    public function registrarCorredores($pdo,$categoria){
        $corredorDAO = new corredorDAO();
        //De acordo com a categoria abre o arquio específico
        if($categoria == '1.5km'){
            $arquivo = fopen(DOCS_SISTEMA.'\corredores_1.5km.csv','a');
        }else{
            $arquivo = fopen(DOCS_SISTEMA.'\corredores_3km.csv','a');
        }
        // Obtém a lista de corredores do banco de dados
        $dados = $corredorDAO->listarClassificacao($pdo, $categoria);

        // Caso não encontrar nenhum notifica o usuário
        if($dados == null){
            $_SESSION['mensagem'] = "Nenhum corredor da categoria de ".$categoria." para importar";
            return;
        }

        // Escreve o cabeçalho do arquivo
        $cabecalho = "Colocação;Número;Nome;Horário de chegada;Tempo de corrida;Categoria;\n";
        $contador=1;
        fwrite($arquivo, $cabecalho);
        // Percorre cada objeto corredor e escreve ele no arquivo
        foreach($dados as $dado){
            fwrite($arquivo, $contador.";");
            fwrite($arquivo, $dado->corredorToCsv());
            $contador++;
        }

        // Fecha o arquivo e notifica o usuário
        fclose($arquivo);
        $_SESSION['mensagem'] = "Corredores de ".$categoria." exportados com sucesso!";
        return;
}
    public function limparArquivo($categoria){
        if($categoria == '1.5km'){
            $arquivo = fopen(DOCS_SISTEMA.'\corredores_1.5km.csv','w');
        }else{
            $arquivo = fopen(DOCS_SISTEMA.'\corredores_3km.csv','w');
        }
        fclose($arquivo);
    }
}