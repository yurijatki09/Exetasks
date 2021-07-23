<?php
    $idUser = $_GET['idUser'];
    $idGroup = $_GET['idGroup'];

    $sql_sel_users_activities = "SELECT a.nome AS atividadenome, a.descricao, a.prazo, ua.status, u.nome AS usuarionome FROM usuarios_has_atividades AS ua INNER JOIN atividades AS a ON ua.atividades_id = a.id INNER JOIN usuarios AS u ON u.id = ua.usuarios_id INNER JOIN grupos_has_atividades AS ga ON ga.atividades_id = ua.atividades_id INNER JOIN grupos AS g ON g.id = ga.grupos_id WHERE g.id=$idGroup";
    $sel_users_activities = $db_connection->prepare($sql_sel_users_activities);
    $users_activities = $sel_users_activities->execute();
    $fetch_users_activities = $sel_users_activities->fetchAll(PDO::FETCH_ASSOC); 
    
?>

<div class="row justify-content-md-center">
    <h3 class="font-weight-light">Relatório</h3>
</div>
<div class="row">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <th style="text-align: center; vertical-align:middle !important">Usuário</th>
            <th style="text-align: center; vertical-align:middle !important">Atividade</th>
            <th style="text-align: center; vertical-align:middle !important">Descrição</th>
            <th style="text-align: center; vertical-align:middle !important">Prazo</th>
            <th style="text-align: center; vertical-align:middle !important">Situação</th>
        </thead>
        <tbody>
            <?php foreach($fetch_users_activities as $users_activities){ 
                if($users_activities['status']==0){
                    $situacao = "A fazer";
                }else{
                    $situacao = "Concluída";
                }
                
                ?>
                <tr>
                    <td style="text-align: center; vertical-align:middle !important"><?php echo $users_activities['usuarionome']; ?></td>
                    <td style="text-align: center; vertical-align:middle !important"><?php echo $users_activities['atividadenome']; ?></td>
                    <td style="text-align: center; vertical-align:middle !important"><?php echo $users_activities['descricao']; ?></td>
                    <td style="text-align: center; vertical-align:middle !important"><?php echo $users_activities['prazo']; ?></td> 
                    <td style="text-align: center; vertical-align:middle !important"><?php echo $situacao; ?></td>
                </tr>
            <?php 
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