<?php

try{
    $db = new PDO('mysql:host=localhost; dbname=lottery', "root", "");
} catch (PDOException $e){
    echo "Error!: ". $e->getMessage(). "<br/>". $e->getCode();
    die();
}

?>