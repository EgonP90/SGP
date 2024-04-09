<?php 

    class Logs extends Controller{

        public function __construct()
        {
            $this->helper = new Helpers();
            if($this->helper->sessionValidate()){
                $this->logModel = $this->model('LogModel');
            }else{
                $this->helper->homeRedirect();
            }
        }

        public function index(){
            if($this->helper->sessionValidate()){
                if($_SESSION["sgp_perfil"] == 0){
                    $dados = [
                        'dados' => $this->listaLogs(),
                    ];
                    $this->view('logs/index', $dados);
                }else{
                    $this->helper->homeRedirect();
                }
            }else{
                echo "<script>window.location.href='./login';</script>";
            }
        }

        // Listar logs
        public function listaLogs(){
            return $this->logModel->listaLogs();
        }
    }

?>