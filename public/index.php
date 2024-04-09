<?php
    session_start(["session_sgp"]);
    include './../app/php_error.php';
    include './../app/config.php';
    include './../app/autoload.php';
    include './../app/Libraries/Helpers.php';	
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="SGP - INSERIR UMA DESCRIÇÃO">
        <meta name="Júlio Fraga" content="Shop B2B" />
        <title><?= APP_NOME ?></title>
        <!-- Favicon-->
        <!-- <link rel="icon" type="image/x-icon" href="/public/assets/favicon.ico" /> -->
        <!-- Bootstrap Icons-->
        <link href="<?= URL ?>/public/css/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= URL ?>/public/css/styles.css" rel="stylesheet">
        <link href="<?= URL ?>/public/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= URL ?>/public/css/carousel.css" rel="stylesheet">
        <link href="<?= URL ?>/public/css/footers.css" rel="stylesheet">
        <link href="<?= URL ?>/public/css/navbar.css" rel="stylesheet">
        <link href="<?= URL ?>/public/css/bootstrap.min.css.map" rel="stylesheet">
        <link href="<?= URL ?>/public/css/modals.css" rel="stylesheet">
        <link href="<?= URL ?>/public/css/multi_select.css" rel="stylesheet">
        <link href="<?= URL ?>/public/css/offcanvas.css" rel="stylesheet">
        <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
        <!-- INSERIR LINKS PARA O BOOTSTRAP E PARA O CSS -->
        <script src="<?= URL ?>/public/js/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
    
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
    </head>
    <body onresize="realinhaIcones()" onLoad="realinhaIcones()">
        <?php 
            include '../app/Views/header.php';
            $rotas = new Routes();
            include '../app/Views/footer.php';
        ?>
    </body>
    <!-- INCLUIR LINKS PARA OS ARQUIVOS JAVASCRIPtS, JQUERY-->
    <script src="<?= URL ?>/public/js/scripts.js"></script>
    <script src="<?= URL ?>/public/js/bootstrap.bundle.min.js"></script>
    <script src="<?= URL ?>/public/js/functions.js"></script>
    <script src="<?= URL ?>/public/js/offcanvas.js"></script>
        <!-- Bootstrap core JS-->
   <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>-->
    <!-- SimpleLightbox plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</html>