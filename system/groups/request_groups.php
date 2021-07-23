<?php
    $idUser = $_GET['idUser'];
    $idGroup = $_GET['idGroup'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";

    $sql_ins_user_group = "INSERT INTO usuarios_has_grupos (usuarios_id, grupos_id, permissao, status) VALUES ($idUser, $idGroup, 0, 0)";
    $instruction_ins_user_group = $db_connection->prepare($sql_ins_user_group);
    // $instruction_ins_user_group->bindParam(':idUser', $idUser);
    // $instruction_ins_user_group->bindParam(':idGroup', $idGroup);
    $result_ins_user_group = $instruction_ins_user_group->execute();
    if($result_ins_user_group){
        $msg = "Solicitação enviada";
        $status = "success";
    }else{
        $msg = "Falha ao solicitar entrada";
    }
    $link = "main.php?folder=pages/&file=active_groups.php&msg=".$msg."&status=".$status;
    header("Location: $link");