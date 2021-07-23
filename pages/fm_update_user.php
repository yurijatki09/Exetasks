<div class="row">
<?php
  session_start();
  $id = $_SESSION['id'];
  $nameUser = $_SESSION['nameUser'];
  $ageUser = $_SESSION['ageUser'];
  $sexUser = $_SESSION['sexUser'];
  $typeUser = $_SESSION['typeUser'];
  include "security/database/connection_database.php";
?>
  <h2 class="font-weight-light">Alterar Dados</h2>
    <div class="col-md-6">
        <form action="main.php?folder=system/users/&file=upd_users.php" method="POST" name="updateUser" class="justify-content-md-center content">
            <div class="col-md-12">
                <label for="nameUser"></label>
                <input type="text" name="nameUser" class="form-control" placeholder="Nome completo" maxlength="20" value="<?php echo $nameUser?>">
            </div>
            <div class="col-md-12">
                <label for="nicknameUser"></label>
                <input type="text" name="nicknameUser" class="form-control" placeholder="Apelido" maxlength="20" value="<?php echo $user?>">
            </div>
            <div class="col-md-12">
                <label for="emailUser"></label>
                <input type="email" name="emailUser" class="form-control" placeholder="E-mail" maxlength="40" value="<?php echo $_SESSION['emailUser']?>">
            </div>
            <div class="col-md-12">
                <label for="ageUser"></label>
                <input type="date" name="ageUser" class="form-control" placeholder="Data de Nascimento" value="<?php echo $ageUser ?>">
            </div>
            <div class="form-group col-md-12">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="typeUser"></label>
                        <select name="typeUser" id="typeUser" class="form-control">
                          <?php if($typeUser == "P"){ ?>
                              <option value="P">Professor</option>
                              <option value="E">Estudante</option>
                          <?php  }else{ ?>
                            <option value="E">Estudante</option>
                            <option value="P">Professor</option>
                          <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="sexUser"></label>
                        <select name="sexUser" id="sexUser" class="form-control">
                          <?php if($sexUser == "M"){ ?>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                          <?php }else{ ?>
                            <option value="F">Feminino</option>
                            <option value="M">Masculino</option>
                          <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-primary btn-block">Alterar</button>
            </div>
            <div class="form-group col-md-12">
              <a href="main.php?folder=system/users/&file=del_users.php">
                <button type="button" class="btn btn-danger btn-block">Deletar Usuário</button>
              </a>
            </div> 
        </form>
    </div>
</div>
