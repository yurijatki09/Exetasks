<?php
    $idUser = $_SESSION['id'];
    $idActivity = $_POST['idActivity'];
    $nameActivity = $_POST['nameActivity'];
    $descriptionActivity = $_POST['descriptionActivity'];
    $deadlineActivity = $_POST['deadlineActivity'];
    $xpActivity = $_POST['xpActivity'];
    $idPage = $_POST['idPage'];
    $msg = "";
    $status = "danger";

    if(empty($nameActivity)){
        $msg ="Preencha o nome da atividade";
    }elseif(empty($descriptionActivity)){
        $msg ="Preencha a descrição da atividade";
    }elseif(empty($deadlineActivity)){
        $msg ="Preencha a data de entrega da atividade";
    }elseif(empty($xpActivity)){
        $msg ="Escolha uma dificuldade";
    }else{
        include "../../security/database/connection_database.php";
        $sql_upd_activity = "UPDATE atividades SET nome = :nameActivity, descricao = :descriptionActivity, prazo = :deadlineActivity, experiencia = :xpActivity WHERE id = :idActivity";
        $upd_activity = $db_connection->prepare($sql_upd_activity);
        $upd_activity->bindParam(':idActivity', $idActivity);
        $upd_activity->bindParam(':nameActivity', $nameActivity);
        $upd_activity->bindParam(':descriptionActivity', $descriptionActivity);
        $upd_activity->bindParam(':deadlineActivity', $deadlineActivity);
        $upd_activity->bindParam(':xpActivity', $xpActivity);
        $result_upd_activity = $upd_activity->execute();
        if($result_upd_activity){
            $msg = "Sucesso ao alterar atividade";
            $status = "success";
        }else{
            $sql_del_acitivities = "DELETE FROM atividades WHERE id = '$idActivity'";
            $instruction_delete_activities = $db_connection->prepare($sql_del_activities);
            $instruction_delete_activities->execute();
            $del = $instruction_delete_activities->fetchAll(PDO::FETCH_ASSOC);
            $msg = "Falha ao realizar o cadastro";
        }
    }
    if($idPage==1){
        $idGroup = $_POST['idGroup'];
        $link = "../../main.php?folder=pages/&file=group.php&idGroup=".$idGroup."&msg=".$msg."&status=".$status;
    }else{
        $link = "../../main.php?&msg=".$msg."&status=".$status;
    }
header("Location: $link");