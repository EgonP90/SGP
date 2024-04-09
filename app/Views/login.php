<div class="login_page_computador" id="login-page">
    <form name="form_login_admin" id="form_login_admin" method="POST" action="<?= URL ?>/login/validaLogin">
        <div class="row mb-5">
            <div class="col=12 title_center">
                <h1 class="h3 mb-3 fw-normal">Insira suas credencais de acesso</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="login" name="login">
                    <label for="floatingInput">Login</label>
                </div>
            </div>
        </div>            
        <div class="row">
            <div class="col-sm-12 mt-4">
                <div class="form-floating mt-2">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="******" required>
                    <label for="floatingPassword">Senha</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="checkbox mb-3 mt-2">
                    <label>
                      <!--  <input type="checkbox" name="keepConnected" id="keepConnected"> Mantenha-me conectado -->
                    </label>
                </div>
            </div>
        </div>
        <?php 
            if(isset($_SESSION["sgp_rotina"]) and $_SESSION["sgp_tipo"] == 'error'){
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<center>".$_SESSION["sgp_mensagem"]."</center>";
                echo "</div>";
            }
        ?>
        <div class="row mt-3">
            <div class="col-sm-12">
                <input class="w-100 btn btn-lg btn-primary" type="submit" name="btLogin" id="btLogin" value="Entrar">
            </div>
        </div>
    </form>
</div>
<?php
    $_SESSION["sgp_rotina"] = null;
?>