<?php
// $availablePublisherss = $publishersManager->getListNotInGame($game) ;
?>
<div class="mb-3 bg-primary p-2 bg-opacity-10">
    <form name="addFile" method="post" class="d-inline" action="ajax/file_add.php" enctype="multipart/form-data">
        <div class="row g-2">
            <div class="col-auto" id="availablePublishers">
                <select class="form-select" id="selectPublishers" onkeyup="if (event.keyCode == 13) html_requete('/ajax/addGamePublisher/'+this.value);">
                    <?php
                    if (count($availablePublishers)) {
                        foreach ($availablePublishers as $available) {
                            echo '<option value="', ($game->id * 10000 + $available->id), '">', $available->name, '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-auto">
                <span class="btn btn-danger" onclick="html_requete('/ajax/addGamePublisher/'+document.getElementById('selectPublishers').value);"><i class="fa-solid fa-plus"></i></span>
            </div>
        </div>
    </form>
</div>
<div class="row g-2" id="gamePublishers">
    <?php
    if ($publishers) :
        foreach ($publishers as $publisher) :
    ?>
            <div class="col-auto">
                <div class="text-center">
                    <img src="/assets/images/publishers/<?= $publisher->image; ?>" class="image-64">
                </div>
                <div class="px-3 text-center h5">
                    <span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal mb-1"><?= $publisher->name; ?><button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete('/ajax/deleteGamePublisher/<?= $game->id * 10000 + $publisher->id; ?>');"></button></span>
                </div>
            </div>
    <?php
        endforeach;
    endif;
    ?>
</div>