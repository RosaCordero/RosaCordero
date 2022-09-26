<?php

try {
    $mbd = new PDO('mysql:host=localhost;dbname=banco', 'root', 'admin');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}


try {

    $statement = $mbd->prepare("INSERT INTO titular (identificacion, nombres, telefono) VALUES (:identificacion, :nombres, :telefono)");

    $statement->bindParam(':identificacion', $identificacion);
    $statement->bindParam(':nombres', $nombres);
    $statement->bindParam(':telefono', $telefono);

    $identificacion = $_POST['identificacion'];
    $nombres = $_POST['nombres'];
    $telefono = $_POST['telefono'];  

    $statement->execute();
    $_POST['id'] = $mbd->lastInsertId();
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
