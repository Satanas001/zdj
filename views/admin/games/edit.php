<section class="mt-4">
    <h1><?= $game->article, $game->title; ?><span class="small ms-3 text-muted">- Modification</span></h1>
    <section class="row">
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" id="generalTab" data-bs-toggle="tab" data-bs-target="#general" role="tab" aria-controls="general" aria-selected="true">Infos</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" id="authorsTab" data-bs-toggle="tab" data-bs-target="#authors" role="tab" aria-controls="authors" aria-selected="true">Auteurs</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" id="publishersTab" data-bs-toggle="tab" data-bs-target="#publishers" role="tab" aria-controls="publishers" aria-selected="true">Editeurs</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" id="contentsTab" data-bs-toggle="tab" data-bs-target="#contents" role="tab" aria-controls="contents" aria-selected="false">Contenu</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" id="rulesTab" data-bs-toggle="tab" data-bs-target="#rules" role="tab" aria-controls="rules" aria-selected="false">Règles</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" id="filesTab" data-bs-toggle="tab" data-bs-target="#files" role="tab" aria-controls="files" aria-selected="false">Fichiers</button>
            </li>
        </ul>
        <div class="tab-content " id="myTabContent">
            <div class="tab-pane fade pt-2 show active" id="general" role="tabpanel" aria-labelledby="generalTab">
                <div class="row">
                    <div class="col-auto">
                        <?= $form ; ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade pt-2" id="authors" role="tabpanel" aria-labelledby="authorsTab">
                <?php include 'edit_authors.php'; ?>
            </div>
            <div class="tab-pane fade pt-2" id="publishers" role="tabpanel" aria-labelledby="publishersTab">
                <!-- <?php include 'edit_infos.php'; ?> -->
            </div>
            <div class="tab-pane fade pt-2" id="contents" role="tabpanel" aria-labelledby="contentsTab">

            </div>
            <div class="tab-pane fade pt-2" id="rules" role="tabpanel" aria-labelledby="rulesTab">

            </div>
            <div class="tab-pane fade pt-2" id="files" role="tabpanel" aria-labelledby="filesTab">

            </div>
        </div>
    </section>
</section>
<script type="text/javascript">
    document.getElementById('title').select();
</script>