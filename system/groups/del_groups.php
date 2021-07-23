<?php
    $idGroup = $_GET['id'];
    $msg = "";
    $status = "danger";
    include "security/database/connection_database";
    
    $sql_del_group = "UPDATE grupos SET status = 0 WHERE id = :idGroup";
    $del_group = $db_connection->prepare($sql_del_group);
    $del_group->bindParam(':idGroup', $idGroup);
    $result = $del_group->execute();
    $fetch_del_group = $del_group->fetchAll(PDO::FETCH_ASSOC);
    if($result){
        $msg = "Grupo desativado com sucesso";
        $status = "success";
    }else{
        $msg = "Falha ao desativar o grupo";
    }
    $link = "main.php?folder=pages/&file=active_groups.php&msg=".$msg."&status=".$status;
    header("Location: $link");