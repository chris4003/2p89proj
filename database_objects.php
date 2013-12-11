<?php
$SERVER   = "localhost";
$USERNAME = "vm10vf";
$PASSWORD = "4864450";
$DATABASE = "vm10vf";

$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
?>