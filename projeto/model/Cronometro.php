<?php

class Cronometro{

    private ?DateTime $tempo_inicial; //Aceita tanto objeto DateTime quanto null
    private ?DateTime $tempo_final; //Aceita tanto objeto DateTime quanto null

    public function __construct(){
        $this->tempo_inicial = null;
        $this->tempo_final = null;
    }

    // GETTER

    public function getTempoInicial(){
        return $this->tempo_inicial;
    }

    // Usado para imprimir na interface do cliente o DateTime corretamente
    public function getTempoInicialFormatado(){
        return $this->tempo_inicial->format("H:i:s");
    }

    public function getTempoFinal(){
        return $this->tempo_final;
    }

    // Usado para imprimir na interface do cliente o DateTime corretamente
    public function getTempoFinalFormatado(){
        return $this->tempo_final->format("H:i:s");
    }

    //SETTER

    public function setTempoInicial(){
        $this->tempo_inicial = new DateTime();
    }

    public function setTempoFinal(){
        $this->tempo_final = new DateTime();
    }

    // Usado para definir manualmente o cronômetro pelo usuário
    public function setTempoInicialManual($tempo){
        $this->tempo_inicial = new DateTime($tempo);
    }

}


?>