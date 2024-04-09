<?php 

    class Usuario extends Controller{

        private $tipoSuccess = 'success';
        private $tipoError = 'error';
        private $tipoWarning = 'warning';
        private $rotinaCad = 'usuario';
        private $rotinaAlt = 'usuario';

        public function __construct()
        {
            $this->helper = new Helpers();
            if($this->helper->sessionValidate()){
                $this->usuarioModel = $this->model('UsuarioModel');
                $this->log = new Logs();
            }else{
                $this->helper->loginRedirect();
            }
        }
        
        // Exibe tela de cadastro de usuário
        public function cadastro(){
            if($this->helper->sessionValidate()){
                $this->view('usuario/cadastro');
            }else{
                $this->helper->loginRedirect();
            }
        }

        // Executa rotina para cadastrar um novo usuário
        public function cadastrar(){
            $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if($this->helper->validateFields($form)){
                if(!$this->usuarioModel->verificaLogin($form["login"])){
                    if($form["senha"] == $form["repetesenha"]){
                        if(strlen($form["senha"]) >= 6){
                            $form["senha"] = password_hash($form["senha"], PASSWORD_DEFAULT);
                            $dateTime = $this->helper->returnDateTime();
                            $lastInserId = $this->usuarioModel->cadastrarUsuario($form, $dateTime);
                            if($lastInserId != null){
                                $this->helper->setReturnMessage(
                                    $this->tipoSuccess,
                                    'Usuário cadastrado com sucesso!',
                                    $this->rotinaCad
                                );
                                $this->log->registraLog($_SESSION["sgp_id"], "Usuário", $lastInserId, 0, $dateTime);
                            }else{
                                $this->helper->setReturnMessage(
                                    $this->tipoError,
                                    'Não foi possível cadastrar o usuário, tente novamente!',
                                    $this->rotinaCad
                                );
                            }
                        }else{
                            $this->helper->setReturnMessage(
                                $this->tipoError,
                                'A senha deve ter no minimo 6 caracteres, tente novamente!',
                                $this->rotinaCad
                            );
                        }
                    }else{
                        $this->helper->setReturnMessage(
                            $this->tipoError,
                            'As senhas não conferem, tente novamente!',
                            $this->rotinaCad
                        );
                    }
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Não foi possível cadastrar o usuário, já existe um usuário cadastrado no sistema com este login, tente novamente informando outro login!',
                        $this->rotinaCad
                    );
                }
            }else{
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    'Existem campos que não foram preenchidos, verifique novamente!',
                    $this->rotinaCad
                );
            }
            echo "<script>window.location.href='../cadastro';</script>";
        }

        // Exibe tela de consulta de usuários
        public function consulta(){
            if($this->helper->sessionValidate()){
                $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(($form == null or !isset($form)) or ($form != null and isset($form["limpar"]))){
                    $dados = [
                        'dados' =>  $this->listaUsuarios(),
                        'nome' => null,
                    ];
                }else{
                    $dados = [
                        'dados' =>  $this->listaUsuarioPorNome($form['nome_usuario']),
                        'nome' => $form['nome_usuario'],
                    ];
                }
                $this->view('usuario/consulta', $dados);
            }else{
                $this->helper->loginRedirect();
            }
        }

        // Listar usuários cadastrados
        public function listaUsuarios(){
            return $this->usuarioModel->listaUsuarios();
        }

        public function listaUsuarioPorNome($nome){
            return $this->usuarioModel->listaUsuarioPorNome($nome);
        }

        // Alterar usuário
        public function alterar(){
            $dateTime = $this->helper->returnDateTime();
            $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if(isset($form["update"])){
                if($this->updateUsuario($form))
                    $this->log->registraLog($_SESSION["sgp_id"], "Usuário", $form["id"], 1, $dateTime);
            }else if(isset($form["inativar"])){
                if($this->ativarInativarUsuario($form, "inativar"))
                    $this->log->registraLog($_SESSION["sgp_id"], "Usuário", $form["id"], 1, $dateTime);
            }else if(isset($form["ativar"])){
                if($this->ativarInativarUsuario($form, "ativar"))
                    $this->log->registraLog($_SESSION["sgp_id"], "Usuário", $form["id"], 1, $dateTime);
            }
            echo "<script>window.location.href='../usuario/consulta';</script>";
        }

        public function alterarPerfil(){
            if($this->helper->sessionValidate()){
                $dateTime = $this->helper->returnDateTime();
                $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($form["nome"])){
                    $info = $this->usuarioModel->buscaUsuarioPorId($form["id"]);
                    if($form["nome"] == $info[0]->nome and (empty($form["senha"]) and empty($form["repetesenha"]))){
                        $this->helper->setReturnMessage(
                            $this->tipoWarning,
                            'Não foi necessária nenhuma alteração no cadastro do usuário',
                            $this->rotinaAlt
                        );
                    }else if($form["nome"] != $info[0]->nome and (empty($form["senha"]) and empty($form["repetesenha"]))){
                        if($this->usuarioModel->alteraUsuario($form, "nome", $dateTime)){
                            $this->helper->setReturnMessage(
                                $this->tipoSuccess,
                                'Usuário alterado com sucesso!',
                                $this->rotinaAlt
                            );
                            $this->log->registraLog($_SESSION["sgp_id"], "Usuário", $form["id"], 1, $dateTime);
                        }else{
                            $this->helper->setReturnMessage(
                                $this->tipoError,
                                'Erro ao alterar usuário, tente novamente, se o problema persistir, entre em contato com o administrador do sistema!',
                                $this->rotinaAlt
                            );
                        }
                    }else if((!empty($form["senha"]) and !empty($form["repetesenha"])) or
                        (empty($form["senha"]) and !empty($form["repetesenha"])) or 
                        (!empty($form["senha"]) and empty($form["repetesenha"])))
                        {
                            if($form["senha"] != $form["repetesenha"]){
                                $this->helper->setReturnMessage(
                                    $this->tipoError,
                                    'Não foi possível alterar o cadastro, as senhas não conferem, tente novamente!',
                                    $this->rotinaAlt
                                );
                            }else if(strlen($form["senha"]) < 6){
                                $this->helper->setReturnMessage(
                                    $this->tipoError,
                                    'Não foi possível alterar o cadastro, as senhas não possuem o mínimo de 6 caracteres!',
                                    $this->rotinaAlt
                                );
                            }else if(strlen($form["senha"]) >= 6 and $form["senha"] == $form["repetesenha"]){
                                $form["senha"] = password_hash($form["senha"], PASSWORD_DEFAULT);
                                if($this->usuarioModel->alteraUsuario($form, "senha", $dateTime)){
                                    $this->helper->setReturnMessage(
                                        $this->tipoSuccess,
                                        'Usuário alterado com sucesso!',
                                        $this->rotinaAlt
                                    );
                                    $this->log->registraLog($_SESSION["sgp_id"], "Usuário", $form["id"], 1, $dateTime);
                                }else{
                                    $this->helper->setReturnMessage(
                                        $this->tipoError,
                                        'Erro ao alterar usuário, tente novamente, se o problema persistir, entre em contato com o administrador do sistema!',
                                        $this->rotinaAlt
                                    );
                                }
                            }
                        }
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Nome não está preenchido, não foi possível alterar o usuário, tente novamente!',
                        $this->rotinaCad
                    );  
                }
                echo "<script>window.location.href='../perfil';</script>";
            }else{
                $this->helper->loginRedirect();
            }
        }

        public function perfil(){
            if($this->helper->sessionValidate()){
                $dados = [
                    'dados' => $this->usuarioModel->buscaUsuarioPorId($_SESSION["sgp_id"])
                ];
                $this->view('usuario/perfil', $dados);
            }else{
                $this->helper->loginRedirect();
            }   
        }

        // Executa rotinas de alterações do usuário
        private function updateUsuario($form){
            $retorno = false;
            if(!empty($form["nome"])){
                $info = $this->usuarioModel->buscaUsuarioPorId($form["id"]);
                if($form["nome"] == $info[0]->nome and $form["perfil"] == $info[0]->perfil and (empty($form["senha"]) and empty($form["repetesenha"]))){
                    $this->helper->setReturnMessage(
                        $this->tipoWarning,
                        'Não foi necessária nenhuma alteração no cadastro do usuário',
                        $this->rotinaAlt
                    );
                }else if(($form["nome"] != $info[0]->nome or $form["perfil"] != $info[0]->perfil) and (empty($form["senha"]) and empty($form["repetesenha"]))){
                    if($this->usuarioModel->alteraUsuario($form, "nome-perfil", $this->helper->returnDateTime())){
                        $this->helper->setReturnMessage(
                            $this->tipoSuccess,
                            'Usuário alterado com sucesso!',
                            $this->rotinaAlt
                        );
                        $retorno = true;
                    }else{
                        $this->helper->setReturnMessage(
                            $this->tipoError,
                            'Erro ao alterar usuário, tente novamente, se o problema persistir, entre em contato com o administrador do sistema!',
                            $this->rotinaAlt
                        );
                    }
                }else if((!empty($form["senha"]) and !empty($form["repetesenha"])) or
                        (empty($form["senha"]) and !empty($form["repetesenha"])) or 
                        (!empty($form["senha"]) and empty($form["repetesenha"])))
                {
                    if($form["senha"] != $form["repetesenha"]){
                        $this->helper->setReturnMessage(
                            $this->tipoError,
                            'Não foi possível alterar o cadastro, as senhas não conferem, tente novamente!',
                            $this->rotinaAlt
                        );
                    }else if(strlen($form["senha"]) < 6){
                        $this->helper->setReturnMessage(
                            $this->tipoError,
                            'Não foi possível alterar o cadastro, as senhas não possuem o mínimo de 6 caracteres!',
                            $this->rotinaAlt
                        );
                    }else if(strlen($form["senha"]) >= 6 and $form["senha"] == $form["repetesenha"]){
                        $form["senha"] = password_hash($form["senha"], PASSWORD_DEFAULT);
                        if($this->usuarioModel->alteraUsuario($form, "senha", $this->helper->returnDateTime())){
                            $this->helper->setReturnMessage(
                                $this->tipoSuccess,
                                'Usuário alterado com sucesso!',
                                $this->rotinaAlt
                            );
                        }else{
                            $this->helper->setReturnMessage(
                                $this->tipoError,
                                'Erro ao alterar usuário, tente novamente, se o problema persistir, entre em contato com o administrador do sistema!',
                                $this->rotinaAlt
                            );
                        }
                    }
                }
            }else{
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    'Nome não está preenchido, não foi possível alterar o usuário, tente novamente!',
                    $this->rotinaCad
                );  
            }
            return $retorno;
        }

        // Executa a rotina de ativação e inativação do usuário
        private function ativarInativarUsuario($form, $acao){
            $retorno = false;
            if($this->usuarioModel->ativaInativaUsuario($form["id"], $acao, $dateTime = $this->helper->returnDateTime())){
                if($acao == "inativar")
                    $mensagem = 'Usuário inativado com sucesso!';
                else if($acao == "ativar")
                    $mensagem = 'Usuário ativado com sucesso!';
                $this->helper->setReturnMessage(
                    $this->tipoSuccess,
                    $mensagem,
                    $this->rotinaCad
                );
                $retorno = true;
            }else{
                if($acao == "inativar")
                    $mensagem = 'Não foi possível inativar este usuário, tente novamente mais tarde!';
                else if($acao == "ativar")
                    $mensagem = 'Não foi possível ativar este usuário, tente novamente mais tarde!';
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    $mensagem,
                    $this->rotinaCad
                );
            }
            return $retorno;
        }

        private function alteraNomeUsuario($nome, $id, $dateTime){
            return $this->usuarioModel->alteraNomeUsuario($nome, $id, $dateTime);
        }

        private function alteraSenhaUsuario($senha, $id, $dateTime){
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            return $this->usuarioModel->alteraSenhaUsuario($senha, $id, $dateTime);
        }
    }

?>