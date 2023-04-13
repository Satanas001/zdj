<section class="mt-4">
    <h1 class="text-primary mb-4">Liste des jeux</h1>
    <?php if (!empty($initials) && count($initials) >= 2) : ?>
        <section id="alphabet" class="border-bottom mb-3 pb-1">
            <?php foreach ($initials as $initial) : 
                    $active = isset($activeInitial) && $activeInitial == $initial->initial ? ' bg-primary bg-opacity-25' : '' ;
            ?>

                <a href="/games/filter/<?= $initial->initial ; ?>" class="btn <?= $active ; ?>"><?= $initial->initial ; ?></a>
            <?php endforeach ; ?>
        </section>
    <?php endif ; ?>
    <section>
        <?php if ($games) : ?>
            <?php foreach ($games as $game) : ?>
                <article class="border p-3 mb-3 bg-light bg-opacity-25">
                    <a href="/games/game/<?= $game->id, '/', urlTitle($game->title); ?>" class="text-decoration-none d-block">
                        <h2 class="text-primary"><?= $game->article . $game->title; ?></h2>
                        <div>
                            <img src="/assets/images/games/<?= $game->image; ?>" alt="boite du jeu <?= $game->article . $game->title; ?>" class="image-64 me-4">
                            <span class="text-success h5 me-4"><i class="fa-solid fa-users me-1" title="Joueurs"></i>
                                <?= $game->players_min, $game->players_min != $game->players_max ? ' - ' . $game->players_max : ''; ?>
                            </span>
                            <span class="text-danger h5 me-4"><i class="fa-solid fa-birthday-cake me-1" title="A partir de"></i><?= $game->age; ?>+</span>
                            <span class="text-warning h5 me-4"><i class="fa-solid fa-stopwatch me-1" title="Durée"></i>
                                <?= $game->duration_min, $game->duration_min != $game->duration_max ? ' - ' . $game->duration_max : ''; ?>&rsquo;</span>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        <?php else : ?>
            <article class="alert alert-danger shadow-sm fs-6">
                <div>Aucun jeu dans la base.</div>
            </article>
        <?php endif ; ?>
    </section>
</section>