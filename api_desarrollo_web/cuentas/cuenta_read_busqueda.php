<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=banco', 'root', 'admin');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $statement = $mbd->prepare("SELECT * FROM cuentas AS c 
                                INNER JOIN titular AS t ON t.id = c.id_titular
                                WHERE c.id = ". $_GET['id']);   
    $statement->execute();
    $cuenta = $statement->fetch(PDO::FETCH_ASSOC);   

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "cuenta" => $cuenta
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
