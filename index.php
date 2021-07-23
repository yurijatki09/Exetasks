<!--fazer upload do banco de dados e inserts dos interesses(_db/inserts/interesses.sql)-->
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
    </head>
    <body>
        <div class="pos-f-t">
            <div class="collapse purple2" id="navbarToggleExternalContent">
                <div class="p-4">
                    <ul class="nav justify-content-center">
                        <li><a href="index.php" class="nav-item nav-link li_header active txt_yellow">Principal</a></li>
                        <li><a href="index.php?folder=pages/&file=about.html" class="nav-item nav-link li_header active txt_yellow">Sobre</a></li>
                        <li><a href="index.php?folder=pages/&file=ranking.php" class="nav-item nav-link li_header active txt_yellow">Ranking</a></li>
                    </ul>
                </div>
            </div>
            <nav class="navbar navbar-expand-md purple">
                <button class="navbar-toggler bt_navbar" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Alterna navegação">
                    <span class="fas fa-bars"></span>
                </button>
                <div class="logo_header">
                    <img src="assets/imgs/logo2.png">
                </div>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav justify-content-center">
                        <li><a href="index.php" class="nav-item nav-link li_header active txt_yellow">Principal</a></li>
                        <li><a href="index.php?folder=pages/&file=about.html" class="nav-item nav-link li_header active txt_yellow">Sobre</a></li>
                        <li><a href="index.php?folder=pages/&file=ranking.php" class="nav-item nav-link li_header active txt_yellow">Ranking</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#loginModal">Login</button>
            </nav>
        </div>
        <div class="container-fluid">
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
            <?php
                $fixed="fixed-bottom";
                if(isset($_GET['folder']) && isset($_GET['file'])){
                    $fixed="";
                    if(@!include $_GET['folder'].$_GET['file']){
                        echo "404 - Página não encontrada";
                    }
                    }else{
                        include "pages/initial.html";
                    }
                ?>
        </div>
        <footer class="page-footer fixed-bottom purple no_hover_yellow">
            <div class="footer-copyright text-center py-3">
                Copyright © ExeTasks - 2019
            </div>
        </footer>
        <!-- Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModal">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div id="msgErrorJs"></div>
                        <form action="security/authentication/login.php" method="POST" name="frmLogin" id="frmLogin" onsubmit="return validate(this);">
                            <div>
                                <div>
                                    <label for="userLogin">Usuário:</label>
                                    <input type="text" name="userLogin" class="form-control">
                                </div>
                            </div>
                            <div>
                                <div>
                                    <label for="password">Senha:</label>
                                    <input type="password" name="passwordLogin" class="form-control">
                                    <small id="senhaAjuda" class="form-text text-muted"><a href="#">Esqueceu sua senha?</a></small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script>
            function validate(form){
                msgError="";
                if(form.userLogin.value==""){
                    $msgError="Preencha o login";
                }else if(form.passwordLogin.value==""){
                    $msgError="Preencha a senha";
                }else{
                    return true;
                }
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+ $msgError +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $("#msgErrorJs").html($alert);
                return false;
            }
        </script>

    </body>
</html>
