<?php
    class LogModel
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        // Efetua o registro dos logs
        public function registraLog($usuario, $classe, $id_classe, $acao, $dateTime){
            try{
                $this->db->query("INSERT INTO logs (usuarios_id, classe, id_classe, acao, created_at) VALUES (:usuario, :classe, :id_classe, :acao, :dateTime)");
                $this->db->bind("usuario", $usuario);
                $this->db->bind("classe", $classe);
                $this->db->bind("id_classe", $id_classe);
                $this->db->bind("acao", $acao);
                $this->db->bind("dateTime", $dateTime);
                $this->db->execQuery();
            } catch (Throwable $th) {
                return null;
            }
        }

        // Retorna os logs registrados
        public function listaLogs(){
            try {
                $this->db->query("SELECT l.*, u.login FROM logs l, usuarios u WHERE l.usuarios_id = u.id order by l.created_at DESC");
                return $this->db->results();
            } catch (Throwable $th) {
                return null;
            }
        }
    }
?>