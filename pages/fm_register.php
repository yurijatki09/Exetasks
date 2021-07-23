<div class="row">
    <div class="col-md-6 justify-content-md-center content">
        <h1 class="font-weight-light d-flex justify-content-center">Junte-se a nós!</h1>
        <br>
        <h2 class="font-weight-light d-flex justify-content-center">Obtenha recompensas ao completar tarefas.</h2>
        <h2 class="font-weight-light d-flex justify-content-center">Vamos estudar!</h2>
    </div>
    <div class="col-md-6">
        <form action="index.php?folder=system/users/&file=ins_users.php" method="POST" name="regUser" class="justify-content-md-center content">
            <div class="d-flex justify-content-center">
                <h1 class="font-weight-light">Cadastre-se</h1>
            </div>
            <div class="col-md-12">
                <label for="nameUser"></label>
                <input type="text" name="nameUser" class="form-control" placeholder="Nome" maxlength="20">
            </div>
            <div class="col-md-12">
                <label for="nicknameUser"></label>
                <input type="text" name="nicknameUser" class="form-control" placeholder="Usuário" maxlength="20">
            </div>
            <div class="col-md-12">
                <label for="passwordUser"></label>
                <input type="password" name="passwordUser" class="form-control" placeholder="Senha" maxlength="32">
            </div>
            <div class="col-md-12">
                <label for="emailUser"></label>
                <input type="email" name="emailUser" class="form-control" placeholder="E-mail" maxlength="40">
            </div>
            <div class="col-md-12">
                <label for="ageUser"></label>
                <input type="date" name="ageUser" class="form-control" placeholder="Data de Nascimento">
            </div>
            <div class="form-group col-md-12">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="typeUser"></label>
                        <select name="typeUser" id="typeUser" class="form-control">
                            <option value="">Você é...</option>
                            <option value="P">Professor</option>
                            <option value="E">Estudante</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="sexUser"></label>
                        <select name="sexUser" id="sexUser" class="form-control">
                            <option value="">Sexo</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
            </div>
        </form>
    </div>
</div>
