<?php
    $idUser = $_SESSION['id'];
    
    include "security/database/connection_database";
    $sql_user_history = "SELECT * FROM atividades AS a, usuarios_has_atividades AS ua WHERE ua.atividades_id = a.id AND ua.status = 1 AND ua.usuarios_id = :idUser";
    $instruction_user_history = $db_connection->prepare($sql_user_history);
    $instruction_user_history->bindParam(':idUser', $idUser);
    $instruction_user_history->execute();
    $result = $instruction_user_history->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <h2 class="font-weight-light">Histórico</h2>
    </div>
</div>
<div class="col-md-auto">
        <div class="row">
            <table class="table table-success table-hover">
                <thead class="thead-dark">
                    <th style="text-align: center; vertical-align:middle !important">Nome</th>
                    <th style="text-align: center; vertical-align:middle !important">Descrição</th>
                    <th style="text-align: center; vertical-align:middle !important">Experiência</th>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($result as $user_history): ?>
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $user_history['nome']; ?></td>
                        <td style="text-align: center; vertical-align:middle !important">
                        <?php
                            $length = strlen($user_history['descricao']);
                            $diff = ($length>30)?$length-30:0;
                            if($diff>0){
                                $description=$user_history['descricao']; 
                                $user_history['descricao'] = substr($user_history['descricao'], 0, -$diff);
                                $user_history['descricao']="<span title='".$description."' style='cursor: default;'>".$user_history['descricao']."...</span>";
                            }
                            echo $user_history['descricao'];
                            ?>
                        </td>
                        <td style="text-align: center; vertical-align:middle !important"><?php echo $user_history['experiencia']; ?></td>
                        
                    </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</div>