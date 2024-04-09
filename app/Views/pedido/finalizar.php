<div id="conteudo" style="margin-top: 5%;">
    <form name="form_finaliza_pedido" id="form_finaliza_pedido" method="POST" action="<?= URL ?>/pedido/registrar">
        <div class="form-center-conteudo">
            <div class="row">
                <p class="tituloConsultas">Dados do Cliente</p>
                <p><b>Nome:</b> <?= $dados["cliente"][0]->nome ?> - <b>Telefone:</b> <?= $dados["cliente"][0]->telefone ?></p>
                <p><b>Endereço:</b> <?= $dados["cliente"][0]->rua != "" ? $dados["cliente"][0]->rua : 'Não informado' ?>, Nº <?= $dados["cliente"][0]->numero_endereco != 0 ? $dados["cliente"][0]->numero_endereco : 'Não informado' ?></p> <p><b>Bairro:</b> <?= $dados["cliente"][0]->bairro != "" ? $dados["cliente"][0]->bairro : 'Não informado' ?></p> <p><b>Cidade/Estado:</b> <?= $dados["cliente"][0]->cidade != "" ? $dados["cliente"][0]->cidade : 'Não informado' ?> / <?= $dados["cliente"][0]->estado != "" ?  $dados["cliente"][0]->estado : 'Não informado'?> </p>
            </div>
            <hr class="divisor_horizontal">
            <div class="row">
                <p class="tituloConsultas">Itens do Pedido</p>
            </div>
            <div class="row">
                <div class="col-3">
                    Descrição
                </div>
                <div class="col-3">
                    Valor Unit.
                </div>
                <div class="col-3" style="text-align: center;">
                    Quantidade
                </div>
                <div class="col-3" style="text-align: right;">
                    Sub-total
                </div>
            </div>
            <input type="hidden" name="cliente_id" id="cliente_id" value="<?= $dados["cliente"][0]->id ?>">
            <input type="hidden" name="valor_total" id="valor_total" value="<?= $dados["subtotal"] ?>">
            <?php
                $i = 0;
                $j = 0;
                while($i < count($dados["itens"])){
            ?>
                    <div class="row mt-0">
                        <p>
                            <div class="col-3">
                                <?php echo "<h5>".$dados["itens"][$i]; $i++ ?>
                            </div>
                            <div class="col-3">
                                <?php echo "R$ ".$dados["itens"][$i]; ?>
                                <input type="hidden" name="valor_unitario__<?= $j ?>" id="valor_unitario__<?= $j ?>" value="<?php echo $dados["itens"][$i]; $i++; ?>">
                            </div>
                            <div class="col-3" style="text-align: center;">
                                <?= $dados["itens"][$i] ?>
                                <input type="hidden" name="quantidade__<?= $j ?>" id="quantidade__<?= $j ?>" value="<?php echo $dados["itens"][$i]; $i++; ?>">
                            </div>
                            <div class="col-3" style="text-align: right;">
                                <?php echo "R$ ".$dados["itens"][$i]."</h5>" ?>
                                <input type="hidden" name="subtotal__<?= $j ?>" id="subtotal__<?= $j ?>" value="<?php echo $dados["itens"][$i]; $i++; ?>">
                            </div>
                            <input type="hidden" name="produto_id__<?= $j ?>" id="produto_id__<?= $j ?>" value="<?php echo $dados["itens"][$i]; $i++; ?>">
                        </p>
                    </div>
            <?php
                $j++;
                }
            ?>
            <input type="hidden" name="qtd_itens" id="qtd_itens" value="<?= $j ?>">
            <div class="row mt-0">
                <div class="col-sm-10 mb-0" style="text-align: right;">
                    <p><h4><b>Total: <?= $dados["subtotal"] ?></b></h4></p>
                </div>
            </div>
            <hr class="divisor_horizontal">
            <div class="row">
                <p class="tituloConsultas">Dados do Pedido</p>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <textarea  class="form-control h-100" id="observacao" name="observacao" placeholder="Observação" rows="10"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="datetime-local" class="form-control" id="data_entrega" name="data_entrega" required onblur="validaData(this.value);">
                        <label for="data_entrega">Data de Entrega</label>
                        <small id="avisoDiferencaData" class="form-text" style="color:red; display:none;">
                        A data de entrega não pode ser menor do que a data atual.
                    </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="forma_entrega" name="forma_entrega">
                            <option value="0">Retirada no local</option>
                            <option value="1">Entregar na casa do cliente</option>
                        </select>
                        <label for="um-1">Local de Entrega</label>
                    </div>
                </div>
            </div>
            <div class="row mt-2 mb-4"> 
                <div class="col-sm-6 mt-2">
                    <button class="w-100 btn btn-primary btn-md" type="submit" name="btnFinalizarPedido" id="btnFinalizarPedido" value="btnFecharPedido">FECHAR PEDIDO</button>
                </div>
                <div class="col-sm-6 mt-2">
                    <button class="w-100 btn btn-danger btn-md" type="submit" name="btnCancelarPedido" id="btnCancelarPedido" value="btnCancelarPedido">CANCELAR PEDIDO</button>
                </div>
            </div>
        </div>
    </form>
</div>