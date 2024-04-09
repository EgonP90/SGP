<?php
    $helper = new Helpers();
?>
<body>
    <div id="conteudo" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li class="breadcrumb-item"><a href="#">Produtos</a></li>
                <li class="breadcrumb-item"><a href="<?= URL ?>/produto/cadastro">Cadastrar Produtos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produtos Cadastrados</li>
            </ol>
        </nav>
        <div class="container conteudo_consulta">
        <form method="POST" action="<?= URL ?>/produto/consulta" id="form_busca_produto" name="form_busca_produto">
                <div class="row mt-5">
                    <div class="col-sm-5">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="descricao" name="descricao" placeholder="Descrição ou Código do Produto" value="<?= $dados["descricao"] != null ? $dados["descricao"] : '' ?>"/>
                            <label for="produto">Descrição ou Codigo do Produto</label>
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
                    }if(count($dados["dados"]) == 0){
                        echo "<h4><center>Produto não encontrado ou não cadastrado!!</center></h4>";
                    }else{
                ?>
                <h6>Produtos Cadastrados</h6>
                <div class="row mt-4">
                    <div class="col-sm-2">
                        CÓDIGO
                    </div>
                    <div class="col-sm-3">
                        DESCRIÇÃO
                    </div>
                    <div class="col-sm-2">
                        UNIDADE DE MEDIDA
                    </div>
                    <div class="col-sm-2">
                        VALOR (R$)
                    </div>
                    <div class="col-sm-1">
                        SITUAÇÃO
                    </div>
                </div>
                <hr class="divisor_horizontal">
                <?php 
                    foreach($dados["dados"] as $produtos){
                ?>
                    <div class="row mt-4">
                        <div class="col-sm-2">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $produtos->codigo_produto ?>
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $produtos->descricao ?>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $produtos->um ?>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $produtos->preco ?>
                            </p>
                        </div>
                        <div class="col-sm-1">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?php 
                                    if($produtos->situacao == 0)
                                        echo "Ativo";
                                    else if($produtos->situacao == 1)
                                        echo "Inativo";
                                ?>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-primary btn-sm" style="width: 100%;" data-toggle="modal" data-target="#modal-<?= $produtos->id ?>">Editar</a>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-<?= $produtos->id ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><?= $produtos->descricao ?> - <?= $produtos->codigo_produto ?></h4>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="<?= URL ?>/produto/alterar" id="form_altera_produto" name="form_altera_produto">
                                        <div class="row mt-3">
                                            <input type="hidden" id="id" name="id"  value="<?= $produtos->id ?>" required>
                                            <div class="col-sm-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código do Produto*" value="<?= $produtos->codigo_produto ?>" required>
                                                    <label for="codigo">Código do Produto*</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição*" value="<?= $produtos->descricao ?>" required>
                                                    <label for="nome">Descrição*</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="form-floating mt-3">
                                                    <select class="form-control" id="um" name="um" required>
                                                        <option value="KG" <?= $helper->setSelected("KG", $produtos->um) ?>>KG</option>
                                                        <option value="UN" <?= $helper->setSelected("UN", $produtos->um) ?>>UN</option>
                                                    </select>
                                                    <label for="un">Unidade de Medida*</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="preco" name="preco" placeholder="Preço*" value="<?= $produtos->preco ?>" required onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});">
                                                <label for="preco">Preço*</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mt-4">
                                                    <b>Data de Criação:</b> <?= $helper->formataDateTime($produtos->created_at) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mt-4">
                                                    <b>Última Alteração:</b> <?= $helper->formataDateTime($produtos->updated_at) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="inline inline-block">
                                                <input type="submit" class="btn btn-primary" style="margin-top:40px;" name="update" id="update" value="Alterar">
                                                <input type="submit" class="btn btn-danger" style="margin-top:40px;" name="delete" id="delete" value="Deletar">
                                                <?php 
                                                    if($produtos->situacao == 0){
                                                ?>
                                                        <input type="submit" class="btn btn-warning" style="margin-top:40px;" name="inativar" id="inativar" value="Inativar">
                                                <?php 
                                                    }else if($produtos->situacao == 1){
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
                <nav class="mt-5">
                    <ul class="pagination">
                        <div class="col-sm-6">
                            <li class="page-item">
                                <?php 
                                    $next = $dados["pag"] + 1;
                                    $previous = $dados["pag"] - 1;
                                    if($dados["pag"] > 1){
                                ?>
                                <a class="page-link w-50" href="<?= URL ?>/produto/consulta/<?= $previous ?>"><< Anterior</a>
                                <?php 
                                    }
                                ?>
                            </li>
                        </div>
                        <div class="col-sm-6">
                            <li class="page-item">
                                <?php 
                                    if($dados["ultima"] == 10){
                                ?>
                                <a class="page-link w-50" href="<?= URL ?>/produto/consulta/<?= $next ?>" style="float:right;text-align:right;">Próximo >></a>
                                <?php 
                                    }
                                }
                                ?>
                            </li>
                        </div>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</body>