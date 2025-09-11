<?php
class CorredorDAO{
    public function __construct(){

    }
    
    public function getCorredores(PDO $pdo, $categoria){
        $query = "SELECT * FROM corredores WHERE categoria = :categoria";
        $corredores=[];
        $contador = 0;
        $state = $pdo->prepare($query);
        $state->bindValue("categoria", $categoria, PDO::PARAM_STR);
        $state->execute();
        $resultado = $state->fetchAll(PDO::FETCH_ASSOC);
        if($resultado == null){
            return null;
        }
        foreach($resultado as $result){
            $corredor = new Corredor($result["numero"],$result["nome"]);
            //$result["tempo_chegada"] = null;
            $corredor->setChegadaDAO($result["tempo_chegada"]);
            $corredor->setTempoCorridaDAO($result["tempo_percurso"]?? "");
            $corredor->setCategoria($result['categoria']);
            $corredores[$contador] = $corredor;
            $contador++;
        }
        return $corredores;
    }

    public function getCorredor(PDO $pdo, $numero, $categoria){
        $query = "SELECT * FROM corredores WHERE numero = :numero and categoria = :categoria";
        $state = $pdo->prepare($query);
        $state->bindValue('numero', $numero,PDO::PARAM_INT);
        $state->bindValue('categoria', $categoria ,PDO::PARAM_STR_CHAR);
        $state->execute();
        $dados = $state->fetch(PDO::FETCH_ASSOC);
        if($dados == null){
            return null;
        }
        $corredor = new Corredor($dados["numero"],$dados["nome"]);
        $corredor->setCategoria($dados["categoria"]);
        if($dados["tempo_chegada"] != null){
            $corredor->setChegadaDAO($dados["tempo_chegada"]);
            $corredor->setTempoCorridaDAO($dados["tempo_percurso"]);
        }
        return $corredor;
    }

    public function cadastrarCorredores(PDO $pdo, array $corredores, $categoria){
        $query = "INSERT INTO corredores(numero, nome, tempo_chegada, tempo_percurso,categoria) VALUES (:numero,:nome,:tempo_chegada,:tempo_percurso,:categoria)";
        foreach ($corredores as $corredor) {
            $state = $pdo->prepare($query);
            $state->bindValue("numero", $corredor->getNumero(),PDO::PARAM_INT);
            $state->bindValue("nome", $corredor->getNome(),PDO::PARAM_STR);
            $state->bindValue("tempo_chegada", null ,PDO::PARAM_NULL);
            $state->bindValue("tempo_percurso", null ,PDO::PARAM_NULL);
            $state->bindValue("categoria", $categoria, PDO::PARAM_STR);
            $state->execute();
        }
        return;
    }

    public function atualizarCorredor(PDO $pdo, $corredor, $categoria){
        $query = "UPDATE corredores SET tempo_chegada = :tempo_chegada, tempo_percurso = :tempo_percurso WHERE numero = :numero AND categoria = :categoria";
        $state = $pdo->prepare($query);
        $state->bindValue("tempo_chegada",$corredor->getChegadaFormatado(),PDO::PARAM_STR);
        $state->bindValue("tempo_percurso", $corredor->getTempoCorrida(),PDO::PARAM_STR);
        $state->bindValue("numero", $corredor->getNumero(),PDO::PARAM_INT);
        $state->bindValue("categoria", $categoria,PDO::PARAM_STR);
        $state->execute();
        return;
    }


    public function listarClassificacao(PDO $pdo, $categoria){
        $query = "SELECT * FROM corredores WHERE categoria = :categoria ORDER BY tempo_chegada DESC";
        $lista_classificados = [];
        $contador = 0;
        $state = $pdo->prepare($query);
        $state->bindValue("categoria", $categoria, PDO::PARAM_STR);
        $state->execute();
        $resultado = $state->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultado as $result){
            $corredor = new Corredor($result["numero"],$result["nome"]);
            $corredor->setChegadaDAO($result["tempo_chegada"]);
            $corredor->setTempoCorridaDAO($result["tempo_percurso"]?? "");
            $corredor->setCategoria($result["categoria"]);
            $lista_classificados[$contador] = $corredor;
            $contador++;
        }
        return $lista_classificados;
    }

    public function limparBanco(PDO $pdo, $categoria){
        $query = "delete from corredores WHERE categoria = :categoria";
        $state = $pdo->prepare($query);
        $state->bindValue('categoria', $categoria, PDO::PARAM_STR);
        $state->execute();
        return;
    }

    public function getTotalCorredores(PDO $pdo, $categoria){
        $query = "SELECT count(numero) as total FROM corredores WHERE categoria = :categoria";
        $state = $pdo->prepare($query);
        $state->bindValue("categoria", $categoria, PDO::PARAM_STR);
        $state->execute();
        $total = $state->fetch();
        return $total['total'];
    }

    public function getCorredoresConcluidos(PDO $pdo, $categoria){
        $query = "SELECT count(numero) as total FROM corredores WHERE tempo_chegada IS NOT NULL AND categoria = :categoria";
        $state = $pdo->prepare($query);
        $state->bindValue("categoria", $categoria,PDO::PARAM_STR);
        $state->execute();
        $total_concluido = $state->fetch();
        return $total_concluido['total'];
    }

    public function getCorredoresNaoConcluidos(PDO $pdo, $categoria){
        $query = "SELECT count(numero) as total FROM corredores WHERE tempo_chegada IS NULL AND categoria = :categoria";
        $state = $pdo->prepare($query);
        $state->bindValue("categoria", $categoria,PDO::PARAM_STR);
        $state->execute();
        $total_nconcluido = $state->fetch();
        return $total_nconcluido['total'];
    }


}