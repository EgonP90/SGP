<?php
    class ProdutoModel
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        //Verificar se login informado para cadastro já está cadastrado no sistema
        public function verificaProduto($descricao, $um, $id = null)
        {
            try {
                if($id == null){
                    $this->db->query("SELECT id FROM produtos WHERE descricao = :descricao and um = :um");
                    $this->db->bind("descricao", $descricao);
                    $this->db->bind("um", $um);
                    $this->db->execQuery();
                    if($this->db->numRows() > 0)
                        return true;
                    else
                        return false;
                }else{
                    $this->db->query("SELECT id FROM produtos WHERE descricao = :descricao and um = :um and id <> :id");
                    $this->db->bind("id", $id);
                    $this->db->bind("descricao", $descricao);
                    $this->db->bind("um", $um);
                    $this->db->execQuery();
                    if($this->db->numRows() > 0)
                        return true;
                    else
                        return false;
                }
            } catch (Throwable $th) {
                return false;
            }
        }

        // Cadastrar produto
        public function cadastrarProduto($dados, $dataHora)
        {
            try {
                $this->db->query("INSERT INTO produtos(codigo_produto, descricao, um, preco, situacao, created_at) VALUES (:codigo, :descricao, :um, :preco, :ativo, :dataHora)");
                $this->db->bind("codigo", $dados['codigo']);
                $this->db->bind("descricao", $dados['descricao']);
                $this->db->bind("um", $dados['um']);
                $this->db->bind("preco", $dados['preco']);
                $this->db->bind("ativo", 0);
                $this->db->bind("dataHora", $dataHora);
                if($this->db->execQuery()){
                    return $this->db->lastInsertId();
                }else{
                    return null;
                }
            } catch (Throwable $th) {
                return null;
            }   
        }

        //Retorna todos os produtos cadastrados
        public function listaProdutos($inicio = null)
        {
            try {
                if($inicio == null){
                    $this->db->query("SELECT * FROM produtos order by codigo_produto ASC");
                }else{
                    $this->db->query("SELECT * FROM produtos order by codigo_produto ASC limit 10 OFFSET :inicio");
                    $this->db->bind("inicio", $inicio);
                }
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }

        public function TemMaisRegistro($inicio, $nome = null)
        {
            try {
                $filter = "descricao like '%". $nome . "%'";
                if($nome == null){
                    $this->db->query("SELECT * FROM produtos order by codigo_produto ASC limit 10 OFFSET :inicio");
                }else{
                    $this->db->query("SELECT * FROM produtos WHERE $filter order by codigo_produto ASC limit 10 OFFSET :inicio");
                }
                $this->db->bind("inicio", $inicio);
                $this->db->execQuery();
                return $this->db->numRows();
            } catch (Throwable $th) {
                return null;
            }
        }

        public function listaProdutosPorDescricao($descricao)
        {
            try {
                $filter = "descricao like '%". $descricao . "%' or codigo_produto like '%" . $descricao . "%'";
                $this->db->query("SELECT * FROM produtos WHERE $filter order by codigo_produto ASC");
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }

        //Retorna usuário por id
        public function buscaProdutoPorId($id)
        {
            try {
                $this->db->query("SELECT * FROM produtos WHERE id = :id");
                $this->db->bind("id", $id);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }   
        }

        //Alterar produto
        public function alteraProduto($dados, $dateTime)
        {
            try {
                $this->db->query("UPDATE produtos SET codigo_produto = :codigo, descricao = :descricao, um = :um, preco = :preco, updated_at = :dataHora WHERE id = :id");
                $this->db->bind("codigo", $dados["codigo"]);
                $this->db->bind("descricao", $dados["descricao"]);
                $this->db->bind("um", $dados["um"]);
                $this->db->bind("preco", $dados["preco"]);
                $this->db->bind("dataHora", $dateTime);
                $this->db->bind("id", $dados["id"]);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return true;
                else
                    return false;
            } catch (Throwable $th) {
                return false;
            }
        }

        public function deletaProduto($produtoId){
            try{
                $this->db->query("DELETE FROM produtos WHERE id = :id");
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

        // Ativar ou inativar produto
        public function ativaInativaProduto($id, $acao, $dateTime){
            try {
                $situacao = $acao == "inativar" ? 1 : 0;
                $this->db->query("UPDATE produtos SET situacao = :situacao, updated_at = :dataHora WHERE id = :id");
                $this->db->bind("situacao", $situacao);
                $this->db->bind("dataHora", $dateTime);
                $this->db->bind("id", $id);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return true;
                else
                    return false;
            } catch (Throwable $th) {
                return false;
            }  
        }
    }
?>