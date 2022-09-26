<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=banco', 'root', 'admin');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $statement = $mbd->prepare("UPDATE cuentas SET id_titular = :id_titular, tipo = :tipo, observacion = :observacion, fecha_registro = :fecha_registro, numero_transacciones = :numero_transacciones, saldo = :saldo, corre_activacion = :corre_activacion WHERE id = :id");

    $statement->bindParam(':id', $id);
    $statement->bindParam(':id_titular', $id_titular);
    $statement->bindParam(':tipo', $tipo);
    $statement->bindParam(':observacion', $observacion);
    $statement->bindParam(':fecha_registro', $fecha_registro);
    $statement->bindParam(':numero_transacciones', $numero_transacciones);
    $statement->bindParam(':saldo', $saldo);
    $statement->bindParam(':corre_activacion', $corre_activacion);

    $id = $_POST['id'];
    $id_titular = $_POST['id_titular'];
    $tipo = $_POST['tipo'];
    $observacion = $_POST['observacion'];
    $fecha_registro = $_POST['fecha_registro'];
    $numero_transacciones = $_POST['numero_transacciones'];
    $saldo = $_POST['saldo'];
    $corre_activacion = $_POST['corre_activacion'];

    $statement->execute();

    $statement = $mbd->prepare("SELECT * FROM cuentas AS c 
                                INNER JOIN titular AS t ON t.id = c.id_titular
                                WHERE c.id = " . $_POST['id']);
    $statement->execute();
    $cuenta = $statement->fetch(PDO::FETCH_ASSOC);   

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "mensaje" => "Registro actualizado satisfactoriamente",
        "data" => $cuenta
    ]);
} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}
