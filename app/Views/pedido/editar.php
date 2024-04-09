<?php
    $helper = new Helpers();
    $_SESSION["sgp_dados_pedido"] = null;
    $_SESSION["sgp_dados_pedido"]["itens"] = "";
    $readonly = "";
    $disabled = "";
    if($dados["pedido"][0]->situacao == "3" or $dados["pedido"][0]->situacao == "4"){
        $readonly = "readonly";
        $disabled = "disabled";
    }
?>
<div id="conteudo" style="margin-top: 5%;">
    <div class="form-center-conteudo">
        <h4>Edição - Pedido Nº <?= $dados["pedido"][0]->id ?> </h4>
        <form method="POST" action="<?= URL?>/public/assets/mpdf/gera_pdf.php" target="_blank">
            <div class="row mt-2">
                <div class="col-sm-2 mt-2">
                    <button class="btn btn-secondary btn-sm" type="submit" name="btnImprimir" id="btnImprimir" value="btnImprimir">IMPRIMIR 2ª VIA</button>
                </div>
                <div class="col-sm-2 mt-2">
                    <input class="form-check-input" type="checkbox" value="epson" name="tipoImpressora" checked>
                    <label class="form-check-label" for="flexCheckDefault">
                        Impressora Epson
                    </label>
                </div>
            </div>
        </form>
        <form name="form_alt_cliente" id="form_alt_cliente" method="POST" action="<?= URL ?>/pedido/editar">
            <?php 
                $_SESSION["sgp_dados_pedido"]["numero_pedido"] = $dados["pedido"][0]->id;
            ?>
            <div class="col-sm-3 mb-2 mt-3">
                
                    <!--<a href="<?= URL?>/public/assets/mpdf/gera_pdf.php" target="_blank"><button class="btn btn-secondary btn-sm" type="button" name="btnImprimir" id="btnImprimir" value="btnImprimir">IMPRIMIR 2ª VIA</button></a> -->
            </div>
            <hr class="divisor_horizontal">
            <h6>Dados do Cliente</h6>
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
                    <input type="hidden" class="form-control" id="txtUrl" name="txtUrl" value="<?= URL ?>">
                    <input type="hidden" name="cliente_id" value="<?= $dados["cliente"][0]->id ?>">
                    <input type="hidden" name="pedido_id" value="<?= $dados["pedido"][0]->id ?>">
                    <div class="form-floating mt-3">
                         <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome*" value="<?= $dados["cliente"][0]->nome ?>" <?= $readonly ?>>
                        <label for="nome">Nome*</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="cpfcnpj" name="cpfcnpj" placeholder="cpfcnpj" onkeypress='mascaraMutuario(this,cpfCnpj)' value="<?= $dados["cliente"][0]->cpfcnpj ?>" <?= $readonly ?>>
                        <label for="cpfcnpj">CPF/CNPJ</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone*" required onkeypress='mascaraMutuario(this,mtel)' maxlength="15" value="<?= $dados["cliente"][0]->telefone ?>" <?= $readonly ?>>
                        <label for="telefone">Telefone*</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-3">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" onBlur="buscaCep(this.value);" onkeypress='mascaraMutuario(this,cepMasc)' maxlength="9" value="<?= $dados["cliente"][0]->cep ?>" <?= $readonly ?>>
                        <label for="cep">CEP</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="Logradouro" value="<?= $dados["cliente"][0]->rua ?>" <?= $readonly ?>>
                        <label for="logradouro">Logradouro</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" value="<?= $dados["cliente"][0]->numero_endereco ?>" <?= $readonly ?>>
                        <label for="numero">Número</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complemento"  value="<?= $dados["cliente"][0]->complemento ?>" <?= $readonly ?>>
                        <label id="label_complemento">Complemento</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="estado" name="estado" <?= $readonly ?>>
                            <option value="">Selecione...</option>
                            <option value="AC" <?= $helper->setSelected('AC', $dados["cliente"][0]->estado) ?>>AC</option>
                            <option value="AL" <?= $helper->setSelected('AL', $dados["cliente"][0]->estado) ?>>AL</option>
                            <option value="AP" <?= $helper->setSelected('AP', $dados["cliente"][0]->estado) ?>>AP</option>
                            <option value="AM" <?= $helper->setSelected('AM', $dados["cliente"][0]->estado) ?>>AM</option>
                            <option value="BA" <?= $helper->setSelected('BA', $dados["cliente"][0]->estado) ?>>BA</option>
                            <option value="CE" <?= $helper->setSelected('CE', $dados["cliente"][0]->estado) ?>>CE</option>
                            <option value="DF" <?= $helper->setSelected('DF', $dados["cliente"][0]->estado) ?>>DF</option>
                            <option value="ES" <?= $helper->setSelected('ES', $dados["cliente"][0]->estado) ?>>ES</option>
                            <option value="GO" <?= $helper->setSelected('GO', $dados["cliente"][0]->estado) ?>>GO</option>
                            <option value="MA" <?= $helper->setSelected('MA', $dados["cliente"][0]->estado) ?>>MA</option>
                            <option value="MT" <?= $helper->setSelected('MT', $dados["cliente"][0]->estado) ?>>MT</option>
                            <option value="MS" <?= $helper->setSelected('MS', $dados["cliente"][0]->estado) ?>>MS</option>
                            <option value="MG" <?= $helper->setSelected('MG', $dados["cliente"][0]->estado) ?>>MG</option>
                            <option value="PA" <?= $helper->setSelected('PA', $dados["cliente"][0]->estado) ?>>PA</option>
                            <option value="PB" <?= $helper->setSelected('PB', $dados["cliente"][0]->estado) ?>>PB</option>
                            <option value="PR" <?= $helper->setSelected('PR', $dados["cliente"][0]->estado) ?>>PR</option>
                            <option value="PE" <?= $helper->setSelected('PE', $dados["cliente"][0]->estado) ?>>PE</option>
                            <option value="PI" <?= $helper->setSelected('PI', $dados["cliente"][0]->estado) ?>>PI</option>
                            <option value="RJ" <?= $helper->setSelected('RJ', $dados["cliente"][0]->estado) ?>>RJ</option>
                            <option value="RN" <?= $helper->setSelected('RN', $dados["cliente"][0]->estado) ?>>RN</option>
                            <option value="RS" <?= $helper->setSelected('RS', $dados["cliente"][0]->estado) ?>>RS</option>
                            <option value="RO" <?= $helper->setSelected('RO', $dados["cliente"][0]->estado) ?>>RO</option>
                            <option value="RR" <?= $helper->setSelected('RR', $dados["cliente"][0]->estado) ?>>RR</option>
                            <option value="SC" <?= $helper->setSelected('SC', $dados["cliente"][0]->estado) ?>>SC</option>
                            <option value="SP" <?= $helper->setSelected('SP', $dados["cliente"][0]->estado) ?>>SP</option>
                            <option value="SE" <?= $helper->setSelected('SE', $dados["cliente"][0]->estado) ?>>SE</option>
                            <option value="TO" <?= $helper->setSelected('TO', $dados["cliente"][0]->estado) ?>>TO</option>
                        </select>
                        <label for="estado">Estado</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="<?= $dados["cliente"][0]->estado ?>" <?= $readonly ?>>
                        <label for="cidade">Cidade</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?= $dados["cliente"][0]->bairro ?>" <?= $readonly ?>>
                        <label for="bairro">Bairro</label>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 mb-5">
                    <button class="btn btn-primary btn-md" type="submit" name="btnAlteraDadosCliente" id="btnAlteraDadosCliente" <?= $disabled ?>>ALTERAR DADOS DO CLIENTE</button>
                </div>
            </div>
            <?php 
                $_SESSION["sgp_rotina"] = null;
                $_SESSION["sgp_dados_pedido"]["emitido"] = $helper->formataDateTime($dados["pedido"][0]->data_emissao);
                $_SESSION["sgp_dados_pedido"]["nome"] = $dados["cliente"][0]->nome;
                $_SESSION["sgp_dados_pedido"]["telefone"] = $dados["cliente"][0]->telefone;
                $_SESSION["sgp_dados_pedido"]["cpfcnpj"] = $dados["cliente"][0]->cpfcnpj != "" ? $dados["cliente"][0]->cpfcnpj : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["endereco"] = $dados["cliente"][0]->rua != "" ? $dados["cliente"][0]->rua : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["numero"] = $dados["cliente"][0]->numero_endereco != 0 ? $dados["cliente"][0]->numero_endereco : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["bairro"] = $dados["cliente"][0]->bairro != "" ? $dados["cliente"][0]->bairro : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["cidade"] = $dados["cliente"][0]->cidade != "" ? $dados["cliente"][0]->cidade : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["estado"] = $dados["cliente"][0]->estado != "" ?  $dados["cliente"][0]->estado : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["complemento"] = $dados["cliente"][0]->complemento != "" ? $dados["cliente"][0]->complemento : '';
                $_SESSION["sgp_dados_pedido"]["entrega"] = $helper->formataDateTime($dados["pedido"][0]->data_entrega);
                $_SESSION["sgp_dados_pedido"]["formaEntrega"] = $dados["pedido"][0]->retirada == 0 ? 'Retirada no local' : 'Entregar na casa do cliente';
            ?>
        </form>
        <hr class="divisor_horizontal">
        <h6>Itens do Pedido</h6>
        <div class="row mt-4">
            <div class="col-sm-3">
                <b>DESCRIÇÃO</b>
            </div>
            <div class="col-sm-2">
                <b>UM</b>
            </div>
            <div class="col-sm-2">
                <b>VALOR</b>
            </div>
            <div class="col-sm-2">
                <b>QUANTIDADE</b>
            </div>
            <div class="col-sm-2">
                <b>SUB-TOTAL</b>
            </div>
        </div>
        <form name="form_altera_itens_pedido" id="form_altera_itens_pedido" method="POST" action="<?= URL ?>/pedido/editar">
        <?php
            $i = 1; 
            foreach($dados["itens"] as $item){
        ?>
                <div class="row mt-3">
                    <div class="col-sm-3">
                        <div class="form-floating mt-2">
                            <input type="hidden" class="form-control" id="prod_item-<?=$i?>" name="prod_item-<?=$i?>" value="<?= $item->id ?>">
                            <input type="text" class="form-control" id="item-<?=$i?>" name="item-<?=$i?>" value="<?= $item->codigo_produto." - ".$item->descricao ?>" readonly>
                            <label for="item-<?=$i?>">Item</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-floating mt-2">
                            <select class="form-control" id="um-<?=$i?>" name="um-<?=$i?>" <?= $readonly ?>>
                                <option value="KG" <?= $helper->setSelected('KG', $item->um) ?>>KG</option>
                                <option value="UN" <?= $helper->setSelected('UN', $item->um) ?>>UN</option>
                            </select>
                            <label for="um-<?=$i?>">UM</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="preco-<?=$i?>" name="preco-<?=$i?>" placeholder="Preço" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(<?= $i ?>);" value="<?= $item->valor_unit ?>" <?= $readonly ?>>
                            <label for="preco-<?=$i?>">Preço</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-floating mt-2">
                            <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-<?=$i?>" name="qtd-<?=$i?>" placeholder="Qtd*" onBlur="calculaTotal(<?= $i ?>);" value="<?= $item->quantidade_pedida ?>" <?= $readonly ?>>
                            <label for="qtd-<?=$i?>">Qtd</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="total-<?=$i?>" name="total-<?=$i?>" placeholder="Total*" value="<?= $helper->multiplicaFormata($item->quantidade_pedida, $item->valor_unit, "Sem moeda") ?>" readonly>
                            <label for="total-<?=$i?>">Sub-total</label>
                        </div>
                    </div>
                </div>
        <?php
            $_SESSION["sgp_dados_pedido"]["itens"] .= $item->codigo_produto." - ".$item->descricao.";;;";
            $_SESSION["sgp_dados_pedido"]["itens"] .= $item->um.";;;";
            $_SESSION["sgp_dados_pedido"]["itens"] .= $item->quantidade_pedida.";;;";
            $_SESSION["sgp_dados_pedido"]["itens"] .= $item->valor_unit.";;;";
            $_SESSION["sgp_dados_pedido"]["itens"] .= $helper->multiplicaFormata($item->quantidade_pedida, $item->valor_unit)."---";
            $i++;
            }
        ?>
            <input type="hidden" class="form-control" id="num_campos_exibidos" name="num_campos_exibidos" value="<?= $i - 1 ?>">
            <input type="hidden" class="form-control" id="txtUrl" name="txtUrl" value="<?= URL ?>">
            <?php  
                while($i <= 30){
            ?>
                    <div class="row">
                        <div class="col-sm-3 coluna-item-<?= $i?>" style="display: none;">
                            <div class="form-floating mt-3">
                                <select class="form-control" id="item-<?= $i ?>" name="item-<?= $i ?>" onChange="buscaDadosItem(this.id);">
                                    <option value="">Selecione...</option>
                                    <?php 
                                        for($j = 0; $j < count($dados["produtos"]); $j++){
                                            echo "<option value='".$dados["produtos"][$j]->id."'>".$dados["produtos"][$j]->descricao."</option>";
                                        }
                                    ?>
                                </select>
                                <label for="item-<?= $i ?>">Item</label>
                            </div>
                        </div>
                        <div class="col-sm-2 coluna-um-<?= $i ?>" style="display: none;">
                            <div class="form-floating mt-3">
                                <select class="form-control" id="um-<?= $i ?>" name="um-<?= $i ?>">
                                    <option value="">Selecione</option>
                                    <option value="KG">KG</option>
                                    <option value="UN">UN</option>
                                </select>
                                <label for="um-<?= $i ?>">UM</label>
                            </div>
                        </div>
                        <div class="col-sm-2 coluna-preco-<?= $i ?>" style="display: none;">
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="preco-<?= $i ?>" name="preco-<?= $i ?>" placeholder="Preço*" onkeypress="$(this).mask('R$ ###.###.##0,00', {reverse: true});" onBlur="calculaTotal(<?= $i ?>);">
                                <label for="preco-<?= $i ?>">Preço*</label>
                            </div>
                        </div>
                        <div class="col-sm-2 coluna-qtd-<?= $i ?>" style="display: none;">
                            <div class="form-floating mt-3">
                                <input type="text" onkeypress="$(this).mask(' ###.###.##0,00', {reverse: true});" class="form-control" id="qtd-<?= $i ?>" name="qtd-<?= $i ?>" placeholder="Qtd*" onBlur="calculaTotal(<?= $i ?>);">
                                <label for="qtd-<?= $i ?>">Qtd*</label>
                            </div>
                        </div>
                        <div class="col-sm-2 coluna-total-<?= $i ?>" style="display: none;">
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="total-<?= $i ?>" name="total-<?= $i ?>" placeholder="Total*" value="0,00" readonly>
                                <label for="total-<?= $i ?>">Total</label>
                            </div>
                        </div>
                    </div>
            <?php
                $i++; 
                }
            ?>
            <div class="row mt-4">
                <div class="col-sm-12 mb-2">
                    <button class="btn btn-secondary btn-sm" type="button" name="btnAddItem" id="btnAddItem" onclick="exibeCampos();" <?= $disabled ?>>ADICIONAR ITEM</button>
                </div>
            </div>
            <div class="row mt-4">
                <input type="hidden" name="pedido_id" value="<?= $dados["pedido"][0]->id ?>">
                <?php
                    $_SESSION["sgp_dados_pedido"]["valorTotal"] = $dados["pedido"][0]->valor_total;
                    $_SESSION["sgp_dados_pedido"]["status"] = $dados["pedido"][0]->situacao == "3" ? "Entregue" : "novo";
                ?>
                <input type="hidden" id="txtValortotal" name="txtValortotal">
                <p class="tituloConsultas">Sub-total: R$ <label id="subtotal"><?= $dados["pedido"][0]->valor_total ?></label></p>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 mb-2">
                    <button class="btn btn-primary btn-md" type="submit" name="btnAlteraItens" id="btnAlteraItens" <?= $disabled ?>>SALVAR ITENS</button>
                </div>
            </div>
        </form>
        <hr class="divisor_horizontal">
        <h6>Dados do Pedido</h6>
        <form name="form_altera_dados_pedido" id="form_altera_dados_pedido" method="POST" action="<?= URL ?>/pedido/editar">
            <input type="hidden" name="pedido_id" value="<?= $dados["pedido"][0]->id ?>">
            <div class="row">
                <div class="col-sm-12">
                    <textarea  class="form-control h-100" id="observacao" name="observacao" placeholder="Observação" rows="10" <?= $readonly ?>><?= $dados["pedido"][0]->observacao ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="datetime-local" class="form-control" id="data_entrega" name="data_entrega" required onblur="validaData(this.value);" value="<?= $dados["pedido"][0]->data_entrega ?>" <?= $readonly ?>>
                        <label for="data_entrega">Data de Entrega</label>
                        <small id="avisoDiferencaData" class="form-text" style="color:red; display:none;">
                        A data de entrega não pode ser menor do que a data atual.
                    </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="forma_entrega" name="forma_entrega" <?= $readonly ?>>
                            <option value="0" <?= $helper->setSelected('0', $dados["pedido"][0]->retirada) ?>>Retirada no local</option>
                            <option value="1" <?= $helper->setSelected('1', $dados["pedido"][0]->retirada) ?>>Entregar na casa do cliente</option>
                        </select>
                        <label for="um-1">Local de Entrega</label>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col-sm-12 mb-0">
                    <button class="btn btn-primary btn-lg w-100" type="submit" name="btnAlteraDadosPedido" id="btnAlteraDadosPedido" value="btnFecharPedido" <?= $disabled ?>>ALTERAR DADOS DO PEDIDO</button>
                </div>
            </div>
        </form>
    </div>
</div>