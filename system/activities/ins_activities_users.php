<?php
    session_start();
    $idUser = $_SESSION['id'];
    $nameActivity = $_POST['nameActivity'];
    $descriptionActivity = $_POST['descriptionActivity'];
    $deadlineActivity = $_POST['deadlineActivity'];
    $xpActivity = $_POST['xpActivity'];
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
        $sql_sel = "SELECT nome FROM atividades WHERE nome = :nameActivity";
        $instruction = $db_connection->prepare($sql_sel);
        $instruction->bindParam(':nameActivity', $nameActivity);
        $result = $instruction->execute();
        $count = $instruction->rowCount();
        if($count==0){
            $sql_ins = "INSERT INTO atividades(nome, descricao, prazo, experiencia) VALUES(:nameActivity, :descriptionActivity, :deadlineActivity, :xpActivity)";
            $instruction = $db_connection->prepare($sql_ins);
            $instruction->bindParam(':nameActivity', $nameActivity);
            $instruction->bindParam(':descriptionActivity', $descriptionActivity);
            $instruction->bindParam(':deadlineActivity', $deadlineActivity);
            $instruction->bindParam(':xpActivity', $xpActivity);
            $result_activity = $instruction->execute();
            if($result_activity){
                $idActivity = $db_connection->lastInsertId();
                $sql_ins_users_activities ="INSERT INTO usuarios_has_atividades(usuarios_id, atividades_id) VALUES(:idUser, :idActivity)";
                $instruction_users_activities = $db_connection->prepare($sql_ins_users_activities);
                $instruction_users_activities->bindParam(':idUser', $idUser);
                $instruction_users_activities->bindParam(':idActivity', $idActivity); 
                $result_users_activities = $instruction_users_activities->execute(); 
            }
            if($result_users_activities){
                $msg = "Atividade cadastrada com sucesso";
                $status = "success";
            }else{
                $sql_del_acitivities = "DELETE FROM atividades WHERE id = '$idActivity'";
                $instruction_delete_activities = $db_connection->prepare($sql_del_activities);
                $instruction_delete_activities->execute();
                $del = $instruction_delete_activities->fetchAll(PDO::FETCH_ASSOC);
                $msg = "Falha ao realizar o cadastro";
            }
        }else{
            $msg= "Nome da atividade já existe, escolha outro";
        }
    }
    $link = "../../main.php?&msg=".$msg."&status=".$status;
    header("Location: $link");
