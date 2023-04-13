<?php
namespace App\Controllers ;

use App\Models\File ;
use App\Models\Game ;

class GamesController extends Controller
{
    public function index()
    {
        $gameModel = new Game() ;
        $games = $gameModel->findBy(['active' => 1], ['title']) ;

        $initials = $gameModel->findInitials('title', ['active' => 1]) ;

        $this->render('games/index', ['games' => $games, 'initials' => $initials]) ;
    }

    public function filter(string $initial = '')
    {
        $gameModel = new Game() ;
        $games = $gameModel->findBy([
            'active' => 1, 
            'lcase(left(title, 1))' => strtolower($initial)
        ], ['title']) ;

        $initials = $gameModel->findInitials('title', ['active' => 1]) ;

        $this->render('games/index', [
            'games' => $games, 
            'initials' => $initials,
            'activeInitial' => $initial
        ]) ;
    }

    public function game(int $id = null)
    {
        if ($id) {
            $gameModel = new Game() ;
            $fileModel = new File() ;
            
            $game = $gameModel->find($id) ;
            $authors = $gameModel->findAuthorsBy($id, ['is_author' => 1]) ;
            $illustrators = $gameModel->findAuthorsBy($id, ['is_illustrator' => 1]) ;
            $publishers = $gameModel->findPublishers($id) ;
            $components = [] ;
            $rules = [] ;
            $files = $fileModel->findBy(['game_id' => $id]) ;

            $this->render('games/game', [
                'game' => $game,
                'authors' => $authors,
                'illustrators' => $illustrators,
                'publishers' => $publishers,
                'components' => $components,
                'rules' => $rules,
                'files' => $files,
            ]) ;
        }
        else {
            http_response_code(302) ;
            header('Location: /games') ;
        }
    }
}