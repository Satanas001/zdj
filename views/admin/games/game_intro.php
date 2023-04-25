<?php if ($game->description) : ?>
    <section class="row">
        <article class="lettrine"><?= nl2br($game->description); ?></article>
    </section>
<?php endif; ?>
<?php if ($game->goal) : ?>
    <article class="row mt-3">
        <h2 class="text-primary">But du Jeu</h2>
        <article><?= nl2br($game->goal); ?></article>
    </article>
<?php endif; ?>