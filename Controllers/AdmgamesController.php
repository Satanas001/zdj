<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\ToolBarBuilder;
use App\Models\File;
use App\Models\Game;

class AdmgamesController extends GamesController
{
    public function add()
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $minPlayer = 1;
            $maxPlayer = null;
            $age = null;
            $minDuration = $maxDuration = null;

            if (!Form::cancel($_POST)) {
                if (Form::validate($_POST, ['title', 'playersMin', 'age', 'durationMin'])) {
                    $title = splitTitle(strip_tags($_POST['title']));

                    $game = new Game();

                    $minPlayer = (int)$_POST['playersMin'];
                    $maxPlayer = $_POST['playersMax'] <= $minPlayer ? $minPlayer : (int)$_POST['playersMax'];

                    $minDuration = (int)$_POST['durationMin'];
                    $maxDuration = $_POST['durationMax'] <= $minDuration ? $minDuration : (int)$_POST['durationMax'];

                    $age = (int)$_POST['age'];

                    if (!empty($_FILES['imgfile']['name'])) {
                        $image = strtolower($_FILES['imgfile']['name']);
                        $result = move_uploaded_file($_FILES['imgfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/assets/images/games/' . $image);

                        if ($result) resizeImage('/assets/images/games/' . $image, 200, 200, true);
                    } else {
                        $image = '';
                    }

                    $game->hydrate([
                        'article' => $title['article'],
                        'title' => $title['title'],
                        'playersMin' => $minPlayer,
                        'playersMax' => $maxPlayer,
                        'durationMin' => $minDuration,
                        'durationMax' => $maxDuration,
                        'age' => $age,
                        'image' => $image,
                        'active' => 0,
                        'prefix' => urltitle($title['title']),
                    ]);

                    // var_dump($game) ;
                    $game->create();

                    $_SESSION['flashes'][] = ['message' => 'Jeu enregistré.', 'style' => 'success'];

                    header('Location: /admgames/view/' . $game->lastId());
                    exit;
                } else {
                    if ($_POST) {
                        $_SESSION['flashes'][] = ['message' => 'Les champs jaunes sont obligatoires', 'style' => 'danger'];
                    }
                    $title = isset($_POST['title']) ? strip_tags($_POST['title']) : '';
                }
            } else {
                header('Location: /admgames');
                exit;
            }

            $form = new Form();
            $form->startForm()
                ->addInput('text', 'title', 'Titre', [
                    'class' => 'form-control required',
                    'value' => $title
                ])
                ->addInput('text', 'playersMin', 'Nombre minimum de joueurs', [
                    'class' => 'form-control required',
                    'value' => $minPlayer,
                ])
                ->addInput('text', 'playersMax', 'Nombre maximum de joueurs', [
                    'class' => 'form-control',
                    'value' => $maxPlayer,
                    'placeholder' => 0,
                ])
                ->addInput('text', 'age', 'Âge', [
                    'class' => 'form-control required',
                    'value' => $age,
                ])
                ->addInput('text', 'durationMin', 'Durée minimum', [
                    'class' => 'form-control required',
                    'value' => $minDuration,
                ])
                ->addInput('text', 'durationMax', 'Durée maximum', [
                    'class' => 'form-control',
                    'value' => $maxDuration,
                    'placeholder' => 0,
                ])
                ->addInput('file', 'imgfile', 'Image', [
                    'class' => 'form-control',
                ])
                ->addFooterAdd()
                ->endForm();

            $this->render('admin/games/add', [
                'form' => $form->create(),
            ], 'admin');
        } else header('Location: /');
    }

    public function edit($id)
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $gameModel = new Game();
            $game = $gameModel->find($id);

            $authors = $gameModel->findAuthorsBy($id, ['is_author' => 1]);
            $availableAuthors = $gameModel->findAvailableAuthorsBy(['game_id' => $id, 'is_author' => 1]) ;
            $illustrators = $gameModel->findAuthorsBy($id, ['is_illustrator' => 1]);
            $availableIllustrators = $gameModel->findAvailableAuthorsBy(['game_id' => $id, 'is_illustrator' => 1]) ;
            $publishers = $gameModel->findPublishers($id) ;
            $availablePublishers = $gameModel->findAvailablePublishersBy(['game_id' => $id]) ;

            if (!Form::cancel($_POST)) {
                if (Form::validate($_POST, ['title', 'playersMin', 'age', 'durationMin'])) {
                    $title = splitTitle(strip_tags($_POST['title']));

                    $minPlayer = (int)$_POST['playersMin'];
                    $maxPlayer = $_POST['playersMax'] <= $minPlayer ? $minPlayer : (int)$_POST['playersMax'];

                    $minDuration = (int)$_POST['durationMin'];
                    $maxDuration = $_POST['durationMax'] <= $minDuration ? $minDuration : (int)$_POST['durationMax'];

                    $age = (int)$_POST['age'];

                    $prefix = $_POST['prefix'] ? $_POST['prefix'] : urltitle($title['title']) ;

                    if (!empty($_FILES['imgfile']['name'])) {
                        $extension = strrchr($_FILES['imgfile']['name'],'.') ;
                        $image = strtolower($prefix.$extension) ;
                        $result = move_uploaded_file($_FILES['imgfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/images/games/'.$image) ;

                        if ($result) resizeImage('/assets/images/games/'.$image, 200, 200, true) ;
                    }
                    else {
                        $image = '' ;
                    }

                    $gameModel->hydrate([
                        'id' => (int)$id,
                        'article' => $title['article'],
                        'title' => $title['title'],
                        'playersMin' => $minPlayer,
                        'playersMax' => $maxPlayer,
                        'durationMin' => $minDuration,
                        'durationMax' => $maxDuration,
                        'age' => $age,
                        'melodice' =>$_POST['melodice'],
                        'description' => $_POST['description'],
                        'goal' => $_POST['goal'],
                        'active' => isset($_POST['active']) ? 1 : 0,
                        'prefix' => $prefix,
                    ]) ;
                    
                    if ($image) {
                        $gameModel->hydrate(['image' => $image]) ;
                    }

                    $gameModel->update() ;

                    $_SESSION['flashes'][] = ['message' => 'Jeu modifié.', 'style' => 'success'] ;

                    header('Location: /admgames/view/'.$id) ;
                    exit ;
                } else {
                    if ($_POST) {
                        $_SESSION['flashes'][] = ['message' => 'Les champs jaunes sont obligatoires', 'style' => 'danger'];
                    }
                    $title = isset($_POST['title']) ? strip_tags($_POST['title']) : '';
                }
            } else {
                header('Location: /admgames/view/' . $id);
                exit;
            }

            $form = new Form();
            $form->startForm()
                ->addInput('text', 'title', 'Titre', [
                    'class' => 'form-control required',
                    'value' => $game->article . $game->title
                ])
                ->addInput('text', 'playersMin', 'Nombre minimum de joueurs', [
                    'class' => 'form-control required',
                    'value' => $game->players_min,
                ])
                ->addInput('text', 'playersMax', 'Nombre maximum de joueurs', [
                    'class' => 'form-control',
                    'value' => $game->players_max,
                    'placeholder' => 0,
                ])
                ->addInput('text', 'age', 'Âge', [
                    'class' => 'form-control required',
                    'value' => $game->age,
                ])
                ->addInput('text', 'durationMin', 'Durée minimum', [
                    'class' => 'form-control required',
                    'value' => $game->duration_min,
                ])
                ->addInput('text', 'durationMax', 'Durée maximum', [
                    'class' => 'form-control',
                    'value' => $game->duration_max,
                    'placeholder' => 0,
                ])
                ->addInput('text', 'melodice', 'Lien Melodice.org', [
                    'class' => 'form-control',
                    'value' => $game->melodice,
                    'placeholder' => 'URL',
                ])
                ->addInput('file', 'imgfile', 'Image', [
                    'class' => 'form-control',
                ])
                ->addLabelFor('description', 'Description', ['class' => 'text-primary'])
                ->addTextarea('description', $game->description ?? '', [
                    'class' => 'form-control mb-2',
                    'rows' => 5,
                    'cols' => 60,
                    'id' => 'description'
                ])
                ->addLabelFor('goal', 'But du jeu', ['class' => 'text-primary'])
                ->addTextarea('goal', $game->goal ?? '', [
                    'class' => 'form-control mb-2',
                    'rows' => 5,
                    'cols' => 60,
                    'id' => 'goal'
                ])
                ->addInput('checkbox', 'active', 'Valide', [
                    'class' => 'form-check',
                    'checked' => $game->active ? true : false,
                ])
                ->addInput('text', 'prefix', 'Préfixe pour les fichiers, images', [
                    'class' => 'form-control',
                    'value' => $game->prefix ? $game->prefix : urlTitle($game->title)
                ])
                ->addFooterEdit()
                ->endForm();

            $this->render('admin/games/edit', [
                'form' => $form->create(),
                'game' => $game,
                'authors' => $authors,
                'illustrators' => $illustrators,
                'availableAuthors' => $availableAuthors,
                'availableIllustrators' => $availableIllustrators,
                'publishers' => $publishers,
                'availablePublishers' => $availablePublishers,
            ], 'admin');
        } else header('Location: /');
    }

    public function filter(string $initial = '')
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $gameModel = new Game();
            $games = $gameModel->findBy([
                'lcase(left(title, 1))' => strtolower($initial)
            ], ['title']);

            $initials = $gameModel->findInitials('title');

            $toolBar = new ToolBarBuilder();
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un jeu', ['href' => '/admgames/add'])
                ->endToolBar();

            $this->render(
                'admin/games',
                [
                    'games' => $games,
                    'initials' => $initials,
                    'activeInitial' => $initial,
                    'nbGames' => count($games),
                    'toolBar' => $toolBar->create(),
                ],
                'admin'
            );
        } else header('Location: /');
    }

    public function index()
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $gameModel = new Game();
            $games = $gameModel->findAll(['title']);

            $initials = $gameModel->findInitials('title');

            $toolBar = new ToolBarBuilder();
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un jeu', ['href' => '/admgames/add'])
                ->endToolBar();

            $this->render(
                'admin/games',
                [
                    'games' => $games,
                    'initials' => $initials,
                    'nbGames' => count($games),
                    'toolBar' => $toolBar->create(),
                ],
                'admin'
            );
        } else header('Location: /');
    }

    public function view(int $id = null)
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $gameModel = new Game();
            $fileModel = new File();

            $game = $gameModel->find($id);
            $authors = $gameModel->findAuthorsBy($id, ['is_author' => 1]);
            $illustrators = $gameModel->findAuthorsBy($id, ['is_illustrator' => 1]);
            $publishers = $gameModel->findPublishers($id);
            $components = [];
            $rules = [];
            $files = $fileModel->findBy(['game_id' => $id]);

            $toolBar = new ToolBarBuilder();
            $toolBar->startToolBar()
                ->addButton('list', 'Retour à la liste', ['href' => '/admgames/filter/' . $game->title[0]])
                ->addButton('edit', 'Modifier l\'éditeur', ['href' => '/admgames/edit/' . $game->id]);

            $this->render(
                'admin/games/index',
                [
                    'game' => $game,
                    'authors' => $authors,
                    'illustrators' => $illustrators,
                    'publishers' => $publishers,
                    'components' => $components,
                    'rules' => $rules,
                    'files' => $files,
                    'toolBar' => $toolBar->create(),
                ],
                'admin'
            );
        } else header('Location: /');
    }
}
