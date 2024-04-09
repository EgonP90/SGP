<?php
    class PedidoModel
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function registraPedido($cliente, $dataEmissao, $dataEntrega, $valorTotal, $formaEntrega, $observacao = "")
        {
            try {
                $this->db->query("INSERT INTO ordens(clientes_id, data_emissao, data_entrega, valor_total, retirada, situacao, created_at, observacao) VALUES (:cliente, :data_emissao, :data_entrega, :valor_total, :retirada, :situacao, :created_at, :observacao)");
                $this->db->bind("cliente", $cliente);
                $this->db->bind("data_emissao", $dataEmissao);
                $this->db->bind("data_entrega", $dataEntrega);
                $this->db->bind("valor_total", $valorTotal);
                $this->db->bind("retirada", $formaEntrega);
                $this->db->bind("situacao", 0);
                $this->db->bind("created_at", $dataEmissao); 
                $this->db->bind("observacao", $observacao);                
                if($this->db->execQuery()){
                    return $this->db->lastInsertId();
                }else{
                    return null;
                }
            } catch (Throwable $th) {
                return null;
            } 
        }

        public function insereItensPedido($pedido, $produto, $quantidade, $valor, $dateTime)
        {
            try {
                $this->db->query("INSERT INTO ordens_produtos(ordens_id, produtos_id, quantidade_pedida, valor_unit, situacao, created_at) VALUES (:pedido, :produto, :quantidade, :valor, :situacao, :dataHora)");
                $this->db->bind("pedido", $pedido); 
                $this->db->bind("produto", $produto); 
                $this->db->bind("quantidade", $quantidade); 
                $this->db->bind("valor", $valor); 
                $this->db->bind("situacao", 0); 
                $this->db->bind("dataHora", $dateTime);               
                if(!$this->db->execQuery()){
                    return null;
                }else{
                    return true;
                }
            } catch (Throwable $th) {
                return null;
            } 
        }

        public function buscaPorOrdemProduto($pedido, $produto)
        {
            try {
                $this->db->query("SELECT quantidade_pedida FROM ordens_produtos WHERE ordens_id = :pedido and produtos_id = :produto");
                $this->db->bind("pedido", $pedido);
                $this->db->bind("produto", $produto);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return $this->db->results();
                else
                    return false;
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function buscaPedidoClientePorId($id)
        {
            try {
                $this->db->query("SELECT c.nome, c.cpfcnpj, c.cep, c.rua, c.numero_endereco, c.complemento, c.bairro, c.cidade, c.estado, c.telefone, o.data_emissao, o.data_entrega, o.valor_total, o.retirada, o.observacao FROM clientes c, ordens o WHERE o.clientes_id = c.id and o.id = :id");
                $this->db->bind("id", $id);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            } 
        }

        public function buscaItensPedidoPorId($id)
        {
            try {
                $this->db->query("SELECT p.descricao, p.codigo_produto, p.um, p.id, op.quantidade_pedida, op.valor_unit FROM produtos p, ordens_produtos op WHERE op.produtos_id = p.id and op.ordens_id = :id");
                $this->db->bind("id", $id);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            } 
        }

        public function verificaItemPedido($produto_id, $pedido_id)
        {
            try {
                $this->db->query("SELECT * FROM ordens_produtos WHERE ordens_id = :pedido_id AND produtos_id = :produto_id");
                $this->db->bind("pedido_id", $pedido_id);
                $this->db->bind("produto_id", $produto_id);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return true;
                else
                    return false;
            } catch (Throwable $th) {
                return null;
            } 
        }

        public function buscaPedidoPorCliente($clienteId)
        {
            try{
                $this->db->query("SELECT id FROM ordens WHERE clientes_id = :id");
                $this->db->bind("id", $clienteId);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return true;
                else
                    return false;
            } catch (Throwable $th) {
                return null;
            } 
        }

        public function buscaPedidoPorProduto($produtoId)
        {
            try{
                $this->db->query("SELECT produtos_id FROM ordens_produtos WHERE produtos_id = :id");
                $this->db->bind("id", $produtoId);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return true;
                else
                    return false;
            } catch (Throwable $th) {
                return null;
            } 
        }

        public function buscaPedidoPorDataEntrega($data1, $data2 = null)
        {
            try{
                $dataInicio = $data1." 00:00:01";
                if($data2 == null){
                    $dataFim = $data1." 23:59:59";
                }else{
                    $dataFim = $data2." 23:59:59";
                }
                $this->db->query("SELECT o.id, o.data_emissao, o.data_entrega, o.retirada, o.situacao, op.quantidade_pedida, op.situacao as situacao_item, c.nome, p.descricao, p.codigo_produto, p.um, op.produtos_id FROM ordens o, ordens_produtos op, clientes c, produtos p WHERE op.ordens_id = o.id and o.clientes_id = c.id and op.produtos_id = p.id and (o.data_entrega >= :dataInicio and o.data_entrega <= :dataFim) order by o.data_entrega asc, ordens_id asc, produtos_id asc");
                $this->db->bind("dataInicio", $dataInicio);
                $this->db->bind("dataFim", $dataFim);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            } 
        }

        public function atualizaStatusItemPedido($pedido_id, $produto_id, $novoStatus, $dateTime)
        {
            try {
                $this->db->query("UPDATE ordens_produtos SET situacao = :status, updated_at = :datetime WHERE ordens_id = :pedido and produtos_id = :produto");
                $this->db->bind("status", $novoStatus);
                $this->db->bind("pedido", $pedido_id);
                $this->db->bind("produto", $produto_id);
                $this->db->bind("datetime", $dateTime);
                $this->db->execQuery();
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function atualizaQuantidade($pedido_id, $produto_id, $quantidade)
        {
            try {
                $this->db->query("UPDATE ordens_produtos SET quantidade_pedida = :quantidade WHERE ordens_id = :pedido and produtos_id = :produto");
                $this->db->bind("quantidade", $quantidade);
                $this->db->bind("pedido", $pedido_id);
                $this->db->bind("produto", $produto_id);
                $this->db->execQuery();
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function atualizaPedido($produto_id, $pedido_id, $quantidade, $valor, $dateTime)
        {
            try {
                $this->db->query("UPDATE ordens_produtos SET quantidade_pedida = :quantidade, valor_unit = :valor, updated_at = :dataHora WHERE ordens_id = :pedido and produtos_id = :produto");
                $this->db->bind("quantidade", $quantidade);
                $this->db->bind("valor", $valor);
                $this->db->bind("pedido", $pedido_id);
                $this->db->bind("produto", $produto_id);
                $this->db->bind("dataHora", $dateTime);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return true;
                else
                    return false;
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function atualizaStatusPedidoItem($pedido_id, $dateTime)
        {
            try {
                $this->db->query("UPDATE ordens_produtos SET situacao = :status, updated_at = :datetime WHERE ordens_id = :pedido and (situacao <> :cancelado and situacao <> :entregue)");
                $this->db->bind("status", 3);
                $this->db->bind("pedido", $pedido_id);
                $this->db->bind("datetime", $dateTime);
                $this->db->bind("cancelado", 4);
                $this->db->bind("entregue", 3);
                $this->db->execQuery();
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function atualizaStatusPedido($pedido_id, $status, $dateTime)
        {
            try {
                $this->db->query("UPDATE ordens SET situacao = :status, updated_at = :datetime WHERE id = :pedido");
                $this->db->bind("status", $status);
                $this->db->bind("pedido", $pedido_id);
                $this->db->bind("datetime", $dateTime);
                if($this->db->execQuery()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function atualizaValorTotalPedido($pedido_id, $novoTotal, $dateTime)
        {
            try {
                $this->db->query("UPDATE ordens SET valor_total = :valor, updated_at = :datetime WHERE id = :pedido");
                $this->db->bind("valor", $novoTotal);
                $this->db->bind("pedido", $pedido_id);
                $this->db->bind("datetime", $dateTime);
                $this->db->execQuery();
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function atualizaDadosPedido($dados, $pedido_id, $dateTime)
        {
            try {
                $this->db->query("UPDATE ordens SET observacao = :observacao, data_entrega = :entrega, retirada = :retirada, updated_at = :datetime WHERE id = :pedido");
                $this->db->bind("observacao", $dados["observacao"]);
                $this->db->bind("entrega", $dados["data_entrega"]);
                $this->db->bind("retirada", $dados["forma_entrega"]);
                $this->db->bind("datetime", $dateTime);
                $this->db->bind("pedido", $pedido_id);
                if($this->db->execQuery()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function contaItensPedidoPorStatus($pedido_id, $status) 
        {
            try {
                $this->db->query("SELECT count(*) as count FROM ordens_produtos WHERE ordens_id = :pedido and situacao = :status");
                $this->db->bind("status", $status);
                $this->db->bind("pedido", $pedido_id);
                $this->db->execQuery();
                return $this->db->results();
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function retornaNumeroItensPedido($pedido_id)
        {
            try {
                $this->db->query("SELECT count(*) as count FROM ordens_produtos WHERE ordens_id = :pedido");
                $this->db->bind("pedido", $pedido_id);
                $this->db->execQuery();
                return $this->db->results();
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function buscaPedidoPorNomeOuId($criterio)
        {
            try {
                $filter = "c.nome like '%". $criterio . "%'";
                $this->db->query("SELECT o.id, o.data_emissao, o.data_entrega, o.retirada, o.situacao, op.quantidade_pedida, op.situacao as situacao_item, c.nome, p.descricao, p.codigo_produto, p.um, op.produtos_id FROM ordens o, ordens_produtos op, clientes c, produtos p WHERE op.ordens_id = o.id and o.clientes_id = c.id and op.produtos_id = p.id and (o.id = :criterio or $filter) order by o.data_entrega asc, ordens_id asc, produtos_id asc");
                $this->db->bind("criterio", $criterio);
                $this->db->execQuery();
                return $this->db->results();
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function buscaPedidoPorId($id)
        {
            try {
                $this->db->query("SELECT * FROM ordens WHERE id = :id");
                $this->db->bind("id", $id);
                $this->db->execQuery();
                return $this->db->results();
            } catch (\Throwable $th) {
                return null;
            }
        }

        public function buscaPedidos($data_emissao_de = null, $data_emissao_ate = null, $data_entrega_de = null, $data_entrega_ate = null, $pedido = null, $cliente = null, $produto = null, $situacao = null, $tipo)
        {
            try {
                $emissao = "";
                $entrega = "";
                $pedidoFilter = "";
                $clienteFilter = "";
                $produtoFilter1 = "";
                $produtoFilter2 = "";
                $produtoFilterFrom = "";
                $statusFilter = "";
                // Faz busca por data(s) de emissão
                if($data_emissao_de != null and $data_emissao_ate == null)
                    $emissao = " and (o.data_emissao >= '$data_emissao_de 00:00:01' and o.data_emissao <= '$data_emissao_de 23:59:59')";
                else if($data_emissao_de == null and $data_emissao_ate != null)
                    $emissao = " and (o.data_emissao >= '$data_emissao_ate 00:00:01' and o.data_emissao <= '$data_emissao_ate 23:59:59')";
                else if($data_emissao_de != null and $data_emissao_ate != null)
                    $emissao = " and (o.data_emissao >= '$data_emissao_de 00:00:01' and o.data_emissao <= '$data_emissao_ate 23:59:59')";
                
                // Faz busca por data(s) de entrega
                if($data_entrega_de != null and $data_entrega_ate == null)
                    $entrega = " and (o.data_entrega >= '$data_entrega_de 00:00:01' and o.data_entrega <= '$data_entrega_de 23:59:59')";
                else if($data_entrega_de == null and $data_entrega_ate != null)
                    $entrega = " and (o.data_entrega >= '$data_entrega_ate 00:00:01' and o.data_entrega <= '$data_entrega_ate 23:59:59')";
                else if($data_entrega_de != null and $data_entrega_ate != null)
                    $entrega = " and (o.data_entrega >= '$data_entrega_de 00:00:01' and o.data_entrega <= '$data_entrega_ate 23:59:59')";
                
                // Faz busca por número do pedido
                if($pedido != null){
                    $array = explode('-', $pedido);
                    if(count($array) == 1){
                        $pedidoFilter = "and o.id = '$pedido'";
                    }else if(count($array) == 2){
                        $pedidoFilter = "and (o.id >= '".$array["0"]."' and o.id <= '".$array["1"]."')";
                    }else{
                        $pedidoFilter = "";
                    }
                }
                
                // Faz busca por cliente
                if($cliente != null){
                    $clienteFilter .= " and (";
                    for($i = 0; $i < count($cliente); $i++){
                        $clienteFilter .= "o.clientes_id = '".$cliente[$i]."'";
                        if($i != count($cliente) - 1){
                            $clienteFilter .= " or ";
                        }
                    }
                    $clienteFilter .= ")";
                }

                // Faz busca por status
                if($situacao != null and $situacao[0] != ""){
                    $statusFilter .= " and (";
                    for($i = 0; $i < count($situacao); $i++){
                        $statusFilter .= "o.situacao = '".$situacao[$i]."'";
                        if($i != count($situacao) - 1){
                            $statusFilter .= " or ";
                        }
                    }
                    $statusFilter .= ")";
                }

                // Faz busca por produto
                if($produto != null){
                    $produtoFilterFrom = ", ordens_produtos op ";
                    $produtoFilter1 = "and op.ordens_id = o.id";
                    $produtoFilter1 .= " and (";
                    $produtoFilter2 .= " and (";
                    for($i = 0; $i < count($produto); $i++){
                        $produtoFilter1 .= "op.produtos_id = '".$produto[$i]."'";
                        $produtoFilter2 .= "op.produtos_id = '".$produto[$i]."'";
                        if($i != count($produto) - 1){
                            $produtoFilter1 .= " or ";
                            $produtoFilter2 .= " or ";
                        }
                    }
                    $produtoFilter1 .= ")";
                    $produtoFilter2 .= ")";
                }
                
                if($tipo == 's'){
                    $this->db->query("SELECT o.id, c.nome, o.data_emissao, o.data_entrega, o.valor_total, o.situacao FROM ordens o, clientes c $produtoFilterFrom WHERE o.clientes_id = c.id $emissao $entrega $pedidoFilter $clienteFilter $statusFilter $produtoFilter1 order by id");
                    $this->db->execQuery();
                    return $this->db->results();
                }else if($tipo == 'a'){
                    $this->db->query("SELECT o.id, c.nome, o.data_emissao, o.data_entrega, o.valor_total, o.situacao, op.valor_unit, p.descricao, op.quantidade_pedida, p.um FROM ordens o, clientes c, ordens_produtos op, produtos p WHERE o.clientes_id = c.id and o.id = op.ordens_id and op.produtos_id = p.id $emissao $entrega $pedidoFilter $clienteFilter $statusFilter $produtoFilter2 order by id");
                    $this->db->execQuery();
                    return $this->db->results();
                }
            } catch (\Throwable $th) {
                return null;
            }
        }

    }

?>