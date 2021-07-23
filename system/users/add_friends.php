<?php
    $idUser = $_SESSION['id'];
    $idFriend = $_GET['idFriend'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";
    $sql_add_friend = "INSERT INTO usuarios_has_usuarios(usuarios_id, usuarios_idamigos) VALUES ($idUser, $idFriend)";
    $instruction_add_friend = $db_connection->prepare($sql_add_friend);
    $result_add_friend = $instruction_add_friend->execute();

    if($result_add_friend ){
        $msg="Amigo adicionado";
        $status = "success";
    }else{
        $msg="Falha ao adicionar o amigo";
    }
    $link = "main.php?&msg=".$msg."&status=".$status;
    header("Location: $link");