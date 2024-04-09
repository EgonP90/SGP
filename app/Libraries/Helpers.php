<?php 

    class Helpers{

        private $minNum = 1;
        private $maxNum = 99999999;
        private $url = URL;


        public function __construct()
        {
            date_default_timezone_set('America/Sao_Paulo');   
        }

        // Validar se os campos estão preenchidos
        public function validateFields($array){
            $retorno = true;
            foreach($array as $ar){
                if($ar == "" or empty($ar) or $ar == null)
                    $retorno = false;
            }
            return $retorno;  
        }

        public function setReturnMessage($tipo, $mensagem, $rotina){
            $_SESSION["sgp_tipo"] = $tipo;
            $_SESSION["sgp_mensagem"] = $mensagem;
            $_SESSION["sgp_rotina"] = $rotina;
        }

        //return São Paulo date time
        public function returnDateTime(){
            $dateTime = date("Y-m-d H:i:s");
            return $dateTime;
        }

        //return current date
        public function returnDate(){
            $dateTime = date("Y-m-d");
            return $dateTime;
        }

        public function setSelected($valor1, $valor2){
            if($valor1 == $valor2)
                return "selected";
        }

        public function setMultiSelect($array = null, $valor){
            if($array != null){
                for($i = 0; $i < count($array); $i++){
                    if($array[$i] == $valor){
                        return "selected";
                    }
                }
            }
        }

        public function formataDateTime($dateTime){
            if($dateTime != null and !empty($dateTime)){
                $divisor = explode(" ", $dateTime);
                $data = explode("-", $divisor[0]);
                return $dateTime = $data[2]."/".$data[1]."/".$data[0]." - ".$divisor[1];
            }else{
                return "00/00/00 00:00:00";
            }
        }

        // Verifica se o usuário está logado ou não
        public function sessionValidate(){
            if(isset($_SESSION["sgp_session_id"])){
                return true;
            }
            else{
                return false;   
            }   
        }

        // Redirecionar para a página home
        public function homeRedirect(){
            echo "<script>window.location.href='$this->url/index';</script>";
        }
        

        // Redirecionar para a página home
        public function loginRedirect(){
            echo "<script>window.location.href='$this->url';</script>";
        }

        public function multiplicaFormata($v1, $v2, $att = null){
            $v1 = str_replace(",", ".", $v1);
            $v2 = str_replace(",", ".", $v2);
            $total = $v1 * $v2;
            $array = explode(".", $total);
            if(count($array) < 2){
                $total .= ",00";
            }else{
                if(strlen($array[1]) > 2){
                    $total = $array[0].",".substr($array[1], 0, 2);
                }else if(strlen($array[1]) == 2){
                    $total = str_replace(".", ",", $total);
                }else if(strlen($array[1]) < 2){
                    $total = str_replace(".", ",", $total);
                    $total = $total."0";
                }
            }
            if($att == null){
                $total = 'R$ '.$total;
            }
            return $total;
        }

        public function formataValor($valor){
            $array = explode(',', $valor);
            if(count($array) == 1){
                return $valor.",00";
            }else{
                if(strlen($array[1]) == 1){
                    return $valor."0";
                }else{
                    return $valor;
                }
            }
        }

        public function formataValor2($valor){
            return number_format($valor, 2, ',', '.');
        }

        public function retornaHorario($dateTime){
            $array = explode(" ", $dateTime);
            return $array[1];
        }

        public function setCookie($nome, $valor){
            setcookie($nome, $valor, time()+2592000, "/");
        }

        public function geraHashMd5(){
            return md5(rand(1,100000));   
        }

        public function formataCodigo($id){
            if(strlen($id) == 1){
                return "000".$id;
            }else if(strlen($id) == 2){
                return "00".$id;
            }else if(strlen($id) == 3){
                return "0".$id;
            }else{
                return $id;
            }
        }
        
    } 
?>