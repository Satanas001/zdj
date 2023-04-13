<?php
    $modalMessage = 'Voulez-vous supprimer « <span class="text-danger fw-semibold">'.$modalDelete['label'].'</span> » ?' ;
    
    if (isset($modalMessageBis)) $modalMessage .= '<p>'.$modalMessageBis.'</p>' ;
?>
<div class="modal fade " id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-bg-danger" id="exampleModalLabel"><i class="fa-solid fa-triangle-exclamation me-2 fa-lg"></i>Suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p><?= $modalMessage ; ?></p>
                <p class="text-danger fw-bold">Attention, cette opération est irrécupérable !</p>
            </div>
            <div class="modal-footer bg-danger bg-opacity-10">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal"><i class="fa-solid fa-times me-2 fa-lg"></i>Annuler</button>
                <a class="btn btn-danger" href="/authors/delete/<?=$modalDelete['code']; ?>"><i class="fa-regular fa-trash-alt me-2 fa-lg"></i>Supprimer</a>
            </div>
        </div>
    </div>
</div>