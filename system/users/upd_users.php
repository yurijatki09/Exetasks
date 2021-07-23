<?php
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];
    $nameUser = $_POST['nameUser'];
    $nicknameUser = $_POST['nicknameUser'];
    $passwordUser = $_POST['passwordUser'];
    $emailUser = $_POST['emailUser'];
    $ageUser = $_POST['ageUser'];
    $sexUser = $_POST['sexUser'];
    $typeUser = $_POST['typeUser'];
    // $photoUser = $_FILES['photoUser'];
    $msg = "";
    $status = "danger";
    $required = array('nameUser', 'nicknameUser', 'emailUser', 'ageUser', 'sexUser', 'typeUser');
    $error = false;

    foreach($required as $field) {
        if (empty($_POST[$field])) {
            $error = true;
        }
    }

    if ($error) {
        if(empty($nameUser)){
            $msg = "Preencha o campo nome";
        }elseif(empty($nicknameUser)){
            $msg = "Preencha o campo de apelido";
        }elseif(empty($emailUser)){
            $msg = "Preencha o campo e-mail";
        }elseif(empty($ageUser)){
            $msg = "Preencha o campo data de nascimento";
        }elseif(empty($typeUser)){
            $msg = "Informe seu tipo de usuário";
        }elseif(empty($sexUser)){
            $msg = "Informe seu sexo";
        }
        $link = "main.php?folder=pages/&file=fm_update_user.php&msg=".$msg."&status=".$status;
    }else{
        include "security/database/connection_database.php";
        $sql_sel = "SELECT usuario FROM usuarios WHERE usuario = :nicknameUser";
        $instruction = $db_connection->prepare($sql_sel);
        $instruction->bindParam(':nicknameUser', $nicknameUser);
        $result = $instruction->execute();
        $count = $instruction->rowCount();
        if(($count==0)||($nicknameUser==$user)){
            $sql_update = "UPDATE usuarios SET nome= :nameUser, usuario= :nicknameUser, email= :emailUser, data_nasc= :ageUser, sexo= :sexUser, tipo= :typeUser WHERE id= :id";
            $instruction = $db_connection->prepare($sql_update);
            $instruction->bindParam(':id', $id);
            $instruction->bindParam(':nameUser', $nameUser);
            $instruction->bindParam(':nicknameUser', $nicknameUser);
            $instruction->bindParam(':emailUser', $emailUser);
            $instruction->bindParam(':ageUser', $ageUser);
            $instruction->bindParam(':sexUser', $sexUser);
            $instruction->bindParam(':typeUser', $typeUser);
            $result = $instruction->execute();
            if($result){
                $msg = "Seus dados foram alterados com sucesso";
                $status = "success";
                $link = "main.php?&msg=".$msg."&status=".$status;
                $_SESSION['user'] = $nicknameUser;
                $_SESSION['emailUser'] = $emailUser;
            }else{
                $msg = "Falha ao alterar os dados";
                $link = "main.php?folder=pages/&file=fm_update_user.php&msg=".$msg."&status=".$status;
            }
        }else{
            $msg = "Já existe um usuário com este apelido, escolha outro";
            $link = "main.php?folder=pages/&file=fm_update_user.php&msg=".$msg."&status=".$status;
        }
    }
    //echo "<script type='text/javascript'>window.top.location='$link';</script>";

   header("Location: $link");
