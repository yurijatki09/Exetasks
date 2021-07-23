<?php
  try{
    $db_connection = new PDO("mysql:host=localhost;dbname=db_exetasks;charset=utf8", "root", "");
  }catch(PDOexception $e){
    die("Erro ao conectar com o banco de dados: ". $e->getMessage());
  }
?>
