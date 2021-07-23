<?php
    $id = $_SESSION['id'];
    $idFriend = $_POST['idUserFriend'];
    $idGroup = $_POST['inviteFriendSelect'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database.php";
    $sql_invite_friend_group = "INSERT INTO usuarios_has_grupos (usuarios_id, grupos_id, permissao, status) VALUES(:idFriend, :idGroup, 0, 2)";
    $instruction_groups_invite = $db_connection->prepare($sql_invite_friend_group);
    $instruction_groups_invite->bindParam(':idFriend', $idFriend);
    $instruction_groups_invite->bindParam(':idGroup', $idGroup);
    $result_invite_friend_group = $instruction_groups_invite->execute();
    if($result_invite_friend_group){
        $msg = "Usuário convidado ao grupo.";
        $status = "success";
    }else{
        $msg = "Falha ao convidar usuário ao grupo.";
    }
    $link = "main.php?&msg=".$msg."&status=".$status;
    header("Location: $link");
