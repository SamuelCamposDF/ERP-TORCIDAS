<?php
ob_start();
session_start();
if (isset($_SESSION['usuario']) && (isset($_SESSION['senha']))) {
    header("Location: inicio.php");
    exit;
}
include("Model/conect.php");
?>

<!DOCTYPE html>
<html lang="br">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

</head>

<body class="bg-light">

    <div class="container">

        <div class="mx-auto col-md-4 col-12 mb-5 py-5">

            <div class="text-center mb-5">
                <p class="fw-bold h5">Entrar na sua conta ou <a href="../cadastre-se.php">fazer cadastro</a></p>

            </div>

            <?php
            if (isset($_GET['acao'])) {

                if (!isset($_POST['logar'])) {

                    $acao = $_GET['acao'];
                    if ($acao == 'negado') {
                        echo '<div class="alert alert-danger">
						  <strong>Erro ao acessar!</strong> Você precisa estar logado para acessar o Sistema.
					</div>';
                    }
                }
            }
            if (isset($_POST['logar'])) {
                // RECUPERAR DADOS FORM
                $usuario = trim(strip_tags(htmlspecialchars($_POST['usuario'])));
                $senha = trim(strip_tags(htmlspecialchars($_POST['senha'])));
                // SELECIONAR BANCO DE DADOS
                $select = "SELECT * from usuarios WHERE BINARY usuario=:usuario AND BINARY senha=:senha ";
                try {
                    $result = $pdo->prepare($select);
                    $result->bindParam(':usuario', $usuario, PDO::PARAM_STR);
                    $result->bindParam(':senha', $senha, PDO::PARAM_STR);
                    $result->execute();
                    $contar = $result->rowCount();
                    if ($contar > 0) {
                        $usuario = $_POST['usuario'];
                        $senha = $_POST['senha'];
                        $_SESSION['usuario'] = $usuario;
                        $_SESSION['senha'] = $senha;

                        echo '<div class="text-center"><div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div></div>';
                        header("Refresh: 1, inicio.php");
                    } else {
                        header("Refresh: 0, ?acao=incorreto");
                    }
                } catch (PDOException $e) {
                    $e;
                }
            } // se clicar no botão entrar no sistema
            ?>


            <form action="#" method="post" class="borda rounded shadow py-3 p-3 bg-white" enctype="multipart/form-data">

                <div class="form-floating mb-3">
                    <input type="text" name="usuario" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label class="fw-bold" for="floatingInput">Email</label>
                </div>

                <div class="form-floating">
                    <input type="password" name="senha" class="form-control" id="floatingPassword" placeholder="Password">
                    <label class="fw-bold" for="floatingPassword">Senha</label>
                </div>
                <div class="py-3 text-end">
                    <a href="reset_senha.php">Redefinir senha</a>
                </div>

                <div class="text-center">
                    <input type="submit" name=" logar" value="Entrar" class="col-md-6 col-auto button btn btn-dark btn-large mt-3">
                </div>
            </form>
            <?php
            if (isset($_GET['acao'])) {

                if (!isset($_POST['logar'])) {

                    $acao = $_GET['acao'];
                    if ($acao == 'cadastrado') {
                        echo '<div class="alert alert-success">
                      <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
						  <strong>Parabéns!</strong> Você conseguiu se cadastrar, entre com email e senha para acessar o sistema.
					</div>';
                    }
                }
            }
            ?>

            <?php
            if (isset($_GET['acao'])) {

                if (!isset($_POST['logar'])) {

                    $acao = $_GET['acao'];
                    if ($acao == 'incorreto') {
                        echo '<div class="mt-2 alert alert-info">
                  <strong>Error !</strong> O login ou senha inserida está incorreta ou não não existe cadastro. 
                  </div>';
                    }
                }
            }
            ?>

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

    <script src="bootstrap-5.2.0-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>