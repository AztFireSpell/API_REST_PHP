<?php
/* 
if(!array_key_exists('HTTP_X_TOKEN', $_SERVER)){
    die;
}
*/
$url = 'http://localhost:8001';

$ch = curl_init( $url);
/*
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    [
        "X-Token: {$_SERVER['HTTP_X_TOKEN']}"
    ]
    );

curl_setopt(
    $ch,
    CURLOPT_RETURNTRANSFER,
    true
);

$ret = curl_exec( $ch );

if($ret !== 'true') {
    die;
}
*/
// Definimos los recursos disponibles
$allowedResourceTypes = [
    'books',
    'authors',
    'genres'
];


//validamos que el recurso este disponible
$resourceType = $_GET['resource_type'];

if( !in_array($resourceType, $allowedResourceTypes)){
    http_response_code(400);
    die;
}

//Definimos los recursos

$books = [
    1 => [
        'titulo' => 'Lo que el viento se llevo',
        'id_autor' => 2,
        'id_genero' => 2
    ],
    2 => [
        'titulo' => 'La iliada',
        'id_autor' => 1,
        'id_genero' => 1
    ],
    3 => [
        'titulo' => 'La odisea',
        'id_autor' => 1,
        'id_genero' => 1
    ]
];

//Levantamo el id del recurso buscado individual
$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';

header('Content-Type: application/json');


//Generamos la respuesta asumiendo que el pedido es correcto
//REQUEST_METHOD => post, delete, put, get
switch(strtoupper($_SERVER['REQUEST_METHOD'])){


    case 'GET':
        if ( empty( $resourceId ) ){
           echo json_encode( $books );
        }else{
           if( array_key_exists( $resourceId, $books) ){
               echo json_encode( $books[ $resourceId ] );
           }else{
               http_response_code(404);
           }
       }
        break;
    case 'POST':
        //Tomamos la entrada cruda de php, porque no tenemos un formulario
        $json = file_get_contents('php://input');
        //Transformamos el json obtenido en un nuevo elemento del array
        $books[] = json_decode($json, true);

        //Emitimos la ultima entrada del aaray
        //echo array_keys($books)[count($books) - 1];

        //Mostramos todos el arreglo de books
        echo json_encode($books);
        break;
    case 'PUT':

        /*Importante: 
            Para put no se puede modificar un campo especifico
            Toda la informacion debe ser enviada con todos los campos
            Ya que reemplaza la informacion lineal
        */

        //Validamos que el recurso buscado exista
        if(!empty($resourceId) && array_key_exists($resourceId, $books)){
            //tomamos la entrada cruda
            $json = file_get_contents('php://input');

            //Pasamos el resourceId para ver cual recurso sera reemplazado
            $books[ $resourceId ] = json_decode($json, true);

            //Devolvemos la coleccion modificada
            echo json_encode($books);
        }
        break;
    case 'DELETE':
        //Validamos que el recurso exista
        if(!empty($resourceId) && array_key_exists($resourceId, $books)){  

            //Lo eliminamos del arreglo
            unset($books[$resourceId]);

        }   
        
        echo json_encode($books);
        break;

} 