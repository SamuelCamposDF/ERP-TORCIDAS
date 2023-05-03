<div class="col-md-12">
    <?php
    if (!isset($_SESSION['msg'])) {
    } else {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
</div>



<?php if (empty($membrosCadastrados)) : ?>
    <div class="mx-auto col-md-7">
        <span class="h3">Não existem membros cadastrados</span>
    </div>
    <div class="container mx-5 me-2 row p-3">
        <div class="col-sm-3"><a href="?cadastrar-membros" class="btn btn-sm btn-primary shadow"> Cadastrar Membro</a></div>
    </div>
<?php else : ?>


    <div class="container mx-5 me-2 row p-3">
        <div class="col fw-bold">Membros</div>
        <div class="col-sm-3"><a href="?cadastrar-membros" class="btn btn-sm btn-primary shadow"> Cadastrar Membro</a></div>
    </div>
    <div class="mt-3 py-3 border rounded-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Bonde</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($membrosCadastrados as $i => $resultado) : ?>
                    <?php
                    "Indice =>" . $i . "<br>";
                    $sql = "SELECT * FROM grupomembros WHERE idMembro = $resultado->id";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $bonde = $stm->fetchAll(PDO::FETCH_OBJ);
                    $arrBondeMembro = '';
                    foreach ($bonde as $arrBonde) {

                        $sql = "SELECT * FROM grupos WHERE id = $resultado->id";
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $bondes = $stm->fetchAll(PDO::FETCH_OBJ);
                        foreach ($bondes as $arrBondes) {
                            $arrBondeMembro = $arrBondes->nome;
                        }
                    }

                    $arrPmember[] = array(
                        "idMembro" => $resultado->id,
                        "nomeMembro" => $resultado->nomeMembro,
                        "idTo" => $idInstituicaoLogado,
                        "Torcida" => $nomeInstituicao,
                        "Bonde" =>  $arrBondeMembro
                        //    "Cargos" =>  $arrCargosMembros[$i]
                    );
                    ?>
                    <tr>
                        <th scope="row"><?= $resultado->id;  ?></th>
                        <td>
                            <a href="?perfil=<?= $resultado->hash ?>">
                                <?= $resultado->nomeMembro;  ?>
                            </a>
                        </td>
                        <td>
                            <?= $resultado->contatoMembro;  ?>
                        </td>
                        <td>
                            <?= $resultado->emailMembro;  ?>
                        </td>
                        <td><?= $arrBondeMembro;  ?></td>

                        <td> <?= $resultado->status;  ?></td>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>