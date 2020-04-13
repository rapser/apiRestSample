<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// GET Todos los clientes
$app->get('/api/clientes', function (Request $request, Response $response, $args) {
    $sql = "SELECT * FROM clientes";
    try {
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0){
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            // echo json_encode($clientes);
            $response->getBody()->write(json_encode($clientes));
            return $response
            ->withHeader('Content-Type', 'application/json');
        }else {
            // echo json_encode("no existen clientes en la base de datos");
            $response->getBody()->write("no existen clientes en la base de datos");
            return $response;
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $err) {
        echo '{"error": {"text: '.$err->getMessage().'}';
    }
});

// GET Recuperar cliente por id
$app->get('/api/clientes/{id}', function (Request $request, Response $response, $args) {
    $id_cliente = $request->getAttribute('id');
    $sql = "SELECT * FROM clientes WHERE id = $id_cliente";
    try {
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0){
            $cliente = $resultado->fetchAll(PDO::FETCH_OBJ);
            $response->getBody()->write(json_encode($cliente));
            return $response
            ->withHeader('Content-Type', 'application/json');
        }else {
            $response->getBody()->write("no existen cliente en la base de datos");
            return $response;
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $err) {
        echo '{"error": {"text: '.$err->getMessage().'}';
    }
});

// POST Crear nuevo cliente
$app->post('/api/clientes/nuevo', function (Request $request, Response $response, $args) {

    $value = json_decode($request->getBody());
    $sql = "INSERT INTO clientes (nombre, apellidos, telefono, email, direccion, ciudad) VALUES 
    (:nombre, :apellidos, :telefono, :email, :direccion, :ciudad)";

    try {
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $value->nombre);
        $resultado->bindParam(':apellidos', $value->apellidos);
        $resultado->bindParam(':telefono', $value->telefono);
        $resultado->bindParam(':email', $value->email);
        $resultado->bindParam(':direccion', $value->direccion);
        $resultado->bindParam(':ciudad', $value->ciudad);
        $resultado->execute();

        $response->getBody()->write(json_encode($value));
        return $response
        ->withHeader('Content-Type', 'application/json');
        $resultado = null;
        $db = null;
    } catch (PDOException $err) {
        echo '{"error": {"text: '.$err->getMessage().'}';
    }
});

// PUT Modificar cliente
$app->put('/api/clientes/modificar/{id}', function (Request $request, Response $response, $args) {
    $id_cliente = $request->getAttribute('id');
    $value = json_decode($request->getBody());

    $sql = "UPDATE clientes SET 
    nombre = :nombre, 
    apellidos = :apellidos, 
    telefono = :telefono, 
    email = :email, 
    direccion = :direccion, 
    ciudad = :ciudad WHERE id = $id_cliente";

    try {
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $value->nombre);
        $resultado->bindParam(':apellidos', $value->apellidos);
        $resultado->bindParam(':telefono', $value->telefono);
        $resultado->bindParam(':email', $value->email);
        $resultado->bindParam(':direccion', $value->direccion);
        $resultado->bindParam(':ciudad', $value->ciudad);
        $resultado->execute();

        $response->getBody()->write(json_encode($value));
        return $response
        ->withHeader('Content-Type', 'application/json');
        $resultado = null;
        $db = null;
    } catch (PDOException $err) {
        echo '{"error": {"text: '.$err->getMessage().'}';
    }
});

// DELETE Eliminar cliente
$app->delete('/api/clientes/delete/{id}', function (Request $request, Response $response, $args) {
    $id_cliente = $request->getAttribute('id');

    $sql = "DELETE FROM clientes WHERE id = $id_cliente";

    try {
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
            $response->getBody()->write("cliente eliminado");
            return $response;
        } else {
            $response->getBody()->write("el id no existe");
            return $response;
        }

        $resultado = null;
        $db = null;
    } catch (PDOException $err) {
        echo '{"error": {"text: '.$err->getMessage().'}';
    }
});