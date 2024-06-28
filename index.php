<?php

require("init.php");


$url = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) ;

//echo $url;
$urlArray = explode("/",$url);

$resource = $urlArray[2];

$id = $urlArray[3] ?? null;

if($resource !== "tasks"){
 
   http_response_code(404);
    exit;
}

    
    
    
    $database = new Connection($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $db = $database->getConnection();
$taskGateway = new TaskGateway($database);
$usergatway = new Usergateway($database);
$auth = new Auth($usergatway);
if(!$auth->authen()){
exit;
}

$task = new Task($taskGateway,$usergatway,$usergatway->getId($_SERVER['HTTP_X_API_KEY']));
$task->proceessRequest($_SERVER['REQUEST_METHOD'],$id);

