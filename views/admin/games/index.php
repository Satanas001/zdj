<section class="mt-4">
    <h1 class="mb-2"><?= $game->article . $game->title; ?></h1>
    <?php 
        if (isset($toolBar)) {
            echo $toolBar ; 
        } 
    ?>  
    <section class="clearfix mt-3 mb-2">
        <img src="/assets/images/games/<?= $game->image; ?>" alt="boite du jeu <?= $game->article . $game->title; ?>" title="<?= $game->article . $game->title; ?>" class="img-fluid me-3 mb-2 img-thumbnail float-start shadow-sm" />
        <div class="mb-2 p-3">
            <span class="text-success h3 me-4 fw-normal" title="Joueurs"><i class="fa-solid fa-users me-1"></i><?= $game->players_min, $game->players_min != $game->players_max ? ' - ' . $game->players_max : ''; ?></span>
            <span class="text-danger h3 me-4 fw-normal" title="A partir de"><i class="fa-solid fa-birthday-cake me-1"></i><?= $game->age; ?>+</span>
            <span class="text-warning h3 me-4 fw-normal" title="Durée"><i class="fa-solid fa-stopwatch me-1"></i><?= $game->duration_min, $game->duration_min != $game->duration_max ? ' - ' . $game->duration_max : ''; ?>&rsquo;</span>
            <?= $game->melodice ? '<a href="'.$game->melodice.'" target="_blank" class="" ><span class="h3 fw-normal" title="Melodice"><i class="border border-primary p-2 rounded-circle shadow-sm bg-info bg-opacity-25 fa-solid fa-music"></i></a>' : '' ;?>
            <?php if (!$game->active) : ?>
                <span class="float-end ms-3">
                    <span class="py-1 px-4 bg-danger bg-opacity-25 text-danger h5 border border-danger rounded-4 shadow-sm"><i class="fa-solid fa-exclamation-triangle me-3"></i>Brouillon</span>
                </span>
            <?php else : ?>
                <span class="float-end ms-3">
                    <span class="py-1 px-4 bg-success bg-opacity-25 text-success h5 border border-success rounded-4 shadow-sm"><i class="fa-solid fa-check me-3"></i>En ligne</span>
                </span>
            <?php endif; ?>
        </div>
        <div class="mb-2">
            <?php if ($authors) : ?>
                <div>
                    <i class="fa-solid fa-pen-alt text-primary me-1"></i>
                    <?php 
                        $authorString = '' ;
                        
                        foreach ($authors as $author) {
                            $authorString .= $author->first_name.$author->last_name . ', ' ;
                        }

                        echo substr($authorString, 0, -2) ;
                    ?>
                </div>
            <?php endif; ?>
            <?php if ($illustrators) : ?>
                <div>
                    <i class="fa-solid fa-paint-brush text-primary me-1"></i>
                    <?php 
                        $authorString = '' ;
                        
                        foreach ($illustrators as $illustrator) {
                            $authorString .= $illustrator->first_name.$illustrator->last_name . ', ' ;
                        }

                        echo substr($authorString, 0, -2) ;
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($publishers) : ?>
            <div class="row g-2 mb-2">
                <?php foreach ($publishers as $publisher) : ?>
                    <div class="col-auto">
                        <div class="position-relative text-center">
                            <?php if ($publisher->image) : ?>
                                <img src="/assets/images/publishers/<?= $publisher->image; ?>" alt="<?= $publisher->name ; ?>" class="image-64" title="<?= $publisher->name ; ?>" />
                            <?php else : ?>
                                <i class="fa-solid fa-camera text-primary fa-4x opacity-25 "></i>
                                <div class="position-absolute bottom-0 w-100 fw-bold"><?= $publisher->name ; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <section class="row">
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" id="generalTab" data-bs-toggle="tab" data-bs-target="#general" role="tab" aria-controls="general" aria-selected="true">Intro</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link <?= !$components ? 'disabled' : '' ?>" id="contentsTab" data-bs-toggle="tab" data-bs-target="#contents" role="tab" aria-controls="contents" aria-selected="false">Contenu</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link <?= !$rules ? 'disabled' : '' ?>" id="rulesTab" data-bs-toggle="tab" data-bs-target="#rules" role="tab" aria-controls="rules" aria-selected="false">Règles</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link <?= !$files ? 'disabled' : '' ?>" id="filesTab" data-bs-toggle="tab" data-bs-target="#files" role="tab" aria-controls="files" aria-selected="false">Fichiers</button>
            </li>
        </ul>
        <div class="tab-content " id="myTabContent">
            <div class="tab-pane fade pt-2 show active" id="general" role="tabpanel" aria-labelledby="generalTab">
                <?php include 'game_intro.php'; ?>
            </div>
            <div class="tab-pane fade pt-2" id="contents" role="tabpanel" aria-labelledby="contentsTab">
                <?php include 'game_contents.php'; ?>
            </div>
            <div class="tab-pane fade pt-2" id="rules" role="tabpanel" aria-labelledby="rulesTab">
                <?php include 'game_rules.php'; ?>
            </div>
            <div class="tab-pane fade pt-2" id="files" role="tabpanel" aria-labelledby="filesTab">
                <?php include 'game_files.php'; ?>
            </div>
        </div>
    </section>
</section>