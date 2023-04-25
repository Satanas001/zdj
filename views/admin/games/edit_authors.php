<?php
    // $availableAuthors = $authorManager->getAuthorListNotInGame($game) ;
    // $availableIllustrators = $authorManager->getIllustratorListNotInGame($game) ;
?>
<section>
    <h2 class="text-primary"><i class="fa-solid fa-pen-alt me-2"></i>Auteurs</h2>
    <div class="mb-3 h4" id="gameAuthors">
        <?php
            // if (count($game->getAuthors())) {
            //     foreach ($game->getAuthors() as $author) {
            //         echo '<span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal me-3 mb-1">', $author->getName(), '<button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete(\'ajax/game_author_delete.php?gameId=', $code, '&authorId=', $author->getAuthorId(), '\');"></button></span>';
            //     }
            // }
        ?>
    </div>
    <div class="row g-2 px-2 pb-2 bg-primary bg-opacity-10">
        <div class="col-auto" id="availableAuthors">
            <select class="form-select" id="selectAuthors">
                <?php
                    // if (count($availableAuthors)) {
                    //     foreach ($availableAuthors as $available) {
                    //         $authorName = mb_strtoupper($available->getLastName()).($available->getFirstName() ? ', '.$available->getFirstName() : '') ;
                    //         echo '<option value="', $available->getAuthorId(), '">', $authorName, '</option>' ;
                    //     }
                    // }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <span class="btn btn-danger" onclick="html_requete('ajax/game_author_add.php?gameId=<?= $code ; ?>&authorId='+document.getElementById('selectAuthors').value);"><i class="fa-solid fa-plus"></i></span>
        </div>
    </div>
</section>
<hr>
<section>
    <h2 class="text-primary"><i class="fa-solid fa-paint-brush me-2"></i>Illustrateurs</h2>
    <div class="mb-3 h4" id="gameIllustrators">
        <?php
            // if (count($game->getIllustrators())) {
            //     foreach ($game->getIllustrators() as $author) {
            //         echo '<span class="badge rounded-pill text-bg-secondary bg-opacity-75 fw-normal me-3 mb-1">', $author->getName(), '<button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete(\'ajax/game_illustrator_delete.php?gameId=', $code, '&authorId=', $author->getAuthorId(), '\');"></button></span>';
            //     }
            // }
        ?>
    </div>
    <div class="row g-2 px-2 pb-2 bg-primary bg-opacity-10">
        <div class="col-auto" id="availableIllustrators">
            <select class="form-select" id="selectIllustrators">
                <?php
                    // if (count($availableIllustrators)) {
                    //     foreach ($availableIllustrators as $available) {
                    //         $authorName = mb_strtoupper($available->getLastName()).($available->getFirstName() ? ', '.$available->getFirstName() : '') ;
                    //         echo '<option value="', $available->getAuthorId(), '">', $authorName, '</option>' ;
                    //     }
                    // }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <span class="btn btn-danger" onclick="html_requete('ajax/game_illustrator_add.php?gameId=<?= $code ; ?>&authorId='+document.getElementById('selectIllustrators').value);"><i class="fa-solid fa-plus"></i></span>
        </div>
    </div>
</section>