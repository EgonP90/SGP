<div id="conteudo" style="margin-top: 5%;">
    <label class="titulo">Editar Perfil</label>
    <form name="form_cad_usuario" id="form_cad_usuario" method="POST" action="<?= URL ?>/usuario/alterarPerfil/">
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
                if(isset($_SESSION["sgp_rotina"]) and $_SESSION["sgp_tipo"] == 'warning'){
            ?>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
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
                        <input type="hidden" class="form-control" id="id" name="id" placeholder="Nome completo*" required value="<?= $dados['dados'][0]->id ?>">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo*" required value="<?= $dados['dados'][0]->nome ?>">
                        <label for="nome">Nome completo*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="login" name="login" placeholder="Login*" required disabled value="<?= $dados['dados'][0]->login ?>">
                        <label for="login">Login*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha*" onkeyup="validaComplexidadeSenha(this.value);">
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
                        <input type="password" class="form-control" id="repeteSenha" name="repetesenha" placeholder="Repetir Senha*" onkeyup="comparaSenhas(this.value);">
                        <label for="repeteSenha">Repetir Senha*</label>
                        <small id="avisoSenhasNaoConferem" class="form-text" style="color:red;display:none;">
                            As senhas devem ser iguais.
                        </small>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 mb-5">
                    <button class="w-100 btn btn-primary btn-lg" type="alterar" name="alterar" id="alterar" value="update">Alterar</button>
                </div>
            </div>
            <?php 
                $_SESSION["sgp_rotina"] = null;
            ?>
        </div>
    </form>
</div>