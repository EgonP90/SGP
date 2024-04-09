<?php
    $helper = new Helpers();
?>
<meta http-equiv="refresh" content="30">
<div id="conteudo_consulta">
    <div class="row" style="margin-left:10px;margin-top:5%;">
        <?php 
            if($_SESSION["sgp_perfil"] != 3){
        ?>
        <div class="col-sm-12 mb-5">
            <a href="<?= URL ?>/pedido/novo">
              <button class="btn btn-primary btn-lg" type="submit" name="novoPedido" id="novoPedido" value="Novo Pedido">Novo Pedido</button>
            </a>
        </div>
        <?php 
            }
        ?>
    </div>
    <?php
        $data = date('d/m/Y');
        if(!isset($dados["pedidos"])){
            echo "<center><h4>Até o momento, não há pedidos com previsão de entrega para hoje - ".$data."</h4></center>";
        }else{
            echo "<center><h4>Pedidos para serem entregues hoje - ".$data."</h4></center>";
        
    ?>
    <div class="container conteudo_consulta mb-5">
        <?php 
            $aux = null;
            foreach($dados['pedidos'] as $pedido){
                if($aux != $pedido->id){
                    $aux = $pedido->id;
                    $id = $pedido->id;
                    echo "<div class='row mt-5'>";
                    echo "<hr class='divisor_horizontal'>";
                    echo "<div class='col-sm-2'>";
                    echo "<h6>".$pedido->id."</h6>";
                    echo "</div>";
                    echo "<div class='col-sm-3'>";
                    echo "<h6>".$pedido->nome."</h6>";
                    echo "</div>";
                    echo "<div class='col-sm-2'>";
                    echo "<h6>".$helper->retornaHorario($pedido->data_entrega)."</h6>";
                    echo "</div>";
                    echo "<div class='col-sm-3'>";
                    echo $pedido->retirada == 0 ? '<h6>Retirada no local</h6>' : '<h6>Entreguar na casa do cliente</h6>';
                    echo "</div>";
                    echo "<div class='col-sm-2' align='center'>";
                    if($pedido->situacao == 0){
                        echo "<h6 style='background-color:red; color:white'>Não entregue</h6>";
                    }else if($pedido->situacao == 1){
                        echo "<h6 style='background-color:orange; color:white'>Em produção</h6>";
                    }else if($pedido->situacao == 2){
                        echo "<h6 style='background-color:blue; color:white'>Produzido</h6>";
                    }else if($pedido->situacao == 3){
                        echo "<h6 style='background-color:green; color:white'>Entregue</h6>";
                    }else if($pedido->situacao == 4){
                        echo "<h6 style='background-color:black; color:white'>Cancelado</h6>";
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "<hr>";
                }
                echo "<div class='row mt-3'>";
                echo "<div class='col-sm-3'>";
                echo $pedido->descricao;
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo $pedido->quantidade_pedida." - ".$pedido->um;
                echo "</div>";
                echo "<div class='col-sm-2'>";
                if($pedido->situacao_item == 0){
                    echo "<h6 style='color:red'>Não produzido</h6>";
                }else if($pedido->situacao_item == 1){
                    echo "<h6 style='color:orange'>Em produção</h6>";
                }else if($pedido->situacao_item == 2){
                    echo "<h6 style='color:blue'>Produzido</h6>";
                }else if($pedido->situacao_item == 3){
                    echo "<h6 style='color:green'>Entregue</h6>";
                }else if($pedido->situacao_item == 4){
                    echo "<h6 style='color:black'>Cancelado</h6>";
                }
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
</div>