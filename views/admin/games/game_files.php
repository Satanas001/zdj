<article class="row g-3">
    <?php 
        foreach ($files as $file) : 
            if (file_exists('./assets/pdf/' . $file->file_name)) {
                $fileSize = filesize('./assets/pdf/' . $file->file_name);
            } 
            else {
                $fileSize = 0;
            }

            $fileSizeLabel = $fileSize ? ' <em>(' . fileSizeFormat($fileSize) . ')</em>' : '';
        ?>

        <article class="col-auto">
            <?php if ($file->image) : ?>
                <figure class="card shadow-sm p-1">
                    <a href="/assets/pdf/<?= $file->file_name; ?>" target="_blank"><img src="/assets/images/files/<?= $file->image; ?>" alt="<?= $game->article.$game->title.' : '.$file->designation ; ?>" class="image-256"></a>
                    <figcaption class="small text-center text-muted"><?= $file->designation . $fileSizeLabel; ?></figcaption>
                </figure>
            <?php else : ?>
                <div class="card shadow-sm p-1">
                    <div class="h4 text-center text-danger">
                        <a href="/assets/pdf/<?= $file->file_name; ?>" target="_blank"><i class="<?= fileExtensionFormat($file->file_name); ?> fa-fw fa-3x"></i></a>
                    </div>
                    <div class="card_footer small text-center text-muted"><?= $file->designation . $fileSizeLabel; ?></div>
                </div>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</article>