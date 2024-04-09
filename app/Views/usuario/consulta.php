<?php
    $helper = new Helpers();
?>
<body>
    <div id="conteudo" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li class="breadcrumb-item"><a href="#">Usuários</a></li>
                <li class="breadcrumb-item"><a href="<?= URL ?>/usuario/cadastro">Cadastrar Usuários</a></li>
                <li class="breadcrumb-item active" aria-current="page">Usuários Cadastrados</li>
            </ol>
        </nav>
        <div class="container conteudo_consulta">
            <form method="POST" action="<?= URL ?>/usuario/consulta" id="form_busca_usuario" name="form_busca_usuario">
                <div class="row mt-5">
                    <div class="col-sm-5">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="nome_usuario" name="nome_usuario" placeholder="Nome do Usuário" value="<?= $dados["nome"] != null ? $dados["nome"] : '' ?>"/>
                            <label for="usuario">Nome do Usuário</label>
                        </div>
                    </div>
                    <div class="col-sm-2 mt-2">
                        <button class="w-100 btn btn-primary btn-lg" type="submit" name="buscar">Buscar</button>
                    </div>
                    <div class="col-sm-2 mt-2">
                        <button class="w-100 btn btn-warning btn-lg" type="submit" name="limpar">Limpar</button>
                    </div>
                </div>
            </form>
            <div class="resultados_admin mt-4">
                <?php 
                    if(isset($_SESSION["sgp_rotina"])){
                        if($_SESSION["sgp_tipo"] == "error")
                            $tipo = "danger";
                        else if($_SESSION["sgp_tipo"] == "success")
                            $tipo = "success";
                        else if($_SESSION["sgp_tipo"] == "warning")
                            $tipo = "warning";
                ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-<?= $tipo ?>" role="alert">
                                <?= $_SESSION["sgp_mensagem"] ?>
                            </div>
                        </div>
                    </div>
                <?php 
                    }
                ?>
                <h6>Usuários Cadastrados</h6>
                <div class="row mt-4">
                    <div class="col-sm-3">
                        NOME
                    </div>
                    <div class="col-sm-3">
                        LOGIN
                    </div>
                    <div class="col-sm-3">
                        PERFIL
                    </div>
                    <div class="col-sm-1">
                        SITUAÇÃO
                    </div>
                </div>
                <hr class="divisor_horizontal">
                <?php 
                    foreach($dados["dados"] as $usuarios){
                ?>
                    <div class="row mt-4">
                        <div class="col-sm-3">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $usuarios->nome ?>
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $usuarios->login ?>
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?php 
                                    $perfil = [
                                        '0' => 'Super Administrador',
                                        '1' => 'Administrador',
                                        '2' => 'Operador',
                                        '3' => 'Visualizador',
                                    ];
                                    echo $perfil[$usuarios->perfil];
                                ?>
                            </p>
                        </div>
                        <div class="col-sm-1">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?php 
                                    if($usuarios->situacao == 0)
                                        echo "Ativo";
                                    else if($usuarios->situacao == 1)
                                        echo "Inativo";
                                ?>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-primary btn-sm" style="width: 100%;" data-toggle="modal" data-target="#modal-<?= $usuarios->id ?>">Editar</a>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-<?= $usuarios->id ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><?= $usuarios->nome ?></h4>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="<?= URL ?>/usuario/alterar" id="form_altera_usuario" name="form_altera_usuario">
                                        <div class="row mt-3">
                                            <input type="hidden" id="id" name="id"  value="<?= $usuarios->id ?>" required>
                                            <div class="col-sm-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" value="<?= $usuarios->nome ?>" required>
                                                    <label for="nome">Nome completo</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-floating mt-3">
                                                    <input type="login" class="form-control" id="login" name="login" placeholder="E-mail" value="<?= $usuarios->login ?>" disabled required>
                                                    <label for="login">Login</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-floating mt-3">
                                                    <select class="form-control" id="perfil" name="perfil" required>
                                                        <option value="1" <?= $helper->setSelected(1, $usuarios->perfil) ?>>Administrador</option>
                                                        <option value="2" <?= $helper->setSelected(2, $usuarios->perfil) ?>>Operador</option>
                                                        <option value="3" <?= $helper->setSelected(3, $usuarios->perfil) ?>>Visualizador</option>
                                                    </select>
                                                    <label for="email">Perfil</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-floating mt-3">
                                                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" value="">
                                                    <label for="senha">Senha</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-floating mt-3">
                                                    <input type="password" class="form-control" id="repeteSenha" name="repetesenha" placeholder="Repetir Senha" value="">
                                                    <label for="repeteSenha">Repetir Senha</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mt-4">
                                                   <b>Último Acesso:</b> <?= $helper->formataDateTime($usuarios->ultimo_acesso) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mt-4">
                                                    <b>Data de Criação:</b> <?= $helper->formataDateTime($usuarios->created_at) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mt-4">
                                                    <b>Última Alteração:</b> <?= $helper->formataDateTime($usuarios->updated_at) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="inline inline-block">
                                                <input type="submit" class="btn btn-primary" style="margin-top:40px;" name="update" id="update" value="Alterar">
                                                <?php 
                                                    if($usuarios->situacao == 0){
                                                ?>
                                                        <input type="submit" class="btn btn-warning" style="margin-top:40px;" name="inativar" id="inativar" value="Inativar">
                                                <?php 
                                                    }else if($usuarios->situacao == 1){
                                                ?>
                                                        <input type="submit" class="btn btn-success" style="margin-top:40px;" name="ativar" id="ativar" value="Ativar">
                                                <?php 
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                    $_SESSION["sgp_rotina"] = null;
                ?>
            </div>
        </div>
    </div>
</body>