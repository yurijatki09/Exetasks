<?php
    $idUserAdm = $_GET['idUserAdm'];
    $idUserDel = $_GET['idUserDel'];
    $idGroupUserDel = $_GET['idGroupUserDel'];
    $idGroup = $_GET['idGroup'];
    $msg = "";
    $status = "danger";

    include "security/database/connection_database";

    //Select para verificar se quem está tentando deletar é administrador do grupo
    $sql_sel_adm_group = "SELECT * FROM usuarios_has_grupos WHERE usuarios_id = :idUserAdm";
    $instruction_adm_group = $db_connection->prepare($sql_sel_adm_group);
    $instruction_adm_group->bindParam(':idUserAdm', $idUserAdm);
    $result_adm_group = $instruction_adm_group->execute();
    $pdo_adm_group = $instruction_adm_group->fetchAll(PDO::FETCH_ASSOC);
    foreach($pdo_adm_group as $adm_group){
        $permission_adm = $adm_group['permissao'];
    }
    if($permission_adm==1){
        $sql_sel_del_user_group = "DELETE FROM usuarios_has_grupos WHERE usuarios_id = :idUserDel";
        $instruction_del_user_group = $db_connection->prepare($sql_sel_del_user_group);
        $instruction_del_user_group->bindParam(':idUserDel', $idUserDel);
        $result_del_user_group = $instruction_del_user_group->execute();
        if($result_del_user_group){
            $msg = "Usuário deletado do grupo";
            $status = "success";
        }else{
            $msg = "Falha ao deletar usuário do grupo";
        }
    }else{
        $msg = "Você não tem permissão para completar esta ação";
    }
    $link = "main.php?folder=pages/&file=users_group.php&idGroup=".$idGroup."msg=".$msg."&status=".$status;
    header("Location: $link");