<?php if ($game->description) : ?>
<article class="row">
    <div class="lettrine"><?= nl2br($game->description) ; ?></div>
</article>
<?php endif; ?>
<?php if ($game->goal) : ?>
<article class="row">
    <h2 class="text-primary">But du Jeu</h2>
    <div><?= nl2br($game->goal) ; ?></div>
</article>
<?php endif ; ?>