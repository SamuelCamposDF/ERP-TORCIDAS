<div class="container-fluid">


    <form class="bg-white border rounded-3 p-3 py-3" enctype="multipart/form-data" method="post" action="">
        <input type="hidden" name="menu" value="cadastrar-membros">
        <input type="hidden" name="idInstituicao" value="<?php echo $idInstituicaoLogado ?>">

        <div class="row">


            <div class="col-md-12 col-12 mt-2 mb-2 row" id="">
                <div class="mx-auto col-md-10 col-12">
                    <label style="width: 100%;" for="upload1" class="border rounded bg-light p-3">
                        <p class="text-center">
                            <i class="bi bi-image h3 text-primary"></i> <span class="text-primary">Inserir imagem</span>
                        </p>
                        <div class="mx-auto col-md-5 col-12">
                            <img id="output" style="max-width: 150px;" class="img-fluid text-center col-md-auto">
                        </div>
                    </label>
                    <input style="width: 0px;" required title="" name="arquivo" id="upload1" class="form-control-md" type="file" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                </div>
            </div>


            <div class="col-md-4 mb-2">
                <input type="text" disabled value="<?= $idInstituicaoLogado ?>" class="form-control" placeholder=".">
            </div>

            <div class="col-md-4 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" disabled value="<?= $nomeInstituicao ?>" placeholder=".">
                    <label for="floatingInput">Torcida</label>
                </div>
            </div>

            <div class="col-md-4 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" disabled value="<?= $siglaTorcida ?>" placeholder=".">
                    <label for="floatingInput">Sigla da Torcida</label>
                </div>
            </div>


            <div class="col-md-5 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" required name="nomeMembro" placeholder=".">
                    <label for="floatingInput">Nome completo</label>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" required name="cpfMembro" placeholder=".">
                    <label for="floatingInput">CPF</label>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" required name="dataMembro" placeholder=".">
                    <label for="floatingInput">Data de nascimento</label>
                </div>
            </div>

            <div class="col-md-4 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" required name="maeMembro" placeholder=".">
                    <label for="floatingInput">Nome da mãe</label>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" required name="paiMembro" placeholder=".">
                    <label for="floatingInput">Nome do pai</label>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" required name="profissaoMembro" placeholder=".">
                    <label for="floatingInput">Profissão</label>
                </div>
            </div>

            <div class="col-md-8 mb-2">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" required name="emailMembro" placeholder=".">
                    <label for="floatingInput">E-mail</label>
                </div>
            </div>

            <div class="col-md-4 mb-2">
                <div class="row">
                    <span title="" class="text-primary h6">Acesso ao sistema: </span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="acesso" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Desativar / Ativar</label>
                    </div>
                </div>
            </div>
            <?php if (!empty($todosGrupos)) : ?>

                <div style="overflow-x: scroll; height: 180px;" class="col-md-4 mb-2">
                    <div class="row">
                        <span title="" class="text-primary h6">Grupos: </span>
                        <?php foreach ($todosGrupos as $arr) : ?>
                            <div class="col-md-12 mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="grupoMembro[]" value="<?= $arr ?>" id="inlineRadio<?= $arr ?>">
                                    <label title="Cargos" class="form-check-label" for="inlineRadio<?= $arr ?>">
                                        <?= $arr ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div style="overflow-x: scroll; height: 200px;" class="col-md-4 mb-2">
                <div class="row">
                    <span class="text-primary h6">Cargos: </span>
                    <?php foreach ($CargosTorcida as $arr) : ?>
                        <div class="col-md-12 mb-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cargosMembro[]" value="<?= $arr->nome ?>" id="cargos<?= $arr->nome ?>">
                                <label title="Cargos" class="form-check-label" for="cargos<?= $arr->nome ?>">
                                    <?= $arr->nome ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="mx-auto col-md-2">
            <button type="submit" name="acao" value="cadastrarMembro" class="btn btn-sm btn-success">Cadastrar</button>
        </div>
    </form>
</div>