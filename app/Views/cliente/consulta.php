<?php
    $helper = new Helpers();
?>
<body>
    <div id="conteudo" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li class="breadcrumb-item"><a href="#">Clientes</a></li>
                <li class="breadcrumb-item"><a href="<?= URL ?>/cliente/cadastro">Cadastrar Clientes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clientes Cadastrados</li>
            </ol>
        </nav>
        <div class="container conteudo_consulta">
            <form method="POST" action="<?= URL ?>/cliente/consulta" id="form_busca_cliente" name="form_busca_cliente">
                <div class="row mt-5">
                    <div class="col-sm-5">
                        <div class="form-floating mt-2">
                            <input class="form-control" type="text" id="nome_cliente" name="nome_cliente" placeholder="Nome do Cliente" value="<?= $dados["nome"] != null ? $dados["nome"] : '' ?>"/>
                            <label for="cliente">Nome do Cliente</label>
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
                    if(count($dados["dados"]) == 0){
                        echo "<h4><center>Cliente não encontrado ou não cadastrado!!</center></h4>";
                    }else{
                ?>
                <h6>Clientes Cadastrados</h6>
                <div class="row mt-4">
                    <div class="col-sm-3">
                        NOME
                    </div>
                    <div class="col-sm-2">
                        TELEFONE
                    </div>
                    <div class="col-sm-3">
                        CIDADE
                    </div>
                    <div class="col-sm-2">
                        BAIRRO
                    </div>
                </div>
                <hr class="divisor_horizontal">
                <?php
                    foreach($dados["dados"] as $clientes){
                ?>
                    <div class="row mt-4">
                        <div class="col-sm-3">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $clientes->nome ?>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $clientes->telefone ?>
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $clientes->cidade ?>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $clientes->bairro ?>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-primary btn-sm" style="width: 100%;" data-toggle="modal" data-target="#modal-<?= $clientes->id ?>">Editar</a>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-<?= $clientes->id ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><?= $clientes->nome ?></h4>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="<?= URL ?>/cliente/alterar" id="form_altera_cliente" name="form_altera_cliente">
                                        <input type="hidden" id="id" name="id"  value="<?= $clientes->id ?>" required>
                                        <div class="row mt-3">
                                        <div class="col-sm-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome*" required value="<?= $clientes->nome ?>">
                                                <label for="nome">Nome*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="cpfcnpj" name="cpfcnpj" placeholder="cpfcnpj" value="<?= $clientes->cpfcnpj ?>" onkeypress='mascaraMutuario(this,cpfCnpj)'>
                                                <label for="cpfcnpj">CPF/CNPJ</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone*" required value="<?= $clientes->telefone ?>" onkeypress='mascaraMutuario(this,mtel)' maxlength="15">
                                                <label for="telefone">Telefone*</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-3">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" value="<?= $clientes->cep ?>" onBlur="buscaCep(this.value);" onkeypress='mascaraMutuario(this,cepMasc)' maxlength="9">
                                                <label for="cep">CEP</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="Logradouro" value="<?= $clientes->rua ?>">
                                                <label for="logradouro">Logradouro</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" 
                                                value="<?php echo $clientes->numero_endereco == 0 ? '' : $clientes->numero_endereco; ?>">
                                                <label for="numero">Número</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complem." value="<?= $clientes->complemento ?>">
                                                <label for="complemento">Complem.</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-4">
                                            <div class="form-floating mt-3">
                                                <select class="form-control" id="estado" name="estado">
                                                    <option value="">Selecione...</option>
                                                    <option value="AC" <?= $helper->setSelected('AC', $clientes->estado) ?>>AC</option>
                                                    <option value="AL" <?= $helper->setSelected('AL', $clientes->estado) ?>>AL</option>
                                                    <option value="AP" <?= $helper->setSelected('AP', $clientes->estado) ?>>AP</option>
                                                    <option value="AM" <?= $helper->setSelected('AM', $clientes->estado) ?>>AM</option>
                                                    <option value="BA" <?= $helper->setSelected('BA', $clientes->estado) ?>>BA</option>
                                                    <option value="CE" <?= $helper->setSelected('CE', $clientes->estado) ?>>CE</option>
                                                    <option value="DF" <?= $helper->setSelected('DF', $clientes->estado) ?>>DF</option>
                                                    <option value="ES" <?= $helper->setSelected('ES', $clientes->estado) ?>>ES</option>
                                                    <option value="GO" <?= $helper->setSelected('GO', $clientes->estado) ?>>GO</option>
                                                    <option value="MA" <?= $helper->setSelected('MA', $clientes->estado) ?>>MA</option>
                                                    <option value="MT" <?= $helper->setSelected('MT', $clientes->estado) ?>>MT</option>
                                                    <option value="MS" <?= $helper->setSelected('MS', $clientes->estado) ?>>MS</option>
                                                    <option value="MG" <?= $helper->setSelected('MG', $clientes->estado) ?>>MG</option>
                                                    <option value="PA" <?= $helper->setSelected('PA', $clientes->estado) ?>>PA</option>
                                                    <option value="PB" <?= $helper->setSelected('PB', $clientes->estado) ?>>PB</option>
                                                    <option value="PR" <?= $helper->setSelected('PR', $clientes->estado) ?>>PR</option>
                                                    <option value="PE" <?= $helper->setSelected('PE', $clientes->estado) ?>>PE</option>
                                                    <option value="PI" <?= $helper->setSelected('PI', $clientes->estado) ?>>PI</option>
                                                    <option value="RJ" <?= $helper->setSelected('RJ', $clientes->estado) ?>>RJ</option>
                                                    <option value="RN" <?= $helper->setSelected('RN', $clientes->estado) ?>>RN</option>
                                                    <option value="RS" <?= $helper->setSelected('RS', $clientes->estado) ?>>RS</option>
                                                    <option value="RO" <?= $helper->setSelected('RO', $clientes->estado) ?>>RO</option>
                                                    <option value="RR" <?= $helper->setSelected('RR', $clientes->estado) ?>>RR</option>
                                                    <option value="SC" <?= $helper->setSelected('SC', $clientes->estado) ?>>SC</option>
                                                    <option value="SP" <?= $helper->setSelected('SP', $clientes->estado) ?>>SP</option>
                                                    <option value="SE" <?= $helper->setSelected('SE', $clientes->estado) ?>>SE</option>
                                                    <option value="TO" <?= $helper->setSelected('TO', $clientes->estado) ?>>TO</option>
                                                </select>
                                                <label for="estado">Estado</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="<?= $clientes->cidade ?>">
                                                <label for="cidade">Cidade</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?= $clientes->bairro ?>">
                                                <label for="bairro">Bairro</label>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mt-4">
                                                    <b>Data de Criação:</b> <?= $helper->formataDateTime($clientes->created_at) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mt-4">
                                                    <b>Última Alteração:</b> <?= $helper->formataDateTime($clientes->updated_at) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="inline inline-block">
                                                <input type="submit" class="btn btn-primary" style="margin-top:40px;" name="update" id="update" value="Alterar">
                                                <input type="submit" class="btn btn-danger" style="margin-top:40px;" name="delete" id="delete" value="Deletar">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
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
                                <a class="page-link w-50" href="<?= URL ?>/cliente/consulta/<?= $previous ?>"><< Anterior</a>
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
                                <a class="page-link w-50" href="<?= URL ?>/cliente/consulta/<?= $next ?>" style="float:right;text-align:right;">Próximo >></a>
                                <?php 
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