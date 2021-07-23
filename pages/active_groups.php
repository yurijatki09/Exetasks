<div class="row">
    <h3 class="font-weight-light text-center">Grupos Ativos</h3>
    <form class="form-inline ml-auto" action="main.php?folder=pages/&file=active_groups.php" method="POST" name="frmSearchGroup">
        <div class="md-form my-0">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#groupModal">Novo Grupo</button>
            <input class="form-control" type="text" name="searchGroups" placeholder="Pesquisar Grupo" aria-label="Search">
        </div>
        <button class="btn btn-outline-primary btn-md my-0 ml-sm-2" type="submit">Pesquisar</button>
    </form>
</div>
<?php
    //Lista e solicita entrada nos grupos
    ob_start();
    session_start();
    $id = $_SESSION['id'];
    if(isset($_POST['searchGroups'])){
        $searchGroups = $_POST['searchGroups'];
        include "security/database/connection_database.php";

        //Select para pegar os ids dos grupos que o usuário já está.
        $sql_sel_groups_f = "SELECT DISTINCT grupos_id, grupos.nome FROM usuarios_has_grupos INNER JOIN grupos ON grupos.id=usuarios_has_grupos.grupos_id WHERE usuarios_id=$id";
        $instruction_sel_groups_f = $db_connection->prepare($sql_sel_groups_f);
        $result_sel_groups_f = $instruction_sel_groups_f->execute();
        $fetch_sel_groups_f = $instruction_sel_groups_f->fetchAll(PDO::FETCH_ASSOC);
        $ids_active_groups = "(";
        foreach($fetch_sel_groups_f as $group){
            $ids_active_groups .= $group['grupos_id'].",";
        }
        $ids_active_groups = substr($ids_active_groups, 0, -1);
        $ids_active_groups .= ")";
        if($ids_active_groups==")"){
            //Select se o usuário não estiver em nenhum grupo
            $sql_sel_groups = "SELECT g.id, g.nome, g.descricao, i.nome AS interessesnome FROM grupos AS g INNER JOIN interesses AS i ON g.interesses_id = i.id";
            $instruction_sel_groups = $db_connection->prepare($sql_sel_groups);
            $result_sel_groups = $instruction_sel_groups->execute();
            $fetch_sel_groups = $instruction_sel_groups->fetchAll(PDO::FETCH_ASSOC);
        }else{
            //Select filtrando os grupos que o usuário já está e trazendo os que ele não está como resultado
            $sql_sel_groups = "SELECT g.id, g.nome, g.descricao, i.nome AS interessesnome FROM grupos AS g INNER JOIN interesses AS i ON g.interesses_id = i.id WHERE g.id NOT IN $ids_active_groups";
            $instruction_sel_groups = $db_connection->prepare($sql_sel_groups);
            $result_sel_groups = $instruction_sel_groups->execute();
            $fetch_sel_groups = $instruction_sel_groups->fetchAll(PDO::FETCH_ASSOC);
        }
        if($result_sel_groups){ ?>
            <button type="button" class="close" aria-label="Close" onclick="closeSearchGroups(this)">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" id="searchGroups">
                    <thead class="thead-dark">
                        <th style="text-align: center; vertical-align:middle !important">Nome</th>
                        <th style="text-align: center; vertical-align:middle !important">Descrição</th>
                        <th style="text-align: center; vertical-align:middle !important">Interesse</th>
                        <th style="text-align: center; vertical-align:middle !important">Acesso</th>
                    </thead>
                    <tbody>
                        <?php foreach($fetch_sel_groups as $sel_groups): ?>
                            <tr>
                                <td style="text-align: center; vertical-align:middle !important"><?php echo $sel_groups['nome']; ?></td>
                                <td style="text-align: center; vertical-align:middle !important"><?php echo $sel_groups['descricao']; ?></td>
                                <td style="text-align: center; vertical-align:middle !important"><?php echo $sel_groups['interessesnome']; ?></td>
                                <td style="text-align: center; vertical-align:middle !important">
                                    <a href="main.php?folder=system/groups/&file=request_groups.php&idUser=<?php echo $id; ?>&idGroup=<?php echo $sel_groups['id']; ?>">
                                        <button type="button" class="btn btn-outline-primary">Solicitar</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
<?php }
    }
?>
<div class ="row justify-content-between pt-3">
<?php 
    //querys usuários e grupos inserir e alterar
    $sql_sel_users_has_groups = "SELECT g.id, g.nome, ug.status AS usuariogrupostatus, ug.permissao, g.status AS grupostatus, i.nome AS interessesnome, i.id AS interessescodigo, g.descricao FROM usuarios_has_grupos AS ug INNER JOIN grupos AS g ON ug.grupos_id = g.id INNER JOIN interesses AS i ON g.interesses_id = i.id WHERE ug.usuarios_id = $id";
    $instruction_users_has_groups = $db_connection->prepare($sql_sel_users_has_groups);
    $instruction_users_has_groups->execute();
    $count_groups = $instruction_users_has_groups->rowCount();
    $users_has_groups = $instruction_users_has_groups->fetchAll(PDO::FETCH_ASSOC);
    
    $sql_sel_status_groups = "SELECT * FROM usuarios_has_grupos AS ug INNER JOIN grupos AS g ON ug.grupos_id = g.id WHERE ug.status = 1 AND ug.usuarios_id = $id AND g.status = 1";
    $instruction_users_status = $db_connection->prepare($sql_sel_status_groups);
    $instruction_users_status->execute();
    $count_groups_status = $instruction_users_status->rowCount();
    
    if(($count_groups_status==0)||($count_groups_status==0)){?>
        <div class="col-md-12">
            <div class="card py-md-3">
                <div class="card-body">
                    <h6 class="card-subtitle text-center text-muted">Você não está cadastrado em nenhum grupo no momento.</h6>
                </div>
            </div>
        </div>
    <?php    
    }else{
        foreach($users_has_groups as $nameGroup){
            if($nameGroup['grupostatus']==1){
                if($nameGroup['usuariogrupostatus']==1){ ?>
                    <div class="card border-primary col-md-5 mb-3" style="max-width: 18rem;">
                        <form action = "main.php" method="GET" name="frm_group_id">
                            <div class="card-header bg-transparent border-primary">
                                <?php echo $nameGroup['nome'];?>
                            </div>
                            <div class="card-body text-primary">
                                <h5 class="card-title"><?php echo $nameGroup['interessesnome'];?></h5>
                                <p class="card-text"><?php echo $nameGroup['descricao']; ?></p> 
                            </div>
                            <div class="card-footer bg-transparent border-primary">
                                <div class="row justify-content-between">
                                    <input type="hidden" name="folder" value="pages/">
                                    <input type="hidden" name="file" value="group.php">
                                    <input type="hidden" name="idGroup" value="<?php echo $nameGroup['id'] ?>">
                                    <?php $sizeCol = ($nameGroup['permissao']==1)?5:12; ?>
                                    <button type="submit" class="btn btn-primary col-md-<?=$sizeCol?>">Entrar</button>
                                    <?php 
                                        if($nameGroup['permissao']==1){ ?>
                                        <button type="button" class="btn btn-secondary col-md-5" id="btn-alterGroup"  data-toggle="modal" data-target="#groupAlterModal" data-id="<?=$nameGroup['id']?>" data-nome="<?=$nameGroup['nome']?>" data-descricao="<?=$nameGroup['descricao']?>" data-tipo="<?=$nameGroup['interessescodigo']?>">Alterar</button>
                                            
                                    <?php 
                                        } 
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php   
                }
            }
        }
    }
?>
</div>
<div class="row">
    <h3 class="font-weight-light">Convite de grupos</h3>
</div>
<div class ="row justify-content-between pt-3">
    <?php
    $sql_sel_status_invite = "SELECT * FROM usuarios_has_grupos AS ug WHERE ug.status = 2 AND ug.usuarios_id = $id";
    $instruction_invite_status = $db_connection->prepare($sql_sel_status_invite);
    $instruction_invite_status->execute();
    $count_invite_status = $instruction_invite_status->rowCount();

    if(($count_invite_status==0)||($count_groups==0)){?>
        <div class="col-md-12">
            <div class="card py-md-3">
                <div class="card-body">
                    <h6 class="card-subtitle text-center text-muted">Você não tem nenhum convite para grupo no momento.</h6>
                </div>
            </div>
        </div>
    <?php
    }else{
        foreach($users_has_groups as $nameGroup){
            if($nameGroup['grupostatus']==1){
                if($nameGroup['usuariogrupostatus']==2){ ?>
                    <div class ="card border-primary col-md-5 mb-3" style="max-width: 18rem;">
                        <form action = "main.php?folder=system/groups/&file=accept_invite.php" method="POST" name="frm_group_id" >
                            <div class="card-header bg-transparent border-primary">
                                <?php echo $nameGroup['nome'];?>
                            </div>
                            <div class="card-body text-primary">
                                <h5 class="card-title"><?php echo $nameGroup['interessesnome'];?></h5>
                                <p class="card-text"><?php echo $nameGroup['descricao']; ?></p> 
                            </div>
                            <input type="hidden" name="idGroup" value="<?php echo $nameGroup['id'] ?>">
                            <div class="card-footer bg-transparent border-primary">
                                <div class="row justify-content-between">
                                    <div class="col-md-5">
                                        <button type="submit" class="btn btn-success btn-sm btn-block">Aceitar</button>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="main.php?folder=system/groups/&file=refuse_invite.php&idGroup=<?php echo $nameGroup['id']; ?>&idUser=<?php echo $id; ?>">
                                            <button type="button" class="btn btn-danger btn-sm btn-block">Recusar</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php 
                }
            }
        }
    }
?>
</div>
<div class="modal fade" id="groupAlterModal" tabindex="-1" role="dialog" arial-labelledby="groupAlterModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="groupAlterModalTitulo">Alterar Grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="return clear();">
                    <span aria-hideen="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="msgErrorJs"></div>
                <form action="main.php" method="GET" name="frmAlterGroup" id="frmAlterGroup" onsubmit="return validateGroup(this)">
                    <input type="hidden" name="folder" value="system/groups/">
                    <input type="hidden" name="file" value="upd_groups.php">
                    <input type="hidden" name="idGroup" value="">
                    <div>
                        <div>
                            <label for="nameGroup">Nome:</label>
                            <input type="text" name="nameGroup" class="form-control" maxlenght="20">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="descriptionGroup">Descrição:</label>
                            <input type="text" name="descriptionGroup" class="form-control">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="interestsGroup">Tipo de conteúdo:</label>
                            <fieldset>
                                <?php
                                    include "security/database/connection_database.php";
                                    $sql_sel_interests = "SELECT * from interesses ORDER BY nome ASC";
                                    $instruction = $db_connection->prepare($sql_sel_interests);
                                    $instruction->execute();
                                ?>
                                <select name="interestsGroup">
                                    <option value=""></option>
                                    <?php
                                        while($sql_sel_interests=$instruction->fetch()){
                                    ?>
                                    <option value="<?php echo $sql_sel_interests['id']; ?>"><?php echo $sql_sel_interests['nome']; ?></option>
                                    <?php } ?>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block">Alterar</button>
                    </div>
                    <div>
                        <a id="linkDesativar" href="">
                            <button type="button" class="btn btn-outline-danger btn-sm btn-block" name="btndesativar">Desativar Grupo</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fim modal alterar grupo -->
<!--modal add grupo-->
<div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="groupModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="groupModal">Cadastro de Grupos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="return clear();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="msgErrorJs"></div>
                <form action="system/groups/ins_groups.php" method="POST" name="frmGroup" id="frmGroup" onsubmit="return validateGroup(this)">
                    <div>
                        <div>
                            <label>Nome:</label>
                            <input type="text" name="nameGroup" class="form-control" maxlength="20">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label>Descrição:</label>
                            <input type="textarea" name="descriptionGroup" class="form-control">
                        </div>
                    </div>
                    <div>
                        <label for="interests">Tipo de conteúdo</label>
                        <fieldset>
                            <?php
                                include "security/database/connection_database.php";
                                $sql_sel_interests = "SELECT * from interesses ORDER BY nome ASC";
                                $instruction = $db_connection->prepare($sql_sel_interests);
                                $instruction->execute();
                            ?>
                            <select name="interestsGroup" class="form-control">
                                <option value=""></option>
                                <?php
                                    while($sql_sel_interests=$instruction->fetch()){
                                ?>
                                <option value="<?php echo $sql_sel_interests['id']; ?>"><?php echo $sql_sel_interests['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- fim modal add grupo-->
