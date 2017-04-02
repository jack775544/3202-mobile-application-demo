<?php

session_start();
require_once "admin.php";

header("Access-Control-Allow-Origin: *");

logout_user();