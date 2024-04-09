<div id="conteudo">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-top: 2%;">
            <li class="breadcrumb-item"><a href="#">Usuário</a></li>
            <li class="breadcrumb-item"><a href="<?= URL ?>/usuario/consulta">Usuários Cadastrados</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastrar Usuário</li>
        </ol>
    </nav>
    <label class="titulo">Cadastro de Usuário</label>
    <form name="form_cad_usuario" id="form_cad_usuario" method="POST" action="<?= URL ?>/usuario/cadastrar/">
        <div class="form-center-conteudo">
            <?php 
                if(isset($_SESSION["sgp_rotina"]) and $_SESSION["sgp_tipo"] == 'success'){
            ?>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-success" role="alert">
                        <?= $_SESSION["sgp_mensagem"] ?>
                    </div>
                </div>
            </div>
            <?php 
                }
                if(isset($_SESSION["sgp_rotina"]) and $_SESSION["sgp_tipo"] == 'error'){
            ?>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION["sgp_mensagem"] ?>
                    </div>
                </div>
            </div>
            <?php 
                }
            ?>
            <div class="row mt-3">
                <div class="col-sm-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo*" required>
                        <label for="nome">Nome completo*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="login" name="login" placeholder="Login*" required>
                        <label for="login">Login*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="perfil" name="perfil" required>
                            <option value="">Selecione...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Operador</option>
                            <option value="3">Visualizador</option>
                        </select>
                        <label for="perfil">Perfil*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha*" required onkeyup="validaComplexidadeSenha(this.value);">
                        <label for="senha">Senha*</label>
                        <small id="avisoComplexidadeSenha" class="form-text" style="color:red; display:none;">
                            Sua senha deve ter no mínimo 6 caracteres.
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <input type="password" class="form-control" id="repeteSenha" name="repetesenha" placeholder="Repetir Senha*" required onkeyup="comparaSenhas(this.value);">
                        <label for="repeteSenha">Repetir Senha*</label>
                        <small id="avisoSenhasNaoConferem" class="form-text" style="color:red;display:none;">
                            As senhas devem ser iguais.
                        </small>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 mb-5">
                    <button class="w-100 btn btn-primary btn-lg" type="submit" name="cadastrar" id="cadastrar" value="cadastrar" disabled>Cadastrar</button>
                </div>
            </div>
            <?php 
                $_SESSION["sgp_rotina"] = null;
            ?>
        </div>
    </form>
</div>