<?php if (empty($CargosTorcida)) : ?>
    <div class="mx-auto col-md-7">
        <span class="h3">Não existem cadastrados</span>
    </div>
    <div class="container mx-5 me-2 row p-3">
        <div class="col-sm-3">
            <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm btn-primary shadow"> Cadastrar </a>
        </div>
    </div>

<?php else : ?>

    <?php


    $deletar = (isset($_POST['deletar'])) ? $_POST['deletar'] : '';
    $editar = (isset($_POST['editar'])) ? $_POST['editar'] : '';

    if (!empty($deletar)) :
    endif;

    if (!empty($editar)) :
        $IdRecebido = $editar;
        $sql = "SELECT * FROM cargos WHERE id = $IdRecebido";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $CargoEdit = $stm->fetchAll(PDO::FETCH_OBJ);

        if (!empty($CargoEdit)) :
            if ($_SERVER['REQUEST_METHOD'] === 'POST') :
                echo '<script>$(document).ready(function(){$("#ModalEditar").modal("show");})</script>';
            endif;
        endif;
        foreach ($CargoEdit as $arr) {
            $nomeCargo = $arr->nome;
        }

    else :
        $IdRecebido = null;
    endif;

    ?>

    <form id="cadastrar" action="#" method="POST">
        <div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar cargo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control mb-3" value="<?= $idInstituicaoLogado ?>" name="Instituicao" placeholder=".">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" value="<?= $nomeCargo ?>" name="nome" placeholder=".">
                            <label for="nome">Nome do Cargo</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?php echo $IdRecebido ?>">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="acao" value="atualizarCargo" class="btn btn-sm btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="container mx-5 me-2 row p-3">
        <div class="col fw-bold">Grupos</div>
        <div class="col-sm-3">
            <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm btn-primary shadow"> Cadastrar </a>
        </div>
    </div>



    <div class="mx-auto mt-3 py-3 border rounded-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($CargosTorcida as $i => $resultado) : ?>
                    <tr>
                        <th scope="row"><?= $resultado->id;  ?></th>
                        <td>
                            <a>
                                <?= $resultado->nome;  ?>
                            </a>
                        </td>

                        <td>

                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="idGp" value="<?= $resultado->id;  ?>">
                                <input type="hidden" name="id" value="<?= $resultado->id;  ?>">
                                <button class="btn btn" name="acao" value="deletarGrupo" type="submit"><i class="bi bi-trash"></i></button>
                                <button class="btn btn" name="editar" value="<?= $resultado->id;  ?>" type="submit"><i class="bi bi-pencil-square"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>


<form id="cadastrar" action="#" method="POST">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Cargo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" value="<?= $idInstituicaoLogado ?>" name="idInstituicao" placeholder=".">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nome" placeholder=".">
                        <label for="nome">Nome do Cargo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="acao" value="cadastrarCargo" class="btn btn-sm btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</form>