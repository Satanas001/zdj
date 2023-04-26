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

    public function addGamePublisher($param)
    {
        $list = '' ;
        $availables = [] ;
        
        $id = $param % 10000 ;
        $gameId = ($param - $id) / 10000 ;

        $gameModel = new Game() ;

        $gameModel->addPublisherBy(['game_id' => $gameId, 'publisher_id' => $id]) ;

        $publishers = $gameModel->findPublishers($gameId);
        $availables = $gameModel->findAvailablePublishersBy(['game_id' => $gameId]) ;

        if ($publishers) :
            foreach ($publishers as $publisher) :
                $list .= '<div class="col-auto"><div class="text-center"><img src="/assets/images/publishers/'. $publisher->image .'" class="image-64"></div><div class="px-3 text-center h5"><span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal mb-1">' . $publisher->name . '<button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete(\'/ajax/deleteGamePublisher/' . ($gameId * 10000 + $id) . '\');"></button></span></div></div>' ;
            endforeach ;
        endif ;

        $select = '<select class="form-select" id="selectPublishers">' ;
        if ($availables) {
            foreach ($availables as $available) {
                $select .= '<option value="'. ($gameId * 10000 + $available->id). '">'. $available->name. '</option>' ;
            }
        }
        $select .= '</select>' ;

        echo 'document.getElementById("gamePublishers").innerHTML = "'.addslashes($list).'";' ;
        echo 'document.getElementById("availablePublishers").innerHTML = "'.addslashes($select).'";' ;
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

    public function deleteGamePublisher($param)
    {
        $list = '' ;
        $availables = [] ;
        
        $id = $param % 10000 ;
        $gameId = ($param - $id) / 10000 ;

        $gameModel = new Game() ;

        $gameModel->deletePublisherBy(['game_id' => $gameId, 'publisher_id' => $id]) ;

        $publishers = $gameModel->findPublishers($gameId);
        $availables = $gameModel->findAvailablePublishersBy(['game_id' => $gameId]) ;

        if ($publishers) :
            foreach ($publishers as $publisher) :
                $list .= '<div class="col-auto"><div class="text-center"><img src="/assets/images/publishers/'. $publisher->image .'" class="image-64"></div><div class="px-3 text-center h5"><span class="badge rounded-pill text-bg-primary bg-opacity-75 fw-normal mb-1">' . $publisher->name . '<button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" style="font-size: .75em" onclick="html_requete(\'/ajax/deleteGamePublisher/' . ($gameId * 10000 + $publisher->id) . '\');"></button></span></div></div>' ;
            endforeach ;
        endif ;

        $select = '<select class="form-select" id="selectPublishers">' ;
        if ($availables) {
            foreach ($availables as $available) {
                $select .= '<option value="'. ($gameId * 10000 + $available->id). '">'. $available->name. '</option>' ;
            }
        }
        $select .= '</select>' ;

        echo 'document.getElementById("gamePublishers").innerHTML = "'.addslashes($list).'";' ;
        echo 'document.getElementById("availablePublishers").innerHTML = "'.addslashes($select).'";' ;
    }
}