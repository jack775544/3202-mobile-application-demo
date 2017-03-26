<?php
/*
 * Takes the following post args:
 * token: if the token is valid with regards to a username then will return true
 * username: the username to check login status
 * password: the password to check the login status, not needed if sending what is thought to be a valid token
 *
 * This page has the following return structure. On failed login:
 * {
 *      "auth": false
 * }
 *
 * And on a successful login:
 *
 * {
 *      "auth": true,
 *      "token": "TOKEN_AS_A_STRING"
 * }
 *
*/

require_once "admin.php";

header('Content-Type: application/json');

$response = array();

// Set up database
$database_path = $_SERVER['DOCUMENT_ROOT'] . '/backend/database.db';
$database_file = 'sqlite:' . $database_path;
$db = new PDO($database_file) or die("Cannot open database");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if their current token is valid
if (isset($_POST['token']) && isset($_POST['username'])) {
    $query = $db->prepare("SELECT count(*) FROM USERS WHERE username = ? and token = ?");
    $query->execute(array($_POST['username'], $_POST['token']));

    $count = $query->fetch(PDO::FETCH_NUM);
    $user_count = $count[0];

    if ($user_count = 1) {
        $response['auth'] = true;
        $response['token'] = $_POST['token'];
        echo json_encode($response);
        return;
    }
}

// Password auth next
if (isset($_POST['username']) && isset($_POST['password'])) {
    $query = $db->prepare("SELECT username, password, token FROM USERS WHERE username = ?");
    $query->execute(array($_POST['username']));
    $user = $query->fetch(PDO::FETCH_NUM);
    // If we actually got a user back
    if ($user !== false) {
        $password_correct = password_check($_POST['password'], $user[1]);
        if ($password_correct) {
            $response['auth'] = true;
            $response['token'] = $user[2];
            echo json_encode($response);
            return;
        }
    }
}

# Their credentials don't match, so return a failure
$response['auth'] = false;
echo json_encode($response);
return;