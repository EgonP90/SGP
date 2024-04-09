<?php 

    class Index extends Controller{


        public function __construct()
        {
            $this->helper = new Helpers();
            $this->pedidoModel = $this->model('PedidoModel');
        }
        
        public function index(){
            $dados = [
                'pedidos' => $this->pedidoModel->buscaPedidoPorDataEntrega($this->helper->returnDate()),
            ];
            if($this->helper->sessionValidate()){
                $this->view('index', $dados);
            }else{
                echo "<script>window.location.href='./login';</script>";
            }
        }
    }

?>