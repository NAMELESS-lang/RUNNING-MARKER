<?php
class Corredor{
    private int $numero;
    private String $nome;
    private ?DateTime $chegada;
    private ?String $tempo_corrida;
    private ?String $categoria;

    public function __construct(int $numero, String $nome){
        $this->numero = $numero;
        $this->nome = $nome;
        $this->chegada = null;
        $this->tempo_corrida = null;
        $this->categoria = null;
    }

    // GETTER

    public function getNumero(){
        return $this->numero;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getChegada(){
        return $this->chegada;
    }

    public function getChegadaFormatado(){
        return $this->chegada->format("H:i:s");
    }

    public function getTempoCorrida(){
        return $this->tempo_corrida;
    }

    public function getCategoria(){
        return $this->categoria;
    }

    // SETTER

    public function setTempoCorridaDataBase($data){
        $this->tempo_corrida = $data;
    }

    public function setChegadaDAO($dado_db){
        if($dado_db == null){
            $this->chegada = null; 
            return;   
        }
        $this->chegada = new DateTime($dado_db);
    }

    public function setChegada(){
        $this->chegada = new DateTime();
    }

     public function setTempoCorrida(DateTime $inicio){
        $tempo = $this->chegada->diff($inicio);
        $this->tempo_corrida = $tempo->format("%H:%I:%S");
    }

    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }

    public function toString(){
        return $this->numero.";".$this->nome.";".$this->tempo_corrida.";".$this->chegada."\n";
    }
}