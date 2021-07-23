<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <h2 class="font-weight-light">Ranking Geral</h2>
    </div>
</div>
<div class="col-md-auto">
    <?php
        $id = $_SESSION['id'];
        include "security/database/connection_database.php";
        $sql_sel = "SELECT * FROM usuarios ORDER BY experiencia DESC LIMIT 11";
        $instruction = $db_connection->prepare($sql_sel);
        $instruction->execute();
        $ranking = $instruction->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <div class="row">
        <table class="table table-light table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">usuario</th>
                    <th scope="col">nivel</th>
                    <th scope="col">xp</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($ranking as $usuario): ?>
                <tr>
                    <?php $i++; ?>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td><?php echo $usuario['nivel']; ?></td>
                    <td><?php echo $usuario['experiencia']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>    