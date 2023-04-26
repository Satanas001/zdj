<?php
// $availableIllustrators = $authorManager->getIllustratorListNotInGame($game) ;
?>
<section>
    <h2 class="text-primary"><i class="fa-solid fa-pen-alt me-2"></i>Auteurs</h2>
    <div class="mb-3 h4" id="gameAuthors">
        <?php if ($authors) :
            foreach ($authors as $author) : ?>
                <span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal me-3 mb-1"><?= $author->first_name, $author->last_name; ?><button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete('/ajax/deleteGameAuthor/<?= $game->id * 10000 + $author->id; ?>');"></button></span>
        <?php endforeach;
        endif; ?>
    </div>
    <div class="row g-2 px-2 pb-2 bg-primary bg-opacity-10">
        <div class="col-auto" id="availableAuthors">
            <select class="form-select" id="selectAuthors">
                <?php
                if (count($availableAuthors)) {
                    foreach ($availableAuthors as $available) {
                        $authorName = mb_strtoupper($available->last_name).($available->first_name ? ', '.$available->first_name : '') ;
                        echo '<option value="', ($game->id * 10000 + $available->id), '">', $authorName, '</option>' ;
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <span class="btn btn-danger" onclick="html_requete('/ajax/addGameAuthor/'+document.getElementById('selectAuthors').value);"><i class="fa-solid fa-plus"></i></span>
        </div>
    </div>
</section>
<hr>
<section>
    <h2 class="text-primary"><i class="fa-solid fa-paint-brush me-2"></i>Illustrateurs</h2>
    <div class="mb-3 h4" id="gameIllustrators">
        <?php if ($illustrators) :
            foreach ($illustrators as $illustrator) : ?>
                <span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal me-3 mb-1"><?= $illustrator->first_name, $illustrator->last_name; ?><button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete('/ajax/deleteGameIllustrator/<?= $game->id * 10000 + $illustrator->id; ?>');"></button></span>
        <?php endforeach;
        endif; ?>
    </div>
    <div class="row g-2 px-2 pb-2 bg-primary bg-opacity-10">
        <div class="col-auto" id="availableIllustrators">
            <select class="form-select" id="selectIllustrators">
            <?php
                if (count($availableIllustrators)) {
                    foreach ($availableIllustrators as $available) {
                        $illustratorName = mb_strtoupper($available->last_name).($available->first_name ? ', '.$available->first_name : '') ;
                        echo '<option value="', ($game->id * 10000 + $available->id), '">', $illustratorName, '</option>' ;
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <span class="btn btn-danger" onclick="html_requete('/ajax/addGameIllustrator/'+document.getElementById('selectIllustrators').value);"><i class="fa-solid fa-plus"></i></span>
        </div>
    </div>
</section>
<script>
    
</script>