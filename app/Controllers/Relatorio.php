<?php 

    class Relatorio extends Controller{

        public function __construct()
        {
            $this->helper = new Helpers();
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] == 0 or $_SESSION["sgp_perfil"] == 1){
                    $this->log = new Logs();
                    $this->produtoModel = $this->model('ProdutoModel');
                    $this->clienteModel = $this->model('ClienteModel');
                    $this->pedidoModel = $this->model('PedidoModel');
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                $this->helper->loginRedirect();
            }
        }

        public function index(){
            if($this->helper->sessionValidate()){
                $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if($form == null or !isset($form) or isset($form["limpar"])){
                    $dados = [
                        'produtos' => $this->produtoModel->listaProdutos(),
                        'clientes' => $this->clienteModel->listaClientes(),
                        'ordens'   => null,
                        'data_emissao_de' => '',
                        'data_emissao_ate' => '',
                        'data_entrega_de' => '',
                        'data_entrega_ate' => '',
                        'pedido' => '',
                        'cliente' => '',
                        'produto' => '',
                        'situacao' => '',
                        'tipo' => '',
                    ];
                    $this->view('relatorio/index', $dados);
                }else{
                    $result = $this->pedidoModel->buscaPedidos(
                        isset($form['data_emissao_de']) ? $form['data_emissao_de'] : null,
                        isset($form['data_emissao_ate']) ? $form['data_emissao_ate'] : null,
                        isset($form['data_entrega_de']) ? $form['data_entrega_de'] : null,
                        isset($form['data_entrega_ate']) ? $form['data_entrega_ate'] : null,
                        isset($form['pedido']) ? $form['pedido'] : null,
                        isset($form['cliente']) ? $form['cliente'] : null,
                        isset($form['produto']) ? $form['produto'] : null,
                        isset($form['situacao']) ? $form['situacao'] : null,
                        $form['tipo'],
                    );

                    $dados = [
                        'produtos' => $this->produtoModel->listaProdutos(),
                        'clientes' => $this->clienteModel->listaClientes(),
                        'ordens'   => $result,
                        'data_emissao_de' => isset($form['data_emissao_de']) ? $form['data_emissao_de'] : '',
                        'data_emissao_ate' => isset($form['data_emissao_ate']) ? $form['data_emissao_ate'] : '',
                        'data_entrega_de' => isset($form['data_entrega_de']) ? $form['data_entrega_de'] : '',
                        'data_entrega_ate' => isset($form['data_entrega_ate']) ? $form['data_entrega_ate'] : '',
                        'pedido' => isset($form['pedido']) ? $form['pedido'] : '',
                        'cliente' => isset($form['cliente']) ? $form['cliente'] : '',
                        'produto' => isset($form['produto']) ? $form['produto'] : '',
                        'situacao' => isset($form['situacao']) ? $form['situacao'] : '',
                        'tipo' => $form['tipo'],
                    ];
                    $this->view('relatorio/index', $dados);
                }
            }else{
                $this->helper->loginRedirect();
            }
        }
    }
?>