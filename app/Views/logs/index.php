<?php
    $helper = new Helpers();
?>
<body>
    <div id="conteudo" class="mb-5">
        <div class="container conteudo_consulta" style="margin-top: 3%;">
            <div class="resultados_admin mt-4">
                <h4>Logs</h4>
                <div class="row mt-4">
                    <div class="col-3">
                        USUÁRIO
                    </div>
                    <div class="col-2">
                        AÇÃO
                    </div>
                    <div class="col-2">
                        TELA
                    </div>
                    <div class="col-2">
                        ID DO OBJETO
                    </div>
                    <div class="col-3">
                        DATA/HORA
                    </div>
                </div>
                <hr class="divisor_horizontal">
                <?php 
                    foreach($dados["dados"] as $logs){
                ?>
                    <div class="row mt-4">
                        <div class="col-3">
                            <p class="pb-1 mb-0 large border-bottom mt-2">
                                <?= $logs->login ?>
                            </p>
                        </div>
                        <div class="col-2">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?php
                                    switch ($logs->acao) {
                                        case 0:
                                            echo "Inseriu";
                                            break;
                                        case 1:
                                            echo "Alterou";
                                            break;
                                        case 2:
                                            echo "Deletou";
                                            break;
                                        case 3:
                                            echo "Fez Login";
                                            break;
                                    } 
                                ?>
                            </p>
                        </div>
                        <div class="col-2">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $logs->classe ?>
                            </p>
                        </div>
                        <div class="col-2">
                            <p class="pb-1 mb-0 large border-bottom mt-2">
                                <?= $logs->id_classe != null ? $logs->id_classe : '<br>'?>
                            </p>
                        </div>
                        <div class="col-3">
                            <p class="pb-1 mb-0 large border-bottom mt-2 ">
                                <?= $helper->formataDateTime($logs->created_at) ?>
                            </p>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</body>