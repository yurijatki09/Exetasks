<?php

    $id = $_SESSION['id'];
    $idGroup = $_POST['idGroup'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";
    $sql_accept_group = "UPDATE usuarios_has_grupos SET status = 1 WHERE grupos_id = $idGroup AND usuarios_id = $id";
    $instruction_accept_group = $db_connection->prepare($sql_accept_group);
    $result_accept_group = $instruction_accept_group->execute();
    if($result_accept_group){
        $msg = "Você aceitou a solicitação.";
        $status = "success";
    }else{
        $msg = "Falha ao aceitar solicitação.";
    }
    $link = "main.php?&msg=".$msg."&status=".$status;
    header("Location: $link");
