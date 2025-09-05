<?php
require '../config/inicializador.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){ // Atende a somente formulário com method GET

    if(isset($_POST['registrar_corredores'])){
        try{

            $categoria = $_POST['tipo_corrida']; //Obtém a categoria
            $service_corredor->filtrarInputs($categoria); // Realiza uma filtragem por segurança

            // Aloca os dados da planilha como um array de objetos corredor e após isso os cadastrar no banco de dados e envia a lista para o cliente
            $service_corredor->importarPlanilhaCorredores($pdo, $_FILES['arquivo']['tmp_name'], $categoria);

            //Indica que a operação foi bem sucedida
            http_response_code(200);
        }catch(PDOException $pdoe){ // Caso ocorra alguma exceção no pdo ou banco de dados

            // Caso tenha alguma transação cancela ela
            if($pdo->inTransaction()){ $pdo->rollBack(); }
            // Registra nas logs o erro ocorrido
            $exception_service->resistrarDataBaseErros($pdoe);
            $_SESSION['mensagem'] = "Houve um erro na base de dados!";
            // Indica que houve um erro interno no servidor
            http_response_code(500);

        }catch(Exception $e){ //Caso ocorra alguma exceção 
            // Registra nas logs o erro ocorrido
            $exception_service->registrarCorredorErros($e);
            $_SESSION['mensagem'] = "Erro ao analisar a tabela, verifique o arquivo!";
            // Indica que houve um erro interno no servidor
            http_response_code(500);

        }finally{ // Por fim sempre redireciona para a página em que o usuário estava
            header(("Location: ../view/importar.php"));
            exit();
        }

    }else if(isset($_POST['registrar_chegada'])){
        try{
            $cronometro = isset($_SESSION['cronometro']) != null ? unserialize($_SESSION['cronometro']) : null; // Obtém o cronômetro

            $numero_corredor = $_POST['numero_corredor']; // Obtém o número do corredor

            $service_corredor->filtrarInputs($numero_corredor); // Valida o input do usuário por segurança

            $categoria = $_SESSION['corrida_atual']; // Obtém a categoria atual de corredores

            // Registra o corredor e então obtém uma nova lista com atualizada
            $service_corredor->registrarChegadaCorredor($pdo, $cronometro, $numero_corredor, $categoria); 

            // Indica sucesso na operação
            http_response_code(200);
        
        }catch(PDOException $pdoe){ // Caso ocorra alguma exceção no pdo ou banco de dados
            
            // Caso tenha alguma transação cancela ela
            if($pdo->inTransaction()){ $pdo->rollBack(); }
            // Registra nas logs o erro ocorrido
            $exception_service->resistrarDataBaseErros($pdoe);
            $_SESSION['mensagem'] = "Houve um erro na base de dados!";
            // Indica que houve um erro
            http_response_code(500);

        }catch(Exception $e){ //Caso ocorra alguma exceção 

            // Registra nas logs o erro ocorrido
            $exception_service->registrarCorredorErros($e);
            $_SESSION['mensagem'] = "Houve um erro ao cadastrar o corredor!";
            // Indica que houve um erro interno
            http_response_code(500);

        }finally{
            header('Location: ../view/corredores.php');
            exit();
        }

    }else if(isset($_POST['limpar_banco_dados'])){
        try{
            
            $categoria = $_POST['banco']; // Obtém qual categoria de corredores quer detelar

            $service_db->filtrarInputs($categoria); // Filtra por segurança

            $service_db->limparBancoDados($pdo, $categoria); // Deleta os corredores de acordo com a categoria

            // Indica que a operação foi concluida
            http_response_code(200);

        }catch(PDOException $pdoe){ // Caso ocorra alguma exceção no pdo ou banco de dados

           // Caso tenha alguma transação cancela ela
            if($pdo->inTransaction()){ $pdo->rollBack(); }
            // Registra nas logs o erro ocorrido
            $exception_service->resistrarDataBaseErros($pdoe);
            $_SESSION['mensagem'] = "Houve um erro na base de dados!";
            // Indica que houve um erro
            http_response_code(500);

        }catch(Exception $e){ //Caso ocorra alguma exceção 

            // Registra nas logs o erro ocorrido
            $exception_service->registrarCorredorErros($e);
            $_SESSION['mensagem'] = "Houve um erro interno!";
            // Indica que houve um erro interno
            http_response_code(500);

        }finally{
            header(("Location: ../view/importar.php"));
            exit();
        }
    }
    
}else if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(isset($_GET['listar_classificacao'])) {
        try{
            
            $categoria = $_GET['tipo_corrida'];
            $service_corredor->filtrarInputs($categoria);

            $service_corredor->listarClassificacaoCorredores($pdo,$categoria);
            http_response_code(200);

        }catch(PDOException $pdoe){ // Caso ocorra alguma exceção no pdo ou banco de dados

            if($pdo->inTransaction()){ $pdo->rollBack(); }
            $exception_service->resistrarDataBaseErros($pdoe);
            $_SESSION['mensagem'] = "Houve um erro na base de dados!";
            http_response_code(500);

        }catch(Exception $e){ //Caso ocorra alguma exceção 

            $exception_service->registrarCorredorErros($e);
            $_SESSION['mensagem'] = "Erro ao listar os classificados!";
            http_response_code(500);

        }finally{
            header("Location: ../view/classificados.php");
            exit();
        }
    }else if(isset($_GET['trocar_corrida'])){
            try{

                $categoria = $_GET['tipo_corrida']; //Obtém a categoria

                $service_corredor->filtrarInputs($categoria); // Realiza uma filtragem por segurança

                $service_corredor->trocarCategoriaCorrida($categoria); // Obtém a lista de corredores de acordo com a categoria
            //Indica que a operação foi bem sucedida
                http_response_code(200);

            }catch(PDOException $pdoe){ // Caso ocorra alguma exceção no pdo ou banco de dados

                // Caso tenha alguma transação cancela ela
                if($pdo->inTransaction()){ $pdo->rollBack(); }
                // Registra nas logs o erro ocorrido
                $exception_service->resistrarDataBaseErros($pdoe);
                $_SESSION['mensagem'] = "Houve um erro na base de dados!";
                // Indica que houve um erro interno no servidor
                http_response_code(500);

            }catch(Exception $e){ //Caso ocorra alguma exceção 

                // Registra nas logs o erro ocorrido
                $exception_service->registrarCorredorErros($e);
                $_SESSION['mensagem'] = "Erro ao trocar a corrida!";
                // Indica que houve um erro interno no servidor
                http_response_code(500);

            }finally{
                header("Location: ../view/corredores.php");
                exit();
            }
    }else{
        http_response_code(405);
        header("Location: ../view/classificados.php");
        exit();
    }
}
?>