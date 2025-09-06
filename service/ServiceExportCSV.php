<?php 

class ServiceExportCSV{
    public function registrarCorredores($categoria){
        global $pdo;
        $corredorDAO = new CorredorDAO();

        if($categoria == '1.5Km'){
            $arquivo = fopen(DOCS_SISTEMA.'\corredores_1.5km.csv','rw');
        }else{
            $arquivo = fopen(DOCS_SISTEMA.'\corredores_3km.csv','rw');
        }

        $cabecalhos = "Numero;Nome;Tempo de Corrida;Tempo de Chegada;\n";
        fwrite($arquivo,$cabecalhos);
        $dados = $corredorDAO->getCorredores($pdo,$categoria);
        foreach($dados as $dado){
            fwrite($arquivo, $dado->toString());
        }
        return;
}
}