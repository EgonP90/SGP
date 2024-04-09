function realinhaIcones(){
    if(screen.width >= 768){
        alinhaLoginPageComputador();
        alinhaComputador();
        
    }else{
        alinhaLoginPageMobile();
        alinhaMobile();
    }
}

function alinhaLoginPageComputador(){
    var loginPage = document.getElementById("login-page");
    if(loginPage){
        loginPage.classList.remove('login_page_mobile');
        loginPage.classList.add('login_page_computador');
    }
}

function alinhaLoginPageMobile(){
    var loginPage = document.getElementById("login-page");
    if(loginPage){
        loginPage.classList.remove('login_page_computador');
        loginPage.classList.add('login_page_mobile');
    }
}

function alinhaComputador(){
    document.getElementById("alinhaHome").style.marginLeft = '6px';
    document.getElementById("alinhaPedido").style.marginLeft = '10px';
    document.getElementById("alinhaClientes").style.marginLeft = '15px';
    document.getElementById("alinhaProduto").style.marginLeft = '19px';
    document.getElementById("alinhaUsuarios").style.marginLeft = '20px';
    document.getElementById("alinhaRelatorios").style.marginLeft = '20px';
    document.getElementById("alinhaLogs").style.marginLeft = '2px';
    document.getElementById("alinhaPerfil").style.marginLeft = '3px';     
    document.getElementById("alinhaSair").style.marginLeft = '3px'; 
    document.getElementById("label_complemento").innerHTML = 'Complemento';
    
    if(screen.width <= 820){
        document.getElementById("label_complemento").innerHTML = 'Comp.'; 
        document.getElementById("btnItensPedido").classList.add('w-100');
        document.getElementById("btnFinalizarItens").classList.add('w-100');
        document.getElementById("Cliente_multi").classList.remove('w-100');
        document.getElementById("produto_multi").classList.remove('w-100');
        document.getElementById("situacao_multi").classList.remove('w-100');
    }else{
        document.getElementById("btnItensPedido").classList.remove('w-100');
        document.getElementById("btnFinalizarItens").classList.remove('w-100');
        document.getElementById("Cliente_multi").classList.add('w-100');
        document.getElementById("produto_multi").classList.add('w-100');
        document.getElementById("situacao_multi").classList.add('w-100');
    }
}

function alinhaMobile(){
    document.getElementById("alinhaHome").style.marginLeft = '1px';
    document.getElementById("alinhaPedido").style.marginLeft = '1px';
    document.getElementById("alinhaClientes").style.marginLeft = '1px';
    document.getElementById("alinhaProduto").style.marginLeft = '1px';
    document.getElementById("alinhaUsuarios").style.marginLeft = '1px';
    document.getElementById("alinhaRelatorios").style.marginLeft = '1px';
    document.getElementById("alinhaLogs").style.marginLeft = '1px';
    document.getElementById("alinhaPerfil").style.marginLeft = '1px';     
    document.getElementById("alinhaSair").style.marginLeft = '1px';
    document.getElementById("label_complemento").innerHTML = 'Comp.'; 
    document.getElementById("btnItensPedido").classList.add('w-100');
    document.getElementById("btnFinalizarItens").classList.add('w-100');
    document.getElementById("Cliente_multi").classList.remove('w-100');
    document.getElementById("produto_multi").classList.remove('w-100');
    document.getElementById("situacao_multi").classList.remove('w-100');
}

function validaComplexidadeSenha(senha){
    let tamanho = senha.length;
    if(tamanho < 6){
        document.getElementById('avisoComplexidadeSenha').style.display = 'block';
    }else{
        document.getElementById('avisoComplexidadeSenha').style.display = 'none';
    }
}

function comparaSenhas(senhaRepetida){
    let senha = document.getElementById('senha').value;
    if(senhaRepetida != senha){
        document.getElementById('avisoSenhasNaoConferem').style.display = 'block';
    }else{
        document.getElementById('avisoSenhasNaoConferem').style.display = 'none';
    }
    if(senhaRepetida.length >= 6 && senhaRepetida == senha){
        document.getElementById('cadastrar').disabled = false;
    }else{
        document.getElementById('cadastrar').disabled = true;
    }
}

function buscaCep(cep){
    cep = cep.replace('-','');
    var requestURL = "https://viacep.com.br/ws/"+cep+"/json/";
    var request = new XMLHttpRequest();
    var endereco = "";
    request.open('GET', requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = function() {
        endereco = request.response;
        document.getElementById("logradouro").value = endereco.logradouro;
        document.getElementById("complemento").value = endereco.complemento;
        document.getElementById("estado").value = endereco.uf; 
        document.getElementById("cidade").value = endereco.localidade;
        document.getElementById("bairro").value = endereco.bairro;
    }
    
}

function mascaraMutuario(o,f){
    v_obj=o
    v_fun=f
    setTimeout('execmascara()',1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function mtel(v){
    v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

function cepMasc(v){
    //Remove tudo o que não é dígito
    v=v.replace(/\D/g,"")
    //Coloca um hífen depois do bloco de cinco dígitos
    v=v.replace(/(\d{5})(\d)/,"$1-$2")
    return v
}

function cpfCnpj(v){

    //Remove tudo o que não é dígito
    v=v.replace(/\D/g,"")
    if(v.length > 11){
        //Coloca ponto entre o segundo e o terceiro dígitos
        v=v.replace(/^(\d{2})(\d)/,"$1.$2")
        //Coloca ponto entre o quinto e o sexto dígitos
        v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
        //Coloca uma barra entre o oitavo e o nono dígitos
        v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
        //Coloca um hífen depois do bloco de quatro dígitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2")
    }else if (v.length <= 11) { //CPF
        //Coloca um ponto entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
        //Coloca um ponto entre o terceiro e o quarto dígitos
        //de novo (para o segundo bloco de números)
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
        //Coloca um hífen entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    } 
    return v
}

function calculaTotal(n){
    var preco = document.getElementById("preco-"+n).value;
    var qtd = document.getElementById("qtd-"+n).value;
    preco = preco.replace(',', '.');
    qtd = qtd.replace('.', '');
    qtd = qtd.replace(',', '.');
    var total = parseFloat(preco) * parseFloat(qtd);
    total = total.toString();
    total = total.replace('.', ',');
    if(total.includes(',') == false){
        total = total+',00';
    }else{
        var div = total.split(",");
        if(div[1].length == 1){
            total = total + '0';
        }else if(div[1].length > 3){
            var format = div[1].substr(0,2);
            total = div[0] + ',' + format;
        }
    }
    document.getElementById("total-"+n).value = total;
    calculaSubTotal();
}

function calculaSubTotal(){
    v1 = document.getElementById("total-1").value;
    v2 = document.getElementById("total-2").value;
    v3 = document.getElementById("total-3").value;
    v4 = document.getElementById("total-4").value;
    v5 = document.getElementById("total-5").value;
    v6 = document.getElementById("total-6").value;
    v7 = document.getElementById("total-7").value;
    v8 = document.getElementById("total-8").value;
    v9 = document.getElementById("total-9").value;
    v10 = document.getElementById("total-10").value;
    v11 = document.getElementById("total-11").value;
    v12 = document.getElementById("total-12").value;
    v13 = document.getElementById("total-13").value;
    v14 = document.getElementById("total-14").value;
    v15 = document.getElementById("total-15").value;
    v16 = document.getElementById("total-16").value;
    v17 = document.getElementById("total-17").value;
    v18 = document.getElementById("total-18").value;
    v19 = document.getElementById("total-19").value;
    v20 = document.getElementById("total-20").value;
    v21 = document.getElementById("total-21").value;
    v22 = document.getElementById("total-22").value;
    v23 = document.getElementById("total-23").value;
    v24 = document.getElementById("total-24").value;
    v25 = document.getElementById("total-25").value;
    v26 = document.getElementById("total-26").value;
    v27 = document.getElementById("total-27").value;
    v28 = document.getElementById("total-28").value;
    v29 = document.getElementById("total-29").value;
    v30 = document.getElementById("total-30").value;


    v1 = v1.replace(',', '.');
    v1 = v1.replace('R$ ', '');
    v2 = v2.replace(',', '.');
    v2 = v2.replace('R$ ', '');
    v3 = v3.replace(',', '.');
    v3 = v3.replace('R$ ', '');
    v4 = v4.replace(',', '.');
    v4 = v4.replace('R$ ', '');
    v5 = v5.replace(',', '.');
    v5 = v5.replace('R$ ', '');
    v6 = v6.replace(',', '.');
    v6 = v6.replace('R$ ', '');
    v7 = v7.replace(',', '.');
    v7 = v7.replace('R$ ', '');
    v8 = v8.replace(',', '.');
    v8 = v8.replace('R$ ', '');
    v9 = v9.replace(',', '.');
    v9 = v9.replace('R$ ', '');
    v10 = v10.replace(',', '.');
    v10 = v10.replace('R$ ', '');
    v11 = v11.replace(',', '.');
    v11 = v11.replace('R$ ', '');
    v12 = v12.replace(',', '.');
    v12 = v12.replace('R$ ', '');
    v13 = v13.replace(',', '.');
    v13 = v13.replace('R$ ', '');
    v14 = v14.replace(',', '.');
    v14 = v14.replace('R$ ', '');
    v15 = v15.replace(',', '.');
    v15 = v15.replace('R$ ', '');
    v16 = v16.replace(',', '.');
    v16 = v16.replace('R$ ', '');
    v17 = v17.replace(',', '.');
    v17 = v17.replace('R$ ', '');
    v18 = v18.replace(',', '.');
    v18 = v18.replace('R$ ', '');
    v19 = v19.replace(',', '.');
    v19 = v19.replace('R$ ', '');
    v20 = v20.replace(',', '.');
    v20 = v20.replace('R$ ', '');
    v21 = v21.replace(',', '.');
    v21 = v21.replace('R$ ', '');
    v22 = v22.replace(',', '.');
    v22 = v22.replace('R$ ', '');
    v23 = v23.replace(',', '.');
    v23 = v23.replace('R$ ', '');
    v24 = v24.replace(',', '.');
    v24 = v24.replace('R$ ', '');
    v25 = v25.replace(',', '.');
    v25 = v25.replace('R$ ', '');
    v26 = v26.replace(',', '.');
    v26 = v26.replace('R$ ', '');
    v27 = v27.replace(',', '.');
    v27 = v27.replace('R$ ', '');
    v28 = v28.replace(',', '.');
    v28 = v28.replace('R$ ', '');
    v29 = v29.replace(',', '.');
    v29 = v29.replace('R$ ', '');
    v30 = v30.replace(',', '.');
    v30 = v30.replace('R$ ', '');

    valorTotal = parseFloat(v1) + parseFloat(v2) + parseFloat(v3) + parseFloat(v4) + parseFloat(v5) + parseFloat(v6) + parseFloat(v7) + parseFloat(v8) + parseFloat(v9) + parseFloat(v10) + parseFloat(v11) + parseFloat(v12) + parseFloat(v13) + parseFloat(v14) + parseFloat(v15) + parseFloat(v16) + parseFloat(v17) + parseFloat(v18) + parseFloat(v19) + parseFloat(v20) + parseFloat(v21) + parseFloat(v22) + parseFloat(v23) + parseFloat(v24) + parseFloat(v25) + parseFloat(v26) + parseFloat(v27) + parseFloat(v28) + parseFloat(v29) + parseFloat(v30);
    
    valorTotal = valorTotal.toString();
    valorTotal = valorTotal.replace('.', ',');
    if(valorTotal.includes(',') == false){
        valorTotal = valorTotal+',00';
    }else{
        var div = valorTotal.split(",");
        if(div[1].length == 1){
            valorTotal = valorTotal + '0';
        }else if(div[1].length > 2){
            valorTotal = valorTotal.substr(0, 5);
        }
    }
    document.getElementById("subtotal").innerHTML = valorTotal; 
    document.getElementById("txtValortotal").value = valorTotal;
}

function buscaDadosCliente(){
    var cliente = document.getElementById('nomeSel').value;
    var url = document.getElementById('txtUrl').value;
    if(cliente != ""){
        $.ajax({
            url: url+'/cliente/retornaDadosCliente/'+cliente,
            success: function(result){
                document.getElementById('btnClose').click();
                retornaNome(result);
                retornaCpfCnpj(result);
                retornaTelefone(result);   
                retornaCep(result);
                retornaRua(result);
                retornaNumero(result);
                retornaComplemento(result);
                retornaEstado(result);
                retornaCidade(result);
                retornaBairro(result);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Cliente não encontrado');
            }
        });
    }else{
        limpaCamposClientePedido();
    }
    return false;
}

function buscaDadosItem(field){
    var value = document.getElementById(field).value;
    var url = document.getElementById('txtUrl').value;
    var id = field.split('-');
    $.ajax({
        url: url+'/produto/imprimeProdutoPorId/'+value,
        success: function(result){
            retornaUM(result, id[1]);
            retornaPreco(result, id[1]);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Item não encontrado');
        }
    });
}

function limpaCamposClientePedido(){
    document.getElementById('cpfcnpj').value = "";
    document.getElementById('telefone').value = "";
    document.getElementById('cep').value = "";
    document.getElementById('logradouro').value = "";
    document.getElementById('numero').value = "";
    document.getElementById('complemento').value = "";
    document.getElementById('estado').value = "";
    document.getElementById('cidade').value = "";
    document.getElementById('bairro').value = "";
}

function retornaNome(result){
    var nome = result.split("<nome>");
    var nome2 = nome[1].split("</nome>");
    document.getElementById('nome').value = nome2[0];
}

function retornaCpfCnpj(result){
    var cpfcnpj = result.split("<cpfcnpj>");
    var cpfcnpj2 = cpfcnpj[1].split("</cpfcnpj>");
    document.getElementById('cpfcnpj').value = cpfcnpj2[0];
}

function retornaTelefone(result){
    var telefone = result.split("<telefone>");
    var telefone2 = telefone[1].split("</telefone>");
    document.getElementById('telefone').value = telefone2[0];
}

function retornaCep(result){
    var cep = result.split("<cep>");
    var cep2 = cep[1].split("</cep>");
    document.getElementById('cep').value = cep2[0];
}

function retornaRua(result){
    var rua = result.split("<rua>");
    var rua2 = rua[1].split("</rua>");
    document.getElementById('logradouro').value = rua2[0];
}

function retornaNumero(result){
    var numero = result.split("<numero>");
    var numero2 = numero[1].split("</numero>");
    document.getElementById('numero').value = numero2[0];
}

function retornaComplemento(result){
    var complemento = result.split("<complemento>");
    var complemento2 = complemento[1].split("</complemento>");
    document.getElementById('complemento').value = complemento2[0];
}

function retornaEstado(result){
    var estado = result.split("<estado>");
    var estado2 = estado[1].split("</estado>");
    document.getElementById('estado').value = estado2[0];
}

function retornaCidade(result){
    var cidade = result.split("<cidade>");
    var cidade2 = cidade[1].split("</cidade>");
    document.getElementById('cidade').value = cidade2[0];
}

function retornaBairro(result){
    var bairro = result.split("<bairro>");
    var bairro2 = bairro[1].split("</bairro>");
    document.getElementById('bairro').value = bairro2[0];
}

function retornaBairro(result){
    var bairro = result.split("<bairro>");
    var bairro2 = bairro[1].split("</bairro>");
    document.getElementById('bairro').value = bairro2[0];
}

function retornaUM(result, field){
    var um = result.split("<UM>");
    var um2 = um[1].split("</UM>");
    document.getElementById('um-'+field).value = um2[0];
}

function retornaPreco(result, field){
    var preco = result.split("<preco>");
    var preco2 = preco[1].split("</preco>");
    document.getElementById('preco-'+field).value = preco2[0];
}

function exibeCampos(){
    var num = document.getElementById('num_campos_exibidos').value;
    num = parseInt(num)+1;
    document.querySelector('.coluna-item-'+num).style.display = 'block';
    document.querySelector('.coluna-um-'+num).style.display = 'block';
    document.querySelector('.coluna-preco-'+num).style.display = 'block';
    document.querySelector('.coluna-qtd-'+num).style.display = 'block';
    document.querySelector('.coluna-total-'+num).style.display = 'block';
    document.getElementById('num_campos_exibidos').value = num;
}

function validaData(dataEntrega){
    const date = new Date();
    const day = date.getDate();
    const month = date.getMonth();
    const year = date.getFullYear();
    const dataAtual = year+'-'+month+'-'+day;
    dataEntrega = dataEntrega.split("T");
    const diffInMs   = new Date(dataEntrega[0]) - new Date(dataAtual)
    const diffInDays = diffInMs / (1000 * 60 * 60 * 24) - 31;
    if(diffInDays < 0){
        document.getElementById('avisoDiferencaData').style.display = 'none';
    }else{
        document.getElementById('avisoDiferencaData').style.display = 'none';
    }
}

function mudaStatusItem(obj, pedido_id){
    var url = document.getElementById('txtUrl').value;
    var perfil = document.getElementById('perfil').value;
    var value = obj.value;
    if(value == 'Pronto p/ Retirada'){
        value = 'ProntoRetirada';
    }
    $.ajax({
        url: url+'/pedido/atualizaStatusItem/'+value+'/'+obj.id,
        success: function(result){
            var id = obj.id.split('_');
            id = id[1];
            var id_pedido = id.split('-');
            id_pedido = id_pedido[0];
            if(obj.value == 'Em produção'){
                document.getElementById(obj.id).classList.remove('btn-secondary');
                document.getElementById(obj.id).classList.add('btn-info');
                document.getElementById(obj.id).value = 'Pronto p/ Retirada';
                document.getElementById('lbStatusItem_'+id).innerHTML = 'Em produção';
                document.getElementById('lbStatusItem_'+id).style.color = 'orange';
            }else if(obj.value == 'Pronto p/ Retirada'){
                document.getElementById(obj.id).classList.remove('btn-info');
                document.getElementById(obj.id).classList.add('btn-success');
                document.getElementById(obj.id).value = 'Entregar';
                document.getElementById('lbStatusItem_'+id).innerHTML = 'Pronto p/ Retirada';
                document.getElementById('lbStatusItem_'+id).style.color = 'blue';
                document.getElementById('btnCancelarItem_'+id).type = 'hidden';
                if(perfil != 0 && perfil != 1){
                    document.getElementById('btnStatusItem_'+id).type = 'hidden';
                    document.getElementById('btnCancelarItem_'+id).type = 'hidden';
                }
            }else if(obj.value == 'Entregar'){
                document.getElementById('btnStatusItem_'+id).type = 'hidden';
                document.getElementById('btnCancelarItem_'+id).type = 'hidden';
                document.getElementById('lbStatusItem_'+id).innerHTML = 'Entregue';
                document.getElementById('lbStatusItem_'+id).style.color = 'green';
            }else if(obj.value == 'Cancelar'){
                document.getElementById('btnStatusItem_'+id).type = 'hidden';
                document.getElementById('btnCancelarItem_'+id).type = 'hidden';
                document.getElementById('btnEntregarPedidoCompleto_'+id_pedido).type = 'hidden';
                document.getElementById('lbStatusItem_'+id).innerHTML = 'Cancelado';
                document.getElementById('lbStatusItem_'+id).style.color = 'black';
            }
            setStatusPedido(result, pedido_id);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Erro ao atualizar status do item');
        }
    });
}

function setStatusPedido(obj, pedido_id){
    var status1 = obj.split("<STATUS_PEDIDO>");
    var status2 = status1[1].split("</STATUS_PEDIDO>");
    document.getElementById('lbStatusPedido_'+pedido_id).innerHTML = status2[0];
    if(status2[0] == 'Não entregue'){
        document.getElementById('lbStatusPedido_'+pedido_id).style.color = 'white';
        document.getElementById('lbStatusPedido_'+pedido_id).style.backgroundColor = 'red';
    }else if(status2[0] == 'Cancelado'){
        document.getElementById('lbStatusPedido_'+pedido_id).style.color = 'white';
        document.getElementById('lbStatusPedido_'+pedido_id).style.backgroundColor = 'black';
    }else if(status2[0] == 'Ent. Parcial'){
        document.getElementById('lbStatusPedido_'+pedido_id).style.color = 'black';
        document.getElementById('lbStatusPedido_'+pedido_id).style.backgroundColor = '#58FAF4';
    }else if(status2[0] == 'Pronto p/ Retirada'){
        document.getElementById('lbStatusPedido_'+pedido_id).style.color = 'white';
        document.getElementById('lbStatusPedido_'+pedido_id).style.backgroundColor = 'blue';
    }else if(status2[0] == 'Em produção'){
        document.getElementById('lbStatusPedido_'+pedido_id).style.color = 'white';
        document.getElementById('lbStatusPedido_'+pedido_id).style.backgroundColor = 'orange';
    }else if(status2[0] == 'Entregue'){
        document.getElementById('lbStatusPedido_'+pedido_id).style.color = 'white';
        document.getElementById('lbStatusPedido_'+pedido_id).style.backgroundColor = 'green';
        document.getElementById('btnEntregarPedidoCompleto_'+pedido_id).type = 'hidden';
    }    
}