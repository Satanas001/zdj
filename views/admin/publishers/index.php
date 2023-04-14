<section class="mt-4">
    <h1 class=""><?= $publisher->name ; ?><span class="small ms-2 "><sup class="badge rounded-pill bg-info pb-1 pt-0 px-2"><?= numberFormat(count($games)) ; ?></sup></span></h1>
    <?php 
        if (isset($toolBar)) {
            echo $toolBar ; 
        } 
    ?>
    <section class="">
        <img src="/assets/images/publishers/<?= $publisher->image ; ?>" alt="Logo de <?= $publisher->name ; ?>" class="img-thumbnail">
    </section>
    <section class="row mt-3">
        <div class="col-auto">
            <div class="card shadow-sm mb-3">
                <table class="table table-striped table-hover table-sm mb-0">
                    <thead>
                        <tr class="bg-primary bg-opacity-25 text-primary">
                            <th>Jeu</th>
                            <th class="text-center"><i class="fa-solid fa-users" title="Joueurs"></i></th>
                            <th class="text-center"><i class="fa-solid fa-birthday-cake" title="A partir de"></i></th>
                            <th class="text-center"><i class="fa-solid fa-stopwatch" title="Durée"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($games) :
                            foreach ($games as $game): ?>
                            <tr>
                                <td><img src="/assets/images/games/<?= $game->image; ?>" alt="boite du jeu <?= $game->article . $game->title; ?>" class="image-24 me-2"><?= $game->article, $game->title ?></td>
                                <td class="text-center"><?= $game->players_min, $game->players_min != $game->players_max ? '-' . $game->players_max : ''; ?></td>
                                <td class="text-center"><?= $game->age; ?>+</td>
                                <td class="text-center"><?= $game->duration_min, $game->duration_min != $game->duration_max ? ' - ' . $game->duration_max : ''; ?>&rsquo;</td>
                            </tr>
                        <?php endforeach ; 
                        else : ?>
                            <tr><td colspan="4" class="text-danger fw-bold"><i class="fa-solid fa-exclamation-circle me-1"></i>Aucun jeu</td></tr>
                        <?php endif ;?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>
<?php
    include 'components/modalDelete.php' ;