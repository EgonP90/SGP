<?php 

    class Cliente extends Controller{

        private $tipoSuccess = 'success';
        private $tipoError = 'error';
        private $tipoWarning = 'warning';
        private $rotinaCad = 'Cliente';
        private $rotinaAlt = 'Cliente';

        public function __construct()
        {
            $this->helper = new Helpers();
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] != 3){
                    $this->clienteModel = $this->model('ClienteModel');
                    $this->log = new Logs();
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                $this->helper->loginRedirect();
            }
        }

        // Exibe tela de cadastro de cliente
        public function cadastro(){
            if($this->helper->sessionValidate()){
                $this->view('cliente/cadastro');
            }else{
                $this->helper->loginRedirect();
            }
        }

        // Executa a rotina de cadastro de cliente
        public function cadastrar($clientePedido = null){
            if($this->helper->sessionValidate()){
                $return = false;
                if($clientePedido == null){
                    $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                }else{
                    $form = $clientePedido;
                }
                if(!empty($form["nome"]) and !empty($form["telefone"])){
                    $dateTime = $this->helper->returnDateTime();
                    $lastInserId = $this->clienteModel->cadastrarCliente($form, $dateTime);
                    if($lastInserId != null){
                        $this->helper->setReturnMessage(
                            $this->tipoSuccess,
                            'Cliente cadastrado com sucesso!',
                            $this->rotinaCad
                        );
                        $return = true;
                        $this->log->registraLog($_SESSION["sgp_id"], "Cliente", $lastInserId, 0, $dateTime);
                    }else{
                        $this->helper->setReturnMessage(
                            $this->tipoError,
                            'Não foi possível cadastrar o cliente, tente novamente!',
                            $this->rotinaCad
                        );
                    }
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Nome e telefone são de preenchimento obrigatórios, tente novamente!',
                        $this->rotinaCad
                    );
                }
                if($clientePedido == null){
                    echo "<script>window.location.href='../cadastro';</script>";
                }else{
                    return $lastInserId;
                }
            }else{
                $this->helper->loginRedirect();
            }
        }

        // Exibe tela de consulta de clientes
        public function consulta($num = 1){
            $_SESSION["sgp_botao_press_cliente"] = null;
            if($num == 1){
                $pag = 1;
                $inicio = 0;
                $_SESSION["sgp_inicio_cliente"] = 10;
                $_SESSION["sgp_pagina_cliente"] = 1;
            }else if($num < $_SESSION["sgp_pagina_cliente"]){
                $inicio = $_SESSION["sgp_inicio_cliente"] - 20;
                $pag = $num;
                if($_SESSION["sgp_botao_press_cliente"] == "next"){
                    $_SESSION["sgp_inicio_cliente"] = $_SESSION["sgp_inicio_cliente"] - 20;
                }else{
                    $_SESSION["sgp_inicio_cliente"] = $_SESSION["sgp_inicio_cliente"] - 10;
                }
                $_SESSION["sgp_pagina_cliente"] = $_SESSION["sgp_pagina_cliente"] - 1;
                $_SESSION["sgp_botao_press_cliente"] = "previous";
            }else{
                $inicio = $_SESSION["sgp_inicio_cliente"];
                $pag = $num;
                if($_SESSION["sgp_botao_press_cliente"] == "previous"){
                    $_SESSION["sgp_inicio_cliente"] = $_SESSION["sgp_inicio_cliente"] + 20;
                }else{
                    $_SESSION["sgp_inicio_cliente"] = $_SESSION["sgp_inicio_cliente"] + 10;
                }
                $_SESSION["sgp_pagina_cliente"] = $_SESSION["sgp_pagina_cliente"] + 1;
                $_SESSION["sgp_botao_press_cliente"] = "next";
            }
            if($this->helper->sessionValidate()){
                $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(($form == null or !isset($form)) or ($form != null and isset($form["limpar"])) or (empty($form['nome_cliente']))){
                    $temMaisRegistro = $this->clienteModel->TemMaisRegistro($inicio + 10);
                    $dados = [
                        'dados' =>  $this->listaClientes($inicio),
                        'nome' => null,
                        'pag'  => $pag,
                        'ultima' => $temMaisRegistro,
                    ];
                }else{
                    $temMaisRegistro = $this->clienteModel->TemMaisRegistro($inicio + 10, $form['nome_cliente']);
                    $dados = [
                        'dados' =>  $this->listaClientePorNome($form['nome_cliente']),
                        'nome' => $form['nome_cliente'],
                        'pag'  => $pag,
                        'ultima' => $temMaisRegistro,
                    ];
                }
                $this->view('cliente/consulta', $dados);
            }else{
                $this->helper->loginRedirect();
            }
        }
        
        // Listar clientes cadastrados
        public function listaClientes($inicio = null){
            return $this->clienteModel->listaClientes($inicio);
        }

        // Listar clientes cadastrados buscando pelo nome
        public function listaClientePorNome($nome){
            return $this->clienteModel->listaClientePorNome($nome);
        }

        // Alterar cliente
        public function alterar(){
            $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if(isset($form["alterar"])){
                $this->alteraCliente($form);
                $_SESSION["sgp_nome_aux"] = $form["nome"];
                $_SESSION["sgp_telefone_aux"] = $form["telefone"];
                $_SESSION["sgp_logradouro_aux"] = $form["logradouro"];
                $_SESSION["sgp_numero_aux"] = $form["numero"];
                $_SESSION["sgp_estado_aux"] = $form["estado"];
                $_SESSION["sgp_cidade_aux"] = $form["cidade"];
                $_SESSION["sgp_bairro_aux"] = $form["bairro"];
                echo "<script>window.location.href='../pedido/itens';</script>";
            }else{
                if(isset($form["update"])){
                    $this->updateCliente($form);
                }else if(isset($form["delete"])){
                    $this->deletarCliente($form);
                }
                echo "<script>window.location.href='../cliente/consulta';</script>";
            }
        }

        public function alteraCliente($form){
            if(!empty($form["nome"]) and !empty($form["telefone"])){
                if($this->clienteModel->alteraCliente($form, $this->helper->returnDateTime(), $form["id_cliente"], "parcial")){
                    $this->helper->setReturnMessage(
                        $this->tipoSuccess,
                        'Cliente alterado com sucesso!',
                        $this->rotinaAlt
                    );
                    $this->log->registraLog($_SESSION["sgp_id"], "Cliente", $form["id_cliente"], 1, $this->helper->returnDateTime());
                    $retorno = true;
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Erro ao alterar cliente, tente novamente, se o problema persistir, entre em contato com o administrador do sistema!',
                        $this->rotinaAlt
                    );
                }
            }else{
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    'Nome e telefone são de preenchimento obrigatórios, tente novamente!',
                    $this->rotinaCad
                );
            }
        }
        
        // Efetuar a alteração do cliente
        public function updateCliente($form, $id = null){
            $retorno = false;
            if(!empty($form["nome"]) and !empty($form["telefone"])){
                if($this->clienteModel->alteraCliente($form, $this->helper->returnDateTime(), $id)){
                    $this->helper->setReturnMessage(
                        $this->tipoSuccess,
                        'Cliente alterado com sucesso!',
                        $this->rotinaAlt
                    );
                    if($id == null){
                        $logId = $form["id"];
                    }else{
                        $logId = $id;
                    }
                    $this->log->registraLog($_SESSION["sgp_id"], "Cliente", $logId, 1, $this->helper->returnDateTime());
                    $retorno = true;
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Erro ao alterar cliente, tente novamente, se o problema persistir, entre em contato com o administrador do sistema!',
                        $this->rotinaAlt
                    );
                }
            }else{
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    'Nome e telefone são de preenchimento obrigatórios, tente novamente!',
                    $this->rotinaCad
                );
            }
            return $retorno;
        }

        public function deletarCliente($form){
            $retorno = file_get_contents(URL."/pedido/buscaPedidoPorCliente/".$form["id"]);
            $array1 = explode("CLIENTE_TEM_PEDIDO", $retorno);
            $array2 = explode("CLIENTE_NAO_TEM_PEDIDO", $retorno);
            if(count($array1) > 1){
                $this->helper->setReturnMessage(
                    $this->tipoWarning,
                    'Cliente não pode ser excluído, pois está ligado a um ou mais pedidos!',
                    $this->rotinaAlt
                );
            }else if(count($array2) > 1){
                if($this->clienteModel->deletaCliente($form["id"])){
                    $this->helper->setReturnMessage(
                        $this->tipoSuccess,
                        'Cliente excluído com sucesso!',
                        $this->rotinaAlt
                    );
                    $this->log->registraLog($_SESSION["sgp_id"], "Cliente", $form["id"], 2, $this->helper->returnDateTime());
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Erro ao excluir cliente, tente novamente!',
                        $this->rotinaAlt
                    );
                }
            }else{
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    'Cliente não encontrado',
                    $this->rotinaAlt
                );
            }
        }

        public function buscaClientePorNome($nome){
            return $this->clienteModel->buscaClientePorNome($nome);
        }

        public function retornaDadosCliente($id){
            $dados = $this->clienteModel->buscaClientePorId($id);
            echo "<nome>" . $dados[0]->nome . "</nome>";
            echo "<cpfcnpj>" . $dados[0]->cpfcnpj . "</cpfcnpj>";
            echo "<telefone>" . $dados[0]->telefone . "</telefone>";
            echo "<cep>" . $dados[0]->cep . "</cep>";
            echo "<rua>" . $dados[0]->rua . "</rua>";
            echo "<numero>" . $dados[0]->numero_endereco . "</numero>";
            echo "<complemento>" . $dados[0]->complemento . "</complemento>";
            echo "<estado>" . $dados[0]->estado . "</estado>";
            echo "<cidade>" . $dados[0]->cidade . "</cidade>";
            echo "<bairro>" . $dados[0]->bairro . "</bairro>";
        }

        public function buscaClientePorId($id){
            return $this->clienteModel->buscaClientePorId($id);
        }
    }

?>