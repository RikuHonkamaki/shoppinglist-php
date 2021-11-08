<?php
header('Access-Control-Allow-Origin:' . $_SERVER['HTTP_ORIGIN']);
header('Access-conrol-Allow-Credentials:true');
header('Access-control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-type');
header('Access-Control-Max-Age: 3600');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD']==='OPTIONS') {
    return 0;
}

$input = json_decode(file_get_contents('php://input'));
$description = filter_var($input->description,FILTER_SANITIZE_STRING);

try {
    $database = new PDO('mysql:host=localhost;dbname=shoppinglist;charset=utf8','root','');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from item";
    $query = $database->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
   header('HTTP/1.1 200 OK');
   print json_encode($results); 
}   catch (PDOException $pdoex) {
    header('HTTP/1.1 500 Internal Server Error');
    $error = array('error' => $pdoex->getMessage());
    print json_encode($error);
}