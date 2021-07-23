<?php
    session_start();
    $idUser = $_SESSION['id'];
    $idActivity = $_GET['idActivity'];
    $statusActity = $_GET['statusActivity'];
    $idPage = $_GET['idPage'];
    $status = "danger";
    
    include "../../security/database/connection_database.php";
    
    $statusActity = 1;
    $sql_upd_status_activity = "UPDATE usuarios_has_atividades SET status = :statusActivity WHERE atividades_id = :idActivity AND usuarios_id = :idUser";
    $instruction_upd_status_activity = $db_connection->prepare($sql_upd_status_activity);
    $instruction_upd_status_activity->bindParam(':statusActivity', $statusActity);
    $instruction_upd_status_activity->bindParam(':idActivity', $idActivity);
    $instruction_upd_status_activity->bindParam(':idUser', $idUser);
    $instruction_upd_status_activity->execute();

    $sql_sel_xp = "SELECT experiencia FROM atividades WHERE id = :idActivity";
    $instruction_xp = $db_connection->prepare($sql_sel_xp);
    $instruction_xp->bindParam(':idActivity', $idActivity);
    $instruction_xp->execute();
    $result_xp_activity = $instruction_xp->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_xp_activity as $xp){
        $xp_activity = $xp['experiencia'];
    }

    $sql_upd_xp = "UPDATE usuarios SET experiencia = experiencia + :xpActivity WHERE id = :idUser";
    $instruction_upd_xp = $db_connection->prepare($sql_upd_xp);
    $instruction_upd_xp->bindParam(':xpActivity', $xp_activity);
    $instruction_upd_xp->bindParam(':idUser', $idUser);
    $result_upd_xp = $instruction_upd_xp->execute();
    if($result_upd_xp){
        $msg="Você ganhou ".$xp_activity." xp!";
        $status = "success";
    }else{
        $msg="Erro ao cadastrar a atividade";
    }

    $sql_sel_user = "SELECT experiencia, nivel FROM usuarios WHERE id = $idUser";
    $instruction_user = $db_connection->prepare($sql_sel_user);
    $instruction_user->bindParam(':idUser', $idUser);
    $instruction_user->execute();
    $result_user = $instruction_user->fetch(PDO::FETCH_ASSOC);
    $xp_user = $result_user['experiencia'];
    $result_xp_lvl  = $result_user['nivel'];
    if($result_user >=100){
        $lvl_user = $xp_user/100;
        $int_lvl_user = intval($lvl_user);

        $sql_upd_lvl = "UPDATE usuarios SET nivel = :lvlUser WHERE id = :idUser";
        $instruction_upd_lvl_user = $db_connection->prepare($sql_upd_lvl);
        $instruction_upd_lvl_user->bindParam(':idUser', $idUser);
        $instruction_upd_lvl_user->bindParam(':lvlUser', $int_lvl_user);
        $instruction_upd_lvl_user->execute();
    }else{
        $msg="Erro ao calcular o nível";
        $status="danger";
    }if($idPage==1){
        $idGroup = $_GET['idGroup'];
        $link = "../../main.php?&folder=pages/&file=group.php&idGroup=".$idGroup."&msg=".$msg."&status=".$status;
    }else{
        $link = "../../main.php?&msg=".$msg."&status=".$status;
    }
        
    
    header("Location: $link");
    