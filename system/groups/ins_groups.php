<?php
    session_start();
    $idUser = $_SESSION['id'];
    $nameGroup = $_POST['nameGroup'];
    $descriptionGroup = $_POST['descriptionGroup'];
    $interestsGroup = $_POST['interestsGroup'];
    $status = "danger";
    $msg="";

    if(empty($nameGroup)){
        $msg = "Preencha o campo nome";
    }else if(empty($descriptionGroup)){
        $msg = "Preencha o campo descrição";
    }else if(empty($interestsGroup)){
        $msg = "Escolha o tipo de conteúdo do grupo";
    }else{
        include "../../security/database/connection_database.php";
        $sql_sel = "SELECT nome from grupos WHERE nome = :nameGroup";
        $instruction = $db_connection->prepare($sql_sel);
        $instruction->bindParam(':nameGroup', $nameGroup);
        $result = $instruction->execute();
        $count = $instruction->rowCount();
        if($count==0){
            $sql_ins_groups = "INSERT INTO grupos(nome, descricao, status, interesses_id) VALUES(:nameGroup, :descriptionGroup, '1', :interestsGroup)";
            $instruction = $db_connection->prepare($sql_ins_groups);
            $instruction->bindParam(':nameGroup', $nameGroup);
            $instruction->bindParam(':descriptionGroup', $descriptionGroup);
            $instruction->bindParam(':interestsGroup', $interestsGroup);
            $result_groups = $instruction->execute();
            if($result_groups){
                $idGroup = $db_connection->lastInsertId();
                $sql_ins_users_groups ="INSERT INTO usuarios_has_grupos(usuarios_id, grupos_id, permissao, status) VALUES(:idUser, :idGroup, '1', '1')";
                $instruction_users_groups = $db_connection->prepare($sql_ins_users_groups);
                $instruction_users_groups->bindParam(':idUser', $idUser);
                $instruction_users_groups->bindParam(':idGroup', $idGroup);
                $result_users_groups = $instruction_users_groups->execute();
                if($result_users_groups){
                    $msg = "Grupo cadastrado com sucesso";
                    $status = "success";
                }else{
                    $sql_del_groups = "DELETE FROM grupos WHERE id = '$idGroup'";
                    $instruction_delete_group = $db_connection->prepare($sql_del_groups);
                    $instruction_delete_group->execute();
                    $del = $instruction_delete_group->fetchAll(PDO::FETCH_ASSOC);
                    $msg = "Falha ao realizar o cadastro";
                } 
            }else{
                $msg = "Falha ao realizar o cadastro";
            }
        }else{
            $msg = "Esse grupo já existe, escolha outro nome";
        }
    }
    $link = "../../main.php?folder=pages/&file=active_groups.php&msg=".$msg."&status=".$status;
    header("Location: $link");
