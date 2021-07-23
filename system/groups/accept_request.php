<?php 
    $idUserPendency = $_GET['idUserPendency'];
    $idGroup = $_GET['idGroup'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";

    $sql_accept_user_pendency = "UPDATE usuarios_has_grupos SET status = 1 WHERE usuarios_id = :idUserPendency AND grupos_id = :idGroup";
    $instruction_accept_user = $db_connection->prepare($sql_accept_user_pendency);
    $instruction_accept_user->bindParam(':idGroup', $idGroup);
    $instruction_accept_user->bindParam(':idUserPendency', $idUserPendency);
    $result_accept_user = $instruction_accept_user->execute();
    if($result_accept_user){
        $msg = "Usuário foi aceito no grupo";
        $status = "success";
    }else{
        $msg = "Falha ao aceitar usuário no grupo";
    }
    $link = "main.php?folder=pages/&file=requests.php&idGroup=".$idGroup."&msg=".$msg."&status=".$status;
    header("Location: $link");
