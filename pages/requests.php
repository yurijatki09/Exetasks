<?php 
    $idGroup = $_GET['idGroup'];

    include "security/database/connection_database.php";

    $sql_sel_users_pendency = "SELECT * FROM usuarios_has_grupos AS ug INNER JOIN usuarios AS u ON ug.usuarios_id = u.id WHERE ug.grupos_id = :idGroup";
    $instruction_users_pendency = $db_connection->prepare($sql_sel_users_pendency);
    $instruction_users_pendency->bindParam(':idGroup', $idGroup);
    $result_users_pendency = $instruction_users_pendency->execute();
    $pdo_users_pendency = $instruction_users_pendency->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="row justify-content-md-center">
    <h3 class="font-weight-light">Solicitações</h3>
</div>
<div class="row">
    <table class="table table-dark table-bordered table-striped">
        <thead class="thead-light">
            <th style="text-align: center; vertical-align:middle !important">Usuário</th>
            <th style="text-align: center; vertical-align:middle !important">Tipo</th>
            <th style="text-align: center; vertical-align:middle !important">Nível</th>
            <th style="text-align: center; vertical-align:middle !important">Ações</th>
        </thead>
        <tbody>
            <?php foreach($pdo_users_pendency as $users_pendency){
                if($users_pendency['status']==0){ ?>
                <tr>
                    <td style="text-align: center; vertical-align:middle !important"><?php echo $users_pendency['nome']; ?></td>
                    <td style="text-align: center; vertical-align:middle !important"><?php echo $users_pendency['tipo']; ?></td>
                    <td style="text-align: center; vertical-align:middle !important"><?php echo $users_pendency['nivel']; ?></td>
                    <td style="text-align: center; vertical-align:middle !important">
                        <a href="main.php?folder=system/groups/&file=accept_request.php&idUserPendency=<?php echo $users_pendency['id']; ?>&idGroup=<?php echo $idGroup; ?>">✓</a>
                        <a href="main.php?folder=system/groups/&file=refuse_request.php&idUserPendency=<?php echo $users_pendency['id']; ?>&idGroup=<?php echo $idGroup; ?>">〤</a>
                    </td>
                </tr>
            <?php }
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