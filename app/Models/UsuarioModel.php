<?php
    class UsuarioModel
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        //Verificar se login informado para cadastro já está cadastrado no sistema
        public function verificaLogin($login)
        {
            try {
                $this->db->query("SELECT id FROM usuarios WHERE login = :login");
                $this->db->bind("login", $login);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return true;
                else
                    return false;
            } catch (Throwable $th) {
                return false;
            }
            
        }

        // Cadastrar usuario
        public function cadastrarUsuario($dados, $dataHora)
        {
            try {
                $this->db->query("INSERT INTO usuarios(nome, login, senha, perfil, situacao, created_at) VALUES (:nome, :login, :senha, :perfil, :ativo, :dataHora)");
                $this->db->bind("nome", $dados['nome']);
                $this->db->bind("login", $dados['login']);
                $this->db->bind("senha", $dados['senha']);
                $this->db->bind("perfil", $dados['perfil']);
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

        //Retorna todos os usuários cadastrados
        public function listaUsuarios()
        {
            try {
                $this->db->query("SELECT * FROM usuarios where perfil <> :superadmin order by nome ASC");
                $this->db->bind("superadmin", 0);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }

        public function listaUsuarioPorNome($nome)
        {
            try {
                $filter = "nome like '%". $nome . "%'";
                $this->db->query("SELECT * FROM usuarios WHERE perfil <> :superadmin and $filter order by nome ASC");
                $this->db->bind("superadmin", 0);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }

        //Retorna usuário por id
        public function buscaUsuarioPorId($id)
        {
            try {
                $this->db->query("SELECT * FROM usuarios WHERE id = :id");
                $this->db->bind("id", $id);
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }   
        }

        //Alterar usuário
        public function alteraUsuario($dados, $rotina, $dateTime)
        {
            try {
                if($rotina == "nome-perfil"){
                    $this->db->query("UPDATE usuarios SET nome = :nome, perfil = :perfil, updated_at = :dataHora WHERE id = :id");
                    $this->db->bind("nome", $dados["nome"]);
                    $this->db->bind("perfil", $dados["perfil"]);
                    $this->db->bind("dataHora", $dateTime);
                    $this->db->bind("id", $dados["id"]);
                }else if($rotina == "senha"){
                    $this->db->query("UPDATE usuarios SET nome = :nome, perfil = :perfil, senha = :senha, updated_at = :dataHora  WHERE id = :id");
                    $this->db->bind("nome", $dados["nome"]);
                    $this->db->bind("perfil", $dados["perfil"]);
                    $this->db->bind("senha", $dados["senha"]);
                    $this->db->bind("dataHora", $dateTime);
                    $this->db->bind("id", $dados["id"]);
                }else if($rotina == "nome"){
                    $this->db->query("UPDATE usuarios SET nome = :nome, updated_at = :dataHora WHERE id = :id");
                    $this->db->bind("nome", $dados["nome"]);
                    $this->db->bind("dataHora", $dateTime);
                    $this->db->bind("id", $dados["id"]);
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

        // Ativar ou inativar usuário
        public function ativaInativaUsuario($id, $acao, $dateTime){
            try {
                $situacao = $acao == "inativar" ? 1 : 0;
                $this->db->query("UPDATE usuarios SET situacao = :situacao, updated_at = :dataHora WHERE id = :id");
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

        //Verificar se dados de acesso são validos
        public function validaLogin($login)
        {
            try {
                $this->db->query("SELECT id, nome, senha, perfil, situacao, login FROM usuarios WHERE login = :login");
                $this->db->bind("login", $login);
                $this->db->execQuery();
                if($this->db->numRows() > 0)
                    return $this->db->results();
                else
                    return null;
            } catch (Throwable $th) {
                return null;
            }   
        }

        public function alteraSenhaUsuario($senha, $id, $dateTime)
        {
            try {
                $this->db->query("UPDATE usuarios SET senha = :senha, updated_at = :dataHora WHERE id = :id");
                $this->db->bind("senha", $senha);
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
  
        public function alteraNomeUsuario($nome, $id, $dateTime)
        {
            try {
                $this->db->query("UPDATE usuarios SET nome = :nome, updated_at = :dataHora WHERE id = :id");
                $this->db->bind("nome", $nome);
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