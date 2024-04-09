<?php

session_start(["session_sgp"]);

$pedido = $_SESSION["sgp_dados_pedido"]["numero_pedido"];
$dataEmissao = $_SESSION["sgp_dados_pedido"]["emitido"];
$nome = $_SESSION["sgp_dados_pedido"]["nome"];
$telefone = $_SESSION["sgp_dados_pedido"]["telefone"];
$cnpj = $_SESSION["sgp_dados_pedido"]["cpfcnpj"];
$endereco = $_SESSION["sgp_dados_pedido"]["endereco"];
$numero = $_SESSION["sgp_dados_pedido"]["numero"];
$bairro = $_SESSION["sgp_dados_pedido"]["bairro"];
$cidade = $_SESSION["sgp_dados_pedido"]["cidade"];
$estado = $_SESSION["sgp_dados_pedido"]["estado"];
$complemento = $_SESSION["sgp_dados_pedido"]["complemento"];
$dataEntrega = $_SESSION["sgp_dados_pedido"]["entrega"];
$formaEntrega = $_SESSION["sgp_dados_pedido"]["formaEntrega"];
$valortotal = $_SESSION["sgp_dados_pedido"]["valorTotal"];
$status = $_SESSION["sgp_dados_pedido"]["status"];

if(!isset($_POST["tipoImpressora"]) or (isset($_POST["tipoImpressora"]) and $_POST["tipoImpressora"] != "epson"))
{
    $html = "
    <h1 style='font-size:25px'>Pedido - Nº ". $pedido ."<br>
    ----------------------------------------------------------</h1>
    <p style='font-size:15px'><b>Dados do Cliente</b></p>
    <p style='font-size:14px'>
        <b>Emitido em:</b> ".$dataEmissao."<br>
        <b>Nome:</b> ".$nome."<br>
        <b>Telefone:</b> ".$telefone."<br>
        <b>CPF/CNPJ:</b> ".$cnpj."<br>
        <b>Endereço:</b> ".$endereco.", Nº - ".$numero." <b>Bairro:</b> ".$bairro."<br>
        <b>Complemento:</b> ".$complemento." <br> 
        <b>Cidade/Estado:</b> ".$cidade."/".$estado."<br>
        <b>Data da Entrega:</b> ".$dataEntrega."<br>
        <b>Forma de Entrega:</b> ".$formaEntrega."
    </p>
    <h1 style='font-size:25px'>
    ----------------------------------------------------------</h1>
    <p style='font-size:15px'><b>Itens do Pedido</b></p>
    <table>
        <tr>
            <td style='font-size:14px' width='150px'>Descrição</td>
            <td style='font-size:14px' width='100px'>UM</td>
            <td style='font-size:14px' width='150px'>Quantidade</td>";
    if($status != "novo"){
        $html .= "
                <td style='font-size:14px' width='150px'>Valor Unit.</td>        
                <td style='font-size:14px' width='100px'>Sub-total</td>
            </tr>
        ";
    }
    $array = explode("---", $_SESSION["sgp_dados_pedido"]["itens"]);
    for($i = 0; $i < count($array); $i++){
        $array2 = explode(";;;", $array[$i]);
        for($j = 0; $j < count($array2) - 1; $j++){
            $html .="
            <tr>
                <td style='font-size:12px' width='300px'>".$array2[$j]."</td>";
                $j++;
            $html .= "
                <td style='font-size:12px'>".$array2[$j]."</td>";
                $j++;
            $html .= "
                <td style='font-size:12px'>".$array2[$j]."</td>";
                $j++;
            if($status != "novo"){
                $html .= "
                    <td style='font-size:12px'>R$ ".$array2[$j]."</td> ";
            }
            $j++;
            if($status != "novo"){
                $html .= "       
                    <td style='font-size:12px'>".$array2[$j]."</td>";
            }
            $j++;
            $html .= "
            </tr>
        ";
        }
    }
    if($status != "novo"){
        $html .= "
        </table>
        <p style='font-size:14px'><b>Total:</b> R$ ".$valortotal."</p>
        ";
    }else{
        $html .= "
        </table>
        ";
    }
}else{
    $html = "
    <div style='width:40%; margin-left: -5%; font-family: monospace'>
	<h1 style='font-size:12px;'>Mercado e Panificadora Tedesco LTDA</h1>
	<h2 style='font-size:10px; text-align: left;' >CNPJ 06.102.785/0001-90</h2>
        <h1 style='font-size:10px;line-height: 0.5; text-align: center'>Pedido - Nº ". $pedido ."<br>
        ---------------------------------------------</h1>
        <p style='font-size:10px'>
            <b>Emitido em:".$dataEmissao."<br>
            <b>".$nome.","."</b>
            ".$telefone."<br>
            <b>CPF/CNPJ:</b>".$cnpj."<br>
            <b>Endereço:</b>".$endereco."
            <b>Nº</b> - ".$numero."<br>
            <b>Bairro:</b>".$bairro."<br>
            <b>Complemento:</b> ".$complemento." <br> 
            <b>Cidade/Estado:</b> ".$cidade."/".$estado."<br>
            <b>Data da Entrega:</b> ".$dataEntrega."<br>
            <b>Forma de Entrega:</b> ".$formaEntrega."
        </p></b>
        <h1 style='font-size:10px;line-height: 0.5; text-align: center'>Itens do Pedido</h1>
        <table>";
        $html .="<tr><td style='font-size:12px;font-family: monospace; text-align: justify;'><b>Cód. -  Descricao</b></td></tr>";
        $html .="<td style='font-size:12px;font-family: monospace; text-align: justify;'><b>UM</b></td>";
        $html .="<td style='font-size:12px;font-family: monospace; text-align: center;'><b>Quantidade</b></td>";
        $array = explode("---", $_SESSION["sgp_dados_pedido"]["itens"]);
        for($i = 0; $i < count($array); $i++){
            $array2 = explode(";;;", $array[$i]);
            for($j = 0; $j < count($array2) - 1; $j++){
                $html .="
                    <tr><td style='font-size:10px;font-family: monospace;'><b>".$array2[$j]."</b></td></tr>";
                     $j++;
                $html .= "
                    <td style='font-size:10px;font-family: monospace;'><b>".$array2[$j]."</b></td>";
                    $j++;
                $html .= "
                <td style='font-size:10px;font-family: monospace;'><b>".$array2[$j]."</b></td>";
                    $j++;
                if($status != "novo"){
                    $html .= "<tr><td style='font-size:10px;font-family: monospace;'><b>Valor Unit.: R$ ".$array2[$j]."</b></td></tr>";
                }
                $j++;
                if($status != "novo"){
                    $html .= "<td style='font-size:10px;font-family: monospace;'><b>Sub-total:</b></td></tr>";
                    $html .= "<td style='font-size:10px;font-family: monospace;'><b>".$array2[$j]."</b></td>";
                }
                $j++;
                if($status != "novo"){
                    $html .= "<tr><td style='font-size:08px;font-family: monospace;line-height: 0.5;text-align: justify'>-----------------------------------</td></tr>";
                }
                $j++;
            }
        }
        if($status != "novo"){
            $html .= "
            </table>
            <p style='font-size:10px;font-family: monospace;'><b>Total: R$ ".$valortotal.",00</b></p>
			 <p style='font-size:10px;font-family: monospace;'>
            <b style='font-size:10px;font-family: monospace;'>Emitido em: ".$dataEmissao."</b><br>
			</p>
            ";
        }else{
            $html .= "
            </table>
            ";
        }

    $html .= "</div>";
}


require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf(['mode' => 'c']);

$mpdf->WriteHTML($html);
$mpdf->Output();