<?php
    $idUserPendency = $_GET['idUserPendency'];
    $idGroup = $_GET['idGroup'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";
    $sql_refuse_user_pendency = "DELETE FROM usuarios_has_grupos WHERE usuarios_id = :idUserPendency AND grupos_id = :idGroup";
    $instruction_refuse_user = $db_connection->prepare($sql_refuse_user_pendency);
    $instruction_refuse_user->bindParam(':idGroup', $idGroup);
    $instruction_refuse_user->bindParam(':idUserPendency', $idUserPendency);
    $result_refuse_user = $instruction_refuse_user->execute();
    if($result_refuse_user){
        $msg = "Usuário não aceito no grupo";
    }
    else{
        $msg = "Falha ao recusar usuário no grupo";
    }
    $link = "main.php?folder=pages/&file=requests.php&idGroup=".$idGroup."&msg=".$msg."&status=".$status;
    header("Location: $link");