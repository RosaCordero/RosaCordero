<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=banco', 'root', 'admin');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {


    $statement = $mbd->prepare("SELECT * FROM cuentas WHERE id = :id");
    $statement->bindParam(':id', $id);    
    $id = $_POST['id'];
    $statement->execute();
    $cuenta = $statement->fetch(PDO::FETCH_ASSOC);
  
    $statement = $mbd->prepare("SELECT * FROM titular WHERE id = :id");
    $statement->bindParam(':id', $id);    
    $id =$cuenta['id_titular'];
    $statement->execute();
    $titular = $statement->fetch(PDO::FETCH_ASSOC);  

    $cuenta['titular'] = $titular;

    $statement = $mbd->prepare("DELETE FROM cuentas WHERE id = :id");
    $statement->bindParam(':id', $id);    
    $id = $_POST['id'];
    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "mensaje" => "Registro eliminado satisfactoriamnte",
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
