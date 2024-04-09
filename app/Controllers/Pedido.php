<?php 

    class Pedido extends Controller{

        private $tipoSuccess = 'success';
        private $tipoError = 'error';
        private $tipoWarning = 'warning';
        private $rotinaCad = 'Pedido';
        private $rotinaAlt = 'Pedido';
        public $helper;
        public $cliente;
        public $pedidoModel;
        public $produto;
        public $log;

        public function __construct()
        {
            $this->helper = new Helpers();
            require 'Cliente.php';
            $this->cliente = new Cliente();
            require 'Produto.php';
            $this->produto = new Produto();
            $this->pedidoModel = $this->model('PedidoModel');
            $this->log = new Logs();
        }
        // Show home page with the most visited functions
        public function index(){
            if($this->helper->sessionValidate()){
                $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if($form == null){
                    $dados = [
                        'pedidos'  => $this->pedidoModel->buscaPedidoPorDataEntrega($this->helper->returnDate()),
                        'data_de'  => null,
                        'data_ate' => null,
                    ];
                }else{
                    if(isset($form["search_pedido_cliente"])){
                        $dados = [
                            'pedidos'  => $this->pedidoModel->buscaPedidoPorNomeOuId($form["search_pedido_cliente"]),
                            'data_de'  => null,
                            'data_ate' => null,
                        ];
                    }else{
                        if(isset($form["btnEntregarPedidoCompleto"])){
                            $this->atualizaStatusPedidoItem($form["ordem_id"]);
                        }
                        $dados = [
                            'pedidos'  => $this->pedidoModel->buscaPedidoPorDataEntrega($form["data_de"], $form["data_ate"]),
                            'data_de'  => $form["data_de"],
                            'data_ate' => $form["data_ate"]
                        ];
                    }
                }
                $this->view('pedido/index', $dados);
            }else{
                echo "<script>window.location.href='../login';</script>";
            }
        }

        public function novo(){
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] != 3){
                    $dados = [
                        'clientes' => $this->cliente->listaClientes(null)
                    ];
                    $this->view('pedido/novo', $dados);
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                echo "<script>window.location.href='./login';</script>";
            }
        }

        public function itens(){
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] != 3){
                    if(!isset($_SESSION["sgp_nome_aux"]) or $_SESSION["sgp_nome_aux"] == null or $_SESSION["sgp_nome_aux"] == ""){
                        $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $consulta = $this->cliente->buscaClientePorNome($form["nome"]);
                    }else{
                        $consulta = $this->cliente->buscaClientePorNome($_SESSION["sgp_nome_aux"]);
                    }
                    if($consulta == null){
                        // Cadastra novo cliente
                        $cadastro = $this->cliente->cadastrar($form);
                        if(!$cadastro){
                         //   $this->novo();
                        }
                    }else{
                        // Atualiza cliente já existente
                       // if(!$this->cliente->updateCliente($form, $consulta[0]->id)){
                        //    $this->novo();
                        //}
                    }
                    $itens = $this->produto->listaProdutos(null);
                    if(!isset($_SESSION["sgp_nome_aux"]) or $_SESSION["sgp_nome_aux"] == null or $_SESSION["sgp_nome_aux"] == ""){
                        $dados = [ 
                            'id_novo'     => isset($cadastro) ? $cadastro : null,
                            'id_update'   => isset($consulta[0]->id) ? $consulta[0]->id : null,
                            'nome'        => $form["nome"],
                            'telefone'    => $form["telefone"],
                            'rua'         => $form["logradouro"],
                            'numero'      => $form["numero"],
                            'cidade'      => $form["cidade"],
                            'bairro'      => $form["bairro"],
                            'estado'      => $form["estado"],
                            'itens'       => $itens
                        ];
                    }else{
                        $dados = [ 
                            'id_novo'     => isset($cadastro) ? $cadastro : null,
                            'id_update'   => isset($consulta[0]->id) ? $consulta[0]->id : null,
                            'nome'        => $_SESSION["sgp_nome_aux"],
                            'telefone'    => $_SESSION["sgp_telefone_aux"],
                            'rua'         => $_SESSION["sgp_logradouro_aux"],
                            'numero'      => $_SESSION["sgp_numero_aux"],
                            'cidade'      => $_SESSION["sgp_cidade_aux"],
                            'bairro'      => $_SESSION["sgp_bairro_aux"],
                            'estado'      => $_SESSION["sgp_estado_aux"],
                            'itens'       => $itens
                        ];
                    }
                    $_SESSION["sgp_nome_aux"] = null;
                    $_SESSION["sgp_telefone_aux"] = null;
                    $_SESSION["sgp_logrdouro_aux"] = null;
                    $_SESSION["sgp_numero_aux"] = null;
                    $_SESSION["sgp_estado_aux"] = null;
                    $_SESSION["sgp_cidade_aux"] = null;
                    $_SESSION["sgp_bairro_aux"] = null;
                    $this->view('pedido/itens', $dados);
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                echo "<script>window.location.href='./login';</script>";
            }
        }

        public function finalizar(){
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] != 3){
                    $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $cliente = $this->cliente->buscaClientePorId($form["id_cliente"]);
                    $itens = [];
                    for($i = 1; $i < count($form) - 2; $i++){
                        if(isset($form["item-$i"]) and $form["item-$i"] != ""){
                            $produto = $this->produto->buscaProdutoPorId($form["item-$i"]);
                            array_push($itens, $produto[0]->codigo_produto." - ".$produto[0]->descricao);
                            array_push($itens, $form["preco-$i"]);
                            array_push($itens, $form["qtd-$i"]);
                            array_push($itens, $form["total-$i"]);
                            array_push($itens, $produto[0]->id);
                        }
                    }
                    $dados = [ 
                        'cliente'  => $cliente,
                        'itens'    => $itens,
                        'subtotal' => $form["txtValortotal"]
                    ];
                    $this->view('pedido/finalizar', $dados);
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                echo "<script>window.location.href='./login';</script>";
            }
        }

        public function registrar(){
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] != 3){
                    $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    if(isset($form["btnFinalizarPedido"])){
                        $dateTime = $this->helper->returnDateTime();
                        $idPedido = $this->pedidoModel->registraPedido(
                            $form["cliente_id"],
                            $dateTime,
                            $this->formataDataHora($form["data_entrega"]),
                            $form["valor_total"],
                            $form["forma_entrega"],
                            $form["observacao"],
                        );
                        if($idPedido != null){
                            for($i = 0; $i < $form["qtd_itens"]; $i++){
                                $pedido_ordem = $this->pedidoModel->buscaPorOrdemProduto($idPedido, $form["produto_id__$i"]);
                                if(!$pedido_ordem){
                                    $this->pedidoModel->insereItensPedido(
                                        $idPedido,
                                        $form["produto_id__$i"],
                                        $form["quantidade__$i"],
                                        $form["valor_unitario__$i"],
                                        $dateTime
                                    );
                                }else{
                                    $quantidade = $pedido_ordem[0]->quantidade_pedida + $form["quantidade__$i"];
                                    $this->pedidoModel->atualizaQuantidade($idPedido, $form["produto_id__$i"], $quantidade);
                                }
                            }
                            $this->helper->setReturnMessage(
                                $this->tipoSuccess,
                                'Pedido registrado com sucesso!',
                                $this->rotinaCad
                            );
                            $this->log->registraLog($_SESSION["sgp_id"], "Pedido", $idPedido, 0, $dateTime);
                        }else{
                            $this->helper->setReturnMessage(
                                $this->tipoError,
                                'Erro ao registrar pedido, tente novamente!',
                                $this->rotinaCad
                            );
                        }
                        $dados = [
                            'numero_pedido'  => $idPedido,
                            'cliente_pedido' => $this->pedidoModel->buscaPedidoClientePorId($idPedido),
                            'itens_pedido'   => $this->pedidoModel->buscaItensPedidoPorId($idPedido)
                        ];
                        $this->view('pedido/registrar', $dados);
                    }else{
                        $this->helper->homeRedirect();
                    }
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                echo "<script>window.location.href='./login';</script>";
            }
        }

        public function buscaPedidoPorCliente($clienteId){
            if($this->pedidoModel->buscaPedidoPorCliente($clienteId)){
                echo "<info>CLIENTE_TEM_PEDIDO</info>";
            }else{
                echo "<info>CLIENTE_NAO_TEM_PEDIDO</info>";
            }
        }

        public function buscaPedidoPorProduto($produtoId){
            if($this->pedidoModel->buscaPedidoPorProduto($produtoId)){
                echo "<info>PRODUTO_TEM_PEDIDO</info>";
            }else{
                echo "<info>PRODUTO_NAO_TEM_PEDIDO</info>";
            }
        }

        public function atualizaStatusItem($statusAtual, $id){
            if($this->helper->sessionValidate()){
                $array = explode('_', $id);
                $array2 = explode('-', $array[1]);
                $pedido_id = $array2[0];
                $produto_id = $array2[1];
                $novoStatus = null;
                echo "STATUS ATUAL: ".$statusAtual;
                if($statusAtual == 'Emproduo'){
                    $novoStatus = 1;
                }else if($statusAtual == 'ProntoRetirada'){
                    $novoStatus = 2;
                }else if($statusAtual == 'Entregar'){
                    $novoStatus = 3;
                }else if($statusAtual == 'Cancelar'){
                    $novoStatus = 4;
                }
                $dateTime = $this->helper->returnDateTime();
                if($novoStatus != null){
                    $this->pedidoModel->atualizaStatusItemPedido($pedido_id, $produto_id, $novoStatus, $dateTime);
                    $this->log->registraLog($_SESSION["sgp_id"], "Item pedido", $pedido_id, 1, $dateTime);
                    $this->log->registraLog($_SESSION["sgp_id"], "Item pedido", $produto_id, 1, $dateTime);
                }
                $statusPedido = $this->verificaStatusPedido($pedido_id);
                echo "<STATUS_PEDIDO>".$statusPedido."</STATUS_PEDIDO>";
                $novoStatusPedido = null;
                if($statusPedido == "Cancelado"){
                    $novoStatusPedido = 4;
                }else if($statusPedido == "Ent. Parcial"){
                    $novoStatusPedido = 5;
                }else if($statusPedido == "Pronto p/ Retirada"){
                    $novoStatusPedido = 2;
                }else if($statusPedido == "Não entregue"){
                    $novoStatusPedido = 0;
                }else if($statusPedido == "Em produção"){
                    $novoStatusPedido = 1;
                }else if($statusPedido == "Entregue"){
                    $novoStatusPedido = 3;
                }
                $this->atualizaStatusPedido($pedido_id, $novoStatusPedido, $dateTime);
            }else{
                $this->helper->homeRedirect();
            }
        }

        public function editar(){
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] != 3){
                    $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    if($form != NULL){
                        if(isset($form["btnAlteraDadosCliente"])){
                            $pedidoId = $form["pedido_id"];
                            $this->cliente->updateCliente($form, $form["cliente_id"]);
                        }else if(isset($form["btnAlteraDadosPedido"])){
                            $pedidoId = $form["pedido_id"];
                            $this->atualizaDadosPedido($form, $pedidoId);
                        }else if(isset($form["btnAlteraItens"])){
                            $pedidoId = $form["pedido_id"];
                            $this->atualizaItensPedido($form);
                            $this->atualizaValorTotalPedido($pedidoId, $form["txtValortotal"]);
                        }else{
                            $pedidoId = $form["ordem_id"];
                        }
                        $pedido = $this->pedidoModel->buscaPedidoPorId($pedidoId);
                        $cliente = $this->cliente->buscaClientePorId($pedido[0]->clientes_id);
                        $itens = $this->pedidoModel->buscaItensPedidoPorId($pedidoId);
                        $produtos = $this->produto->listaProdutos();
                        $dados = [
                            'pedido' => $pedido,
                            'cliente' => $cliente,
                            'itens' => $itens,
                            'produtos' => $produtos,
                        ];
                        $this->view('pedido/editar', $dados);
                    }else{
                        $this->view('pagenotfound');
                    }
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                echo "<script>window.location.href='../login';</script>";
            }
        }

        private function atualizaValorTotalPedido($pedido_id, $novoTotal){
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] != 3){
                    $dateTime = $this->helper->returnDateTime();
                    $this->pedidoModel->atualizaValorTotalPedido($pedido_id, $novoTotal, $dateTime);
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                echo "<script>window.location.href='../login';</script>";
            }
        }

        private function atualizaItensPedido($dados){
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] != 3){
                    for($i = 1; $i <= 30; $i++){
                        if(!empty($dados["item-$i"])){
                            $produto_id = isset($dados["prod_item-$i"]) ? $dados["prod_item-$i"] : $dados["item-$i"];
                            $dateTime = $this->helper->returnDateTime();
                            if($this->pedidoModel->verificaItemPedido($produto_id, $dados["pedido_id"])){ 
                                if($this->pedidoModel->atualizaPedido($produto_id, $dados["pedido_id"], $dados["qtd-$i"], $dados["preco-$i"], $dateTime)){
                                    $this->helper->setReturnMessage(
                                        $this->tipoSuccess,
                                        'Itens do pedido atualizados com sucesso!',
                                        $this->rotinaCad
                                    );
                                    $this->log->registraLog($_SESSION["sgp_id"], "Pedido", $dados["pedido_id"], 1, $dateTime);
                                }else{
                                    $this->helper->setReturnMessage(
                                        $this->tipoError,
                                        'Erro ao atualizar itens do pedido, tente novamente!',
                                        $this->rotinaCad
                                    );
                                }
                            }else{
                                if($this->pedidoModel->insereItensPedido(
                                    $dados["pedido_id"],
                                    $produto_id,
                                    $dados["qtd-$i"],
                                    $dados["preco-$i"],
                                    $dateTime
                                )){
                                    $this->helper->setReturnMessage(
                                        $this->tipoSuccess,
                                        'Itens do pedido atualizados com sucesso!',
                                        $this->rotinaCad
                                    );
                                    $this->log->registraLog($_SESSION["sgp_id"], "Pedido", $dados["pedido_id"], 1, $dateTime);
                                }else{
                                    $this->helper->setReturnMessage(
                                        $this->tipoError,
                                        'Erro ao atualizar itens do pedido, tente novamente!',
                                        $this->rotinaCad
                                    );
                                }
                            }
                        }
                    }
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                echo "<script>window.location.href='../login';</script>";
            }
        }

        private function atualizaDadosPedido($dados, $pedido_id){
            if($this->helper->sessionValidate()){
                $dateTime = $this->helper->returnDateTime();
                if($this->pedidoModel->atualizaDadosPedido($dados, $pedido_id, $dateTime)){
                    $this->helper->setReturnMessage(
                        $this->tipoSuccess,
                        'Pedido alterado com sucesso!',
                        $this->rotinaCad
                    );
                    $this->log->registraLog($_SESSION["sgp_id"], "Pedido", $pedido_id, 1, $dateTime);
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Erro ao alterar pedido, tente novamente!',
                        $this->rotinaCad
                    );
                }
            }else{
                $this->helper->homeRedirect();
            }
        }

        private function atualizaStatusPedido($pedido_id, $status, $dateTime){
            if($this->helper->sessionValidate()){
                if($this->pedidoModel->atualizaStatusPedido($pedido_id, $status, $dateTime)){
                    $this->log->registraLog($_SESSION["sgp_id"], "Pedido", $pedido_id, 1, $dateTime);
                }
            }else{
                $this->helper->homeRedirect();
            }
        }

        private function atualizaStatusPedidoItem($pedido_id){
            if($this->helper->sessionValidate()){
                $dateTime = $this->helper->returnDateTime();
                $this->pedidoModel->atualizaStatusPedidoItem($pedido_id, $dateTime);
                $this->atualizaStatusPedido($pedido_id, 3, $dateTime);
                $this->log->registraLog($_SESSION["sgp_id"], "Pedido", $pedido_id, 1, $dateTime);
            }else{
                $this->helper->homeRedirect();
            }
            
        }

        private function verificaStatusPedido($pedido_id){
            echo "<br><br><br><br>";
            $nroItensPedido = $this->pedidoModel->retornaNumeroItensPedido($pedido_id);
            $naoProduzido = $this->pedidoModel->contaItensPedidoPorStatus($pedido_id, 0);
            $emProducao = $this->pedidoModel->contaItensPedidoPorStatus($pedido_id, 1);
            $produzido = $this->pedidoModel->contaItensPedidoPorStatus($pedido_id, 2);
            $entregue = $this->pedidoModel->contaItensPedidoPorStatus($pedido_id, 3);
            $cancelado = $this->pedidoModel->contaItensPedidoPorStatus($pedido_id, 4);
            var_dump($nroItensPedido);
            echo "<br>";
            var_dump($naoProduzido);
            echo "<br>";
            var_dump($emProducao);
            echo "<br>";
            var_dump($produzido);
            echo "<br>";
            var_dump($entregue);
            echo "<br>";
            var_dump($cancelado);
            echo "<br>";
            if($nroItensPedido == $cancelado){
                echo "Cancelado";
                return "Cancelado";
            }else if($entregue[0]->count > 0 and ($entregue[0]->count + $cancelado[0]->count < $nroItensPedido[0]->count)){
                echo "Ent. Parcial";
                return "Ent. Parcial";
            }else if(($nroItensPedido[0]->count == $produzido[0]->count) or ($nroItensPedido[0]->count == $produzido[0]->count + $cancelado[0]->count)){
                echo "Produzido";
                return "Pronto p/ Retirada";
            }else if(($nroItensPedido[0]->count == $naoProduzido[0]->count) or ($nroItensPedido[0]->count == $naoProduzido[0]->count + $cancelado[0]->count)){
                echo "Não entregue";
                return "Não entregue";
            }else if(($emProducao[0]->count > 0) or ($produzido[0]->count + $naoProduzido[0]->count == $nroItensPedido[0]->count) or ($produzido[0]->count + $naoProduzido[0]->count + $cancelado[0]->count == $nroItensPedido[0]->count)){
                echo "Em produção";
                return "Em produção";
            }else if(($entregue[0]->count == $nroItensPedido[0]->count) or ($entregue[0]->count + $cancelado[0]->count == $nroItensPedido[0]->count)){
                echo "Entregue";
                return "Entregue";
            }
        }

        private function formataDataHora($dataHora){
            $divisor = explode("T", $dataHora);
            return $divisor[0]." ".$divisor[1].":00";
        }

    }

?>