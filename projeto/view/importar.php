<?php
require_once '../config/inicializador.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Corredores</title>
    <link rel="stylesheet" href="../style/import.css">
</head>
<body>
    <header>
        <h1>RUNNING MARKER</h1>
    </header>
    <div>
        <a href="corredores.php">Início</a>
    </div>
    <main>
        <h2><?= htmlspecialchars(isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : "");?></h2>
        <form class="form2" action="../controller/controlador_corredor.php" method="POST" enctype="multipart/form-data">
            <div class="modalidade">
                <label for="tipo_corrida">Categoria: </label>
                <select name="tipo_corrida">
                    <option value="1.5km">1.5 Km</option>
                    <option value="3km">3 Km</option>
                </select>
            </div>
            <div class="arquivo">
                <label for="arquivo">Arquivo: </label>
                <input type="file" name="arquivo">
            </div>
            <button type="submit" name = "registrar_corredores" value="registrar_corredores">Enviar</button>
        </form>

        <form  class="form_db" action="../controller/controlador_corredor.php" method="POST">
            <label for="banco">Corrida: </label>
            <select name="banco">
                <option value="1.5km">1.5 km</option>
                <option value="3km">3 km</option>
            </select>
            <button  type="submit" name="limpar_banco_dados" value="limpar_banco_dados">Limpar dados</button>
        </form>
    </main>
</body>
</html>