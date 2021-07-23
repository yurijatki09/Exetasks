<?php
    $idGroup = $_GET['idGroup'];
    $idUser = $_GET['idUser'];

    include "security/database/connection_database.php";

    $sql_sel_users_group = "SELECT * from usuarios_has_grupos AS ug INNER JOIN usuarios AS u ON ug.usuarios_id = u.id WHERE grupos_id = :idGroup";
    $instruction_users_group = $db_connection->prepare($sql_sel_users_group);
    $instruction_users_group->bindParam(':idGroup', $idGroup);
    $result_users_group = $instruction_users_group->execute();
    $pdo_users_group = $instruction_users_group->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Tabela para mostrar apenas administradores -->
<h3 class="font-weight-light text-center">Administrador</h3>
<div class="row">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <th style="text-align: center; vertical-align:middle !important">Usuário</th>
            <th style="text-align: center; vertical-align:middle !important">E-mail</th>
            <th style="text-align: center; vertical-align:middle !important">Nível</th>
            <th style="text-align: center; vertical-align:middle !important">Tipo</th>
        </thead>
        <tbody>
            <?php foreach($pdo_users_group as $users_group){
                if($users_group['permissao']==1){ ?>
                    <tr>
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $users_group['usuario']; ?></td>   
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $users_group['email']; ?></td>
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $users_group['nivel']; ?></td>
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $users_group['tipo']; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<!-- Tabela para mostrar usuários comuns -->
<div class="row justify-content-md-center">
    <h3 class="font-weight-light">Integrantes</h3>
</div>
<div class="row">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <th style="text-align: center; vertical-align:middle !important">Usuário</th>
            <th style="text-align: center; vertical-align:middle !important">E-mail</th>
            <th style="text-align: center; vertical-align:middle !important">Nível</th>
            <th style="text-align: center; vertical-align:middle !important">Ações</th>
        </thead>
        <tbody>
            <?php foreach($pdo_users_group as $users_group){
                if(($users_group['permissao']!=1) && ($users_group['status']==1)){ ?>
                    <tr>
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $users_group['usuario']; ?></td>
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $users_group['email']; ?></td>
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $users_group['nivel']; ?></td>
                        <td style="text-align: center; vertical-align:middle !important">
                            <a href="main.php?folder=system/groups/&file=del_users_group.php&idUserDel=<?php echo $users_group['id']; ?>&idGroupUserDel=<?php echo $users_group['grupos_id']; ?>&idUserAdm=<?php echo $idUser; ?>&idGroup=<?php echo $idGroup; ?>">〤</a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<form action="main.php" method="GET">
    <input type="hidden" name="folder" value="pages/">
    <input type="hidden" name="file" value="group.php">
    <input type="hidden" name="idGroup" value="<?php echo $idGroup; ?>">
    <button type="submit" class="btn btn-secondary">Voltar ao grupo</button>
</form>