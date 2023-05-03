<?php include_once '../conexao.php' ?>
<html>

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">

    <title>Redefinir senha</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="logo.png">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <meta name="apple-mobile-web-app-title" content="">

    <link rel="apple-touch-icon" href="icons_192.png">

    <meta name="theme-color" content="#fff" />

    <link rel="stylesheet" href="./bootstrap-5.2.0-dist/css/bootstrap.min.css" />

</head>


<body class="bg-light">

    <div class="container">
        <div class="mx-auto col-md-4 col-12 py-5">

            <div class="text-center py-5">
                <p class="fw-bold h5">Entrar na sua conta ou <a href="../cadastre-se.php">fazer cadastro</a></p>
                <p class="fw-bold h6">Redefinir a senha</p>
            </div>

            <?php include_once 'actions/reset-senha.php' ?>

            <form method="POST" class="shadow borda rounded-3 mt-3 py-3" enctype="multipart/form-data" action="">
                <input type="hidden" name="acao" value="reset">
                <div class="modal-body">
                    <div class="form-floating my-2">
                        <input type="email" class="form-control" placeholder="." required id="floatingInputValue" name="email">
                        <label class="text-dark fw-bold" for="floatingInputValue">E-mail</label>
                    </div>

                </div>
                <div class="text-center py-2">
                    <a class="btn btn-white text-dark shadow rounded-3 fw-bold" href="../">Cancelar</a>
                    <button type="submit" class="btn btn-dark text-white">Redefinir</button>
                </div>
            </form>
        </div>
    </div>



    <div style="position: absolute; bottom: 0;width: 100%;" class="bg-primary mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center text-white fw-bold h3"> © <?php
                                                                    echo date("Y");
                                                                    ?> ERP-TORCIDA</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>

</html>