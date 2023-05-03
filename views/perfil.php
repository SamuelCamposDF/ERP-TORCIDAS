<div class="container-fluid mb-5">
    <?php if (!empty($dadosMembro)) : ?>

        <form class="bg-white border rounded-3 p-3 py-3" enctype="multipart/form-data" method="post" action="#">
            <input type="hidden" name="menu" value="cadastrar-membros">
            <input type="hidden" name="idTorcida" value="<?php echo $idInstituicaoLogado ?>">
            <input type="hidden" name="imagem" value="<?php echo $dadosMembro->imagem ?>">
            <input type="text" name="idMembro" value="<?php echo $dadosMembro->id ?>">
            <input type="text" name="hash" value="<?php echo $dadosMembro->hash ?>">

            <div class="row">
                <div class="col-md-12 col-12 mt-2 mb-2 row" id="">
                    <div class="mx-auto col-md-10 col-12">
                        <label style="width: 100%;" for="upload1" class="p-3">
                            <p class="text-center">
                                <img id="output" src="./views/imagens/<?php echo $dadosMembro->imagem; ?>" style="max-width: 150px;" class="border rounded img-fluid text-center col-md-auto">
                            </p>
                            <div class="mx-auto col-md-5 col-12">
                                <img id="output" style="max-width: 150px;" class="img-fluid text-center col-md-auto">
                            </div>
                        </label>
                        <input style="width: 0px;" title="" name="arquivo" id="upload1" class="form-control-md" type="file" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                </div>

                <div class="col-md-4 col-6 mb-2">
                    <input type="text" disabled value="<?= $idInstituicaoLogado ?>" class="form-control" placeholder=".">
                </div>

                <div class="col-md-12 col-6 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" disabled value="<?= $nomeInstituicao ?>" placeholder=".">
                        <label for="floatingInput">Torcida</label>
                    </div>
                </div>

                <div class="col-md-4 col-6 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" disabled value="<?= $siglaTorcida ?>" placeholder=".">
                        <label for="floatingInput">Sigla da Torcida</label>
                    </div>
                </div>

                <div class="col-md-4 col-12 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="<?php echo $dadosMembro->nomeMembro; ?>" name="nomeMembro" placeholder=".">
                        <label for="floatingInput">Nome completo</label>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="cpfMembro" value="<?php echo $dadosMembro->cpfMembro; ?>" placeholder=".">
                        <label for="floatingInput">CPF</label>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" value="<?php echo $dadosMembro->dataMembro; ?>" name="dataMembro" placeholder=".">
                        <label for="floatingInput">Data de nascimento</label>
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="<?php echo $dadosMembro->maeMembro; ?>" name="maeMembro" placeholder=".">
                        <label for="floatingInput">Nome da mãe</label>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="paiMembro" value="<?php echo $dadosMembro->paiMembro; ?>" placeholder=".">
                        <label for="floatingInput">Nome do pai</label>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="profissaoMembro" value="<?php echo $dadosMembro->profissaoMembro; ?>" placeholder=".">
                        <label for="floatingInput">Profissão</label>
                    </div>
                </div>
                <div class="col-md-8 mb-2">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" required name="emailMembro" value="<?php echo $dadosMembro->emailMembro; ?>" placeholder=".">
                        <label for="floatingInput">E-mail</label>
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="row">
                        <span title="" class="h6">Acesso ao sistema: </span>
                        <div class="form-check form-switch">
                            <input onclick="return confirm('você deseja alterar essa opção?')" class="form-check-input" <?php if ($dadosMembro->acesso == 0) : elseif ($dadosMembro->acesso == 1) :  echo "checked";
                                                                                                                        endif; ?> type="checkbox" name="acesso" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" title="Essa opção dar acesso do membro ao sistema se ele tiver uma senha cadastrada" for="flexSwitchCheckDefault">Desativar / Ativar</label>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 mb-2">
                    <div class="row">
                        <span class="h6">Grupo: </span>

                        <?php $iguais = array_intersect($todosGrupos, $gruposM); ?>
                        <?php $diferentes = array_diff($todosGrupos, $gruposM); ?>

                        <?php foreach ($iguais as $i) : ?>
                            <div class="col-md-12 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" checked type="checkbox" name="grupoMembro[]" value="<?= $i ?>" id="">
                                    <label title="Grupo Atual" class="form-check-label fw-bold" for="inlineRadio<?= $i ?>">
                                        <?= $i ?>
                                    </label>
                                </div>
                            </div>

                        <?php endforeach; ?>

                        <?php foreach ($diferentes as $g) : ?>
                            <div class="col-md-12 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="grupoMembro[]" value="<?= $g ?>" id="">
                                    <label title="Grupo Atual" class="form-check-label" for="inlineRadio<?= $g ?>">
                                        <?= $g ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>


                <div class="col-md-4 mb-2">
                    <div class="row">
                        <span class="h6">Cargos: </span>

                        <?php $iguais = array_intersect($todos, $cargo); ?>
                        <?php $diferentes = array_diff($todos, $cargo); ?>

                        <?php foreach ($iguais as $i) : ?>
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" checked type="checkbox" name="cargosMembro[]" value="<?= $i ?>" id="">
                                    <label title="Cargo Atual" class="form-check-label fw-bold" for="inlineRadio<?= $i ?>">
                                        <?= $i ?>
                                    </label>
                                </div>
                            </div>

                        <?php endforeach; ?>
                        <?php foreach ($diferentes as $d) : ?>
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cargosMembro[]" value="<?= $d ?>" id="">
                                    <label title="Cargo Atual" class="form-check-label" for="inlineRadio<?= $d ?>">
                                        <?= $d ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>


            </div>
            <div class="mx-auto col-md-2">
                <button type="submit" name="acao" value="editarMembro" class="btn btn-sm btn-success">Salvar</button>
            </div>
        </form>
</div>

<?php endif; ?>