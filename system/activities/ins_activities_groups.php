<?php
    session_start();
    $idUser = $_SESSION['id'];
    $idGroup = $_GET['idGroup'];
    $nameActivity = $_GET['nameActivity'];
    $descriptionActivity = $_GET['descriptionActivity'];
    $deadlineActivity = $_GET['deadlineActivity'];
    $xpActivity = $_GET['xpActivity'];
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
        $sql_ins_act_group = "INSERT INTO atividades(nome, descricao, prazo, experiencia) VALUES (:nameActivity, :descriptionActivity, :deadlineActivity, :xpActivity)";
        $instruction_activities_group = $db_connection->prepare($sql_ins_act_group);
        $instruction_activities_group->bindParam(':nameActivity', $nameActivity);
        $instruction_activities_group->bindParam(':descriptionActivity', $descriptionActivity);
        $instruction_activities_group->bindParam(':deadlineActivity', $deadlineActivity);
        $instruction_activities_group->bindParam(':xpActivity', $xpActivity);
        $result_activities_group = $instruction_activities_group->execute();
        if($result_activities_group){          
            $idActivity = $db_connection->lastInsertId();
            $sql_ins_group_act = "INSERT INTO grupos_has_atividades(grupos_id, atividades_id) VALUES(:idGroup, :idActivity)";
            $instruction_group_activities = $db_connection->prepare($sql_ins_group_act);
            $instruction_group_activities->bindParam(':idGroup', $idGroup);
            $instruction_group_activities->bindParam(':idActivity', $idActivity);
            $result_group_activities = $instruction_group_activities->execute();

            $sql_sel_users_group = "SELECT * FROM usuarios_has_grupos WHERE grupos_id = :idGroup";
            $instruction_users_group = $db_connection->prepare($sql_sel_users_group);
            $instruction_users_group->bindParam(':idGroup', $idGroup);
            $result_users_group = $instruction_users_group->execute();
            $pdo_users_group = $instruction_users_group->fetchAll(PDO::FETCH_ASSOC);
            foreach($pdo_users_group as $users_group){
                $sql_ins_users_activities ="INSERT INTO usuarios_has_atividades(usuarios_id, atividades_id) VALUES(:idUser, :idActivity)";
                $instruction_users_activities = $db_connection->prepare($sql_ins_users_activities);
                $instruction_users_activities->bindParam(':idUser', $users_group['usuarios_id']);
                $instruction_users_activities->bindParam(':idActivity', $idActivity); 
                $result_users_activities = $instruction_users_activities->execute(); 
         
                if(($result_group_activities)&&($result_users_activities)){
                    $msg = "Atividade cadastrada com sucesso";
                    $status = "success";
                }else{
                    $sql_del_acitivities = "DELETE FROM atividades WHERE id = $idActivity";
                    $instruction_delete_activities = $db_connection->prepare($sql_del_activities);
                    $instruction_delete_activities->execute();
                    $del = $instruction_delete_activities->fetchAll(PDO::FETCH_ASSOC);
                    $msg = "Falha ao realizar o cadastro";
                }
            }
        }else{
            $msg="Falha ao realizar o cadastro de atividade";
        }
    }
    $link = "../../main.php?&folder=pages/&file=group.php&idGroup=".$idGroup."&msg=".$msg."&status=".$status;
    header("Location: $link");