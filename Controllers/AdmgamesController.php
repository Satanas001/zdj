<?php
namespace App\Controllers ;

use App\Core\ToolBarBuilder;
use App\Models\File;
use App\Models\Game ;

class AdmgamesController extends GamesController 
{
    public function filter(string $initial = '') {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $gameModel = new Game() ;
            $games = $gameModel->findBy([
                'lcase(left(title, 1))' => strtolower($initial)
            ], ['title']) ;

            $initials = $gameModel->findInitials('title') ;

            $toolBar = new ToolBarBuilder() ;
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un jeu', ['href' => 'admgames/add'])
                ->endToolBar();

            $this->render('admin/games', [
                'games' => $games, 
                'initials' => $initials,
                'activeInitial' => $initial,
                'nbGames' => count($games),
                'toolBar' => $toolBar->create(),
            ],
            'admin') ;
        }
        else header('Location: /') ;
    }

    public function index()
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $gameModel = new Game() ;
            $games = $gameModel->findAll(['title']) ;

            $initials = $gameModel->findInitials('title') ;

            $toolBar = new ToolBarBuilder() ;
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un jeu', ['href' => 'admgames/add'])
                ->endToolBar();

            $this->render('admin/games', 
                [
                    'games' => $games, 
                    'initials' => $initials,
                    'nbGames' => count($games),
                    'toolBar' => $toolBar->create(),
                ],
                'admin') ;
        }
        else header('Location: /') ;
    }

    public function view(int $id = null)
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $gameModel = new Game() ;
            $fileModel = new File() ;
            
            $game = $gameModel->find($id) ;
            $authors = $gameModel->findAuthorsBy($id, ['is_author' => 1]) ;
            $illustrators = $gameModel->findAuthorsBy($id, ['is_illustrator' => 1]) ;
            $publishers = $gameModel->findPublishers($id) ;
            $components = [] ;
            $rules = [] ;
            $files = $fileModel->findBy(['game_id' => $id]) ;

            $toolBar = new ToolBarBuilder() ;
            $toolBar->startToolBar()
                ->addButton('list', 'Retour à la liste', ['href' => '/admgames/filter/'.$game->title[0]])
                ->addButton('edit', 'Modifier l\'éditeur', ['href' => '/admgames/edit/'.$game->id]) ;

            $this->render('admin/games/index', [
                'game' => $game,
                'authors' => $authors,
                'illustrators' => $illustrators,
                'publishers' => $publishers,
                'components' => $components,
                'rules' => $rules,
                'files' => $files,
                'toolBar' => $toolBar->create(),
            ],
            'admin') ;
        }
        else header('Location: /') ;
    }
}