<?php
    $user = $_POST['userLogin'];
    $passwordUser = $_POST['passwordLogin'];
    $msg = "";
    $status = "danger";
    $link = "../../index.php";

    if(empty($user)){
        $msg = "Preencha seu nome de usuário";
    }elseif(empty($passwordUser)){
        $msg = "Preencha sua senha";
    }else{
        include "../database/connection_database.php";
        $hash_password = md5($passwordUser);
        $sql_sel = "SELECT * FROM usuarios WHERE usuario='$user' AND senha='$hash_password'";
        $instruction = $db_connection->prepare($sql_sel);
        $result = $instruction->execute();
        if($instruction->rowCount()>0){
            session_start();
            $user_data = $instruction->fetch();
            $id = $user_data['id'];
            $nameUser = $user_data['nome'];
            $emailUser = $user_data['email'];
            $ageUser = $user_data['data_nasc'];
            $sexUser = $user_data['sexo'];
            $typeUser = $user_data['tipo'];
            $_SESSION['id'] = $id;
            $_SESSION['nameUser'] = $nameUser;
            $_SESSION['user'] = $user;
            $_SESSION['emailUser'] = $emailUser;
            $_SESSION['ageUser'] = $ageUser;
            $_SESSION['sexUser'] = $sexUser;
            $_SESSION['typeUser'] = $typeUser;
            $_SESSION['idsession'] = session_id();
            $status = "success";
            $link = "../../main.php";
        }else{
            $msg = "Usuário ou senha incorretos";
        }
    }
    header("Location:".$link."?msg=".$msg."&status=".$status);
