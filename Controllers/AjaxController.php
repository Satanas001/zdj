<?php

namespace App\Controllers ;

use App\Models\Game ;

class AjaxController extends Controller
{

    public function addGameAuthor($param)
    {
        $authorList = '' ;
        $availableAuthors = [] ;
        
        $authorId = $param % 10000 ;
        $gameId = ($param - $authorId) / 10000 ;

        $gameModel = new Game() ;

        $gameModel->addAuthorBy(['game_id' => $gameId, 'author_id' => $authorId, 'is_author' => 1]) ;

        $authors = $gameModel->findAuthorsBy($gameId, ['is_author' => 1]);
        $availableAuthors = $gameModel->findAvailableAuthorsBy(['game_id' => $gameId, 'is_author' => 1]) ;

        if ($authors) :
            foreach ($authors as $author) :
                $authorList .= '<span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal me-3 mb-1">' . $author->first_name . $author->last_name. '<button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete(\'/ajax/deleteGameAuthor/'. ($gameId * 10000 + $author->id) . '\');"></button></span>' ;
            endforeach ;
        endif ;

        $selectAuthors = '<select class="form-select" id="selectAuthors">' ;
        if ($availableAuthors) {
            foreach ($availableAuthors as $available) {
                $authorName = mb_strtoupper($available->last_name).($available->first_name ? ', '.$available->first_name : '') ;
                $selectAuthors .= '<option value="'. ($gameId * 10000 + $available->id). '">'. $authorName. '</option>' ;
            }
        }
        $selectAuthors .= '</select>' ;

        echo 'document.getElementById("gameAuthors").innerHTML = "'.addslashes($authorList).'";' ;
        echo 'document.getElementById("availableAuthors").innerHTML = "'.addslashes($selectAuthors).'";' ;
    }

    public function addGameIllustrator($param)
    {
        $authorList = '' ;
        $availableAuthors = [] ;
        
        $authorId = $param % 10000 ;
        $gameId = ($param - $authorId) / 10000 ;

        $gameModel = new Game() ;

        $gameModel->addAuthorBy(['game_id' => $gameId, 'author_id' => $authorId, 'is_illustrator' => 1]) ;

        $authors = $gameModel->findAuthorsBy($gameId, ['is_illustrator' => 1]);
        $availableAuthors = $gameModel->findAvailableAuthorsBy(['game_id' => $gameId, 'is_illustrator' => 1]) ;

        if ($authors) :
            foreach ($authors as $author) :
                $authorList .= '<span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal me-3 mb-1">' . $author->first_name . $author->last_name. '<button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete(\'/ajax/deleteGameIllustrator/'. ($gameId * 10000 + $author->id) . '\');"></button></span>' ;
            endforeach ;
        endif ;

        $selectAuthors = '<select class="form-select" id="selectIllustrators">' ;
        if ($availableAuthors) {
            foreach ($availableAuthors as $available) {
                $authorName = mb_strtoupper($available->last_name).($available->first_name ? ', '.$available->first_name : '') ;
                $selectAuthors .= '<option value="'. ($gameId * 10000 + $available->id). '">'. $authorName. '</option>' ;
            }
        }
        $selectAuthors .= '</select>' ;

        echo 'document.getElementById("gameIllustrators").innerHTML = "'.addslashes($authorList).'";' ;
        echo 'document.getElementById("availableIllustrators").innerHTML = "'.addslashes($selectAuthors).'";' ;
    }

    public function deleteGameAuthor($param)
    {
        $authorList = '' ;
        $availableAuthors = [] ;
        
        $authorId = $param % 10000 ;
        $gameId = ($param - $authorId) / 10000 ;

        $gameModel = new Game() ;

        $gameModel->deleteAuthorBy(['game_id' => $gameId, 'author_id' => $authorId, 'is_author' => 1]) ;

        $authors = $gameModel->findAuthorsBy($gameId, ['is_author' => 1]);
        $availableAuthors = $gameModel->findAvailableAuthorsBy(['game_id' => $gameId, 'is_author' => 1]) ;

        if ($authors) :
            foreach ($authors as $author) :
                $authorList .= '<span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal me-3 mb-1">' . $author->first_name . $author->last_name. '<button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete(\'/ajax/deleteGameAuthor/'. ($gameId * 10000 + $author->id) . '\');"></button></span>' ;
            endforeach ;
        endif ;

        $selectAuthors = '<select class="form-select" id="selectAuthors">' ;
        if ($availableAuthors) {
            foreach ($availableAuthors as $available) {
                $authorName = mb_strtoupper($available->last_name).($available->first_name ? ', '.$available->first_name : '') ;
                $selectAuthors .= '<option value="'. ($gameId * 10000 + $available->id). '">'. $authorName. '</option>' ;
            }
        }
        $selectAuthors .= '</select>' ;

        echo 'document.getElementById("gameAuthors").innerHTML = "'.addslashes($authorList).'";' ;
        echo 'document.getElementById("availableAuthors").innerHTML = "'.addslashes($selectAuthors).'";' ;
    }

    public function deleteGameIllustrator($param)
    {
        $authorList = '' ;
        $availableAuthors = [] ;
        
        $authorId = $param % 10000 ;
        $gameId = ($param - $authorId) / 10000 ;

        $gameModel = new Game() ;

        $gameModel->deleteAuthorBy(['game_id' => $gameId, 'author_id' => $authorId, 'is_illustrator' => 1]) ;

        $authors = $gameModel->findAuthorsBy($gameId, ['is_illustrator' => 1]);
        $availableAuthors = $gameModel->findAvailableAuthorsBy(['game_id' => $gameId, 'is_illustrator' => 1]) ;

        if ($authors) :
            foreach ($authors as $author) :
                $authorList .= '<span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal me-3 mb-1">' . $author->first_name . $author->last_name. '<button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete(\'/ajax/deleteGameIllustrator/'. ($gameId * 10000 + $author->id) . '\');"></button></span>' ;
            endforeach ;
        endif ;

        $selectAuthors = '<select class="form-select" id="selectIllustrators">' ;
        if ($availableAuthors) {
            foreach ($availableAuthors as $available) {
                $authorName = mb_strtoupper($available->last_name).($available->first_name ? ', '.$available->first_name : '') ;
                $selectAuthors .= '<option value="'. ($gameId * 10000 + $available->id). '">'. $authorName. '</option>' ;
            }
        }
        $selectAuthors .= '</select>' ;

        echo 'document.getElementById("gameIllustrators").innerHTML = "'.addslashes($authorList).'";' ;
        echo 'document.getElementById("availableIllustrators").innerHTML = "'.addslashes($selectAuthors).'";' ;
    }
}