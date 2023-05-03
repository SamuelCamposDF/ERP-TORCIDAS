<?php

/*
include_once("func_php/session_start.php");
// fChecaJSExt(); // proibe intrusão XSS de javascript
fChecaLogin();
*/

include 'new_conexao.php';
$conexao = conexao::getInstance();

$id = (isset($_GET['user'])) ? $_GET['user'] : '';

$sql = "SELECT * FROM efetivo_beta WHERE id=$id";
$stm = $conexao->prepare($sql);
$stm->execute();
$efetivo = $stm->fetchAll(PDO::FETCH_OBJ);


$sql = "SELECT * FROM beneficiariosefetivo WHERE idUserEfetivo=$id";
$stm = $conexao->prepare($sql);
$stm->execute();
$beneficiarios = $stm->fetchAll(PDO::FETCH_OBJ);


// BUSCA AS SEÇÕES CADASTRADAS NO BANCO DE DADOS
$sql = "SELECT * FROM setor WHERE DSC_DIVISAO = 1 ORDER BY `setor`.`IND_NIVEL` ASC";
$stm = $conexao->prepare($sql);
$stm->execute();
$Setores = $stm->fetchAll(PDO::FETCH_OBJ);
?>

<?php foreach ($efetivo as $resultados) {
    $graduacao = $resultados->pst_grd;
    $nome = $resultados->nome_guerra;
    $ImagemMilitar = $resultados->foto;
    $saram = $resultados->saram;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php if (!empty($efetivo)) : ?>
            <?= $graduacao . " " .  $nome ?>
        <?php endif; ?>
    </title>

    <link rel="shortcut icon" type="image/x-icon" href="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

</head>

<body>

    <nav class="navbar bg-primary bg-body-tertiary">
        <div class="container-fluid">
            <input type="button" class="btn btn-primary btn-sm" id="btnss" value="Voltar" />
            <script>
                function reload() {
                    history.go(-1);
                }
                btnss.onclick = reload;
            </script>

        </div>
    </nav>

    <div class="container">


        <?php
        /* API DE INTEGRAÇÃO COM AS IMAGENS DO PORTAL DO MILITAR */
        $arquivoFotoPortal = file_get_contents("http://api.servicos.ccarj.intraer/sigpesApi/fotoes/" . $saram);
        $imagemPortal = json_decode($arquivoFotoPortal, true);
        foreach ($imagemPortal as $rss) :
            $FotoPerfil = $imagemPortal['imFoto'];
        endforeach;
        ?>

        <div class="mx-auto col-md-2 mb-3 mt-3">
            <img style="" alt="foto" title="Foto do Militar" src="data:image/png;base64,<?php echo $FotoPerfil ?>" width="60%" class="img-fluid border rounded" alt="...">
            <?php if (!empty($efetivo)) : ?>
                <br> <span class="fw-bold text-center text-primary mt-2"> <?= $graduacao . " " .  $nome ?> </span>
            <?php endif; ?>
        </div>


        <?php
        ?>

        <!-- Modal -->
        <?php foreach ($efetivo as $resultado) : ?>
            <?php
            /* API DE INTEGRAÇÃO COM OS DADOS DO PORTAL DO MILITAR */
            $arquivo = file_get_contents("http://api.servicos.ccarj.intraer/sigpesApi/pesfisComgepDws/" . $resultado->saram);
            $json = json_decode($arquivo, true);
            //    var_dump($json);
            //  echo $json['nrOrdem'];
            //   var_dump($arr);
            ?>

            <input class="form-control form-control-sm" value="<?php echo $FotoPerfil ?>" name="arquivo" type="hidden">

            <form class="mt-3 mb-5" method="POST" enctype="multipart/form-data" action="acoes.php">
                <div class="rounded-3 border p-3">
                    <div class="modal-content">
                        <div class="modal-header">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-mil<?= $resultado->id;  ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-mil<?= $resultado->id;  ?>" type="button" role="tab" aria-controls="pills-mil<?= $resultado->id;  ?>" aria-selected="true">Dados</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-home<?= $resultado->id;  ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-home<?= $resultado->id;  ?>" type="button" role="tab" aria-controls="pills-home<?= $resultado->id;  ?>" aria-selected="true">Dados Pessoais</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile<?= $resultado->id;  ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-profile<?= $resultado->id;  ?>" type="button" role="tab" aria-controls="pills-profile<?= $resultado->id;  ?>" aria-selected="false">Dados Bancarios</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-endereco<?= $resultado->id;  ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-endereco<?= $resultado->id;  ?>" type="button" role="tab" aria-controls="pills-endereco<?= $resultado->id;  ?>" aria-selected="false">Endereço</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-beneficiario<?= $resultado->id;  ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-beneficiario<?= $resultado->id;  ?>" type="button" role="tab" aria-controls="pills-beneficiario<?= $resultado->id;  ?>" aria-selected="false">Beneficiário</button>
                                </li>
                            </ul>
                        </div>

                        <div class="modal-body overflow-auto">
                            <div class="container">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-mil<?= $resultado->id;  ?>" role="tabpanel" aria-labelledby="pills-mil<?= $resultado->id;  ?>-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-2 mb-3 border rounded bg-light">
                                                <div class="row">
                                                    <span class="text-primary h4">Divisão: </span>
                                                    <?php foreach ($Setores as $arr) : ?>
                                                        <?php "Divisão: " .  $arr->DSC_SIGLA . " Sub Divisão: "; ?>

                                                        <?php
                                                        $haystacks = $resultado->divisao;
                                                        $needles   = $arr->DSC_SIGLA;
                                                        $poss      = strripos($haystacks, $needles);

                                                        if ($poss === false) : ?>
                                                            <div class="col-md-12 mt-2 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="divisao[]" value="<?= $arr->DSC_SIGLA ?>" id="">
                                                                    <label title="Divisão Atual" class="form-check-label text-primary fw-bold" for="inlineRadio<?= $arr->COD_SETOR ?>" data-bs-toggle="collapse" href="#<?= $arr->DSC_SIGLA ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <?= $arr->DSC_SIGLA ?>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        <?php else : ?>
                                                            <div class="col-md-12 mt-2 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" checked type="checkbox" name="divisao[]" value="<?= $arr->DSC_SIGLA ?>" id="">
                                                                    <label title="Divisão Atual" class="form-check-label text-primary fw-bold" for="inlineRadio<?= $arr->COD_SETOR ?>" data-bs-toggle="collapse" href="#<?= $arr->DSC_SIGLA ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <?= $arr->DSC_SIGLA ?>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        <?php endif; ?>
                                                        <?php
                                                        $sql = "SELECT * FROM setor WHERE COD_SETOR_PAI = $arr->COD_SETOR";
                                                        $stm = $conexao->prepare($sql);
                                                        $stm->execute();
                                                        $filhos = $stm->fetchAll(PDO::FETCH_OBJ);
                                                        ?>
                                                        <div class="collapse" id="<?= $arr->DSC_SIGLA ?>">
                                                            <div class="p-3 bg-white">
                                                                <span class="text-primary">Sub Divisão: </span>
                                                                <?php foreach ($filhos as $arrs) : ?>
                                                                    <?php
                                                                    $haystack = $resultado->divisao;
                                                                    $needle   = $arrs->DSC_SIGLA;
                                                                    $pos      = strripos($haystack, $needle);
                                                                    if ($pos === false) : ?>
                                                                        <div class="col-md-auto mt-2 mb-2">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="divisao[]" value="<?= $arrs->DSC_SIGLA ?>" id="flexCheckDefault<?= $arr->id ?>">
                                                                                <label title="<?= $arrs->DSC_NOME ?>" class="form-check-label" for="">
                                                                                    <?= $arrs->DSC_SIGLA ?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <div class="col-md-auto mt-2 mb-2">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" checked name="divisao[]" value="<?= $arrs->DSC_SIGLA ?>" id="flexCheckDefault<?= $arr->id ?>">
                                                                                <label title="<?= $arrs->DSC_NOME ?>" class="form-check-label" for="">
                                                                                    <?= $arrs->DSC_SIGLA ?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>

                                            <div class="col-md-10 mb-3">
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <input type="text" class="form-control" name="nome_guerra" value="<?= $resultado->nome_guerra  ?>" id="floatingInput" placeholder=".">
                                                            <label for="floatingInput">NOME DE GUERRA</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" name="email" value="<?= $resultado->email  ?>" id="floatingInput" placeholder=".">
                                                            <label for="floatingInput">E-MAIL</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" name="saram" value="<?= $resultado->saram  ?>" id="floatingInput" placeholder=".">
                                                            <label for="floatingInput">SARAM (DADOS DO SIGPES)</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <select class="form-select form-select-sm" name="pst_grd" aria-label=".form-select-sm example" id="setarPostoGraduacao" onchange="PostoGraduacao()">
                                                                <option selected value="<?php echo $json['sgPosto'];  ?>"><?php echo $json['sgPosto'];  ?></option>

                                                            </select>
                                                            <label for="floatingInput">POSTO/GRADUAÇÃO</label>
                                                        </div>
                                                    </div>
                                                    <?php if ($resultado->nivel == 4) : ?>

                                                    <?php endif; ?>
                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <input class="form-control" list="datalistOptions" value="<?php echo $json['sgEspd'];  ?>" name="esp" id="exampleDataList" placeholder="Pesquisando especialidade...">
                                                            <datalist id="datalistOptions">
                                                                <option selected><?php echo $json['sgEspd'];  ?></option>
                                                            </datalist>
                                                            <label for="floatingInput">ESPECIALIDADE</label>
                                                        </div>
                                                    </div>

                                                    <!--
											<div class="col-md-2 mb-3">
												<div class="form-floating form-select-sm">
													<select class="form-select form-select-sm" required name="pst_grd" aria-label=".form-select-sm example" id="setarPostoGraduacao" onchange="PostoGraduacao()">
														<option value="TB">TB</option>
														<option value="MB">MB</option>
														<option value="BR">BR</option>
														<option value="CL">CL</option>
														<option value="TC">TC</option>
														<option value="MJ">MJ</option>
														<option value="CP">CP</option>
														<option value="1T">1T</option>
														<option value="1E">1E</option>
														<option value="2T">2T</option>
														<option value="2E">2E</option>
														<option value="AP">AP</option>
														<option value="I5">I5</option>
														<option value="I4">I4</option>
														<option value="I3">I3</option>
														<option value="C4">C4</option>
														<option value="C3">C3</option>
														<option value="C2">C2</option>
														<option value="C1">C1</option>
														<option value="SO">SO</option>
														<option value="1S">1S</option>
														<option value="2S">2S</option>
														<option value="A3">A3</option>
														<option value="A2">A2</option>
														<option value="A1">A1</option>
														<option value="3S">3S</option>
														<option value="I2">I2</option>
														<option value="I1">I1</option>
														<option value="CB">CB</option>
														<option value="G4">G4</option>
														<option value="GM">GM</option>
														<option value="GS">GS</option>
														<option value="G3">G3</option>
														<option value="G2">G2</option>
														<option value="G1">G1</option>
														<option value="TM">TM</option>
														<option value="P1">P1</option>
														<option value="SE">SE</option>
														<option value="S1">S1</option>
														<option value="T1">T1</option>
														<option value="S2">S2</option>
														<option value="SD">SD</option>
														<option value="T2">T2</option>
														<option value="CO">CO</option>
													</select>
													<label for="floatingInput">POSTO/GRADUAÇÃO (DADOS DO SIGPES)</label>
												</div>
											</div>
										
											<div class="col-md-2 mb-3">
												<div class="form-floating form-select-sm">
													<select class="form-select form-select-sm" required name="nivel" aria-label=".form-select-sm example">
														<option selected></option>
														<option value="1">1- OFICIAL</option>
														<option value="2">2- GRADUADO</option>
														<option value="3">3- PRAÇA</option>
														<option value="4">4- CIVÍL</option>
													</select>
													<label for="floatingInput">HIERÁRQUIA</label>
												</div>
											</div>
											-->

                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <select class="form-select form-select-md" name="esquadrilha" aria-label=".form-select-sm example">
                                                                <option selected value="<?= $resultado->esquadrilha  ?>">
                                                                    <?php if ($resultado->esquadrilha == '2') : ?>
                                                                        Branca
                                                                    <?php elseif ($resultado->esquadrilha == '3') : ?>
                                                                        Verde
                                                                    <?php elseif ($resultado->esquadrilha == '1') : ?>
                                                                        Azul
                                                                    <?php endif; ?>
                                                                </option>
                                                                <option></option>
                                                                <option value="1">AZUL</option>
                                                                <option value="2">BRANCA</option>
                                                                <option value="3">VERDE</option>
                                                            </select>
                                                            <label for="floatingInput">ESQUADRILHA</label>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($json['dtPraca'])) ?>" name="praca" id="data<?= $resultado->id;  ?>" placeholder=".">
                                                            <label for="floatingInput">DATA DE PRAÇA</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($json['dtApresAtual']))  ?>" name="apres" id="apresentacao<?= $resultado->id;  ?>" placeholder=".">
                                                            <label for="floatingInput">DATA DE APRESENTAÇÃO AO CENTRO </label>
                                                        </div>
                                                    </div>

                                                    <div title="DATA ÚLTIMA PROMOÇÃO" class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <input type="text" class="form-control" name="prom" value="<?php echo date('d/m/Y', strtotime($json['dtPromocaoAtual']))  ?>" id="promocao<?= $resultado->id;  ?><br>" placeholder="ULTIMA PROMOÇÃO">
                                                            <label for="floatingInput">DATA ÚLTIMA PROMOÇÃO</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <input type="text" class="form-control" value="<?= $resultado->tel_fun  ?>" name="tel_fun" id="tel_fun<?= $resultado->id;  ?>" placeholder=".">
                                                            <label for="floatingInput">TEL. FUNCIONAL</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <input type="text" class="form-control" value="<?= $resultado->funcao  ?>" name="funcao" placeholder=".">
                                                            <label for="floatingInput">FUNÇÃO</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <textarea style="height: 200px;" type="text" class="form-control" name="inspsau" placeholder="ULTIMA ISPSAU"><?= $resultado->inspsau  ?></textarea>
                                                            <label for="floatingInput">DATA ÚLTIMA INSPSAU</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm">
                                                            <select class="form-select form-select-sm" id="desligamento<?= $resultado->id;  ?>" onchange="updateDesligado<?= $resultado->id;  ?>()">
                                                                <?php if ($resultado->desligamento == 0) : ?>
                                                                    <option class="text-success fw-bold" selected value="0">MILITAR ATIVO</option>
                                                                    <option value="1">DESLIGADO</option>
                                                                <?php elseif ($resultado->desligamento == 1) : ?>
                                                                    <option class="text-danger fw-bold" selected value="1">DESLIGADO</option>
                                                                    <option value="0">ATIVO</option>
                                                                <?php else :  ?>
                                                                    <option></option>
                                                                    <option value="1">DESLIGADO</option>
                                                                    <option selected value="0">ATIVO</option>
                                                                <?php endif; ?>
                                                            </select>
                                                            <label for="floatingInput">SITUAÇÃO ATUAL</label>
                                                        </div>
                                                    </div>


                                                    <script>
                                                        function updateDesligado<?= $resultado->id;  ?>() {
                                                            var select = document.getElementById("desligamento<?= $resultado->id;  ?>");
                                                            var opcaoVlan = select.options[select.selectedIndex].value;
                                                            //console.log(opcaoVlan);
                                                            if (opcaoVlan == '1') { // desligado ou desligar centro
                                                                $('#Desl<?= $resultado->id;  ?>').remove();
                                                                if (!$("#desOn<?= $resultado->id; ?>").length) {
                                                                    $("#DivDesligamento<?= $resultado->id;  ?>").prepend('<div id="desOn<?= $resultado->id; ?>" class="row"><input type="hidden" name="desligamento" value="1"><div class="col-md-6 mb-3"><div class="form-floating"><input type="text" class="form-control dataDes" value="<?= $resultado->data_desligamento; ?>" name="data_desligamento" id="floatingInput" placeholder="."><label for="floatingInput">DATA DE DESLIGAMENTO</label></div></div><div class="col-md-6 mb-3"><div class="form-floating"><textarea type="text" class="form-control" value="<?= $resultado->motivo_desligamento; ?>" name="motivo_desligamento" id="floatingInput" placeholder="."><?= $resultado->motivo_desligamento; ?></textarea><label for="floatingInput">MOTIVO DO DESLIGAMENTO</label></div></div></div>');
                                                                }
                                                                $('.dataDes').mask('99/99/9999');
                                                            } else if (opcaoVlan == '0') { // ativo no centro
                                                                $('#desOn<?= $resultado->id;  ?>').remove();
                                                                if (!$("#Desl").length) {
                                                                    $("#DivDesligamento<?= $resultado->id;  ?>").prepend('<div id="Desl<?= $resultado->id;  ?>"><input type="hidden" name="desligamento" value="0"></div>');
                                                                }
                                                            } else {
                                                                $('#desOn<?= $resultado->id;  ?>').remove();
                                                                $('#Desl<?= $resultado->id;  ?>').remove();
                                                            }
                                                        }
                                                        updateDesligado<?= $resultado->id;  ?>();
                                                    </script>

                                                    <div class="col-md-6 mb-3">
                                                        <div id="DivDesligamento<?= $resultado->id;  ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show" id="pills-home<?= $resultado->id;  ?>" role="tabpanel" aria-labelledby="pills-home<?= $resultado->id;  ?>-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-5 mb-3">
                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control" value="<?= $resultado->nome_completo  ?>" name="nome_completo" id="floatingInput" placeholder=".">
                                                    <label for="floatingInput">NOME COMPLETO</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="cpf" value="<?= $resultado->cpf  ?>" id="floatingInput" placeholder=".">
                                                    <label for="floatingInput">CPF</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" value="<?= $resultado->ident  ?>" name="ident" id="floatingInput" placeholder=".">
                                                    <label for="floatingInput">IDENTIDADE</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($json['dtNasc']))  ?>" name="nasc" id="nascimento<?= $resultado->id;  ?>" placeholder=".">
                                                    <label for="floatingInput">DATA DE NASCIMENTO</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control" value="<?= $resultado->tel_res  ?>" name="tel_res" id="tel_res<?= $resultado->id;  ?>" placeholder=".">
                                                    <label for="floatingInput">TEL. RESIDENCIAL </label>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control" value="<?= $resultado->tel_cel  ?>" name="tel_cel" id="tel_cel<?= $resultado->id;  ?>" placeholder=".">
                                                    <label for="floatingInput">CELULAR</label>
                                                </div>
                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="passaporte" value="<?= $resultado->passaporte  ?>" id="floatingInput" placeholder=".">
                                                    <label for="floatingInput">Nº PASSAPORTE</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="validade" value="<?= $resultado->validade  ?>" id="floatingInput" placeholder=".">
                                                    <label for="floatingInput">VALIDADE</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile<?= $resultado->id;  ?>" role="tabpanel" aria-labelledby="pills-profile<?= $resultado->id;  ?>-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control" name="banco" value="<?= $resultado->banco  ?>" id="floatingInput" placeholder=".">
                                                    <label for="floatingInput">BANCO</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control" name="agencia" value="<?php echo $json['cdAgencia'];  ?>" id="floatingInput" placeholder=".">
                                                    <label for="floatingInput">AGÊNCIA</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control" name="conta" value="<?php echo $json['nrCtaCorr'];  ?>" id="floatingInput" placeholder=".">
                                                    <label for="floatingInput">CONTA</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-endereco<?= $resultado->id;  ?>" role="tabpanel" aria-labelledby="pills-endereco<?= $resultado->id;  ?>-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">

                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control border-primary" name="cep" onblur="pesquisacep(this.value);" value="<?= $resultado->cep  ?>" placeholder=".">
                                                    <label for="floatingInput">CEP</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating form-select-sm">
                                                    <input type="text" class="form-control" name="end_res" id="rua" value="<?= $resultado->end_res  ?>" placeholder=".">
                                                    <label class="text-danger fw-bold" for="floatingInput">ENDEREÇO (COMPLETAR O RESTANTE DOS DADOS)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-beneficiario<?= $resultado->id;  ?>" role="tabpanel" aria-labelledby="pills-beneficiario<?= $resultado->id;  ?>-tab" tabindex="0">

                                        <div class="row">
                                            <?php
                                            $url = 'http://api.servicos.ccarj.intraer/sigpesApi/pesfisComgepDws/' . $resultado->saram .  '/dependentes';
                                            $curl = curl_init($url);
                                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);
                                            $return = curl_exec($curl);
                                            curl_close($curl);
                                            $return; // a tua resposta em string json
                                            $arrResp = json_decode($return, true); // o array criado a partir do json de resposta
                                            $array =  $arrResp['_embedded']['dependentes'];
                                            ?>

                                            <table class="table border rounded">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">Data</th>
                                                        <th scope="col">Cadastro</th>
                                                        <th scope="col">Exclusão</th>
                                                        <th scope="col">Recadastro</th>
                                                        <th title="Estado Civil" scope="col">EstCivil</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $contar = 1;
                                                    foreach ($array as $indice => $teste) : ?>
                                                        <tr>
                                                            <th scope="row">
                                                                <?php echo $contar++ ?>
                                                            </th>
                                                            <td><?php echo  $teste['nmNome']; ?></td>
                                                            <td> <?php echo date('d/m/Y', strtotime($teste['dtNasc'])) ?></td>
                                                            <td> <?php echo date('d/m/Y', strtotime($teste['dtCadastro'])) ?></td>
                                                            <td title="<?php echo $teste['dsMotivoExclusao']; ?>">
                                                                <?php
                                                                if (empty($teste['dtExclusao'])) :
                                                                else :
                                                                    echo date('d/m/Y', strtotime($teste['dtExclusao']));
                                                                endif;
                                                                ?>
                                                            </td>
                                                            <td> <?php
                                                                    echo date('d/m/Y', strtotime($teste['dtRecadastro']));
                                                                    ?>
                                                            </td>
                                                            <td><?php echo  $teste['cdEstCivil']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <span class="text-primary">Dados coletados do SIGPES</span>

                                            <!--
                                            <?php foreach ($beneficiarios as $resultado) : ?>
                                                <div class="row">
                                                    <input type="hidden" name="idBenefef[]" value="<?= $resultado->id ?>">
                                                    <div class="col-md-3 mb-3">
                                                        <div class="form-floating form-select-sm"> <input type="text" class="form-control" name="nomeBenef[]" value="<?= $resultado->nomeBenef ?>" id="floatingInput" placeholder="."> <label for="floatingInput">NOME</label> </div>
                                                    </div>
                                                    <div class="col-md-auto mb-3">
                                                        <div class="form-floating form-select-sm"> <input type="text" class="form-control cpf" name="cpfBenef[]" value="<?= $resultado->cpfBenef ?>" id="floatingInput" placeholder="."> <label for="floatingInput">CPF</label> </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm"> <input type="text" class="form-control" name="identidadeBenef[]" value="<?= $resultado->identidadeBenef ?>" id="floatingInput" placeholder="."> <label for="floatingInput">RG</label> </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-floating form-select-sm"> <input type="text" class="form-control teste" name="nascBenef[]" value="<?= $resultado->nascBenef ?>" id="floatingInput" placeholder="."> <label for="floatingInput">DATA NASCIMENTO</label> </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                            <div class="row">
                                                <div class="col-md-2 mb-3 py-3">
                                                    <button id="addCampo" type="button" class="btn btn-primary">Add</button>
                                                </div>
                                            </div>

                                            <div id="inputs">
                                            </div>

                                            <script>
                                                var contar = 1;
                                                $("#addCampo").click(function() {
                                                    contar++;
                                                    $("#inputs").append(' <div id="adicionado' + contar + '"> <div class="row"> <div class="col-md-3 mb-3"> <div class="form-floating form-select-sm"> <input type="text" required class="form-control" name="nomeBenef[]" id="floatingInput" placeholder="."> <label for="floatingInput">NOME</label> </div></div><div class="col-md-auto mb-3"> <div class="form-floating form-select-sm"> <input type="text" class="form-control cpf" required name="cpfBenef[]" id="floatingInput" placeholder="."> <label for="floatingInput">CPF</label> </div></div><div class="col-md-2 mb-3"> <div class="form-floating form-select-sm"> <input type="text" required class="form-control" name="identidadeBenef[]" id="floatingInput" placeholder="."> <label for="floatingInput">RG</label> </div></div><div class="col-md-2 mb-3"> <div class="form-floating form-select-sm"> <input type="text" class="form-control teste" required name="nascBenef[]" id="floatingInput" placeholder="."> <label for="floatingInput">DATA NASCIMENTO</label> </div></div><div class="col-md-2 mb-3 py-3"> <button id="' + contar + '" type="button" class="btn btn-sm btn-danger btn-apagar">-</button> </div></div></div>');
                                                });

                                                var count = 0;
                                                $("#inputs").on("click", ".btn-apagar", function() {
                                                    var idDoBotao = $(this).attr('id');
                                                    $('#adicionado' + idDoBotao + '').remove();
                                                });
                                            </script>

                                            -->
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $resultado->id;  ?>">

                            <a type="button" onclick="SairUser()" class="btn btn-sm btn-secondary me-3">Sair</a>
                            <button type="submit" name="acao" value="atualizarUser" class="btn btn-sm btn-primary text-white me-3">Salvar</button>
                            <button type="submit" name="acao" value="DeletUser" class="btn btn-sm btn-danger text-white">Deletar User</button>

                        </div>
                    </div>
                </div>


                <script>
                    function SairUser() {
                        location.assign("efetivo.php", 'black_content');
                    }
                </script>


            </form>



            <script language="javascript">
                $(document).ready(function() {
                    $('#data<?= $resultado->id;  ?>').mask('99/99/9999');
                    $('#praca<?= $resultado->id;  ?>').mask('99/99/9999');
                    $('#apresentacao<?= $resultado->id;  ?>').mask('99/99/9999');
                    $('#promocao<?= $resultado->id;  ?>').mask('99/99/9999');
                    $('#inspsau<?= $resultado->id;  ?>').mask('99/99/9999');
                    $('#nascimento<?= $resultado->id;  ?>').mask('99/99/9999');
                    $('#tel_res<?= $resultado->id;  ?>').mask('(99) 99999-9999');
                    $('#tel_cel<?= $resultado->id;  ?>').mask('(99) 99999-9999');
                    $('#tel_fun<?= $resultado->id;  ?>').mask('(99) 99999-9999');
                    return false;
                });
            </script>
        <?php endforeach; ?>
    </div>

    <script src="efetivo.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</body>

</html>