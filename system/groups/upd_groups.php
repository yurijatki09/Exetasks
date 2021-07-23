<?php
    $idGroup = $_GET['idGroup'];
    $nameGroup = $_GET['nameGroup'];
    $descriptionGroup = $_GET['descriptionGroup'];
    $interestsGroup = $_GET['interestsGroup'];
    $status = "danger";
    $msg="";
    
    if(empty($nameGroup)){
        $msg = "Preencha o campo nome";
    }else if(empty($descriptionGroup)){
        $msg = "Preencha o campo descrição";
    }else if(empty($interestsGroup)){
        $msg = "Escolha o tipo de conteúdo do grupo";
    }else{
        include "security/database/connection_database.php";
        $sql_upd_groups = "UPDATE grupos SET nome = :nameGroup, descricao = :descriptionGroup, interesses_id = :interestsGroup WHERE id = :idGroup";
        $instruction_upd_groups = $db_connection->prepare($sql_upd_groups);
        $instruction_upd_groups->bindParam(':idGroup', $idGroup);
        $instruction_upd_groups->bindParam(':nameGroup', $nameGroup);
        $instruction_upd_groups->bindParam(':descriptionGroup', $descriptionGroup);
        $instruction_upd_groups->bindParam(':interestsGroup', $interestsGroup);
        $result = $instruction_upd_groups->execute();
        if($result){
            $msg = "Os dados do grupo foram alterados com sucesso";
            $status = "success";
        }else{
            $msg = "Falha ao alterar os dados do grupo".$idGroup;
            $status = "danger";

        }
    }
    $link = "main.php?folder=pages/&file=active_groups.php&msg=".$msg."&status=".$status;
    header("Location: $link");