<div id="conteudo">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-top: 2%;">
            <li class="breadcrumb-item"><a href="#">Produto</a></li>
            <li class="breadcrumb-item"><a href="<?= URL ?>/produto/consulta">Produtos Cadastrados</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastrar Produto</li>
        </ol>
    </nav>
    <label class="titulo">Cadastro de Produto</label>
    <form name="form_cad_produto" id="form_cad_produto" method="POST" action="<?= URL ?>/produto/cadastrar/">
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
                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código do Produto*" required>
                        <label for="codigo">Código do Produto*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição*" required>
                        <label for="descricao">Descrição*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um" name="um" required>
                            <option value="">Selecione...</option>
                            <option value="KG">KG</option>
                            <option value="UN">UNIDADE</option>
                        </select>
                        <label for="um">Unidade de Medida*</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="preco" name="preco" placeholder="Preço*" required onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});">
                        <label for="preco">Preço*</label>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 mb-5">
                    <button class="w-100 btn btn-primary btn-lg" type="submit" name="cadastrar" id="cadastrar" value="cadastrar">Cadastrar</button>
                </div>
            </div>
            <?php 
                $_SESSION["sgp_rotina"] = null;
            ?>
        </div>
    </form>
</div>