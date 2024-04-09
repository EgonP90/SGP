<?php 

    class Login extends Controller{

        private $tipoSuccess = 'success';
        private $tipoError = 'error';
        private $tipoWarning = 'warning';
        private $rotina = 'login';

        public function __construct()
        {
            $this->usuarioModel = $this->model('UsuarioModel');
            $this->helper = new Helpers();
            $this->log = new Logs();
        }

        public function index(){
            if(!$this->helper->sessionValidate()){
                $this->view('login');
            }else{
                $this->helper->homeRedirect();
            }
        }

        // validar informações de login inseridas pelo usuário na tela de login ao sistena
        public function validaLogin(){
            $form = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if($this->helper->validateFields($form)){
                $dados_usuario = $this->usuarioModel->validaLogin($form["login"]);
                if($dados_usuario == null){
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Usuário não encontrado no sistema, tente novamente!',
                        $this->rotina
                    );
                }else if($dados_usuario[0]->situacao == 1){
                    $this->helper->setReturnMessage(
                        $this->tipoError,
                        'Usuário inativo, entre em contato com o administrador do sistema',
                        $this->rotina
                    );
                }else{
                    if(password_verify($form["pass"], $dados_usuario[0]->senha)){
                        $this->setSession($dados_usuario);
                        $this->log->registraLog($_SESSION["sgp_id"], "Login", null, 3, $this->helper->returnDateTime());
                        /*if($form["keepConnected"] == "on"){
                            $cookieName = $this->helper->geraHashMd5();
                            $cookieValue = $this->helper->geraHashMd5();
                            $this->helper->setCookie($cookieName, $cookieValue);
                            $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                        }*/
                        $this->helper->homeRedirect();
                    }else{
                        $this->helper->setReturnMessage(
                            $this->tipoError,
                            'Credenciais inválidas, tente novamente!',
                            $this->rotina
                        );
                    }                    
                }
            }else{
                $this->helper->setReturnMessage(
                    $this->tipoError,
                    'Login ou senha não foram informados, tente novamente!',
                    $this->rotina
                );
            }
            echo "<script>window.location.href='./login';</script>";
        }

        public function logoff(){
            $_SESSION["sgp_session_id"] = null;
            session_destroy();
            $this->helper->loginRedirect();
        }

        // seta variáveis de sessão do usuário
        private function setSession($dados){
            $_SESSION["sgp_nome"] = $dados[0]->nome;
            $_SESSION["sgp_id"] = $dados[0]->id;
            $_SESSION["sgp_perfil"] = $dados[0]->perfil;
            $_SESSION["sgp_login"] = $dados[0]->login;
            $_SESSION["sgp_session_id"] = md5(rand(0, 1000));
            $_SESSION["sgp_nome_aux"] = null;
            $_SESSION["sgp_telefone_aux"] = null;
            $_SESSION["sgp_logradouro_aux"] = null;
            $_SESSION["sgp_numero_aux"] = null;
            $_SESSION["sgp_estado_aux"] = null;
            $_SESSION["sgp_cidade_aux"] = null;
            $_SESSION["sgp_bairro_aux"] = null;
		}
    }
?>