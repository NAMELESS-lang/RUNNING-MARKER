<?php
// Defino o tempo de vida útil da sessão no servidor e do cookie do cliente para 1h
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
// Caso o usuário se desconecte, continua executando o código
ignore_user_abort(true);
session_start();

// Importa as configurações do sistema
require 'configuracoes.php';

// Realiza o import das classes de model e service
spl_autoload_register(function($class){    
    if(file_exists(RAIZ_SISTEMA."\model\\".$class.".php")){
        require RAIZ_SISTEMA."\model\\".$class.".php";
    }else if(file_exists(RAIZ_SISTEMA."\service\\".$class.".php")){
        require RAIZ_SISTEMA."\service\\".$class.".php";
    };
});

// Instancia os objetos
$service_corredor = new ServiceCorredor();
$service_db = new ServiceDB();
$service_cronometro = new ServiceCronometro();
$service_csv = new ServiceExportCSV();
$exception_service = new ExceptionService();
$pdo = new PDO($db_url,$usuario,$senha);


// Defina uma função para tratamento de erros que também são registrados nos arquivos de logs
function tratar_erros($tipo, $menssagem, $arquivo = '', $linha = 0){
    global $exception_service;
    $exception_service->registrarErrosFataiseNaoFatais(throw new ErrorException($menssagem,0,$tipo,$arquivo,$linha));
}


function tratar_erro_fatal(){
    global $exception_service; 
    $erro = error_get_last();
    if($erro){
        $exception_service->registrarErrosFataiseNaoFatais(new ErrorException($erro['message'],0,$erro['type'],$erro['file'],$erro['line']));
    }
}

// Define que a função acima é a padrão para tratamento de erros
set_error_handler('tratar_erros');
register_shutdown_function('tratar_erro_fatal');







?>