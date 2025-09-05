<?php 

class ServiceCronometro{

    public function __construct(){
        
    }

    public function iniciarCronometro(){
        // Instancia o objeto Cronometro e define o tempo inicial
            $cronometro = new Cronometro();
            $cronometro->setTempoInicial();

            // Notifica o usuário do sucesso e serializa o cronômetro
            $_SESSION['cronometro'] = serialize($cronometro);
            $_SESSION['mensagem'] = "Cronômetro iniciado!";
    }

    public function finalizarCronometro(){
         // Verifica se o cronômetro foi iniciado primeiramente, caso não, notifica o usuário
        if(!isset($_SESSION['cronometro'])){
            $_SESSION['mensagem'] = "Cronômetro não iniciado, inicie-o primeiramente!";
            return;
        }

        // Obtém o cronômetro e caso já esteja finalizado notifica o usuário
        $cronometro = unserialize($_SESSION['cronometro']);
        if($cronometro->getTempoFinal() != null){
            $_SESSION['mensagem'] = "Cronômetro já finalizado!";
            return;
        }

        // Define o tempo final, caso não entrou em nenhuma condição anterior
        $cronometro->setTempoFinal();
        // Notifica o usuário
        $_SESSION['mensagem'] = "Cronômetro finalizado!";
        $_SESSION['cronometro'] = serialize($cronometro);
        return;
    }

    public function definirTempoInicialManualmente(){
        // Obtém os dados do formulário e constrói uma string da seguinte forma: hora:minuto:segundo
        if($_POST['hora'] == "" || $_POST['minuto'] == "" || $_POST['segundo'] == ""){
            $_SESSION['mensagem'] = "Preencha todos os campos!";
            return;
        }
        $tempo = $_POST['hora'].":".$_POST['minuto'].":".$_POST['segundo'];
        // Instancia um novo contador de tempo e define o tempo inicial com a string formada
        $cronometro = new Cronometro();
        $cronometro->setTempoInicialManual($tempo);

        // Notifica o usuário
        $_SESSION['cronometro'] = serialize($cronometro);
        $_SESSION['mensagem'] = "Definido manualmente com sucesso!";
    }

}