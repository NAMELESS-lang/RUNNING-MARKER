<?php 
require_once '../config/inicializador.php';

if(isset($_SESSION['corredor_registrado'])){
  $corredor =   unserialize($_SESSION['corredor_registrado']);
}else{ 
    $corredor = null; 
};
$cronometro  = isset($_SESSION['cronometro']) ? unserialize($_SESSION['cronometro']) : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista corredores</title>
    <link rel="stylesheet" href="../style/corredores.css">
</head>
<body>

    <!-- TÍTULO -->

    <header>
        <h1>RUNNING MARKER</h1>
    </header>

    <!-- LINKS-->

    <div>
        <a href="importar.php">Importar planilha</a>
    </div>

    <!-- NOTIFICAÇÃO -->
    <h2><?= htmlspecialchars(isset($_SESSION['mensagem'])? $_SESSION['mensagem'] : "") ?></h2>

    <!-- PRINCIPAL-->

    <main>
        <h1>MARCADOR</h1>
        <form class="registrar_chegada" action="../controller/controlador_corredor.php" method="POST">
            <label for="numero_corredor">Número corredor: </label>
            <input type="number" name ="numero_corredor" min="0">
            <button type="submit" name="registrar_chegada" value="registrar_chegada">Registrar chegada</button>
        </form>
        <div class="rel_cronometro">
            <h4>Início da cronometragem:</h4>
            <p><?= htmlspecialchars(isset($_SESSION['cronometro']) ? $cronometro->getTempoInicialFormatado() : "") ; ?></p>
            <h4>Fim da cronometragem:</h4>
            <p><?php if(isset($_SESSION['cronometro'])){
                    if($cronometro->getTempoFinal() == null){
                       echo null;
                }else{
                    echo htmlspecialchars($cronometro->getTempoFinalFormatado());
                }
            }
            ?></p>
        </div>
        <div class="div_total">
            <div class="div_cronometro">
                <h3>Cronômetro</h3>
                <form action="../controller/controlador_cronometro.php" method="POST">
                    <button class="iniciar" type="submit" name="iniciar_cronometragem" value="iniciar_cronometragem">Iniciar cronometragem</button>
                    <button class="finalizar" type="submit" name="finalizar_cronometragem" value="finalizar_cronometragem">Finalizar cronometragem</button>
                    <div class='div_cronometro_manual'>
                        <label for="hora">H:</label>
                        <input type="" name="hora">
                        <label for="minutos">M:</label>
                        <input type="" name="minuto">
                        <label for="segundos">S:</label>
                        <input type="" name="segundo">
                    </div>
                    <button class="redefir_cronometro_button" type="submit" name="cronometro_manualmente" value="cronometro_manualmente">Definir manualmente</button>
                </form>
            </div>

            <form class='seletor_corrida' action="../controller/controlador_corredor.php" method="GET">
                <label for="tipo_corrida">Categoria de corrida:</label>
                <select name="tipo_corrida">
                    <option value="1.5Km">1.5Km</option>
                    <option value="3Km">3km</option>
                </select>
                <button type="submit" name="trocar_corrida" value="trocar_corrida">Trocar Categoria</button>
            </form>

           <div class="div_relatorios">
            <div class="dados_gerais">
                <div class="valores">
                    <h4>Categoria selecionada</h4>
                    <p><?= isset($_SESSION['corrida_atual']) ? $_SESSION['corrida_atual'] : "S/R"?></p>
                </div>
                <div class="valores">
                    <h4>Total de corredores</h4>
                    <p><?= isset($_SESSION['total_corredores']) ? $_SESSION['total_corredores'] : "S/R"?></p>
                </div>
                <div class="valores">
                    <h4>Chegada Não Registrada</h4>
                    <p><?= isset($_SESSION['chegada_nao_registrada']) ? $_SESSION['chegada_nao_registrada'] : "S/R"?></p>
                </div>
                <div class="valores">
                    <h4>Chegada Resgistrada</h4>
                    <p><?= isset($_SESSION['chegada_registrada']) ? $_SESSION['chegada_registrada'] : "S/R"?></p>
                </div>
            </div>
            <table>
                <thead>
                <tr>
                    <th>N°</th>
                    <th>NOME</th>
                    <th>TEMPO CORRIDA</th>
                    <th>HORÁRIO CHEGADA</th>
                    <th>CATEGORIA</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                if($corredor != null){
               ?>
                    <tr>
                    <td><?= htmlspecialchars($corredor->getNumero()); ?></td>
                    <td><?= htmlspecialchars($corredor->getNome()); ?></td>
                    <td><?= htmlspecialchars($corredor->getTempoCorrida() ?? "") ?></td>
                    <td><?= htmlspecialchars($corredor->getChegada() == null ? "" : $corredor->getChegadaFormatado()) ?></td>
                    <td><?= htmlspecialchars($corredor->getCategoria() == null ? "" : $corredor->getCategoria()) ?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <form class="exportar" action="../controller/controlador_corredor.php" method="POST">
                <h4>Exportar Corredores</h4>
                <select name="categoria">
                    <option value="1.5km">1.5Km</option>
                    <option value="3km">3Km</option>
                </select>
                <button type="submit" name="exportar" value="exportar">Exportar Lista</button>
            </form>
            </div>
        </div>
    </main>
</body>
</html>