<?php
require '../config/inicializador.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['iniciar_cronometragem'])){
        try{

            // Inicia o cronometro  manualmente
            $service_cronometro->iniciarCronometro();

            //Envia-o para o usuário
            header("Location: ../view/corredores.php");
            exit();
            // Indica que a operação foi bem sucedida
            http_response_code(200);
            
            }
        catch(Exception $e){

            $exception_service->registrarCronometroErros($e);
            $_SESSION['mensagem'] = "Houve algum erro na inicialização do cronômetro!";
            header("Location: ../view/corredores.php");
            http_response_code(500);
            exit();
        }

    }else if(isset($_POST['finalizar_cronometragem'])){
        try{

            // Inicia o cronometro  manualmente
            $service_cronometro->finalizarCronometro();
            header("Location: ../view/corredores.php");
            exit();
             // Indica que a operação foi bem sucedida
            http_response_code(200);

        }catch(Exception $e){
            $exception_service->registrarCronometroErros($e);
            $_SESSION['mensagem'] = "Houve algum erro na finalização do cronômetro!";
            header("Location: ../view/corredores.php");
            http_response_code(500);
            exit();
        }

    }else if(isset($_POST['cronometro_manualmente'])){
        try{

            // Inicia o cronometro  manualmente
            $service_cronometro->definirTempoInicialManualmente();
            header('Location: ../view/corredores.php');
            exit();
            // Indica que a operação foi bem sucedida
            http_response_code(200);
        
        }catch(Exception $e){
            $exception_service->registrarCronometroErros($e);
            $_SESSION['mensagem'] = "Erro ao definir o cronômetro!";
            http_response_code(500);
        }
    }
    
}
?>