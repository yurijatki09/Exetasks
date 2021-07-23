<?php
    $idUser = $_GET['idUser'];
    $idActivity = $_GET['idActivity'];
    $idPage = $_GET['idPage'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";

    $sql_del_activity = "DELETE FROM atividades WHERE id = :idActivity";
    $instruction_del_activity = $db_connection->prepare($sql_del_activity);
    $instruction_del_activity->bindParam(':idActivity', $idActivity);
    $result_del_activity = $instruction_del_activity->execute();
    if($result_del_activity){
        $msg = "Atividade deletada.";
        $status = "success";
        $link = "main.php?folder=pages/&file=profile.php&msg=".$msg."&status=".$status;
    }else{
        $msg = "Falha ao deletar atividade.";
        $link = "main.php?folder=pages/&file=profile.php&msg=".$msg."&status=".$status;
    }
    if($idPage==1){
        $idGroup = $_GET['idGroup'];
        $link = "main.php?folder=pages/&file=group.php&idGroup=".$idGroup."&msg=".$msg."&status=".$status;
    }
    header("Location: $link");
