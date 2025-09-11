<?php

class ExceptionService{

    public function __construct(){

    }

    public function registrarCorredorErros(Exception $e){
        $arquivo_log = fopen(LOGS_SISTEMA.'\corredor.log','a');
        $momento_erro = new DateTime();
        
        $momento_erro_formatado = "Data:".$momento_erro->format('d/m/y'). " horário: ".$momento_erro->format('h:i:s')."\n";

        $erro = "Erro: ".$e->getMessage()."\n";

        $linha = "Linha: ".$e->getLine()."\n";

        $arquivo = "Arquivo: ".$e->getFile()."\n";


        fwrite($arquivo_log, $momento_erro_formatado);
        fwrite($arquivo_log, $erro);
        fwrite($arquivo_log, $linha);
        fwrite($arquivo_log, $arquivo);
        fwrite($arquivo_log, " \n");

        fclose($arquivo_log);
    }

    public function registrarCronometroErros(Exception $e){
        $arquivo_log = fopen(LOGS_SISTEMA.'\cronometro.log','a');
        $momento_erro = new DateTime();
        
        $momento_erro_formatado = "Data:".$momento_erro->format('d/m/y'). " horário: ".$momento_erro->format('h:i:s')."\n";

        $erro = "Erro: ".$e->getMessage()."\n";

        $linha = "Linha: ".$e->getLine()."\n";

        $arquivo = "Arquivo: ".$e->getFile()."\n";


        fwrite($arquivo_log, $momento_erro_formatado);
        fwrite($arquivo_log, $erro);
        fwrite($arquivo_log, $linha);
        fwrite($arquivo_log, $arquivo);
        fwrite($arquivo_log, " \n");


        fclose($arquivo_log);
    }

    public function resistrarDataBaseErros(PDOException $pdoe){
        $arquivo_log = fopen(LOGS_SISTEMA.'\database.log','a');
        $momento_erro = new DateTime();
        
        $momento_erro_formatado = "Data:".$momento_erro->format('d/m/y'). " horario: ".$momento_erro->format('h:i:s')."\n";

        $erro = "Erro: ".$pdoe->getMessage()."\n";

        $linha = "Linha: ".$pdoe->getLine()."\n";

        $arquivo = "Arquivo: ".$pdoe->getFile()."\n";


        fwrite($arquivo_log, $momento_erro_formatado);
        fwrite($arquivo_log, $erro);
        fwrite($arquivo_log, $linha);
        fwrite($arquivo_log, $arquivo);
        fwrite($arquivo_log, " \n");

        fclose($arquivo_log);
    }

    public function registrarErrosFataiseNaoFatais(ErrorException $e){
        $arquivo_log = fopen(LOGS_SISTEMA.'\erros_fatais_nfatais.log','a');

        $momento_erro = new DateTime();
        
        $momento_erro_formatado = "Data:".$momento_erro->format('d/m/y'). " horário: ".$momento_erro->format('h:i:s')."\n";

        $erro = "Erro: ".$e->getMessage()."\n";

        $linha = "Linha: ".$e->getLine()."\n";

        $arquivo = "Arquivo: ".$e->getFile()."\n";


        fwrite($arquivo_log, $momento_erro_formatado);
        fwrite($arquivo_log, $erro);
        fwrite($arquivo_log, $linha);
        fwrite($arquivo_log, $arquivo);
        fwrite($arquivo_log, "\n");

        fclose($arquivo_log);
    }

}