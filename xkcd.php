<?php

$json = file_get_contents('https://xkcd.com/info.0.json').PHP_EOL;


//le ponemos tru porque si no lo maneja como un objeto y asi como arreglo

$data = json_decode($json, true);

echo $data['img'].PHP_EOL;