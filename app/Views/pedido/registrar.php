<?php
    $helper = new Helpers();
    $_SESSION["sgp_dados_pedido"] = null;
?>
<div id="conteudo" style="margin-top: 50px;">
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
        <div class="row">
            <p class="tituloConsultas">Dados do Pedido - Nº <b><?= $dados["numero_pedido"] ?></b></p>
            <?php 
                $_SESSION["sgp_dados_pedido"]["numero_pedido"] = $dados["numero_pedido"];
            ?>
                <p><b>Emitido em:</b> <?= $helper->formataDateTime($dados["cliente_pedido"][0]->data_emissao) ?></p>
                <p><b>Nome:</b> <?= $dados["cliente_pedido"][0]->nome ?> - <b>Telefone:</b> <?= $dados["cliente_pedido"][0]->telefone ?></p>
                <p><b>CPF/CNPJ:</b> <?= $dados["cliente_pedido"][0]->cpfcnpj != "" ? $dados["cliente_pedido"][0]->cpfcnpj : 'Não informado' ?></p>
                <p><b>Endereço:</b> <?= $dados["cliente_pedido"][0]->rua != "" ? $dados["cliente_pedido"][0]->rua : 'Não informado' ?>, Nº <?= $dados["cliente_pedido"][0]->numero_endereco != 0 ? $dados["cliente_pedido"][0]->numero_endereco : 'Não informado' ?></p>
                <p><b>Bairro:</b> <?= $dados["cliente_pedido"][0]->bairro != "" ? $dados["cliente_pedido"][0]->bairro : 'Não informado' ?><b>Cidade/Estado:</b> <?= $dados["cliente_pedido"][0]->cidade != "" ? $dados["cliente_pedido"][0]->cidade : 'Não informado' ?> / <?= $dados["cliente_pedido"][0]->estado != "" ?  $dados["cliente_pedido"][0]->estado : 'Não informado'?></p>
                <?= $dados["cliente_pedido"][0]->complemento != "" ?  "<p><b>Complemento:</b>" . $dados["cliente_pedido"][0]->complemento . '</p>' : '' ?>
                <p><b>Data da Entrega:</b> <?= $helper->formataDateTime($dados["cliente_pedido"][0]->data_entrega) ?></p>
                <p><b>Forma de Entrega: </b><?= $dados["cliente_pedido"][0]->retirada == 0 ? 'Retirada no local' : 'Entregar na casa do cliente' ?></p>
                <?= empty($dados["cliente_pedido"][0]->observacao) ? '' : 
                '<p><b>Observação</b><br>'.$dados["cliente_pedido"][0]->observacao . "</p>"
                ?>
            
            <?php 
                $_SESSION["sgp_dados_pedido"]["emitido"] = $helper->formataDateTime($dados["cliente_pedido"][0]->data_emissao);
                $_SESSION["sgp_dados_pedido"]["nome"] = $dados["cliente_pedido"][0]->nome;
                $_SESSION["sgp_dados_pedido"]["telefone"] = $dados["cliente_pedido"][0]->telefone;
                $_SESSION["sgp_dados_pedido"]["cpfcnpj"] = $dados["cliente_pedido"][0]->cpfcnpj != "" ? $dados["cliente_pedido"][0]->cpfcnpj : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["endereco"] = $dados["cliente_pedido"][0]->rua != "" ? $dados["cliente_pedido"][0]->rua : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["numero"] = $dados["cliente_pedido"][0]->numero_endereco != 0 ? $dados["cliente_pedido"][0]->numero_endereco : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["bairro"] = $dados["cliente_pedido"][0]->bairro != "" ? $dados["cliente_pedido"][0]->bairro : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["cidade"] = $dados["cliente_pedido"][0]->cidade != "" ? $dados["cliente_pedido"][0]->cidade : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["estado"] = $dados["cliente_pedido"][0]->estado != "" ?  $dados["cliente_pedido"][0]->estado : 'Não informado';
                $_SESSION["sgp_dados_pedido"]["complemento"] = $dados["cliente_pedido"][0]->complemento != "" ? $dados["cliente_pedido"][0]->complemento : '';
                $_SESSION["sgp_dados_pedido"]["entrega"] = $helper->formataDateTime($dados["cliente_pedido"][0]->data_entrega);
                $_SESSION["sgp_dados_pedido"]["formaEntrega"] = $dados["cliente_pedido"][0]->retirada == 0 ? 'Retirada no local' : 'Entregar na casa do cliente';
            ?>
        </div>
        <hr class="divisor_horizontal">
        <div class="row">
            <p class="tituloConsultas">Itens do Pedido</p>
            <div class="row mt-0">
                <div class="col-3 mb-2">
                    <b>Descrição</b>
                </div>
                <div class="col-1">
                    <b>UM</b>
                </div>
                <div class="col-2" style="text-align: center;">
                    <b>Qtd</b>
                </div>
                <div class="col-3" style="text-align: right;">
                    <b>Vlr. Unit.</b>
                </div>
                <div class="col-3" style="text-align: right;">
                    <b>Sub-total</b>
                </div>
            </div>
            <?php 
                $_SESSION["sgp_dados_pedido"]["itens"] = "";
                foreach($dados["itens_pedido"] as $item){
            ?>
                    <div class="row">
                        <div class="col-3">
                            <?= $item->codigo_produto." - ".$item->descricao ?>
                        </div>
                        <div class="col-1">
                            <?= $item->um ?>
                        </div>
                        <div class="col-2" style="text-align: center;">
                            <?= $item->quantidade_pedida ?>
                        </div>
                        <div class="col-3" style="text-align: right;">
                            <?= 'R$ '.$item->valor_unit ?>
                        </div>
                        <div class="col-3" style="text-align: right;">
                            <?= $helper->multiplicaFormata($item->quantidade_pedida, $item->valor_unit) ?>
                        </div>
                    </div>
                    <?php 
                        $_SESSION["sgp_dados_pedido"]["itens"] .= $item->codigo_produto." - ".$item->descricao.";;;";
                        $_SESSION["sgp_dados_pedido"]["itens"] .= $item->um.";;;";
                        $_SESSION["sgp_dados_pedido"]["itens"] .= $item->quantidade_pedida.";;;";
                        $_SESSION["sgp_dados_pedido"]["itens"] .= $item->valor_unit.";;;";
                        $_SESSION["sgp_dados_pedido"]["itens"] .= $helper->multiplicaFormata($item->quantidade_pedida, $item->valor_unit)."---";
                    ?>
            <?php
                }
            ?>
            <div class="row mt-0">
                <div class="col-sm-12 mb-5" style="text-align: right;">
                    <p><h4><b>Total: R$ <?= $helper->formataValor2($dados["cliente_pedido"][0]->valor_total) ?></b></h4></p>
                </div>
            </div>
            <?php 
                $_SESSION["sgp_dados_pedido"]["valorTotal"] = $dados["cliente_pedido"][0]->valor_total;
                $_SESSION["sgp_dados_pedido"]["status"] = "novo";
            ?>
            <form method="POST" action="<?= URL?>/public/assets/mpdf/gera_pdf.php" target="_blank">
                <div class="row mt-1">
                    <div class="col-sm-3 mb-5">
                        <button class="w-100 btn btn-primary btn-md" type="submit" name="btnImprimir" id="btnImprimir" value="btnImprimir">IMPRIMIR 2ª VIA</button>
                    </div>
                    <div class="col-sm-3 mb-5">
                        <input class="form-check-input" type="checkbox" value="epson" name="tipoImpressora" checked>
                        <label class="form-check-label" for="flexCheckDefault">
                            Impressora Epson
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
    $_SESSION["sgp_rotina"] = null;
?>