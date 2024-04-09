<?php
    class ClienteModel
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        // Cadastrar clienrte
        public function cadastrarCliente($dados, $dataHora)
        {
            try {
                $this->db->query("INSERT INTO clientes(nome, cpfcnpj, cep, rua, numero_endereco, complemento, bairro, cidade, estado, telefone, created_at) VALUES (:nome, :cpfcnpj, :cep, :rua, :numero_endereco, :complemento, :bairro, :cidade, :estado, :telefone, :created_at)");
                $this->db->bind("nome", $dados['nome']);
                $this->db->bind("cpfcnpj", $dados['cpfcnpj']);
                $this->db->bind("cep", $dados['cep']);
                $this->db->bind("rua", $dados['logradouro']);
                $this->db->bind("numero_endereco", $dados['numero']);
                $this->db->bind("complemento", $dados['complemento']);
                $this->db->bind("bairro", $dados['bairro']);
                $this->db->bind("cidade", $dados['cidade']);
                $this->db->bind("estado", $dados['estado']);
                $this->db->bind("telefone", $dados['telefone']);
                $this->db->bind("created_at", $dataHora);
                if($this->db->execQuery()){
                    return $this->db->lastInsertId();
                }else{
                    return null;
                }
            } catch (Throwable $th) {
                return null;
            }   
        }

        //Retorna todos os clientes cadastrados
        public function listaClientes($inicio = null)
        {
            try {
                if($inicio == null){
                    $this->db->query("SELECT * FROM clientes order by nome ASC");
                }else{
                    $this->db->query("SELECT * FROM clientes order by nome ASC limit 10 OFFSET :inicio");
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
                $filter = "nome like '%". $nome . "%'";
                if($nome == null){
                    $this->db->query("SELECT * FROM clientes order by nome ASC limit 10 OFFSET :inicio");
                }else{
                    $this->db->query("SELECT * FROM clientes WHERE $filter order by nome ASC limit 10 OFFSET :inicio");
                }
                $this->db->bind("inicio", $inicio);
                $this->db->execQuery();
                return $this->db->numRows();
            } catch (Throwable $th) {
                return null;
            }
        }

        public function listaClientePorNome($nome)
        {
            try {
                $filter = "nome like '%". $nome . "%'";
                $this->db->query("SELECT * FROM clientes WHERE $filter order by nome ASC");
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }

        // Executa a atualização do cliente
        public function alteraCliente($dados, $dateTime, $id = null, $tipo = null)
        {
            try {
                if($tipo == null){
                    $this->db->query("UPDATE clientes SET nome = :nome, cpfcnpj = :cpfcnpj, cep = :cep, rua = :rua, numero_endereco = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado = :estado, telefone = :telefone, updated_at = :dataHora WHERE id = :id");
                    $this->db->bind("nome", $dados["nome"]);
                    $this->db->bind("cpfcnpj", $dados["cpfcnpj"]);
                    $this->db->bind("cep", $dados["cep"]);
                    $this->db->bind("rua", $dados["logradouro"]);
                    $this->db->bind("numero", $dados["numero"]);
                    $this->db->bind("complemento", $dados["complemento"]);
                    $this->db->bind("bairro", $dados["bairro"]);
                    $this->db->bind("cidade", $dados["cidade"]);
                    $this->db->bind("estado", $dados["estado"]);
                    $this->db->bind("telefone", $dados["telefone"]);
                    $this->db->bind("dataHora", $dateTime);
                }else if($tipo == "parcial"){
                    $this->db->query("UPDATE clientes SET nome = :nome, rua = :rua, numero_endereco = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, telefone = :telefone, updated_at = :dataHora WHERE id = :id");
                    $this->db->bind("nome", $dados["nome"]);
                    $this->db->bind("rua", $dados["logradouro"]);
                    $this->db->bind("numero", $dados["numero"]);
                    $this->db->bind("bairro", $dados["bairro"]);
                    $this->db->bind("cidade", $dados["cidade"]);
                    $this->db->bind("estado", $dados["estado"]);
                    $this->db->bind("telefone", $dados["telefone"]);
                    $this->db->bind("dataHora", $dateTime); 
                }
                if($id == null){
                    $this->db->bind("id", $dados["id"]);
                }else{
                    $this->db->bind("id", $id);
                }
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return true;
                else
                    return false;
            } catch (Throwable $th) {
                return false;
            }
        }

        public function deletaCliente($clienteId){
            try{
                $this->db->query("DELETE FROM clientes WHERE id = :id");
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

        // Busca cliente pelo nome
        public function buscaClientePorNome($nome)
        {
            try {
                $this->db->query("SELECT id FROM clientes wHERE nome = :nome");
                $this->db->bind("nome", $nome);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }

        public function buscaDadosClientePorNome($nome)
        {
            try {
                $this->db->query("SELECT * FROM clientes wHERE nome = :nome");
                $this->db->bind("nome", $nome);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }

        // Busca cliente pelo ID
        public function buscaClientePorId($id)
        {
            try {
                $this->db->query("SELECT * FROM clientes wHERE id = :id");
                $this->db->bind("id", $id);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }
    }
?>