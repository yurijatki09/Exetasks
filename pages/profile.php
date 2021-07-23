<!-- Lista entra na coluna de tamanho 6 da main.php -->
<!-- pesquisar amigos -->
<?php
    $idUser = $_SESSION['id'];  
    if(isset($_GET['searchFriends'])){
        $searchFriends = $_GET['searchFriends'];
        $nicknameUser = $_SESSION['user'];
        include "security/database/connection_database.php"; 
        
        //Select para ver quais usuários são amigos do usuário logado.
        $sql_sel_friends = "SELECT DISTINCT uu.usuarios_idamigos, u.usuario FROM usuarios_has_usuarios AS uu INNER JOIN usuarios AS u ON uu.usuarios_idamigos = u.id WHERE uu.usuarios_id = $idUser"; 
        $instruction_sel_friends = $db_connection->prepare($sql_sel_friends);
        $result_sel_friends = $instruction_sel_friends->execute();
        $fetch_sel_friends = $instruction_sel_friends->fetchAll(PDO::FETCH_ASSOC);

        $idFriend = "(";
        foreach($fetch_sel_friends as $friends){
            $idFriend .= $friends['usuarios_idamigos'].",";
        }
        $idFriend = substr($idFriend, 0, -1);
        $idFriend .= ")";

        if($idFriend==")"){
            //Select se o usuário não tem nenhum amigo.
            $sql_sel_search_friends = "SELECT id, nome, usuario, email, nivel FROM usuarios WHERE $idUser <> id";
            $instruction_search_friends = $db_connection->prepare($sql_sel_search_friends);
            $result_search_friends = $instruction_search_friends->execute();
            $pdo_search_friends = $instruction_search_friends->fetchAll(PDO::FETCH_ASSOC); 
        }else{
            //Select para listar os usuários que o usuário logado não é amigo.
            $sql_sel_search_friends = "SELECT id, nome, usuario, email, nivel FROM usuarios WHERE id NOT IN $idFriend AND $idUser <> id";
            $instruction_search_friends = $db_connection->prepare($sql_sel_search_friends);
            $result_search_friends = $instruction_search_friends->execute();
            $pdo_search_friends = $instruction_search_friends->fetchAll(PDO::FETCH_ASSOC);
        }
        if($pdo_search_friends){ ?>
            <button type="button" class="close" aria-label="Close" onclick="closeSearchFriends(this)">
                <span aria-hidden="true">&times;</span>
            </button>
            <table class="table table-bordered" id="searchFriends">
                <thead class="thead-dark">
                    <th style="text-align: center; vertical-align:middle !important">E-mail</th>
                    <th style="text-align: center; vertical-align:middle !important">Usuário</th>
                    <th style="text-align: center; vertical-align:middle !important">Nível</th>
                    <th style="text-align: center; vertical-align:middle !important">Ação</th>
                </thead>
                    <?php foreach($pdo_search_friends as $sel_friends){ ?>
                        <tr class="table-light">
                            <td style="text-align: center; vertical-align:middle !important"><?php echo $sel_friends['email']; ?></td>
                            <td style="text-align: center; vertical-align:middle !important"><?php echo $sel_friends['usuario']; ?></td>
                            <td style="text-align: center; vertical-align:middle !important"><?php echo $sel_friends['nivel']; ?></td>
                            <td style="text-align: center; vertical-align:middle !important">
                                <a href="main.php?folder=system/users/&file=add_friends.php&idFriend=<?php echo $sel_friends['id']; ?>">
                                    <button type="button" class="btn btn-outline-primary btn-block" name="bt_addfriend">Adicionar</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <tbody>
                </tbody>
            </table>
        <?php 
    }
}
?>
<!-- fim pesquisar amigos -->
<div class="row">
    <div class="col-md-6">
        <h3 class="font-weight-light">Atividades</h3>
    </div>
    <div class="col-md-6">
        <div class="float-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#activityModal">Nova atividade</button>
        </div>
    </div>
</div>
<?php
    include "security/database/connection_database.php";

    //Fazer select para conferir se TODAS as atividades estão com status = 1 da tabelas usuarios_has_atividades aonde o usuariosid é o id do usuário logado, se estiverem ai imprime que o usuário não tem atividades
    $sql_sel_users_status = "SELECT * FROM usuarios_has_atividades AS ua WHERE ua.usuarios_id = $idUser AND ua.status = 0 AND atividades_id NOT IN (SELECT ga.atividades_id FROM grupos_has_atividades AS ga)";
    $instruction_users_status = $db_connection-> prepare($sql_sel_users_status);
    $instruction_users_status->execute(); 
    $count_users_status = $instruction_users_status->rowCount();
    //Select para ver todas as atividades
    $sql_sel_users_has_activities = "SELECT * FROM atividades AS a INNER JOIN usuarios_has_atividades AS ua ON a.id = ua.atividades_id WHERE ua.usuarios_id = $idUser AND atividades_id NOT IN (SELECT ga.atividades_id FROM grupos_has_atividades AS ga)";
    $instruction_users_has_activities = $db_connection->prepare($sql_sel_users_has_activities);
    $instruction_users_has_activities->execute();
    $pdo_users_has_activities = $instruction_users_has_activities->fetchAll(PDO::FETCH_ASSOC);
    $count_activities = $instruction_users_has_activities->rowCount();
    $i = 0;
    if(($count_users_status==0) || ($count_activities==0)){ ?>
        <div class="card py-md-3">
            <div class="card-body">
                <h6 class="card-subtitle text-center text-muted">Você não tem atividades no momento, crie uma e comece já.</h6>
            </div>
        </div>
    <?php
    }else{
        foreach ($pdo_users_has_activities as $users_has_activities){
            if($users_has_activities['status']==0){
    ?>
                <div class ="row">
                    <div class="container-fluid justify-content-md-center">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-light">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <th style="text-align: center; vertical-align:middle !important">Atividade</th>
                                            <th style="text-align: center; vertical-align:middle !important">Descrição</th>
                                            <th style="text-align: center; vertical-align:middle !important">Prazo</th>
                                            <th style="text-align: center; vertical-align:middle !important">Experiência</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center; vertical-align:middle !important"><?php echo $users_has_activities['nome']; ?></td>
                                                <td style="text-align: center; vertical-align:middle !important"><?php echo $users_has_activities['descricao']; ?></td>
                                                <td style="text-align: center; vertical-align:middle !important"><?php echo $users_has_activities['prazo']; ?></td>
                                                <td style="text-align: center; vertical-align:middle !important"><?php echo $users_has_activities['experiencia']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <form action="system/users/upd_lvl_xp.php" method="GET" name="frm_id_activity">
                                    <input type="hidden" name="idPage" value="0">
                                    <input type="hidden" name="idActivity" value="<?php echo $users_has_activities['atividades_id']?>">
                                    <input type="hidden" name="statusActivity" value="<?php echo $users_has_activities['status']?>">
                                    <!-- Buttons -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button class="btn btn-success btn-sm btn-block" type="submit">Concluir</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-secondary btn-block btn-sm" id="btn-alterActivity" data-toggle="modal" data-target="#alterActivityModal" data-id="<?=$users_has_activities['id']?>" data-nome="<?=$users_has_activities['nome']?>" data-descricao="<?=$users_has_activities['descricao']?>" data-prazo="<?=$users_has_activities['prazo']?>"   data-experiencia="<?=$users_has_activities['experiencia']?>"        
                                            >Alterar</button>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="main.php?folder=system/activities/&file=del_activities.php&idActivity=<?php echo $users_has_activities['id']; ?>&idUser=<?php echo $idUser; ?>&idPage=0">
                                                <button class="btn btn-danger btn-sm btn-block" type="button">Deletar</button>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php 
            }
        }
    } 
?>
<!-- Modal cadastro de cadastro de atividade -->
<div class="modal fade" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="activityModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activityModal">Cadastro de Atividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="msgErrorJs"></div>
                <form action="system/activities/ins_activities_users.php" method="POST" name="frmActivity" id="frmActivity" onsubmit="return validateActivity(this)">
                    <div>
                        <div>
                            <label>Nome:</label>
                            <input type="text" name="nameActivity" class="form-control" maxlength="20">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label>Descrição:</label>
                            <input type="textarea" name="descriptionActivity" class="form-control">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label>Prazo:</label>
                            <input type="datetime-local" name="deadlineActivity" class="form-control">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label>Dificuldade:</label>
                            <select name="xpActivity" class="form-control">
                                <option value=""></option>
                                <option value="10">Fácil</option>
                                <option value="20">Médio</option>
                                <option value="30">Difícil</option>
                                <option value="100">IMPOSSÍVEL</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--modal alterar atividade-->
<div class="modal fade" id="alterActivityModal" tabindex="-1" role="dialog" aria-labelledby="alterActivityModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activityModal">Alterar Atividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="msgErrorJs"></div>
                <form action="system/activities/upd_activities.php" method="POST" name="frmActivity" id="frmActivity" onsubmit="return validateActivity(this)">
                    <div>
                        <input type="hidden" name="idActivity" value="<?php echo $users_has_activities['atividades_id']; ?>">
                            <div>
                                <label>Nome:</label>
                                <input type="text" name="nameActivity" class="form-control" maxlength="20" value="<?php echo $users_has_activities['nome']; ?>">
                            </div>
                        </div>
                    <div>
                        <div>
                            <label>Descrição:</label>
                            <input type="textarea" name="descriptionActivity" class="form-control">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label>Prazo:</label>
                            <input type="datetime-local" name="deadlineActivity" class="form-control">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label>Dificuldade:</label>
                            <select name="xpActivity" class="form-control">
                                <option value=""></option>
                                <option value="10">Fácil</option>
                                <option value="20">Médio</option>
                                <option value="30">Difícil</option>
                                <option value="100">IMPOSSÍVEL</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>