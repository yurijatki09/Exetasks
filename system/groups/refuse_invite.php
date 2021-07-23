<?php

    $idUser = $_GET['idUser'];
    $idGroup = $_GET['idGroup'];
    $msg = "";
    $status = "";

    include "security/database/connection_database.php";

    $sql_refuse_invite = "DELETE FROM usuarios_has_grupos WHERE usuarios_id = :idUser AND grupos_id = :idGroup";
    $instruction_refuse_invite = $db_connection->prepare($sql_refuse_invite);
    $instruction_refuse_invite->bindParam(':idUser', $idUser);
    $instruction_refuse_invite->bindParam(':idGroup', $idGroup);
    $result_refuse_invite = $instruction_refuse_invite->execute();
    if($result_refuse_invite){
        $msg = "Você recusou um convite de grupo";
        $status = "warning";
        $link = "main.php?folder=pages/&file=active_groups.php&msg=".$msg."&status=".$status;
    }else{
        $msg = "Falha ao recusar o convite";
        $status = "danger";
        $link = "main.php?folder=pages/&file=active_groups.php&msg=".$msg."&status=".$status;
    }

    header("Location: $link");