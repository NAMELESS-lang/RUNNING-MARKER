<?php 


class ServiceCorredor{
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



    public function importarPlanilhaCorredores($pdo, $aquivo_formulario, $categoria){
        if($aquivo_formulario == null){
            $_SESSION['mensagem'] = "Nenhum arquivo inserido!";
            return;
        }
        // Instancia os objetos necessários
        $corredorDAO = new CorredorDAO();
        // Move o arquivo do espaço temporário e abre ele
        $arquivo = fopen($aquivo_formulario, "r");

        // Cria a lista de corredores e o contador que irá alocando conforme são armazenados os objetos na lista
        $corredores = [];
        $contador = 0;
        
        // Percorre cada linha e coluna e instancia um objeto da classe corredor
        while (($linha = fgetcsv($arquivo, 1000, ";", '"', "\\")) !== FALSE) {
            $this->filtrarInputs($linha[0]);
            $this->filtrarInputs($linha[1]);
            $corredores[$contador] = new Corredor($linha[0], $linha[1]);
            $contador++;
        }

        // Fecha a abaertura do arquivo
        fclose($arquivo);

        // Cadastra no banco de dados de acordo com o tipo de corrida selecionado
        $corredorDAO->cadastrarCorredores($pdo, $corredores, $categoria);

        // Define a mensagem de retorno e qual tipo de corrida está definida inicialmente após importar os dados da planilha
        if($_POST['tipo_corrida'] == '1.5km'){
            $_SESSION['mensagem'] = "Corredores de 1.5km importados com sucesso!";
            $_SESSION['corrida_atual'] = '1.5km';
        }else{
            $_SESSION['mensagem'] = "Corredores de 3km importados com sucesso!";
            $_SESSION['corrida_atual'] = '3km';
        }
    }

    public function trocarCategoriaCorrida($categoria){
        // Serializa a lista de objetos e define o tipo de corrida e a mensagem para o usuário
        $_SESSION['mensagem'] = "Categoria de corrida trocada com sucesso!";
        $_SESSION['corrida_atual'] = $categoria;
        return;
    }

    public function registrarChegadaCorredor($pdo, $cronometro, $numero_corredor, $categoria){
          // Instancia os objetos
        $corredorDAO = new CorredorDAO();

        // Se o contador de tempo não estiver definido, não realiza a operação e notifica o usuário
        if($cronometro == null){
            $_SESSION['mensagem'] = "Inicie o cronômetro para registrar a chegada!";
            return;
        }

        // Se o tempo tempo final estiver definido não permite mais registrar chegada
        if($cronometro != null && $cronometro->getTempoFinal()){
            $_SESSION['mensagem'] = "Cronômetro finalizado, não pode mais registrar a chegada!";
            return;
        }

        $corredor = $corredorDAO->getCorredor($pdo, $numero_corredor, $categoria);
            // Se o numero definido pelo usuário for o do corredor
            if($corredor != null){
                // Se o tempo de chagada deste corredor não for nula, cancela a operação e notifica o usuário de que já foi definido a chegada dele
                if($corredor->getChegada() != null){
                    $_SESSION['mensagem'] = "Chegada já cadastrada para o corredor n° ".$corredor->getNumero();
                    return;
                }

                // Define o horário de chagada e tempo de corrida
                $corredor->setChegada();
                $corredor->setTempoCorrida($cronometro->getTempoInicial());

                //Atualiza no banco de dados o corredor e obtém a lista atualizada com o horário dele
                $corredorDAO->atualizarCorredor($pdo, $corredor,$categoria);

                // Serializa a lista e cria uma mensagem ao usuário
                $_SESSION['mensagem'] = "Corredor n° ".$corredor->getNumero()." Registrado!";
                $_SESSION['corredor_registrado'] = serialize($corredor);
                return;
            }

        // Caso não tenha encotrado o número do corredor na lista, não realiza nenhuma operação e apenas notifica o usuário
        $_SESSION['mensagem'] = "Corredor n° ".$numero_corredor." não encontrado!";
        return;
    }

    public function listarClassificacaoCorredores($pdo, $categoria){
        // Instancia os objetos
        $corredorDAO = new CorredorDAO();

        // Obtém a lista de classificação de acordo com qual corrida desejada
        $lista_classificacao = $corredorDAO->listarClassificacao($pdo, $categoria);
        // Se a lista não estiver vazia notifica o sucesso obtenção dos dados e envia a lista
        if($lista_classificacao != null){
            $_SESSION['mensagem'] = "Listado com sucesso!";
            $_SESSION['lista_classificacao'] = serialize($lista_classificacao);
        }else{
            $_SESSION['mensagem'] = "Nenhum corredor encontrado para a categoria de corrida selecionada!";
            $_SESSION['lista_classificacao'] = null;
        }
        return;
    }


    public function obterRelatorioCategoriaCorrida($pdo, $categoria){
        $corredorDAO = new CorredorDAO();

        $_SESSION['total_corredores'] = $corredorDAO->getTotalCorredores($pdo, $categoria);
        $_SESSION['chegada_registrada'] = $corredorDAO->getCorredoresConcluidos($pdo, $categoria);
        $_SESSION['chegada_nao_registrada'] = $corredorDAO->getCorredoresNaoConcluidos($pdo, $categoria);
        return;
    }
}