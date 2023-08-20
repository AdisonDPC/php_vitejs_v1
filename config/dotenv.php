<?php

try {

    $strEnv = '.env.run'; 

    $dEnv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../tmp/', $strEnv);
    
    $dEnv -> load();
    
    $dEnv -> required('APP_ENV') -> notEmpty();
    $dEnv -> required([ 'APP_NAME', 'APP_DEBUG' ]);
    $dEnv -> required('TEMPLATE_PROVIDER') -> 
        allowedValues([ 'twig', 'php-view' ]);
    
} 
catch (Dotenv\Exception\InvalidPathException $ipe) {

    echo $ipe -> getMessage();

}
catch (Dotenv\Exception\ValidationException $ve) {

    echo $ve -> getMessage();

}
