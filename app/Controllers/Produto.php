<?php 

    class Produto extends Controller{

        private $tipoSuccess = 'success';
        private $tipoError = 'error';
        private $tipoWarning = 'warning';
        private $rotinaCad = 'Produto';
        private $rotinaAlt = 'Produto';
        public $helper;
        public $produtoModel;
        public $log;

        public function __construct()
        {
            $this->helper = new Helpers();
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] == 0 or $_SESSION["sgp_perfil"] == 1 or $_SESSION["sgp_perfil"] == 2){
                    $this->produtoModel = $this->model('ProdutoModel');
                    $this->log = new Logs();
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                $this->helper->loginRedirect();
            }
        }
        
        // Exibe tela de cadastro de produto
        public function cadastro(){
            if($this->helper->sessionValidate()){
                $this->view('produto/cadastro');
            }else{
                $this->helper->loginRedirect();
            }
        }

        // Executa rotina para cadastrar um novo produto
        public function cadastrar(){
            $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if($this->helper->validateFields($form)){
                if(!$this->produtoModel->verificaProduto($form["descricao"], $form["um"])){
                    $dateTime = $this->helper->returnDateTime();
                    $lastInserId = $this->produtoModel->cadastrarProduto($form, $dateTime);
                    if($lastInserId != null){
                        $this->helper->setReturnMessage(
                            $this->tipoSuccess,
                            'Produto cadastrado com sucesso!',
                            $this->rotinaCad
                        );
                        $this->log->registraLog($_SESSION["sgp_id"], "Produto", $lastInserId, 0, $dateTime);
                    }else{
                        $this->helper->setReturnMessage(
                            $this->tipoError,
                            'Não foi possível cadastrar o produto, tente novamente!',
                            $this->rotinaCad
                        );
                    }
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Não foi possível cadastrar o produto, já existe um produto cadastrado no sistema com esta descrição e esta unidade de medida!',
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

        // Exibe tela de consulta de produtos
        public function consulta($num = 1){
            $_SESSION["sgp_botao_press_produto"] = null;
            if($num == 1){
                $pag = 1;
                $inicio = 0;
                $_SESSION["sgp_inicio_produto"] = 10;
                $_SESSION["sgp_pagina_produto"] = 1;
            }else if($num < $_SESSION["sgp_pagina_produto"]){
                $inicio = $_SESSION["sgp_inicio_produto"] - 20;
                $pag = $num;
                if($_SESSION["sgp_botao_press_produto"] == "next"){
                    $_SESSION["sgp_inicio_produto"] = $_SESSION["sgp_inicio_produto"] - 20;
                }else{
                    $_SESSION["sgp_inicio_produto"] = $_SESSION["sgp_inicio_produto"] - 10;
                }
                $_SESSION["sgp_pagina_produto"] = $_SESSION["sgp_pagina_produto"] - 1;
                $_SESSION["sgp_botao_press_produto"] = "previous";
            }else{
                $inicio = $_SESSION["sgp_inicio_produto"];
                $pag = $num;
                if($_SESSION["sgp_botao_press_produto"] == "previous"){
                    $_SESSION["sgp_inicio_produto"] = $_SESSION["sgp_inicio_produto"] + 20;
                }else{
                    $_SESSION["sgp_inicio_produto"] = $_SESSION["sgp_inicio_produto"] + 10;
                }
                $_SESSION["sgp_pagina_produto"] = $_SESSION["sgp_pagina_produto"] + 1;
                $_SESSION["sgp_botao_press_produto"] = "next";
            }
            if($this->helper->sessionValidate()){
                $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $temMaisRegistro = $this->produtoModel->TemMaisRegistro($inicio + 10);
                if(($form == null or !isset($form)) or ($form != null and isset($form["limpar"]))){
                    $dados = [
                        'dados' =>  $this->listaProdutos($inicio),
                        'descricao' => null,
                        'pag'  => $pag,
                        'ultima' => $temMaisRegistro,
                    ];
                }else{
                    $temMaisRegistro = $this->produtoModel->TemMaisRegistro($inicio + 10, $form['descricao']);
                    $dados = [
                        'dados' =>  $this->listaProdutosPorDescricao($form['descricao']),
                        'descricao' => $form['descricao'],
                        'pag'  => $pag,
                        'ultima' => $temMaisRegistro,
                    ];
                }
                $this->view('produto/consulta', $dados);
            }else{
                $this->helper->loginRedirect();
            }
        }

        // Listar produtos cadastrados
        public function listaProdutos($inicio = null){
            return $this->produtoModel->listaProdutos($inicio);
        }

        public function listaProdutosPorDescricao($descricao){
            return $this->produtoModel->listaProdutosPorDescricao($descricao);
        }

        // Alterar produto
        public function alterar(){
            $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $dateTime = $this->helper->returnDateTime();
            if(isset($form["update"])){
                if($this->updateProduto($form))
                    $this->log->registraLog($_SESSION["sgp_id"], "Produto", $form["id"], 1, $dateTime);
            }else if(isset($form["inativar"])){
                if($this->ativarInativarProduto($form, "inativar"))
                    $this->log->registraLog($_SESSION["sgp_id"], "Produto", $form["id"], 1, $dateTime);
            }else if(isset($form["ativar"])){
                if($this->ativarInativarProduto($form, "ativar"))
                    $this->log->registraLog($_SESSION["sgp_id"], "Produto", $form["id"], 1, $dateTime);
            }else if(isset($form["delete"])){
                $this->deletarProduto($form);
            }
            echo "<script>window.location.href='../produto/consulta';</script>";
        } 

        // Retornar produto por ID
        public function buscaProdutoPorId($id){
           return $this->produtoModel->buscaProdutoPorId($id);
        }

        public function imprimeProdutoPorId($id){
            $dados = $this->produtoModel->buscaProdutoPorId($id);
            echo "<UM>" . $dados[0]->um . "</UM>";
            echo "<preco>" . $dados[0]->preco . "</preco>";
        }

        // Executa rotinas de alterações do produto
        private function updateProduto($form){
            $retorno = false;
            if(!empty($form["descricao"]) and !empty($form["um"]) and !empty($form["preco"]) and !empty($form["codigo"])){
                $info = $this->produtoModel->buscaProdutoPorId($form["id"]);
                if($form["descricao"] == $info[0]->descricao and $form["um"] == $info[0]->um and $form["preco"] == $info[0]->preco and $form["codigo"] == $info[0]->codigo_produto){
                    $this->helper->setReturnMessage(
                        $this->tipoWarning,
                        'Não foi necessária nenhuma alteração no cadastro do produto',
                        $this->rotinaAlt
                    );
                }else if(($form["descricao"] != $info[0]->descricao or $form["um"] != $info[0]->um or $form["preco"] != $info[0]->preco or $form["codigo"] != $info[0]->codigo_produto)){
                    if(!$this->produtoModel->verificaProduto($form["descricao"], $form["um"], $form["id"])){
                        if($this->produtoModel->alteraProduto($form, $this->helper->returnDateTime())){
                            $this->helper->setReturnMessage(
                                $this->tipoSuccess,
                                'Produto alterado com sucesso!',
                                $this->rotinaAlt
                            );
                            $retorno = true;
                        }else{
                            $this->helper->setReturnMessage(
                                $this->tipoError,
                                'Erro ao alterar produto, tente novamente, se o problema persistir, entre em contato com o administrador do sistema!',
                                $this->rotinaAlt
                            );
                        }
                    }else{
                        $this->helper->setReturnMessage(
                            $this->tipoError,
                            'Não foi possível alterar o produto, já existe um produto cadastrado no sistema com esta descrição e esta unidade de medida!',
                            $this->rotinaCad
                        );
                    }
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Erro ao alterar produto, tente novamente, se o problema persistir, entre em contato com o administrador do sistema!',
                        $this->rotinaAlt
                    );
                }
            }else{
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    'Existem campos que não estão preenchidos, não foi possível alterar o produto, tente novamente!',
                    $this->rotinaCad
                );  
            }
            return $retorno;
        }

        public function deletarProduto($form){
            $retorno = file_get_contents(URL."/pedido/buscaPedidoPorProduto/".$form["id"]);
            $array1 = explode("PRODUTO_TEM_PEDIDO", $retorno);
            $array2 = explode("PRODUTO_NAO_TEM_PEDIDO", $retorno);
            if(count($array1) > 1){
                $this->helper->setReturnMessage(
                    $this->tipoWarning,
                    'Produto não pode ser excluído, pois está ligado a um ou mais pedidos!',
                    $this->rotinaAlt
                );
            }else if(count($array2) > 1){
                if($this->produtoModel->deletaProduto($form["id"])){
                    $this->helper->setReturnMessage(
                        $this->tipoSuccess,
                        'Produto excluído com sucesso!',
                        $this->rotinaAlt
                    );
                    $this->log->registraLog($_SESSION["sgp_id"], "Produto", $form["id"], 2, $this->helper->returnDateTime());
                }else{
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Erro ao excluir produto, tente novamente!',
                        $this->rotinaAlt
                    );
                }
            }else{
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    'Produto não encontrado',
                    $this->rotinaAlt
                );
            }
        }

        // Executa a rotina de ativação e inativação do produto
        private function ativarInativarProduto($form, $acao){
            $retorno = false;
            if($this->produtoModel->ativaInativaProduto($form["id"], $acao, $dateTime = $this->helper->returnDateTime())){
                if($acao == "inativar")
                    $mensagem = 'Produto inativado com sucesso!';
                else if($acao == "ativar")
                    $mensagem = 'Produto ativado com sucesso!';
                $this->helper->setReturnMessage(
                    $this->tipoSuccess,
                    $mensagem,
                    $this->rotinaCad
                );
                $retorno = true;
            }else{
                if($acao == "inativar")
                    $mensagem = 'Não foi possível inativar este produto, tente novamente mais tarde!';
                else if($acao == "ativar")
                    $mensagem = 'Não foi possível ativar este produto, tente novamente mais tarde!';
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    $mensagem,
                    $this->rotinaCad
                );
            }
            return $retorno;
        }


    }

?>
