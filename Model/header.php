<?php

ob_start();
session_start();
if (!isset($_SESSION['usuario']) && (!isset($_SESSION['senha']))) {
    header("Location: index.php?acao=negado");
    exit;
}

include("conect.php");

//include("includes/logout.php");

$usuarioLogado = $_SESSION['usuario'];
$senhaLogado = $_SESSION['senha'];

// seleciona a usuario logado
$selecionaLogado = "SELECT * from usuarios WHERE usuario=:usuarioLogado AND senha=:senhaLogado";
try {
    $result = $pdo->prepare($selecionaLogado);
    $result->bindParam('usuarioLogado', $usuarioLogado, PDO::PARAM_STR);
    $result->bindParam('senhaLogado', $senhaLogado, PDO::PARAM_STR);
    $result->execute();
    $contar = $result->rowCount();

    if ($contar = 1) {
        $loop = $result->fetchAll();
        foreach ($loop as $resultado) {
            $idLogado = $resultado['id'];
        }
    }
} catch (PDOException $erro) {
    echo $erro;
}


echo "<br><br><br><br>";


if (!empty($idLogado)) :

    $sql = "SELECT * FROM instituicao WHERE idPresidente = $idLogado";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $torcida = $stm->fetchAll(PDO::FETCH_OBJ);
    $contartorcida = $stm->rowCount();

    $arrTorcidaGeral = array();

    foreach ($torcida as $arrTorcida) {
        $idInstituicaoLogado = $arrTorcida->id;
        $nomeInstituicao = $arrTorcida->nomeInstituicao;
        $siglaTorcida = $arrTorcida->sigla;
    }

    $sql = "SELECT * FROM grupos WHERE idInstituicao = $idInstituicaoLogado";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $GruposTorcida = $stm->fetchAll(PDO::FETCH_OBJ);

    $todosGrupos = array();
    foreach ($GruposTorcida as $g) {
        $todosGrupos[] = $g->nome;
    }

    $sql = "SELECT * FROM cargos WHERE idInstituicao = $idInstituicaoLogado";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $CargosTorcida = $stm->fetchAll(PDO::FETCH_OBJ);

    $todos = array();
    foreach ($CargosTorcida as $cs) {
        $todos[] = $cs->nome;
    }

    $sql = "SELECT * FROM membros WHERE idInstituicao = $idInstituicaoLogado";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $membrosCadastrados = $stm->fetchAll(PDO::FETCH_OBJ);

else :
    session_destroy();
    session_unset($_SESSION['usuario']);
    session_unset($_SESSION['senha']);
    header("Location: ./index.php");
endif;


/*

foreach ($membros as $i => $arr) :
     "Indice =>" . $i . "<br>";
    $sql = "SELECT * FROM bondemembros WHERE idTorcedor = $arr->id";
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $bonde = $stm->fetchAll(PDO::FETCH_OBJ);
    foreach ($bonde as $arrBonde) {
        $sql = "SELECT * FROM bondetorcida WHERE id = $arr->id";
        $stm = $conexao->prepare($sql);
        $stm->execute();
        $bondes = $stm->fetchAll(PDO::FETCH_OBJ);
        foreach ($bondes as $arrBondes) {
            $arrBondeMembro = $arrBondes->nome;
        }
    }
    $sql = "SELECT * FROM cargosmembro WHERE idTorcedor = $arr->id";
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $cargosmembro = $stm->fetchAll(PDO::FETCH_OBJ);

    foreach ($cargosmembro as $arrCM) {
        $sql = "SELECT * FROM cargos WHERE id = $arrCM->idCargo";
        $stm = $conexao->prepare($sql);
        $stm->execute();
        $cargos = $stm->fetchAll(PDO::FETCH_OBJ);
        foreach ($cargos as $arrCargos) {
            $arrCargosMembros[$i][] = $arrCargos->descricao;
        }
    }
    $arrPmember[] = array(
        "idMembro" => $arr->id,
        "nomeMembro" => $arr->nome,
        "idTo" => $idTorcidaLogado,
        "Torcida" => $nomeTorcida,
        "Bonde" =>  $arrBondeMembro,
        "Cargos" =>  $arrCargosMembros[$i]
    );

endforeach;

//var_dump($arrPmember);

*/

//----------------------------------------------------------------------------//
/*
if (!empty($id_usuario)) :
    $selecionaLoja = "SELECT * from loja WHERE id_usuario=$id_usuario";
    try {
        $result = $conexao->prepare($selecionaLoja);
        $result->execute();
        $contarLojas = $result->rowCount();

        if ($contarLojas = 1) {
            $loop = $result->fetchAll();
            foreach ($loop as $resultado) {
                $id_loja = $resultado['id'];
                $nome = $resultado['nome_loja'];
                $categoria = $resultado['categoria'];
                $whatsapp = $resultado['whatsapp'];
                $link = $resultado['link'];
                $instagram = $resultado['instagram'];
                $facebook = $resultado['facebook'];
                $email = $resultado['email'];
                $endereco = $resultado['endereco'];
            }
        }
    } catch (PDOException $erro) {
        echo $erro;
    }

    $selecionaPlanoUser = "SELECT * from plano WHERE IdUsuario=$id_usuario";
    $resultado = $conexao->prepare($selecionaPlanoUser);
    $resultado->execute();
    $contarPlano = $resultado->rowCount();
    $loopPlano = $resultado->fetchAll();
    foreach ($loopPlano as $resultado) {
        $plano = $resultado['plano'];
        if ($plano == 1) :
            $plano = 'Grátis';
        elseif ($plano == 2) :
            $plano = 'Basic';
        elseif ($plano == 3) :
            $plano = 'intermediário';
        endif;
    }
else :
    session_destroy();
    session_unset($_SESSION['usuario']);
    session_unset($_SESSION['senha']);
    header("Location: ../../index.php");

endif;
*/