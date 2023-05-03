
<?php
include 'header.php';
//include 'conect.php';
include './logout.php';
include './Controller/controllers.php';



$perfil = (isset($_GET['perfil'])) ? $_GET['perfil'] : ''; // vai receber o hash do membro
$perfil = strip_tags($perfil);


if (!empty($perfil)) :
    $sql = "SELECT * FROM membros WHERE hash=:hash and idInstituicao=$idInstituicaoLogado";
    //  var_dump($sql);
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':hash', strip_tags($perfil));
    $stm->execute();
    $dadosMembro = $stm->fetch(PDO::FETCH_OBJ);

    if (!empty($dadosMembro)) :
        $idMembro =   $dadosMembro->id;
        $dadosMembro->hash;
        $dadosMembro->nomeMembro;
        $dadosMembro->paiMembro;
        $dadosMembro->maeMembro;
        $dadosMembro->cpfMembro;

        $sql = "SELECT * FROM grupomembros WHERE idMembro = $dadosMembro->id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $GrupoMembro = $stm->fetchAll(PDO::FETCH_OBJ);

        $gruposM = array();
        foreach ($GrupoMembro as $gm) {
            $gruposM[] =  $gm->nomeGrupo;
        }

        $sql = "SELECT * FROM cargosmembro WHERE idMembro = $dadosMembro->id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $cargosmembro = $stm->fetchAll(PDO::FETCH_OBJ);
        $cargo = array();
        foreach ($cargosmembro as $c) {
            $cargo[] =  $c->nomeCargo;
        }

        $arrPmember = array(
            "idMembro" => $dadosMembro->id,
            "nomeMembro" => $dadosMembro->nomeMembro,
            "idTo" => $dadosMembro->idInstituicao,
            "Torcida" => $nomeInstituicao
            //    "Grupos" =>  $grupoMembro
            // "Cargos" =>  $arrCargosMembros
        );

    //  var_dump($arrPmember);


    else :

        header("Refresh: 3, ?membros");
        exit;
    endif;


endif;


?>