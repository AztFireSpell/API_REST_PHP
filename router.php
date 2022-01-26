<?php

$matches = [];

if ( in_array($_SERVER["REQUEST_URI"],['/index.html', '/', ''])) {
    echo file_get_contents('index.html');

    die;
}

//Cuando en la peticion url tenemos un get con un elemento particulas
if(preg_match('/\/([^\/]+)\/([^\/]+)/', $_SERVER["REQUEST_URI"], $matches)){
    $_GET['resource_type'] = $matches[1];
    $_GET['resource_id'] = $matches[2];
    
    require 'server.php';
//Cuando en la peticion url solo queremos ver todos los elementos
} elseif (preg_match('/\/([^\/]+)\/?/', $_SERVER["REQUEST_URI"], $matches)){
    $_GET['resource_type'] = $matches[1];
    error_log(print_r($matches, 1));
    require 'server.php';
//No tenemos en la peticion un dato valido
}else{
    error_log('No matches');
    http_response_code(404);
}