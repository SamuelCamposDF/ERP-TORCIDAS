<?php

$acao = (isset($_POST['acao'])) ? $_POST['acao'] : '';

$idMembro = (isset($_POST['idMembro'])) ? $_POST['idMembro'] : '';
$hash = (isset($_POST['hash'])) ? $_POST['hash'] : '';

/* INPUTS REFERENTES AO MEMBRO */
$idInstituicao = (isset($_POST['idInstituicao'])) ? $_POST['idInstituicao'] : '';
$nomeMembro = (isset($_POST['nomeMembro'])) ? $_POST['nomeMembro'] : '';
$paiMembro = (isset($_POST['paiMembro'])) ? $_POST['paiMembro'] : '';
$maeMembro = (isset($_POST['maeMembro'])) ? $_POST['maeMembro'] : '';
$cpfMembro = (isset($_POST['cpfMembro'])) ? $_POST['cpfMembro'] : '';
$dataMembro = (isset($_POST['dataMembro'])) ? $_POST['dataMembro'] : '';
$profissaoMembro = (isset($_POST['profissaoMembro'])) ? $_POST['profissaoMembro'] : '';
$emailMembro = (isset($_POST['emailMembro'])) ? $_POST['emailMembro'] : '';
$socio = (isset($_POST['socio'])) ? $_POST['socio'] : '';
$status = (isset($_POST['status'])) ? $_POST['status'] : '';
$acesso = (isset($_POST['acesso'])) ? $_POST['acesso'] : '';
$grupoMembro = (isset($_POST['grupoMembro'])) ? $_POST['grupoMembro'] : '';
$cargosMembro = (isset($_POST['cargosMembro'])) ? $_POST['cargosMembro'] : '';

/* INPUTS REFERENTES AOS GRUPOS */
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$nome  = (isset($_POST['nome'])) ? $_POST['nome'] : '';
$sigla = (isset($_POST['sigla'])) ? $_POST['sigla'] : '';



$imagem = (isset($_POST['imagem'])) ? $_POST['imagem'] : '';
$arquivo = (isset($_FILES['arquivo'])) ? $_FILES['arquivo'] : '';


if (empty($acesso)) : $acesso = 0;
else :
    $acesso = 1;
endif;



if ($acao == 'cadastrarMembro') :

    echo '<script>function goBack() { window.history.back();}</script>';

    if ($_FILES["arquivo"]["name"] == '') :
        echo "<div class='container mt-3 alert alert-info'> A imagem "  . $key . " está vazia, volte e insira a imagem, clique <button class='btn bg-white' onclick='goBack()'>aqui</button> para voltar! </div>";
        exit;
    else :
        echo "<div class='container mt-3 alert alert-success'><strong>"  . $_FILES["arquivo"]["name"] . "</strong> carregada com sucesso !</div>";
    endif;

    $pasta = './views/imagens/';

    $formatoImagem = $_FILES['arquivo']['type'];
    if ($formatoImagem == "image/png") :
        $NovoFormato = '.png';
    elseif ($formatoImagem == "image/jpeg") :
        $NovoFormato = '.jpeg';
    endif;

    $sql = "SELECT * FROM membros WHERE cpfMembro=:cpfMembro or emailMembro=:emailMembro";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':cpfMembro', strip_tags($cpfMembro));
    $stm->bindValue(':emailMembro', strip_tags($emailMembro));
    $stm->execute();
    $membros = $stm->fetchAll();
    $membros = $stm->rowCount();

    if ($membros >= 1) {
        echo "<div class='alert alert-info' role='alert'>Uma pessoa com esse email ou cpf já foi Cadastrada <a href='javascript:history.back()'>Voltar</a>
        </div>";
        exit;
    } else {
    }



    $rand = rand(1, 999999999);
    $hash = md5($nomeMembro . $rand);
    $hashImg = md5($nomeMembro . $emailMembro . $rand);


    $pessoas = array(
        'hash' => $hash,
        'imagem' => $hashImg . $NovoFormato,
        'idInstituicao' => $idInstituicao,
        'nomeMembro' => $nomeMembro,
        'paiMembro' => $paiMembro,
        'maeMembro' => $maeMembro,
        'cpfMembro' => $cpfMembro,
        'dataMembro' => $dataMembro,
        'profissaoMembro' => $profissaoMembro,
        'emailMembro' => $emailMembro,
        'acesso' => $acesso,
        'socio' => $socio,
        'status' => $status
    );

    $pdo->beginTransaction();
    $sql = "INSERT INTO membros (hash, imagem, idInstituicao, nomeMembro, paiMembro, maeMembro, cpfMembro, dataMembro, profissaoMembro, emailMembro, acesso, socio, status) VALUES (:hash, :imagem, :idInstituicao, :nomeMembro, :paiMembro, :maeMembro, :cpfMembro, :dataMembro, :profissaoMembro, :emailMembro, :acesso, :socio, :status)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute($pessoas);
        echo "Dado inserido com sucesso<br>";
        $idCadastroMembro = $pdo->lastInsertId();
    } catch (PDOException $e) {
        echo "Erro ao inserir dado: " . $e->getMessage() . "<br>";
    }
    if ($pdo->commit()) {
        echo "Transação concluída com sucesso<br>";
    } else {
        echo "Erro ao concluir transação<br>";
        $pdo->rollBack();
    }


    echo $idCadastroMembro;


    foreach ($cargosMembro as $c) {
        $sql = 'INSERT INTO cargosmembro (idMembro, nomeCargo) VALUES (:idMembro, :nomeCargo)';
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':idMembro', (strip_tags($idCadastroMembro)));
        $stm->bindValue(':nomeCargo', (strip_tags($c)));
        echo $c . "<br>";
        $stm->execute();
    }

    foreach ($grupoMembro as $b) {
        $sql = 'INSERT INTO grupomembros (idMembro, nomeGrupo) VALUES (:idMembro, :nomeGrupo)';
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':idMembro', (strip_tags($idCadastroMembro)));
        $stm->bindValue(':nomeGrupo', (strip_tags($b)));
        echo $b . "<br>";
        $stm->execute();
    }

    $uploadfile = $pastaFoto . $hashImg . $NovoFormato;
    $altura = "600";
    $largura = "600";
    "Altura pretendida: $altura - largura pretendida: $largura <br>";

    switch ($_FILES['arquivo']['type']):
        case 'image/jpeg';
        case 'image/pjpeg';
            $imagem_temporaria = imagecreatefromjpeg($_FILES['arquivo']['tmp_name']);

            $largura_original = imagesx($imagem_temporaria);

            $altura_original = imagesy($imagem_temporaria);

            "largura original: $largura_original - Altura original: $altura_original <br>";

            $nova_largura = $largura ? $largura : floor(($largura_original / $altura_original) * $altura);

            $nova_altura = $altura ? $altura : floor(($altura_original / $largura_original) * $largura);

            $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
            imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

            imagejpeg($imagem_redimensionada, $pastaFoto . $hashImg . ".jpeg");

            "<img src='" .  $pastaFoto . $hashImg . '.jpeg' . "'>";

            break;

        case 'image/png':
        case 'image/x-png';
            $imagem_temporaria = imagecreatefrompng($_FILES['arquivo']['tmp_name']);

            $largura_original = imagesx($imagem_temporaria);
            $altura_original = imagesy($imagem_temporaria);
            "Largura original: $largura_original - Altura original: $altura_original <br> ";

            $nova_largura = $largura ? $largura : floor(($largura_original / $altura_original) * $altura);

            $nova_altura = $altura ? $altura : floor(($altura_original / $largura_original) * $largura);

            $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);

            imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

            imagepng($imagem_redimensionada,  $pastaFoto . $hashImg .  ".png");

            "<img src='" .  $pastaFoto . $hashImg  . '.png' . "'>";
            break;
    endswitch;


    echo '<div class="alert alert-alert" role="alert">
    Cadastrando membro  (' . $nomeMembro . ') ... </div> <div class="d-flex justify-content-center">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>';

    // header("Refresh: 3, ?perfil=$idCadastroMembro");
    exit;
endif;

if ($acao == 'editarMembro') :

    $pasta = "./views/imagens/";
    $filename = $pasta . $imagem;

    if ($_FILES["arquivo"]["name"] == '') :
    else :
        if (file_exists($filename)) {
            echo "O arquivo $filename existe";
            echo "<script>alert('tem imagem na pasta e vai excluir')</script>";
            unlink($filename);
        } else {
            //    echo "O arquivo $filename não existe";
            echo "<script>alert('não tem imagem na pasta')</script>";
        }
    endif;

    $formatoImagem = $_FILES['arquivo']['type'];
    if ($formatoImagem == "image/png") :
        $NovoFormato = '.png';
    elseif ($formatoImagem == "image/jpeg") :
        $NovoFormato = '.jpeg';
    elseif ($formatoImagem == "application/pdf") :
        echo $formatoImagem;
        echo  $_FILES["arquivo"]["name"];
        echo "<div class='container mt-3 alert alert-info'>Não é permitido arquivos em PDF, clique <button class='btn bg-white' onclick='goBack()'>aqui</button> para voltar! </div>";
        exit;
    endif;

    // passe todos os dados que deseja atualizar a array deve ser 100% correta o nome da 'coluna' => e $valor

    $dados = array(
        'id' => $idMembro,
        'nomeMembro' => $nomeMembro,
        'cpfMembro' => $cpfMembro,
        'dataMembro' => $dataMembro,
        'maeMembro' => $maeMembro,
        'paiMembro' => $paiMembro,
        'profissaoMembro' => $profissaoMembro,
        'emailMembro' => $emailMembro,
        'acesso' => $acesso
    );
    // var_dump($dados);

    $sql = "UPDATE membros SET nomeMembro = :nomeMembro, cpfMembro =:cpfMembro, dataMembro=:dataMembro, maeMembro=:maeMembro, paiMembro=:paiMembro,  profissaoMembro=:profissaoMembro, emailMembro=:emailMembro, acesso=:acesso WHERE id = :id";
    $stm = $pdo->prepare($sql);
    try {
        $pdo->beginTransaction();
        $stm->execute($dados);
        $pdo->commit();


        $sql = 'DELETE FROM cargosmembro WHERE idMembro = :idMembro';
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':idMembro', $idMembro);
        $stm->execute();

        foreach ($cargosMembro as $c) {
            $sql = 'INSERT INTO cargosmembro (idMembro, nomeCargo) VALUES (:idMembro, :nomeCargo)';
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':idMembro', (strip_tags($idMembro)));
            $stm->bindValue(':nomeCargo', (strip_tags($c)));
            echo $c . "<br>";

            $stm->execute();
        }

        $sql = 'DELETE FROM grupomembros WHERE idMembro = :idMembro';
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':idMembro', $idMembro);
        $stm->execute();

        foreach ($grupoMembro as $b) {

            $sql = 'INSERT INTO grupomembros (idMembro, nomeGrupo) VALUES (:idMembro, :nomeGrupo)';
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':idMembro', (strip_tags($idMembro)));
            $stm->bindValue(':nomeGrupo', (strip_tags($b)));
            echo $b . "<br>";
            $stm->execute();
        }


        if (empty($_FILES['arquivo']['type'])) :
        else :

            $hashImg = md5($nomeMembro . $emailMembro . rand());

            $formatoImagem = $_FILES['arquivo']['type'];
            if ($formatoImagem == "image/png") :
                $NovoFormato = '.png';
            elseif ($formatoImagem == "image/jpeg") :
                $NovoFormato = '.jpeg';
            endif;
            "adiciona imagem";

            $sql = "UPDATE membros SET imagem=:imagem ";
            $sql .= "WHERE id = :id";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':imagem', (strip_tags($hashImg . $NovoFormato)));
            $stm->bindValue(':id', $idMembro);
            $stm->execute();

            $uploadfile = $pasta . $hashImg . $NovoFormato;
            $altura = "600";
            $largura = "600";
            "Altura pretendida: $altura - largura pretendida: $largura <br>";

            if (empty($_FILES['arquivo']['type'])) :
            else :

                switch ($_FILES['arquivo']['type']):
                    case 'image/jpeg';
                    case 'image/pjpeg';
                        $imagem_temporaria = imagecreatefromjpeg($_FILES['arquivo']['tmp_name']);

                        $largura_original = imagesx($imagem_temporaria);

                        $altura_original = imagesy($imagem_temporaria);

                        "largura original: $largura_original - Altura original: $altura_original <br>";

                        $nova_largura = $largura ? $largura : floor(($largura_original / $altura_original) * $altura);

                        $nova_altura = $altura ? $altura : floor(($altura_original / $largura_original) * $largura);

                        $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
                        imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

                        imagejpeg($imagem_redimensionada, $pasta . $hashImg . ".jpeg");

                        "<img src='" .  $pasta . $hashImg . '.jpeg' . "'>";

                        break;

                    case 'image/png':
                    case 'image/x-png';
                        $imagem_temporaria = imagecreatefrompng($_FILES['arquivo']['tmp_name']);

                        $largura_original = imagesx($imagem_temporaria);
                        $altura_original = imagesy($imagem_temporaria);
                        "Largura original: $largura_original - Altura original: $altura_original <br> ";

                        $nova_largura = $largura ? $largura : floor(($largura_original / $altura_original) * $altura);

                        $nova_altura = $altura ? $altura : floor(($altura_original / $largura_original) * $largura);

                        $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);

                        imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

                        imagepng($imagem_redimensionada,  $pasta . $hashImg .  ".png");

                        "<img src='" .  $pasta . $hashImg  . '.png' . "'>";
                        break;
                endswitch;
            endif;

        endif;

        $_SESSION['msg'] = 'Editado e salvo com sucesso!';

        //    $_SESSION['msg'] = '<script>$(document).ready(function(){$("#exemplomodal").modal("show");})</script>';
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo 'Erro ao atualizar dados da pessoa com ID ' . $pessoa['id'] . ': ' . $e->getMessage() . PHP_EOL . "<br>";
    }

    header("Refresh: 2, ?perfil=$hash");

endif;

if ($acao == "cadastrarGrupo") :
    $pessoas = array(
        'idInstituicao' => $idInstituicao,
        'nome' => (filter_var(htmlspecialchars(strip_tags($nome)))),
        'sigla' => $sigla
    );

    $pdo->beginTransaction();

    $sql = "INSERT INTO grupos (idInstituicao, nome, sigla) VALUES (:idInstituicao, :nome, :sigla)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute($pessoas);
        echo "Dado inserido com sucesso<br>";
    } catch (PDOException $e) {
        echo "Erro ao inserir dado: " . $e->getMessage() . "<br>";
    }
    if ($pdo->commit()) {
        header("Refresh: 2, ?grupos");
        $_SESSION['msg'] = 'Cadastrado com sucesso! A pagina será atualizada';
    } else {
        echo "Erro ao concluir transação<br>";
        $pdo->rollBack();
    }

endif;

if ($acao == "atualizarGrupo") :
    $pdo->beginTransaction();
    $updateStmt = $pdo->prepare("UPDATE grupos SET nome = :nome, sigla = :sigla WHERE id = :id");
    $updateStmt->execute(array(
        ':nome' => $nome,
        ':sigla' => $sigla,
        ':id' => $id
    ));
    if ($pdo->commit()) {
        $_SESSION['msg'] = 'Atualizado com sucesso!';
        header("Refresh: 2, ?grupos");
    } else {
        echo "Erro ao concluir transação<br>";
        $pdo->rollBack();
    }
endif;

if ($acao == "deletarGrupo") :
    $pdo->beginTransaction();
    echo $id;
    $updateStmt = $pdo->prepare("DELETE FROM grupos WHERE id = :id");
    $updateStmt->execute(array(
        ':id' => $id
    ));
    if ($pdo->commit()) {
        $_SESSION['msg'] = 'Deletado com sucesso!';
        header("Refresh: 2, ?grupos");
    } else {
        echo "Erro ao concluir transação<br>";
        $pdo->rollBack();
    }
endif;
