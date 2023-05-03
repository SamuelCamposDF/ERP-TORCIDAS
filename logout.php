<?php

if (isset($_REQUEST['sair'])) {
    session_destroy();
    session_unset($_SESSION['usuario']);
    session_unset($_SESSION['senha']);
    header("Location: index.php");
}
?>