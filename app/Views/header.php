<?php 

    $helper = new Helpers();
    if($helper->sessionValidate()){
?>
<style>
        /* Set the border color */
          
        .custom-toggler.navbar-toggler {
            border-color: white;
        }         
        .custom-toggler .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
</style>
<header>
    <nav class="navbar navbar-expand-md fixed-top backgroundCorPadrao">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <?php 
                            if($_SERVER["REQUEST_URI"] == "/sgp/index"){
                                $homeLink = 'textoCorPadraoActive';
                            }else{
                                $homeLink = 'textoCorPadrao';
                            }
                        ?>
                        <a class="nav-link <?= $homeLink ?>" aria-current="page" href="<?= URL ?>/index">
                            <div id="alinhaHome"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                                    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                                </svg>
                            </div>
                            <figcaption>Home</figcaption>
                        </a>
                    </li>
                    <?php
                        if($_SESSION["sgp_perfil"] != 3){
                    ?>
                    <li class="nav-item">
                        <?php 
                            if($_SERVER["REQUEST_URI"] == "/sgp/pedido" or $_SERVER["REQUEST_URI"] == "/sgp/pedido/novo" or $_SERVER["REQUEST_URI"] == "/sgp/pedido/finalizar" or $_SERVER["REQUEST_URI"] == "/sgp/pedido/index" or $_SERVER["REQUEST_URI"] == "/sgp/pedido/itens" or $_SERVER["REQUEST_URI"] == "/sgp/pedido/registrar" or $_SERVER["REQUEST_URI"] == "/sgp/pedido/editar"){
                                $pedidoLink = 'textoCorPadraoActive';
                            }else{
                                $pedidoLink = 'textoCorPadrao';
                            }
                        ?>
                        <a class="nav-link <?= $pedidoLink ?>" aria-current="page" href="<?= URL ?>/pedido">
                            <div id="alinhaPedido"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi        bi-arrow-up-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                                </svg>
                            </div>
                            <figcaption>Pedido</figcaption>
                        </a>
                    </li>
                    <?php 
                        }
                        if($_SESSION["sgp_perfil"] != 3){
                    ?>
                    <li class="nav-item">
                        <?php 
                            if($_SERVER["REQUEST_URI"] == "/sgp/cliente/cadastro" or $_SERVER["REQUEST_URI"] == "/sgp/cliente/consulta"){
                                $clienteLink = 'textoCorPadraoActive';
                            }else{
                                $clienteLink = 'textoCorPadrao';
                            }
                        ?>
                        <a class="nav-link <?= $clienteLink ?>" href="<?= URL ?>/cliente/cadastro">
                            <div id="alinhaClientes">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-c-square" viewBox="0 0 16 16">
                                    <path d="M8.146 4.992c-1.212 0-1.927.92-1.927 2.502v1.06c0 1.571.703 2.462 1.927 2.462.979 0 1.641-.586 1.729-1.418h1.295v.093c-.1 1.448-1.354 2.467-3.03 2.467-2.091 0-3.269-1.336-3.269-3.603V7.482c0-2.261 1.201-3.638 3.27-3.638 1.681 0 2.935 1.054 3.029 2.572v.088H9.875c-.088-.879-.768-1.512-1.729-1.512Z"/>
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"/>
                                </svg>
                            </div>
                            <figcaption>Clientes</figcaption>
                        </a>
                    </li>
                    <?php 
                        }
                        if($_SESSION["sgp_perfil"] == 0 or $_SESSION["sgp_perfil"] == 1){
                    ?>
                    <li class="nav-item">
                        <?php 
                            if($_SERVER["REQUEST_URI"] == "/sgp/produto/cadastro" or $_SERVER["REQUEST_URI"] == "/sgp/produto/consulta"){
                                $produtoLink = 'textoCorPadraoActive';
                            }else{
                                $produtoLink = 'textoCorPadrao';
                            }
                        ?>
                        <a class="nav-link <?= $produtoLink ?>" href="<?= URL ?>/produto/cadastro">
                            <div id="alinhaProduto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-box2" viewBox="0 0 16 16">
                                    <path d="M2.95.4a1 1 0 0 1 .8-.4h8.5a1 1 0 0 1 .8.4l2.85 3.8a.5.5 0 0 1 .1.3V15a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4.5a.5.5 0 0 1 .1-.3L2.95.4ZM7.5 1H3.75L1.5 4h6V1Zm1 0v3h6l-2.25-3H8.5ZM15 5H1v10h14V5Z"/>
                                </svg>
                            </div>  
                            <figcaption>Produtos</figcaption>
                        </a>
                    </li>
                    <?php 
                        }
                        if($_SESSION["sgp_perfil"] == 0 or $_SESSION["sgp_perfil"] == 1){
                    ?>
                    <li class="nav-item">
                        <?php 
                            if($_SERVER["REQUEST_URI"] == "/sgp/usuario/cadastro" or $_SERVER["REQUEST_URI"] == "/sgp/usuario/consulta"){
                                $usuarioLink = 'textoCorPadraoActive';
                            }else{
                                $usuarioLink = 'textoCorPadrao';
                            }
                        ?>
                        <a class="nav-link <?= $usuarioLink ?>" href="<?= URL ?>/usuario/cadastro">
                            <div id="alinhaUsuarios">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </div>  
                            <figcaption>Usuários</figcaption>
                        </a>
                    </li>
                    <?php 
                        }
                        if($_SESSION["sgp_perfil"] == 0 or $_SESSION["sgp_perfil"] == 1){
                    ?>
                    <li class="nav-item">
                        <?php 
                            if($_SERVER["REQUEST_URI"] == "/sgp/relatorio" or $_SERVER["REQUEST_URI"] == "/sgp/relatorio/index"){
                                $relatorioLink = 'textoCorPadraoActive';
                            }else{
                                $relatorioLink = 'textoCorPadrao';
                            }
                        ?>
                        <a class="nav-link <?= $relatorioLink ?>" href="<?= URL ?>/relatorio">
                            <div id="alinhaRelatorios">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2zm1 12h2V2h-2v12zm-3 0V7H7v7h2zm-5 0v-3H2v3h2z"/>
                                </svg>
                            </div>
                            <figcaption>Relatórios</figcaption>
                        </a>
                    </li>
                    <?php 
                        }
                        if($_SESSION["sgp_perfil"] == 0){
                    ?>
                    <li class="nav-item">
                        <?php 
                            if($_SERVER["REQUEST_URI"] == "/sgp/logs"){
                                $logsLink = 'textoCorPadraoActive';
                            }else{
                                $logsLink = 'textoCorPadrao';
                            }
                        ?>
                        <a class="nav-link <?= $logsLink ?>" href="<?= URL ?>/logs">
                            <div id="alinhaLogs">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-post" viewBox="0 0 16 16">
                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                    <path d="M4 6.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-7zm0-3a.5.5 0 0 1 .5-.5H7a.5.5 0 0 1 0 1H4.5a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </div>
                            <figcaption>Logs</figcaption>
                        </a>
                    </li>
                    <?php 
                        }
                    ?>
                    <li class="nav-item">
                        <?php 
                            if($_SERVER["REQUEST_URI"] == "/sgp/usuario/perfil"){
                                $perfilLink = 'textoCorPadraoActive';
                            }else{
                                $perfilLink = 'textoCorPadrao';
                            }
                        ?>
                        <a class="nav-link <?= $perfilLink ?>" href="<?= URL ?>/usuario/perfil">
                            <div id="alinhaPerfil"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
                                    <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                    <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                            </div>
                            <figcaption>Perfil</figcaption>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link textoCorPadrao" href="<?= URL ?>/login/logoff">
                            <div id="alinhaSair"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-bar-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8zm-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5z"/>
                                </svg>
                            </div>
                            <figcaption>Sair</figcaption>
                        </a>
                    </li>
                </ul>
                <form name="form_filtrar_search" id="form_filtrar_search" method="POST" action="<?= URL ?>/pedido/index">
                    <input class="form-control" type="text" placeholder="Pedido ou Cliente" name="search_pedido_cliente">
                </form>
            </div>
        </div>
    </nav>
</header>

<?php 
    }
?>