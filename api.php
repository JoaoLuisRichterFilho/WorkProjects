<?php

error_reporting(0);

session_start();

header("Content-Type: application/json");

define( 'PUBLIC_KEY', '423338233093093' );

require_once './db.php';
require_once './User.class.php';

// print_r($_GET); exit;

$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
$pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$public_key = filter_input(INPUT_POST, 'public_key', FILTER_SANITIZE_STRING);

if(!$public_key || $public_key != PUBLIC_KEY) {
    http_response_code(400);
    echo json_encode(array('msg'=>'ERROR: Token inválido'));
    exit;
}

if(!$action || !in_array($action, array('cad','get'))) {
    http_response_code(400);
    echo json_encode(array('msg'=>'ERROR: A ação informada não é válida'));
    exit;
}

if($action == 'cad') {

    if(!$user) {
        http_response_code(400);
        echo json_encode(array('msg'=>'ERROR: O usuario informado não é válido'));
        exit;
    }

    if(!$pass) {
        http_response_code(400);
        echo json_encode(array('msg'=>'ERROR: A senha informada não é válida'));
        exit;
    }

}



$Usuario = new Usuario();

if($action == 'cad') {
    $result = $Usuario->cadUser($user, $pass);
    if($result) {
        http_response_code(200);
        echo json_encode(array('msg'=>'SUCCESS: Usuário cadastrado'));
    } else {
        http_response_code(400);
        echo json_encode(array('msg'=>'ERROR: Falha ao cadastrar o usuário'));
    }
    exit;
} elseif($action == 'get') {
    $dArray = $Usuario->getListUsers($user);
    if(is_array($dArray)) {
        http_response_code(200);
        echo json_encode(array('dados'=>$dArray));
    } else {
        http_response_code(400);
        echo json_encode(array('msg'=>'ERROR: Falha ao buscar os dados'));
    }
    exit;
}

?>