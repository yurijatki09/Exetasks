<?php
    session_start();
    $idUser = $_SESSION['id'];
    $idFriend = $_GET['idUserDelFriend'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";
    $sql_del_friend = "DELETE FROM usuarios_has_usuarios WHERE usuarios_idamigos = $idFriend ";
    $instruction_del_friend = $db_connection->prepare($sql_del_friend);
    $result_del_friend = $instruction_del_friend->execute();
    if($result_del_friend){
        $msg = "Usuário deletado da lista de amigos.";
        $status = "success";
    }else{
        $msg = "Falha ao deletar usuário da lista de amigos.";
    }
    $link = "main.php?&msg=".$msg."&status=".$status;
    header("Location: $link"); 
