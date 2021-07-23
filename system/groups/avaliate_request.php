<?php
    $idUser = $_GET['idUser'];
    $idGroup = $_GET['idGroup'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";
    $sql_sel_verify_user = "SELECT * FROM usuarios_has_grupos WHERE usuarios_id = :idUser AND grupos_id = :idGroup";
    $instruction_verify_user = $db_connection->prepare($sql_sel_verify_user);
    $instruction_verify_user->bindParam(':idUser', $idUser);
    $instruction_verify_user->bindParam(':idGroup', $idGroup);
    $result_verify_user = $instruction_verify_user->execute();
    $pdo_verify_user = $instruction_verify_user->fetchAll(PDO::FETCH_ASSOC);
    if($result_verify_user){
        foreach($pdo_verify_user as $verify_user){
            if($verify_user['permissao']==0){
                $msg = "Você não tem permissão para aceitar ou recusar solicitações de entrada nesse grupo";
                $link = "main.php?folder=pages/&file=active_groups.php&msg=".$msg."&status=".$status;
            }else{
                $link = "main.php?folder=pages/&file=requests.php&idGroup=".$idGroup;
            }
        }
    }else{
        $msg = "Falha ao verificar sua permissão no grupo";
        $link = "main.php?folder=pages/&file=active_groups.php&msg=".$msg."&status=".$status;
    }

    header("Location: $link");

