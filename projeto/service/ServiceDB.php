<?php 

class ServiceDB{
    public function __construct(){

    }

    public function filtrarInputs($input){
        switch(gettype($input)){
            case 'integer':
                $input = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
                break;
            case 'string':
                $input = filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS);
                break;
            case 'double':
                $input = filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT);
                break;
        }
        return $input;
    }

    public function limparBancoDados($pdo, $categoria){
         // Instancia os objetos
        $corredorDAO = new CorredorDAO();

        // Deleta os dados do banco de dados de acordo com o tipo de corrida!
        $corredorDAO->limparBanco($pdo, $_POST['banco']);

        // Personaliza a mensagem de acordo com a opção de deletar selecionada
        if($_POST['banco'] == '3km'){
            $_SESSION['mensagem'] = "Dados 3km deletados!";
        }else{
            $_SESSION['mensagem'] = "Dados 1.5km deletados!";
        }

        // Define a lista de corredores como nula para outras partes do sistema
        $_SESSION['corredores'] = null;
    }
}