<?php
require_once '../config/inicializador.php';

if(isset($_SESSION['corredor_buscado'])){
    $corredor = unserialize($_SESSION['corredor_buscado']);
}else{
    $corredor = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Corredor</title>
</head>
<body>
    <form action="../controller/controlador_corredor.php" method="GET">
        <label for="numero">Número:</label>
        <input type="number" name="numero" min="0">
        <button type="submit">Buscar</button>
    </form>

    <?php if($corredor != null){?>
        <form action="" method="post">
        <label for="numero">Numero: </label>
        <input type="number" value=<?= $corredor->getNumero();?> >
        </form>
    <?php }?>
</body>
</html>