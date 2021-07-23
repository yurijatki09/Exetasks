<?php

    $idUser = $_SESSION['id'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";
    $sql_del_user =  "DELETE FROM usuarios WHERE id = :idUser";
    $instruction_del_user = $db_connection->prepare($sql_del_user);
    $instruction_del_user->bindParam(':idUser', $idUser);
    $result = $instruction_del_user->execute();
    $del = $instruction_del_user->fetchAll(PDO::FETCH_ASSOC);
    if($result){
        $msg = "Usuário deletado";
        $link = "index.php?&msg=".$msg."&status=".$status;
        session_destroy();
    }else{
        $msg = "Falha ao deletar usuário";
        $link = "main.php?folder=pages/fm_update_user.php".$msg."status=".$status;
    }
    header("Location: $link");
    ?>