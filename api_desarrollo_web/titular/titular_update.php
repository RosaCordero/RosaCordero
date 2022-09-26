<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=banco', 'root', 'admin');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $statement = $mbd->prepare("UPDATE titular SET identificacion = :identificacion,  nombres = :nombres, telefono = :telefono WHERE id = :id");

    $statement->bindParam(':id', $id);
    $statement->bindParam(':identificacion', $identificacion);
    $statement->bindParam(':nombres', $nombres);
    $statement->bindParam(':telefono', $telefono);

    $id = $_POST['id'];
    $identificacion = $_POST['identificacion'];
    $nombres = $_POST['nombres'];
    $telefono = $_POST['telefono'];

    $statement->execute();

    $statement = $mbd->prepare("SELECT * FROM titular WHERE id = :id");
    $statement->bindParam(':id', $id);
    $id = $_POST['id'];
    $statement->execute();
    $titular = $statement->fetchAll(PDO::FETCH_ASSOC);

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "mensaje" => "Registro actualizado satisfactoriamente",
        "data" => $titular
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
