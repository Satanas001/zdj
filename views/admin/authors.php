<section class="mt-4">
    <h1 class="">Auteurs<span class="small ms-2 "><sup class="badge rounded-pill bg-info pb-1 pt-0 px-2"><?= numberFormat($nbAuthors) ; ?></sup></span></h1>
    <?php 
        if (isset($toolBar)) {
            echo $toolBar ; 
        } 
    ?>
    <?php if (!empty($initials) && count($initials) >= 2) : ?>
        <section id="alphabet" class="border-bottom mb-3 pb-1">
            <?php foreach ($initials as $initial) : 
                    $active = isset($activeInitial) && $activeInitial == $initial->initial ? ' bg-primary bg-opacity-25' : '' ;
            ?>

                <a href="/authors/filter/<?= $initial->initial ; ?>" class="btn <?= $active ; ?>"><?= $initial->initial ; ?></a>
            <?php endforeach ; ?>
        </section>
    <?php endif ; ?>
    <section class="row">
        <div class="col-auto">
            <div class="card shadow-sm">
                <table class="table table-striped table-hover table-sm mb-0">
                    <tbody>
                        <?php foreach ($authors as $author): ?>
                            <tr>
                                <td>
                                    <a href="/authors/view/<?= $author->id ;?>" class="d-block"><?= mb_strtoupper($author->last_name), $author->first_name ? '<em>, '.$author->first_name.'</em>' : '' ; ?></a>
                                </td>
                                <td class="text-end">
                                    <?php if (isset($author->nb) && $author->nb > 0) :?>
                                        <span class="badge bg-primary rounded-pill"><?= numberFormat($author->nb) ; ?></span>
                                    <?php endif ; ?>
                                </td>
                            </tr>
                        <?php endforeach ; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>