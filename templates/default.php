<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Christophe COUPIGNY">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/460535078d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/zdj.css">
    <title>Z de Jeux - Accueil</title>
</head>

<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Z de Jeux</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
                    aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/games">Liste des jeux</a>
                        </li>
                    </ul>
                    <!-- <form class="d-flex">
                        <input class="form-control me-sm-2" type="search" placeholder="Chercher un jeu">
                        <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form> -->
                </div>
            </div>
        </nav>
    </header>
    <main class="flex-shrink-0">
        <div class="container">
            <?php if (!empty($_SESSION['flashes'])) : ?>
                <div class="my-3">
                    <?php foreach ($_SESSION['flashes'] as $flash): ?>
                    <div class="alert alert-<?= $flash['style'] ; ?>" role="alert">
                        <?= $flash['message'] ; ?>
                    </div>
                    <?php endforeach ; ?>
                    <?php unset($_SESSION['flashes']) ; ?>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </main>
    <footer class="footer mt-3 py-2 border-top bg-secondary bg-opacity-25">
        <div class="container text-center">
            <span class="text-muted"><a href="/admin">&copy;</a> C² 2023</span>
        </div>
    </footer>

    <script src="/js/bootstrap.bundle.js"></script>
    <script src="/js/ajax.js"></script>
</body>

</html>