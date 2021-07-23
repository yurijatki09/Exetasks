<?php
    $nameUser = $_POST['nameUser'];
    $nicknameUser = $_POST['nicknameUser'];
    $passwordUser = $_POST['passwordUser'];
    $emailUser = $_POST['emailUser'];
    $ageUser = $_POST['ageUser'];
    $sexUser = $_POST['sexUser'];
    $typeUser = $_POST['typeUser'];
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
        }elseif(empty($passwordUser)){
            $msg = "Preencha o campo senha";
        }elseif(empty($emailUser)){
            $msg = "Preencha o campo e-mail";
        }elseif(empty($ageUser)){
            $msg = "Preencha o campo data de nascimento";
        }elseif(empty($typeUser)){
            $msg = "Informe seu tipo de usuário";
        }elseif(empty($sexUser)){
            $msg = "Informe seu sexo";
        }
        $link = "index.php?folder=pages/&file=fm_register.php&msg=".$msg."&status=".$status;
    }else{
        include "security/database/connection_database.php";
        $hash_password = md5($passwordUser);
        $sql_sel = "SELECT usuario FROM usuarios WHERE usuario = :nicknameUser";
        $instruction = $db_connection->prepare($sql_sel);
        $instruction->bindParam(':nicknameUser', $nicknameUser);
        $result = $instruction->execute();
        $count_user = $instruction->rowCount();

        $sql_sel = "SELECT email FROM usuarios WHERE email = :emailUser";
        $instruction = $db_connection->prepare($sql_sel);
        $instruction->bindParam(':emailUser', $emailUser);
        $result = $instruction->execute();
        $count_email = $instruction->rowCount();
        if(($count_user==0)&&($count_email==0)){
            $sql_ins = "INSERT INTO usuarios(nome, usuario, senha, email, data_nasc, sexo, tipo, nivel, experiencia) VALUES(:nameUser, :nicknameUser, :passwordUser, :emailUser, :ageUser, :sexUser, :typeUser, '0', '0')";
            $instruction = $db_connection->prepare($sql_ins);
            $instruction->bindParam(':nameUser', $nameUser);
            $instruction->bindParam(':nicknameUser', $nicknameUser);
            $instruction->bindParam(':passwordUser', $hash_password);
            $instruction->bindParam(':emailUser', $emailUser);
            $instruction->bindParam(':ageUser', $ageUser);
            $instruction->bindParam(':sexUser', $sexUser);
            $instruction->bindParam(':typeUser', $typeUser);
            $result = $instruction->execute();
            if($result){
                $msg = "Cadastro efetuado com sucesso";
                $status = "success";
                $link = "index.php?&msg=".$msg."&status=".$status;
            }else{
                $msg = "Falha ao realizar o cadastro";
                $link = "index.php?folder=pages/&file=fm_register.php&msg=".$msg."&status=".$status;
            }
        }else{
            if($count_user!=0){
                $msg = "Já existe um usuário com este apelido, escolha outro";
            }else{
                $msg = "Esse email já foi cadastrado, escolha outro";
            }
            $link = "index.php?folder=pages/&file=fm_register.php&msg=".$msg."&status=".$status;    
        }
    }

    header("Location: $link");
