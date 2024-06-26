<div id="conteudo">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-top: 2%;">
            <li class="breadcrumb-item"><a href="#">Cliente</a></li>
            <li class="breadcrumb-item"><a href="<?= URL ?>/cliente/consulta">Clientes Cadastrados</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastrar Cliente</li>
        </ol>
    </nav>
    <label class="titulo">Cadastro de Cliente</label>
    <form name="form_cad_cliente" id="form_cad_cliente" method="POST" action="<?= URL ?>/cliente/cadastrar/">
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
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome*" required>
                        <label for="nome">Nome*</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="cpfcnpj" name="cpfcnpj" placeholder="cpfcnpj" onkeypress='mascaraMutuario(this,cpfCnpj)' >
                        <label for="cpfcnpj">CPF/CNPJ</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone*" required onkeypress='mascaraMutuario(this,mtel)' maxlength="15">
                        <label for="telefone">Telefone*</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-3">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" onBlur="buscaCep(this.value);" onkeypress='mascaraMutuario(this,cepMasc)' maxlength="9">
                        <label for="cep">CEP</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="Logradouro">
                        <label for="logradouro">Logradouro</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Número">
                        <label for="numero">Número</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complemento">
                        <label id="label_complemento">Complemento</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="estado" name="estado">
                            <option value="" selected>Selecione...</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AP">AP</option>
                            <option value="AM">AM</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MT">MT</option>
                            <option value="MS">MS</option>
                            <option value="MG">MG</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PR">PR</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RS">RS</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="SC">SC</option>
                            <option value="SP">SP</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>
                        </select>
                        <label for="estado">Estado</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade">
                        <label for="cidade">Cidade</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro">
                        <label for="bairro">Bairro</label>
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