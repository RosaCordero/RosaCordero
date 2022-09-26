<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=banco', 'root', 'admin');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $statement = $mbd->prepare("SELECT * FROM titular WHERE id = :id");
    $statement->bindParam(':id', $id);
    $id = $_POST['id'];
    $statement->execute();
    $titular = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $mbd->prepare("DELETE FROM titular WHERE id = :id");
    $statement->bindParam(':id', $id);
    $id = $_POST['id'];
    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "mensaje" => "Registro eliminado satisfactoriamnte",
        "data " => $titular
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
