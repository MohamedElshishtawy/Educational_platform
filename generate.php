<?php

include_once "backend/connect.php";


$data = $db->prepare("SELECT Column_2,Column_012,TRUE FROM 12_3_xlsx limit 200 ");

$data->execute();

$data = $data->fetchAll((PDO::FETCH_ASSOC));


foreach($data as $student){

    $name = $student['Column_2'];
    $code = $student['Column_012'];
    $active = $student['TRUE'];

    $password = rand(100, 10000);

    $new = $db->prepare("INSERT INTO codes (name, code, password,activate,se) VALUES (?,?,?,?, '3se')");
    $new->execute(array($name, $code, $password,$active));

}