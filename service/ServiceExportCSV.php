<?php 

class ServiceExportCSV{
    public function registrarCorredor($categoria, $dados){
        if($categoria == '1.5Km'){
            $arquivo = fopen(DOCS_SISTEMA.'\corredores_1.5km.csv','rw');
        }else{
            $arquivo = fopen(DOCS_SISTEMA.'\corredores_3km.csv','rw');
        }
}
}