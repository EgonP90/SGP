<?php
    $helper = new Helpers();
    if($dados["data_de"] == null){
        $data_de = $this->helper->returnDate();
    }else{
        $data_de = $dados["data_de"];
    }

    if($dados["data_ate"] == null){
        $data_ate = $this->helper->returnDate();
    }else{
        $data_ate = $dados["data_ate"];
    }
?>
<div id="conteudo_consulta">
    <div class="row mt-5" style="margin-top: 100px;margin-left:10px">
        <div class="col-sm-12 mb-5">
            <a href="<?= URL ?>/pedido/novo">
              <button class="btn btn-primary btn-lg" type="submit" name="novoPedido" id="novoPedido" value="Novo Pedido">Novo Pedido</button>
            </a>
        </div>
    </div>
    <form name="form_filtrar_data" id="form_filtrar_data" method="POST" action="<?= URL ?>/pedido/index">
        <input type="hidden" class="form-control" id="txtUrl" name="txtUrl" value="<?= URL ?>">
        <input type="hidden" class="form-control" id="perfil" name="perfil" value="<?= $_SESSION["sgp_perfil"] ?>">
        <div class="row" style="margin-left:10px">
            <div class="col-sm-2">
                <div class="form-floating mt-1">
                    <input type="date" class="form-control" id="data_de" name="data_de" value="<?= $data_de ?>">
                    <label for="data_de">Data Início</label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-floating mt-1">
                    <input type="date" class="form-control" id="data_ate" name="data_ate" value="<?= $data_ate ?>">
                    <label for="data_ate">Data Fim</label>
                </div>
            </div>
            <div class="col-sm-2 mt-3">
                <button class="w-100 btn btn-primary btn-md" type="submit" name="btnFiltrar" id="btnFiltrar" value="btnFiltrar">Filtrar</button>
            </div>
        </div>
    </form>
    <div class="container conteudo_consulta mb-5">
        <?php 
            $aux = null;
            $i = 0;
            if(isset($dados["pedidos"])){
                foreach($dados['pedidos'] as $pedido){
                    if($aux != $pedido->id){
                        $aux = $pedido->id;
                        $id = $pedido->id;
                        echo "<div class='row mt-5'>";
                        echo "<hr class='divisor_horizontal'>";
                        echo "<div class='col-sm-2'>";
                        echo "<h6>".$pedido->id."</h6>";
                        echo "</div>";
                        echo "<div class='col-sm-2'>";
                        echo "<h6>".$pedido->nome."</h6>";
                        echo "</div>";
                        echo "<div class='col-sm-2'>";
                        echo "<h6>".$helper->retornaHorario($pedido->data_entrega)."</h6>";
                        echo "</div>";
                        echo "<div class='col-sm-2'>";
                        echo $pedido->retirada == 0 ? '<h6>Retirada no local</h6>' : '<h6>Entreguar na casa do cliente</h6>';
                        echo "</div>";
                        echo "<div class='col-sm-2'>";
                        echo "</div>";
                        echo "<div class='col-sm-2' align='center'>";
                        if($pedido->situacao == 0){
                            echo "<h6 style='background-color:red; color:white' id='lbStatusPedido_$pedido->id'>Não entregue</h6>";
                        }else if($pedido->situacao == 1){
                            echo "<h6 style='background-color:orange; color:white' id='lbStatusPedido_$pedido->id'>Em produção</h6>";
                        }else if($pedido->situacao == 2){
                            echo "<h6 style='background-color:blue; color:white' id='lbStatusPedido_$pedido->id'>Pronto p/ Retirada</h6>";
                        }else if($pedido->situacao == 3){
                            echo "<h6 style='background-color:green; color:white' id='lbStatusPedido_$pedido->id'>Entregue</h6>";
                        }else if($pedido->situacao == 4){
                            echo "<h6 style='background-color:black; color:white' id='lbStatusPedido_$pedido->id'>Cancelado</h6>";
                        }else if($pedido->situacao == 5){
                            echo "<h6 style='background-color:#58FAF4; color:black' id='lbStatusPedido_$pedido->id'>Ent. Parcial</h6>";
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "<hr>";
                        if($pedido->situacao == 0 or $pedido->situacao == 1 or $pedido->situacao == 2 or $pedido->situacao == 5 or $pedido->situacao == 3){
                            echo "<div class='row mt-3'>";
                            if($pedido->situacao != 3){
                                echo "<div class='col-sm-2 mt-3'>";
                                echo "<form name='form_entrega_pedido' id='form_entrega_pedido' method='POST' action='".URL."/pedido/index'>";
                                echo "<input type='hidden' name='ordem_id' value='".$pedido->id."'>";
                                echo "<input type='hidden' class='form-control' id='data_de' name='data_de' value='". $data_de ."'>";
                                echo "<input type='hidden' class='form-control' id='data_ate' name='data_ate' value='". $data_ate ."'>";
                                if(($_SESSION["sgp_perfil"] == 0 or $_SESSION["sgp_perfil"] == 1)){
                                    echo "<input type='submit' class='w-100 btn btn-success btn-sm' name='btnEntregarPedidoCompleto' id='btnEntregarPedidoCompleto_$pedido->id' value='Entregar Pedido'>";
                                }
                                echo "</form>";
                                echo "</div>";
                            }
                            echo "<div class='col-sm-2 mt-3'>";
                            echo "<form name='form_edita_pedido' id='form_edita_pedido' method='POST' action='".URL."/pedido/editar'>";
                            echo "<input type='hidden' name='ordem_id' value='".$pedido->id."'>";
                            if($pedido->situacao == 3){
                                $valor = "Imprimir Pedido";
                            }else{
                                $valor = "Editar Pedido";
                            }
                            echo "<input type='submit' class='w-100 btn btn-secondary btn-sm' name='edita' id='edita_$pedido->id' value='".$valor."'>";
                            echo "</form>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    $identificador = $pedido->id."-".$pedido->produtos_id;
                    echo "<div class='row mt-3'>";
                    echo "<div class='col-sm-3 mt-2'>";
                    echo "<input type='hidden' name='ordem_id-.$i' value='".$pedido->id."'>";
                    echo "<input type='hidden' name='produto_id-.$i' value='".$pedido->produtos_id."'>";
                    echo $pedido->codigo_produto." - ".$pedido->descricao;
                    echo "</div>";
                    echo "<div class='col-sm-2 mt-2'>";
                    echo $pedido->quantidade_pedida." - ".$pedido->um;
                    echo "</div>";
                    echo "<div class='col-sm-2 mt-3'>";
                    if($pedido->situacao_item == 0){
                        echo "<h6 style='color:red' id='lbStatusItem_$identificador'>Não produzido</h6>";
                    }else if($pedido->situacao_item == 1){
                        echo "<h6 style='color:orange' id='lbStatusItem_$identificador'>Em produção</h6>";
                    }else if($pedido->situacao_item == 2){
                        echo "<h6 style='color:blue' id='lbStatusItem_$identificador'>Pronto p/ Retirada</h6>";
                    }else if($pedido->situacao_item == 3){
                        echo "<h6 style='color:green' id='lbStatusItem_$identificador'>Entregue</h6>";
                    }else if($pedido->situacao_item == 4){
                        echo "<h6 style='color:black' id='lbStatusItem_$identificador'>Cancelado</h6>";
                    }
                    echo "</div>";
                    echo "<div class='col-sm-2 mt-2'>";
                    if($pedido->situacao_item == 0){
                        echo "<input type='button' class='w-100 btn btn-secondary btn-sm' type='submit' name='btnStatusItem' id='btnStatusItem_$identificador' value='Em produção' onClick='mudaStatusItem(this, $pedido->id);'>";
                    }else if($pedido->situacao_item == 1){
                        echo "<input type='button' class='w-100 btn btn-info btn-sm' type='submit' name='btnStatusItem' id='btnStatusItem_$identificador' value='Pronto p/ Retirada' onClick='mudaStatusItem(this, $pedido->id);'>";
                    }else if($pedido->situacao_item == 2){
                        if($_SESSION["sgp_perfil"] == 0 or $_SESSION["sgp_perfil"] == 1){
                            echo "<input type='button' class='w-100 btn btn-success btn-sm' type='submit' name='btnStatusItem' id='btnStatusItem_$identificador' value='Entregar' onClick='mudaStatusItem(this, $pedido->id);'>";
                        }
                    }
                    echo "</div>";
                    $type = 'hidden';
                    if($pedido->situacao_item != 2 and $pedido->situacao_item != 3 and $pedido->situacao_item != 4){
                        $type = 'button';
                    }
                    echo "<div class='col-sm-2 mt-2'>";
                    echo "<input type='$type' class='w-100 btn btn-danger btn-sm' type='submit' name='btnCancelarItem' id='btnCancelarItem_$identificador' value='Cancelar' onClick='mudaStatusItem(this, $pedido->id);'>";
                    echo "</div>";
                    echo "</div>";
                    $i++;
                }
            }
        ?>
    </div>
</div>