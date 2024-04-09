<?php
    $helper = new Helpers();
    $status = [
        '0' => 'Não Entregue',
        '1' => 'Em Produção',
        '2' => 'Produzido',
        '3' => 'Entregue',
        '4' => 'Cancelado',
        '5' => 'Entregue Parc.',
    ];
?>
<div class="form-center-conteudo mt-5">
    <h3>Relatórios</h3>
    <form name="form_relatorio" id="form_relatorio" method="POST" action="<?= URL ?>/relatorio/index">
        <div class="row mt-3">
            <div class="col-sm-12">
                <h6>Data de Emissão</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>Dê:</label>
                <div class="form-floating mt-2">
                    <input type="date" class="form-control" id="data_emissao_de" name="data_emissao_de" value="<?= $dados["data_emissao_de"] ?>">
                    <label for="data_emissao_de">De</label>
                </div>
            </div>
            <div class="col-sm-6">
            <label>Até:</label>
                <div class="form-floating mt-2">
                    <input type="date" class="form-control" id="data_emissao_ate" name="data_emissao_ate" value="<?= $dados["data_emissao_ate"] ?>">
                    <label for="data_emissao_ate">Até</label>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <h6>Data de Entrega</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>Dê</label>
                <div class="form-floating mt-2">
                    <input type="date" class="form-control" id="data_entrega_de" name="data_entrega_de" value="<?= $dados["data_entrega_de"] ?>">
                    <label for="data_entrega_de">De</label>
                </div>
            </div>
            <div class="col-sm-6">
            <label>Até:</label>
                <div class="form-floating mt-2">
                    <input type="date" class="form-control" id="data_entrega_ate" name="data_entrega_ate" value="<?= $dados["data_entrega_ate"] ?>">
                    <label for="data_entrega_ate">Até</label>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-4 mt-2">
                <div class="form-floating mt-2">
                    <h6>Cliente</h6>
                    <select class="w-100 js-example-basic-multiple" id="Cliente_multi" name="cliente[]" multiple="multiple">
                        <?php
                            foreach($dados["clientes"] as $cliente){
                                $selected = "";
                                for($i = 0; $i < count($dados["cliente"]); $i++){
                                    if($dados["cliente"][$i] == $cliente->id){
                                        $selected = 'selected';
                                    }
                                }
                        ?>
                            <option value="<?= $cliente->id ?>" <?= $selected ?>><?= $cliente->nome ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="form-floating mt-2">
                    <h6>Produto</h6>
                    <select class="w-100 js-example-basic-multiple" id="produto_multi" name="produto[]" multiple="multiple">
                        <?php 
                            foreach($dados["produtos"] as $produto){
                                $selected = "";
                                for($i = 0; $i < count($dados["produto"]); $i++){
                                    if($dados["produto"][$i] == $produto->id){
                                        $selected = 'selected';
                                    }
                                }
                        ?>
                            <option value="<?= $produto->id ?>" <?= $selected ?>><?= $produto->descricao ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="form-floating mt-2">
                    <h6>Status</h6>
                    <select class="w-100 js-example-basic-multiple" id="situacao_multi" name="situacao[]" multiple="multiple">
                        <option value="" <?= $this->helper->setMultiSelect($dados["situacao"], "") ?>>Todos</option>
                        <option value="0" <?= $this->helper->setMultiSelect($dados["situacao"], 0) ?>>Não Entregue</option>
                        <option value="1" <?= $this->helper->setMultiSelect($dados["situacao"], 1) ?>>Em Produção</option>
                        <option value="2" <?= $this->helper->setMultiSelect($dados["situacao"], 2) ?>>Produzido</option>
                        <option value="3" <?= $this->helper->setMultiSelect($dados["situacao"], 3) ?>>Entregue</option>
                        <option value="4" <?= $this->helper->setMultiSelect($dados["situacao"], 4) ?>>Cancelado</option>
                        <option value="5" <?= $this->helper->setMultiSelect($dados["situacao"], 5) ?>>Entregue Parc.</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-4 mt-2">
                <h6>Pedido</h6>
                <div class="form-floating mt-2">    
                    <input type="text" class="form-control" id="pedido" name="pedido" value="<?= $dados["pedido"] ?>">
                    <label for="pedido">Pedido</label>
                </div>
            </div>  
            <div class="col-sm-3 mt-2">
                <h6>Tipo</h6>
                <div class="form-floating mt-2">
                    <select class="form-control" id="tipo" name="tipo">
                        <option value="s" <?= $helper->setSelected('s', $dados["tipo"]) ?>>Sintético</option>
                        <option value="a" <?= $helper->setSelected('a', $dados["tipo"]) ?>>Analítico</option>
                    </select>
                    <label for="Tipo">Tipo</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row mt-5">
                <div class="col-sm-12 mb-2">
                    <button class="w-100 btn btn-primary btn-lg" type="submit" name="gerar" id="gerar" value="gerar">Gerar Relatório</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 mb-2">
                    <button class="w-100 btn btn-warning btn-lg" type="submit" name="limpar" id="limpar" value="limpar">Limpar Filtros</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php 
    if($dados["ordens"] != null) {
        $result = "
            <hr class='divisor_horizontal'>
            <div class='form-center-conteudo'>
                <div class='row mt-4'>
                    <div class='col-sm-2'>
                        <b>Pedido</b>
                    </div>
                    <div class='col-sm-2'>
                        <b>Cliente</b>
                    </div>
                    <div class='col-sm-2'>
                        <b>Emissão</b>
                    </div>
                    <div class='col-sm-2'>
                        <b>Entrega</b>
                    </div>
                    <div class='col-sm-2'>
                        <b>Valor</b>
                    </div>
                    <div class='col-sm-2'>
                        <b>Status</b>
                    </div>
                </div>";
        $result2 = "
            <table>
                <tr>
                    <td>Pedido</td>
                    <td>Cliente</td>
                    <td>Emissao</td>
                    <td>Entrega</td>
                    <td>Valor</td>
                    <td>Status</td>
                </tr>
        ";

            $aux = null;
                $i = 0;
            foreach($dados["ordens"] as $pedido){
                if($dados["tipo"] == "a"){
                    if($aux != $pedido->id){
                        $aux = $pedido->id;
                        $result .= "
                        <div class='row mt-4' style='border: solid 1px; background-color: gray; color:white;font-size: 18px;'>
                            <div class='col-sm-2'>
                                $pedido->id
                            </div>
                            <div class='col-sm-2'>
                                $pedido->nome
                            </div>
                            <div class='col-sm-2'>
                                ".$helper->formataDateTime($pedido->data_emissao)."
                            </div>
                            <div class='col-sm-2'>
                                ".$helper->formataDateTime($pedido->data_entrega)."
                            </div>
                            <div class='col-sm-2'>
                                R$ ".$helper->formataValor($pedido->valor_total)."
                            </div>
                            <div class='col-sm-2'>
                                ".$status[$pedido->situacao]."
                            </div>
                        </div>";
                        $result2 .= "
                            <tr>
                                <td style='border: solid 1px; background-color: gray; color:white;'>$pedido->id</td>
                                <td style='border: solid 1px; background-color: gray; color:white;'>$pedido->nome</td>
                                <td style='border: solid 1px; background-color: gray; color:white;'>".$helper->formataDateTime($pedido->data_emissao)."</td>
                                <td style='border: solid 1px; background-color: gray; color:white;'>".$helper->formataDateTime($pedido->data_entrega)."</td>
                                <td style='border: solid 1px; background-color: gray; color:white;'>".$helper->formataValor($pedido->valor_total)."</td>
                                <td style='border: solid 1px; background-color: gray; color:white;'>".$status[$pedido->situacao]."</td>
                            </tr>
                        ";
                    }
                    $result .= "
                        <div class='row mt-2'>
                            <div class='col-sm-2'>
                                $pedido->descricao
                            </div>
                            <div class='col-sm-1'>
                                $pedido->quantidade_pedida - $pedido->um
                            </div>
                            <div class='col-sm-1'>
                                $pedido->valor_unit
                            </div>
                        </div>";
                        $result2 .= "
                            <tr>
                                <td>$pedido->descricao</td>
                                <td>$pedido->quantidade_pedida - $pedido->um</td>
                                <td>$pedido->valor_unit</td>
                            </tr>
                        ";
                    $i++;
                }else{
                    $result .= "
                    <div class='row mt-4'>
                        <div class='col-sm-2'>
                            $pedido->id
                        </div>
                        <div class='col-sm-2'>
                            $pedido->nome
                        </div>
                        <div class='col-sm-2'>
                            ".$helper->formataDateTime($pedido->data_emissao)."
                        </div>
                        <div class='col-sm-2'>
                            ".$helper->formataDateTime($pedido->data_entrega)."
                        </div>
                        <div class='col-sm-2'>
                            R$ ".$helper->formataValor($pedido->valor_total)."
                        </div>
                        <div class='col-sm-2'>
                            ".$status[$pedido->situacao]."
                        </div>
                    </div>";
                    $result2 .= "
                    <tr>
                        <td>$pedido->id</td>
                        <td>$pedido->nome</td>
                        <td>".$helper->formataDateTime($pedido->data_emissao)."</td>
                        <td>".$helper->formataDateTime($pedido->data_entrega)."</td>
                        <td>R$ ".$helper->formataValor($pedido->valor_total)."</td>
                        <td>".$status[$pedido->situacao]."</td>
                    </tr>
                    ";
                }
            }
            $result2 .="</table>";
            $_SESSION["sgp_result_rel"] = $result2;
            echo $result;
            echo "<a href='".URL."/excel.php' target='_blank'><button class='w-100 btn btn-info btn-lg mt-5 mb-5' type='button' name='geraExcel'>Gerar Excel</button></a>";
            echo "</div>";
    }
?>
