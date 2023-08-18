<?php

use Dotenv\Dotenv,

    Dotenv\Exception\InvalidPathException;

try {

    $dEnv = Dotenv::createImmutable(__DIR__ . '/../');

    $dEnv -> load();

} 
catch (InvalidPathException $ipe) {

    echo 'Error load .env';

}
