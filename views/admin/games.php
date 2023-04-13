<section class="mt-4">
    <h1 class="">Jeux<span class="small ms-2 "><sup class="badge rounded-pill bg-info pb-1 pt-0 px-2"><?= numberFormat($nbGames); ?></sup></span></h1>
    <?php
    if (isset($toolBar)) {
        echo $toolBar;
    }
    ?>
    <?php if (!empty($initials) && count($initials) >= 2) : ?>
        <section id="alphabet" class="border-bottom mb-3 pb-1">
            <?php foreach ($initials as $initial) :
                $active = isset($activeInitial) && $activeInitial == $initial->initial ? ' bg-primary bg-opacity-25' : '';
            ?>

                <a href="/admgames/filter/<?= $initial->initial; ?>" class="btn <?= $active; ?>"><?= $initial->initial; ?></a>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
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
                            <th class="text-center"><i class="fa-solid fa-music" title="Melodice"></i></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($games) :
                            foreach ($games as $game) : ?>
                                <tr>
                                    <td><a href="/admgames/view/<?= $game->id ;?>" class="d-block"><img src="/assets/images/games/<?= $game->image; ?>" alt="boite du jeu <?= $game->article . $game->title; ?>" class="image-24 me-2"><?= $game->article, $game->title ?></a></td>
                                    <td class="text-center"><?= $game->players_min, $game->players_min != $game->players_max ? '-' . $game->players_max : ''; ?></td>
                                    <td class="text-center"><?= $game->age; ?>+</td>
                                    <td class="text-center"><?= $game->duration_min, $game->duration_min != $game->duration_max ? ' - ' . $game->duration_max : ''; ?>&rsquo;</td>
                                    <td class="text-center">
                                        <?= $game->melodice ? '<span class="text-primary"><i class="fa-solid fa-music"></i>' : '' ; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $game->active ? '<span class="text-success"><i class="fa-solid fa-check"></i>' : '<span class="text-danger"><i class="fa-solid fa-times"></i>' ; ?>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else : ?>
                            <tr>
                                <td colspan="4" class="text-danger fw-bold"><i class="fa-solid fa-exclamation-circle me-1"></i>Aucun jeu</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>