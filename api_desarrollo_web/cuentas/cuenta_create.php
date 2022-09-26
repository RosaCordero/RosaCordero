<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=banco', 'root', 'admin');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $statement = $mbd->prepare("INSERT INTO cuentas (id_titular, tipo, observacion, fecha_registro, numero_transacciones, saldo, corre_activacion) 
    VALUES (:id_titular, :tipo, :observacion, :fecha_registro, :numero_transacciones, :saldo, :corre_activacion)");

    $statement->bindParam(':id_titular', $id_titular);
    $statement->bindParam(':tipo', $tipo);
    $statement->bindParam(':observacion', $observacion);
    $statement->bindParam(':fecha_registro', $fecha_registro);
    $statement->bindParam(':numero_transacciones', $numero_transacciones);
    $statement->bindParam(':saldo', $saldo);
    $statement->bindParam(':corre_activacion', $corre_activacion);

    $id_titular = $_POST['id_titular'];
    $tipo = $_POST['tipo'];
    $observacion = $_POST['observacion'];
    $fecha_registro = $_POST['fecha_registro'];
    $numero_transacciones = $_POST['numero_transacciones'];
    $saldo = $_POST['saldo'];
    $corre_activacion = $_POST['corre_activacion'];

    $statement->execute();
    $_POST['id'] = $mbd->lastInsertId();

    $statement = $mbd->prepare("SELECT * FROM titular WHERE id = ". $_POST['id_titular']);
    $statement->execute();
    $data = $statement->fetch(PDO::FETCH_ASSOC);
    $_POST['titular'] = $data;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($_POST);
} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}
