<?php

$version = file_get_contents("version.txt");
$message = file_get_contents("welcomemessage.txt");

echo "$version $message"

?>
