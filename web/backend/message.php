<?php
/*
 * Takes a POST variable 'token' and if it is valid then return a message saying hello
 */

header("Content-Type: application/json");

$response = array();

if ($_POST = '3202Token') {
    $response['message'] = "Hello 3202 Student";
    echo json_encode($response);
    return;
}

$response['message'] = "Who are you";
echo $response;