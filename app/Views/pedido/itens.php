<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
<?php
    $helper = new Helpers();
?>
<div id="conteudo" style="margin-top: 70px;">
    <form name="form_insere_itens_pedido" id="form_insere_itens_pedido" method="POST" action="<?= URL ?>/pedido/finalizar">
        <input type="hidden" class="form-control" id="txtUrl" name="txtUrl" value="<?= URL ?>">
        <input type="hidden" class="form-control" id="num_campos_exibidos" name="num_campos_exibidos" value="2">
        <div class="form-center-conteudo">
            <div class="row">
                <p class="tituloConsultas">Dados do Cliente</p>
                <p><b>Nome:</b> <?= $dados["nome"] ?> - <b>Telefone:</b> <?= $dados["telefone"] ?></p>
                <p><b>Endereço:</b> <?= $dados["rua"] != "" ? $dados["rua"] : 'Não informado' ?>, Nº <?= $dados["numero"] != 0 ? $dados["numero"] : 'Não informado' ?> - <b>Bairro:</b> <?= $dados["bairro"] != "" ? $dados["bairro"] : 'Não informado' ?> - <b>Cidade/Estado:</b> <?= $dados["cidade"] != "" ? $dados["cidade"] : 'Não informado' ?> / <?= $dados["estado"] != "" ?  $dados["estado"] : 'Não informado'?> </p>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 mb-2">
                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-alterarCliente">ALTERAR DADOS DO CLIENTE</a>
                </div>
            </div>
            <hr class="divisor_horizontal">
            <div class="row">
                <p class="tituloConsultas">Itens do Pedido</p>
            </div>
            <input type="hidden" id="id_cliente" name="id_cliente" value="<?= $dados["id_novo"] == null ? $dados["id_update"] : $dados["id_novo"] ?>">
            <div class="row mt-3">
                <div class="col-sm-3">
                    <div class="form-floating mt-2">
                        <select class="form-control" id="item-1" name="item-1" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-2">
                        <select class="form-control" id="um-1" name="um-1">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-1">UM</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control" id="preco-1" name="preco-1" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(1);">
                        <label for="preco-1">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-2">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-1" name="qtd-1" placeholder="Qtd*" onBlur="calculaTotal(1);">
                        <label for="qtd-1">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control" id="total-1" name="total-1" placeholder="Total*" value="0,00" readonly>
                        <label for="total-1">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-2" name="item-2" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-2" name="um-2">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-2">UM</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-2" name="preco-2" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(2);">
                        <label for="preco-2">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-2" name="qtd-2" placeholder="Qtd*" onBlur="calculaTotal(2);">
                        <label for="qtd-2">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-2" name="total-2" placeholder="Total*" value="0,00" readonly>
                        <label for="total-2">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-3" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-3" name="item-3" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-3" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-3" name="um-3">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-3" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-3" name="preco-3" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(3);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-3" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-3" name="qtd-3" placeholder="Qtd*" onBlur="calculaTotal(3);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-3" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-3" name="total-3" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-4" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-4" name="item-4" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-4" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-4" name="um-4">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-4" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-4" name="preco-4" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(4);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-4" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-4" name="qtd-4" placeholder="Qtd*" onBlur="calculaTotal(4);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-4" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-4" name="total-4" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-5" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-5" name="item-5" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-5" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-5" name="um-5">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-5" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-5" name="preco-5" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(5);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-5" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-5" name="qtd-5" placeholder="Qtd*" onBlur="calculaTotal(5);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-5" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-5" name="total-5" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-6" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-6" name="item-6" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-6" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-6" name="um-6">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-6" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-6" name="preco-6" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(6);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-6" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-6" name="qtd-6" placeholder="Qtd*" onBlur="calculaTotal(6);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-6" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-6" name="total6" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-7" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-7" name="item-7" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-7" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-7" name="um-7">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-7" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-7" name="preco-7" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(7);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-7" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-7" name="qtd-7" placeholder="Qtd*" onBlur="calculaTotal(7);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-7" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-7" name="total-7" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-8" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-8" name="item-8" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-8" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-8" name="um-8">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-8" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-8" name="preco-8" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(8);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-8" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-8" name="qtd-8" placeholder="Qtd*" onBlur="calculaTotal(8);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-8" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-8" name="total-8" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-9" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-9" name="item-9" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-9" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-9" name="um-9">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-9" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-9" name="preco-9" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(9);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-9" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-9" name="qtd-9" placeholder="Qtd*" onBlur="calculaTotal(9);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-9" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-9" name="total-9" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-10" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-10" name="item-10" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-10" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-10" name="um-10">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-10" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-10" name="preco-10" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(10);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-10" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-10" name="qtd-10" placeholder="Qtd*" onBlur="calculaTotal(10);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-10" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-10" name="total-10" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-11" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-11" name="item-11" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-11" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-11" name="um-11">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-11" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-11" name="preco-11" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(11);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-11" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-11" name="qtd-11" placeholder="Qtd*" onBlur="calculaTotal(11);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-11" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-11" name="total-11" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-12" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-12" name="item-12" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-12" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-12" name="um-12">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-12" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-12" name="preco-12" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(12);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-12" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-12" name="qtd-12" placeholder="Qtd*" onBlur="calculaTotal(12);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-12" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-12" name="total-12" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-13" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-13" name="item-13" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-13" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-13" name="um-13">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-13" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-13" name="preco-13" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(13);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-13" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-13" name="qtd-13" placeholder="Qtd*" onBlur="calculaTotal(13);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-13" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-13" name="total-13" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-14" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-14" name="item-14" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-14" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-14" name="um-14">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-14" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-14" name="preco-14" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(14);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-14" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-14" name="qtd-14" placeholder="Qtd*" onBlur="calculaTotal(14);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-14" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-14" name="total-14" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-15" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-15" name="item-15" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-15" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-15" name="um-15">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-15" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-15" name="preco-15" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(15);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-15" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-15" name="qtd-15" placeholder="Qtd*" onBlur="calculaTotal(15);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-15" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-15" name="total-15" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-16" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-16" name="item-16" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-16" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-16" name="um-16">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-16" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-16" name="preco-16" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(16);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-16" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-16" name="qtd-16" placeholder="Qtd*" onBlur="calculaTotal(16);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-16" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-16" name="total-16" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-17" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-17" name="item-17" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-17" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-17" name="um-17">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-17" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-17" name="preco-17" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(17);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-17" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-17" name="qtd-17" placeholder="Qtd*" onBlur="calculaTotal(17);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-17" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-17" name="total-17" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-18" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-18" name="item-18" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-18" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-18" name="um-18">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-18" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-18" name="preco-18" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(18);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-18" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-18" name="qtd-18" placeholder="Qtd*" onBlur="calculaTotal(18);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-18" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-18" name="total-18" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-19" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-19" name="item-19" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-19" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-19" name="um-19">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-19" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-19" name="preco-19" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(19);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-19" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-19" name="qtd-19" placeholder="Qtd*" onBlur="calculaTotal(19);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-19" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-19" name="total-19" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-20" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-20" name="item-20" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-20" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-20" name="um-20">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-20" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-20" name="preco-20" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(20);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-20" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-20" name="qtd-20" placeholder="Qtd*" onBlur="calculaTotal(20);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-20" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-20" name="total-20" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-21" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-21" name="item-21" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-21" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-21" name="um-21">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-21" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-21" name="preco-21" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(21);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-21" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-21" name="qtd-21" placeholder="Qtd*" onBlur="calculaTotal(21);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-21" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-21" name="total-21" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-22" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-22" name="item-22" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-22" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-22" name="um-22">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-22" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-22" name="preco-22" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(22);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-22" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-22" name="qtd-22" placeholder="Qtd*" onBlur="calculaTotal(22);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-22" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-22" name="total-22" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-23" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-23" name="item-23" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-23" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-23" name="um-23">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-23" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-23" name="preco-23" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(23);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-23" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-23" name="qtd-23" placeholder="Qtd*" onBlur="calculaTotal(23);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-23" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-23" name="total-23" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-24" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-24" name="item-24" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-24" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-24" name="um-24">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-24" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-24" name="preco-24" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(24);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-24" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-24" name="qtd-24" placeholder="Qtd*" onBlur="calculaTotal(24);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-24" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-24" name="total-24" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-25" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-25" name="item-25" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-25" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-25" name="um-25">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-25" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-25" name="preco-25" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(25);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-25" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-25" name="qtd-25" placeholder="Qtd*" onBlur="calculaTotal(25);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-25" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-25" name="tota25" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-26" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-26" name="item-26" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-26" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-26" name="um-26">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-26" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-26" name="preco-26" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(26);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-26" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-26" name="qtd-26" placeholder="Qtd*" onBlur="calculaTotal(26);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-26" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-26" name="total-26" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-27" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-27" name="item-27" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-27" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-27" name="um-27">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-27" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-27" name="preco-27" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(27);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-27" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-27" name="qtd-27" placeholder="Qtd*" onBlur="calculaTotal(27);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-27" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-27" name="total-27" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-28" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-28" name="item-28" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-28" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-28" name="um-28">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-28" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-28" name="preco-28" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(28);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-28" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-28" name="qtd-28" placeholder="Qtd*" onBlur="calculaTotal(28);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-28" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-28" name="total-28" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-29" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-29" name="item-29" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-29" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-29" name="um-29">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-29" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-29" name="preco-29" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(29);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-29" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-29" name="qtd-29" placeholder="Qtd*" onBlur="calculaTotal(29);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-29" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-29" name="total-29" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 coluna-item-30" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="item-30" name="item-30" onChange="buscaDadosItem(this.id);">
                            <option value="">Selecione...</option>
                            <?php 
                                for($i = 0; $i < count($dados["itens"]); $i++){
                                    echo "<option value='".$dados["itens"][$i]->id."'>".$dados["itens"][$i]->codigo_produto." - ".$dados["itens"][$i]->descricao."</option>";
                                }
                            ?>
                        </select>
                        <label for="item">Item</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-um-30" style="display: none;">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="um-30" name="um-30">
                            <option value="">Selecione</option>
                            <option value="KG">KG</option>
                            <option value="UN">UN</option>
                        </select>
                        <label for="um-3">UM</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-preco-30" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="preco-30" name="preco-30" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(30);">
                        <label for="preco-3">Preço*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-qtd-30" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-30" name="qtd-30" placeholder="Qtd*" onBlur="calculaTotal(30);">
                        <label for="qtd-3">Qtd*</label>
                    </div>
                </div>
                <div class="col-sm-2 coluna-total-30" style="display: none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="total-30" name="total-30" placeholder="Total*" value="0,00" readonly>
                        <label for="total-3">Total</label>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 mb-2">
                    <button class="btn btn-primary btn-sm" type="button" name="btnAddItem" id="btnAddItem" onclick="exibeCampos();">ADICIONAR ITEM</button>
                </div>
            </div>
            <div class="row mt-4">
                <input type="hidden" id="txtValortotal" name="txtValortotal">
                <p class="tituloConsultas">Sub-total: R$ <label id="subtotal">0,00</label></p>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 mb-2">
                    <button class="btn btn-primary btn-md w-100" type="submit" name="btnFinalizarItens" id="btnFinalizarItens">FINALIZAR ITENS</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modal-alterarCliente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $dados["nome"] ?></h4>
                <button type="button" class="btn-close" data-dismiss="modal" nome="btnClose" id="btnClose"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= URL ?>/cliente/alterar" id="form_altera_cliente" name="form_altera_cliente">
                    <div class="row mt-3">
                    <input type="hidden" id="id_cliente" name="id_cliente" value="<?= $dados["id_novo"] == null ? $dados["id_update"] : $dados["id_novo"] ?>">
                        <div class="col-sm-8">
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome*" value="<?= $dados["nome"] ?>" required>
                                <label for="nome">Nome*</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone*" required onkeypress='mascaraMutuario(this,mtel)' maxlength="15" value="<?= $dados["telefone"] ?>">
                                <label for="telefone">Telefone*</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-8">
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="Logradouro" value="<?= $dados["rua"] ?>">
                                <label for="logradouro">Logradouro</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" value="<?= $dados["numero"] ?>">
                                <label for="numero">Número</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <div class="form-floating mt-3">
                                <select class="form-control" id="estado" name="estado">
                                    <option value="">Selecione...</option>
                                    <option value="AC" <?= $helper->setSelected('AC', $dados["estado"]) ?>>AC</option>
                                    <option value="AL" <?= $helper->setSelected('AL', $dados["estado"]) ?>>AL</option>
                                    <option value="AP" <?= $helper->setSelected('AP', $dados["estado"]) ?>>AP</option>
                                    <option value="AM" <?= $helper->setSelected('AM', $dados["estado"]) ?>>AM</option>
                                    <option value="BA" <?= $helper->setSelected('BA', $dados["estado"]) ?>>BA</option>
                                    <option value="CE" <?= $helper->setSelected('CE', $dados["estado"]) ?>>CE</option>
                                    <option value="DF" <?= $helper->setSelected('DF', $dados["estado"]) ?>>DF</option>
                                    <option value="ES" <?= $helper->setSelected('ES', $dados["estado"]) ?>>ES</option>
                                    <option value="GO" <?= $helper->setSelected('GO', $dados["estado"]) ?>>GO</option>
                                    <option value="MA" <?= $helper->setSelected('MA', $dados["estado"]) ?>>MA</option>
                                    <option value="MT" <?= $helper->setSelected('MT', $dados["estado"]) ?>>MT</option>
                                    <option value="MS" <?= $helper->setSelected('MS', $dados["estado"]) ?>>MS</option>
                                    <option value="MG" <?= $helper->setSelected('MG', $dados["estado"]) ?>>MG</option>
                                    <option value="PA" <?= $helper->setSelected('PA', $dados["estado"]) ?>>PA</option>
                                    <option value="PB" <?= $helper->setSelected('PB', $dados["estado"]) ?>>PB</option>
                                    <option value="PR" <?= $helper->setSelected('PR', $dados["estado"]) ?>>PR</option>
                                    <option value="PE" <?= $helper->setSelected('PE', $dados["estado"]) ?>>PE</option>
                                    <option value="PI" <?= $helper->setSelected('PI', $dados["estado"]) ?>>PI</option>
                                    <option value="RJ" <?= $helper->setSelected('RJ', $dados["estado"]) ?>>RJ</option>
                                    <option value="RN" <?= $helper->setSelected('RN', $dados["estado"]) ?>>RN</option>
                                    <option value="RS" <?= $helper->setSelected('RS', $dados["estado"]) ?>>RS</option>
                                    <option value="RO" <?= $helper->setSelected('RO', $dados["estado"]) ?>>RO</option>
                                    <option value="RR" <?= $helper->setSelected('RR', $dados["estado"]) ?>>RR</option>
                                    <option value="SC" <?= $helper->setSelected('SC', $dados["estado"]) ?>>SC</option>
                                    <option value="SP" <?= $helper->setSelected('SP', $dados["estado"]) ?>>SP</option>
                                    <option value="SE" <?= $helper->setSelected('SE', $dados["estado"]) ?>>SE</option>
                                    <option value="TO" <?= $helper->setSelected('TO', $dados["estado"]) ?>>TO</option>
                                </select>
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="<?= $dados["cidade"] ?>">
                                <label for="cidade">Cidade</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?= $dados["bairro"] ?>">
                                <label for="bairro">Bairro</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12 mb-5">
                            <input type="submit" class="btn btn-primary" style="margin-top:40px;" name="alterar" id="alterar" value="Alterar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
    $_SESSION["sgp_rotina"] = null;
?>