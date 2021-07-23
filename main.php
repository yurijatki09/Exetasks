<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="exetasks" content="width=device-width, initial-scale=1.0">
        <title>ExeTasks</title>
        <script src="https://kit.fontawesome.com/4eb4485569.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all">
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all">
        <link rel="stylesheet" href="assets/css/main.css">
        <script src="assets/js/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="assets/js/main.js"></script>
    </head>
    <body>
    <div class="pos-f-t">
        <div class="collapse purple2" id="navbarToggleExternalContent">
            <div class="p-4">
                <ul class="nav justify-content-center">
                    <li><a href="main.php" class="nav-item nav-link li_header active txt_yellow">Perfil</a></li>
                    <li><a href="main.php?folder=pages/&file=about.html" class="nav-item nav-link li_header active txt_yellow">Sobre</a></li>
                    <li><a href="main.php?folder=pages/&file=ranking.php" class="nav-item nav-link li_header active txt_yellow">Ranking</a></li>
                    <li><a href="main.php?folder=pages/&file=user_history.php" class="nav-item nav-link li_header active txt_yellow">Histórico</a></li>
                </ul>
            </div>
        </div>
        <?php
            ob_start();
            session_start();
            $idUser = $_SESSION['id'];
            $user = $_SESSION['user'];
            $emailUser = $_SESSION['emailUser'];
            include "security/database/connection_database.php";
            $sql_sel_lvl_xp = "SELECT * FROM usuarios WHERE id = $idUser";
            $instruction_lvl_xp = $db_connection->prepare($sql_sel_lvl_xp);
            $instruction_lvl_xp->execute();
            $lvl_xp = $instruction_lvl_xp->fetch(PDO::FETCH_ASSOC);
        ?>
        <nav class="navbar navbar-expand-md purple">
            <button class="navbar-toggler bt_navbar" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Alterna navegação">
                <span class="fas fa-bars"></span>
            </button>
            <div class="logo_header">
                <img src="assets/imgs/logo2.png">
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav justify-content-center">
                    <li><a href="main.php" class="nav-item nav-link li_header active txt_yellow">Perfil</a></li>
                    <li><a href="main.php?folder=pages/&file=about.html" class="nav-item nav-link li_header active txt_yellow">Sobre</a></li>
                    <li><a href="main.php?folder=pages/&file=ranking.php" class="nav-item nav-link li_header active txt_yellow">Ranking</a></li>
                    <li><a href="main.php?folder=pages/&file=user_history.php" class="nav-item nav-link li_header active txt_yellow">Histórico</a></li>
                </ul>
            </div>
            <a href="index.php?folder=security/authentication/&file=logout.php">
                <button type="button" class="btn btn-outline-light">Sair</button>
            </a>
        </nav>
        <div class="container-fluid"><!--Main container-->
            <?php if(isset($_GET['msg'])&&$_GET['msg']!=""): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-<?= $_GET['status']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $_GET['msg']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row"><!--main row-->
                <div class="col-md-3 py-md-5 pl-md-5">
                    <div class="row">
                        <h1 class="font-weight-light"><?php echo $user; ?></h1>
                    </div>
                    <div class="row">
                        <h4 class="font-weight-light">
                            <?php
                                $length = strlen($emailUser);
                                $diff = ($length>24)?$length-24:0;
                                if($diff>0){
                                    $emailUserTitle=$emailUser; 
                                    $emailUser = substr($emailUser, 0, -$diff);
                                    $emailUser="<span title='".$emailUserTitle."' style='cursor: default;'>".$emailUser."...</span>";
                                }
                                echo $emailUser;
                            ?>
                        </h4>
                    </div>
                    <div class="row">
                        <h4 class="font-weight-light"><a href="#addFriendModal" data-toggle="modal" data-target="#addFriendModal">Adicionar Amigo</a></h4>
                    </div>
                    <div class="row">
                        <?php 
                            //Select para ver se o usuário está convidado para um novo grupo.
                            $sql_sel_invite_group = "SELECT * FROM usuarios_has_grupos WHERE status = 2 AND usuarios_id = $idUser";
                            $instruction_invite_group = $db_connection->prepare($sql_sel_invite_group);
                            $instruction_invite_group->execute();
                            $count_invite_group = $instruction_invite_group->rowCount();
                        ?>
                        <h4 class="font-weight-light"><a href="main.php?folder=pages/&file=active_groups.php">Grupos Ativos    </a><span class="badge badge-primary"><?php echo $count_invite_group; ?></span></h1></h4>
                    </div>
                    <div class="row">
                        <div class="container-fluid justify-content-md-center content">
                            <ul class="list-group">
                                <h3 class="font-weight-light">Amigos</h3>
                                <?php
                                    $sql_sel_friends = "SELECT uu.usuarios_idamigos, u.nome, u.usuario FROM usuarios_has_usuarios AS uu INNER JOIN usuarios AS u ON uu.usuarios_idamigos = u.id WHERE usuarios_id = $idUser ORDER BY u.usuario ASC";
                                    $instruction_sel_friends = $db_connection->prepare($sql_sel_friends) ;
                                    $result_sel_friends = $instruction_sel_friends->execute();
                                    $fetch_sel_friends = $instruction_sel_friends->fetchAll(PDO::FETCH_ASSOC);
                                    if($instruction_sel_friends->rowCount()>0){
                                        foreach($fetch_sel_friends as $friends){ 
                                            ?>
                                                <li class="list-group-item list-group-item-light">
                                                    <?php echo $friends['usuario']; ?>
                                                    <a href="#inviteFriendModal" data-toggle="modal" data-target="#inviteFriendModal" data-id="<?php echo $friends['usuarios_idamigos']; ?>">Convidar</a>
                                                    <a href="#delFriendModal" data-toggle="modal" data-target="#delFriendModal" data-id="<?php echo $friends['usuarios_idamigos']; ?>">Deletar</a>
                                                </li>
                                        <?php }  
                                    }else{
                                    ?>
                                        <li class="list-group-item list-group-item-light">Você não tem amigos adicionado</li>
                                    <?php
                                    }
                                    ?>
                                    
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 py-md-5 pl-md-2">
                    <?php
                        $fixed="fixed-bottom";
                        if(isset($_GET['folder']) && isset($_GET['file'])){
                            $fixed="";
                        if(@!include $_GET['folder'].$_GET['file']){
                            echo "404 - Página não encontrada";
                        }
                        }else{
                            include "pages/profile.php";
                        }
                    ?>
                </div>
                <div class="col-md-3 py-md-5 pl-md-2">
                    <ul class="font-weight-light">
                        <!-- <h3 class="font-weight-light">Foto</h3> -->
                        <li class="list-group-item list-group-item-primary">Nível <?php echo $lvl_xp['nivel']; ?></li>
                        <?php   $exp = $lvl_xp['experiencia']%100;  ?>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $exp; ?>%" aria-valuenow="<?php echo $exp; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $exp; ?>/100 exp</div>
                        </div>
                    </ul>
                    <div class="d-flex flex-row-reverse">
                        <a href="main.php?folder=pages/&file=fm_update_user.php">
                            <button class="btn btn-secondary">Alterar perfil</button>
                        </a>
                    </div>
                </div>
            </div>
            <!-- end main row-->
            <!-- modal add friends -->
            <div class="modal fade" id="addFriendModal" tabindex="-1" role="dialog" arial-labelledby="addFriendModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFriendModal">Adicionar amigo</h5>
                        </div>
                        <div class="modal-body">
                            <form class="form-inline ml-auto" action="main.php?folder=pages/&file=profile.php" method="GET" name="frmSearchFriends">
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="searchFriends" placeholder="Pesquisar amigo" aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">Pesquisar</button>
                                </div>
                            </div>
                            </form>  
                        </div>          
                    </div>            
                </div>        
            </div>      
            <!-- fim modal add friends -->
            <!-- Modal convidar amigos para grupo -->
            <div class="modal fade" id="inviteFriendModal" tabindex="-1" role="dialog" aria-labelledby="inviteFriendModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="inviteFriendModal">Convidar ao grupo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="msgErrorInvite"></div>
                            <form action="main.php?folder=system/groups/&file=invite_friend_group.php" method="POST" name="frmInviteFriend" id="frmInviteFriend">
                                <input type="hidden" name="idUserFriend" value="">
                                <div>
                                    <div>
                                        <label for="inviteFriendSelect">Grupo:</label>
                                        <select name="inviteFriendSelect" class="form-control">
                                            <option value="">Escolha</option>
                                            <?php 
                                                //Mostrar grupos que o usuário que está CONVIDANDO está e tem permissao e status = 1.
                                                $sql_sel_groups_invite = "SELECT g.id, g.nome FROM grupos AS g INNER JOIN usuarios_has_grupos AS ug ON g.id = ug. grupos_id WHERE ug.usuarios_id = $idUser AND ug.status = 1 AND ug.permissao = 1 AND g.status = 1";
                                                $instruction_groups_invite = $db_connection->prepare($sql_sel_groups_invite);
                                                $result_sel_groups_invite = $instruction_groups_invite->execute();
                                                $groups_invite = $instruction_groups_invite->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php foreach($groups_invite as $groups){ ?>
                                                <option value="<?php echo $groups['id']; ?>"><?php echo $groups['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-block">Convidar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim modal convidar amigos -->
            <!--Modal Deletar amigo-->
            <div class="modal fade" id="delFriendModal" tabindex="-1" role="dialog" aria-labelledby="delFriendModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="delFriendModal">Deseja realmente deletar este amigo?</h6>
                        </div>
                        <div class="modal-body">
                                <form action="main.php" method="GET">
                                    <input type="hidden" name="folder" value="system/users/">
                                    <input type="hidden" name="file" value="del_friends.php">
                                    <input type="hidden" name="idUserDelFriend" value="">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-block btn-danger" type="submit">Sim</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-block btn-success" data-dismiss="modal" type="button">Não</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>          
                    </div>
                </div>
            </div>
            <!--Fim modal Deletar amigo-->
            <footer class="page-footer fixed-bottom purple no_hover_yellow">
                <div class="footer-copyright text-center py-3">
                    Copyright © ExeTasks - 2019
                </div>
            </footer>
        </div><!--end main container-->
        
    </body>
</html>