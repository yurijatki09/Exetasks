<?php 
    session_start();
    $idUser = $_SESSION['id'];
    $idGroup = $_GET['idGroup'];
    $idPage = 1;
    include "security/database/connection_database.php";

    //Select para ver quantidade de solicitações de entrada em grupo pendente
    $sql_sel_req_group = "SELECT status FROM usuarios_has_grupos WHERE grupos_id = $idGroup AND status = 0";
    $instruction_req_group = $db_connection->prepare($sql_sel_req_group);
    $instruction_req_group->execute();
    $count_req = $instruction_req_group->rowCount();

    $sql_sel_info_group = "SELECT g.id, g.nome, g.descricao, ug.permissao, ug.status FROM grupos AS g INNER JOIN usuarios_has_grupos AS ug ON g.id = ug.grupos_id INNER JOIN usuarios AS u ON ug.usuarios_id = u.id WHERE g.id = :idGroup AND u.id = $idUser";
    $instruction_info_group = $db_connection->prepare($sql_sel_info_group);
    $instruction_info_group->bindParam(':idGroup', $idGroup);
    $instruction_info_group->execute();
    $info_group = $instruction_info_group->fetchAll(PDO::FETCH_ASSOC);
    foreach($info_group as $info){
        $nameGroup = $info['nome'];
        $permissionUser = $info['permissao'];
    }
    //Select para ver todas as atividades de usuarios_has_atividades junto de grupos_has_atividades
    $sql_sel_users_has_activities = "SELECT a.id AS idactivity, a.nome, ua.atividades_id, ga.grupos_id, ua.status AS status_usuario, a.descricao, a.prazo, a.experiencia FROM atividades AS a INNER JOIN usuarios_has_atividades AS ua ON a.id = ua.atividades_id INNER JOIN grupos_has_atividades AS ga ON ua.atividades_id = ga.atividades_id INNER JOIN usuarios_has_grupos AS ug ON ga.grupos_id = ug.grupos_id WHERE ua.status = 0 AND ua.usuarios_id = $idUser AND ug.usuarios_id = $idUser"; 
    $instruction_users_has_activities = $db_connection->prepare($sql_sel_users_has_activities);
    $instruction_users_has_activities->execute();
    $count_activities_groups = $instruction_users_has_activities->rowCount();
    $pdo_users_has_activities = $instruction_users_has_activities->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="row">
    <div class="col-md-6">
        <h3 class="font-weight-light float-left">Atividades</h3>
    </div>
    <div class="col-md-6">
        <h3 class="font-weight-light float-right"><?php echo $nameGroup; ?></h2>
    </div>  
</div>
<div class="row">
    <div class="col-md-4">
        <a href="main.php?folder=system/groups/&file=avaliate_request.php&idGroup=<?php echo $idGroup; ?>&idUser=<?php echo $idUser; ?>">
            <button type="button" class="btn btn-outline-primary btn-block btn-sm">Solicitações    <span class="badge badge-dark"><?php echo $count_req; ?></span></button>
        </a>
    </div>
    <div class="col-md-4">
        <a href="main.php?folder=pages/&file=users_group.php&idGroup=<?php echo $idGroup; ?>&idUser=<?php echo $idUser; ?>">
            <button type="button" class="btn btn-outline-primary btn-block btn-sm">Integrantes</button>
        </a>
    </div>
    <div class="col-md-4">
        <a href="main.php?folder=pages/&file=activities_group.php&idGroup=<?php echo $idGroup; ?>&idUser=<?php echo $idUser; ?>">
            <button type="button" class="btn btn-outline-primary btn-block btn-sm">Relatório</button>
        </a>
    </div>
</div>
<!-- Fazer aparecer as atividades -->
<?php       
    $sql_sel_status_users = "SELECT * FROM grupos_has_atividades AS ga INNER JOIN usuarios_has_atividades AS ua ON ga.atividades_id = ua.atividades_id WHERE ga.grupos_id = $idGroup AND ua.status = 0 AND ua.usuarios_id = $idUser";
    $instruction_status_users = $db_connection->prepare($sql_sel_status_users);
    $instruction_status_users->execute();
    $count_users_status = $instruction_status_users->rowCount();

    if(($count_users_status==0) || ($count_activities_groups==0)){?>
        <div class="card py-md-3">
            <div class="card-body">
                <h6 class="card-subtitle text-center text-muted">O grupo não tem atividades no momento.</h6>
            </div>
        </div>
    <?php
    }else{
        foreach($pdo_users_has_activities as $users_has_activities){
            if($users_has_activities['grupos_id']==$idGroup){
                if($users_has_activities['status_usuario']==0){  ?>
                    <div class="row pt-3">
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
                                        <input type="hidden" name="idPage" value="1">
                                        <input type="hidden" name="idGroup" value="<?php echo $idGroup; ?>">
                                        <input type="hidden" name="idActivity" value="<?php echo $users_has_activities['atividades_id']; ?>">
                                        <?php if($info['permissao']==1){ ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button class="btn btn-secondary btn-sm btn-block" type="button" data-toggle="modal" data-target="#alterActivityGroup" data-idgroup="<?php echo $idGroup; ?>" data-id="<?=$users_has_activities['idactivity']?>" data-nome="<?=$users_has_activities['nome']?>" data-descricao="<?=$users_has_activities['descricao']?>" data-prazo="<?=$users_has_activities['prazo']?>"   data-experiencia="<?=$users_has_activities['experiencia']?>"> Alterar</button> 
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="main.php?folder=system/activities/&file=del_activities.php&idActivity=<?php echo $users_has_activities['idactivity']; ?>&idPage=1&idGroup=<?php echo $idGroup; ?>">
                                                        <button class="btn btn-danger btn-sm btn-block" type="button">Deletar</button>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php
                                            }else{ ?>
                                                <button class="btn btn-success btn-block btn-sm" type="submit">Concluir</button>
                                        <?php 
                                            }
                                        ?>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>  
                <?php
                } 
            }
        }
    }
?>
<?php if($info['permissao']==1){ ?>
    <div class="row justify-content-end mt-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#activityGroupModal">Nova Atividade</button>
    </div>
<?php 
    }
?>
<!-- Modal Atividade -->
<div class="modal fade" id="activityGroupModal" tabindex="-1" role="dialog" aria-labelledby="activityGroupModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activityGroupModal">Cadastro de Atividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="msgErrorJs"></div>
                <form action="system/activities/ins_activities_groups.php" method="GET" name="frmActivity" id="frmActivity" onsubmit="return validateActivity(this)">
                    <input type="hidden" name="idGroup" value="<?php echo $idGroup;?>">
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
<!-- Modal alterar atividade grupo -->
<div class="modal fade" id="alterActivityGroup" tabindex="-1" role="dialog" aria-labelledby="alterActivityGroup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alterActivityGroup">Alterar Atividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="msgErrorJs"></div>
                <form action="system/activities/upd_activities.php" method="POST" name="frmActivity" id="frmActivity" onsubmit="return validateActivity(this)">
                    <div>
                        <input type="hidden" name="idActivity" value="">
                        <input type="hidden" name="idGroup" value="<?php echo $idGroup;?>">
                        <input type="hidden" name="idPage" value="<?php echo $idPage;?>">
                            <div>
                                <label>Nome:</label>
                                <input type="text" name="nameActivity" class="form-control" maxlength="20" value="">
                            </div>
                        </div>
                    <div>
                        <div>
                            <label>Descrição:</label>
                            <input type="textarea" name="descriptionActivity" class="form-control" value="">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label>Prazo:</label>
                            <input type="datetime-local" name="deadlineActivity" class="form-control" value="">
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