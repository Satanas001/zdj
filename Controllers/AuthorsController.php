<?php
namespace App\Controllers ;

use App\Core\Form;
use App\Core\ToolBarBuilder;
use App\Models\Author ;

class AuthorsController extends Controller
{
    public function add() {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {

            if (!Form::cancel($_POST)) {
                if (Form::validate($_POST, ['lastName'])) {
                    $lastName = strip_tags($_POST['lastName']) ;
                    $firstName = strip_tags(rtrim($_POST['firstName']).' ') ;

                    $author = new Author() ;

                    $author->hydrate([
                        'firstName' => ucfirst($firstName),
                        'lastName' => ucfirst($lastName)
                    ]) ;

                    $author->create() ;
                    $_SESSION['flashes'][] = ['message' => 'Auteur enregistré.', 'style' => 'success'] ;

                    header('Location: /authors/view/'.$author->lastId()) ;
                    exit ;
                }
                else {
                    if ($_POST) {
                        $_SESSION['flashes'][] = ['message' => 'Le nom est obligatoire', 'style' => 'danger'];
                    }
                    $lastName = isset($_POST['lastName']) ? strip_tags($_POST['lastName']) : '' ;
                    $firstName = isset($_POST['firstName']) ? strip_tags($_POST['firstName']) : '' ;
                }
            }
            else {
                header('Location: /authors') ;
                exit ;
            }

            $form = new Form() ;
            $form->startForm()
                ->addInput('text', 'lastName', 'Nom', [
                    'class' => 'form-control required', 
                    'value' => $lastName
                ])
                ->addInput('text', 'firstName', 'Prénom', [
                    'class' => 'form-control',
                    'value' => $firstName
                    ])
                ->addFooterAdd()
                ->endForm();

            // $_SESSION['flashes'][] = ['message' => 'Coucou', 'style' => 'danger'] ;

            $this->render('admin/authors/add', [
                'form' => $form->create(),
            ], 'admin') ;
        }
        else header('Location: /') ;
    }

    public function delete(int $id) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $authorModel = new Author() ;
            $author = $authorModel->find($id) ;

            if (!$author) {
                http_response_code(404) ;
                $_SESSION['flashes'][] = ['message' => 'L\'auteur n\'existe pas', 'style' => 'danger'];
                header('Location: /authors') ;
                exit ;
            }

            $authorModel->delete($id) ;

            header('Location: /authors/filter/'.mb_strtoupper($author->last_name[0])) ;
        }
        else header('Location: /') ;
    }

    public function edit(int $id) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $authorModel = new Author() ;
            $author = $authorModel->find($id) ;

            if (!$author) {
                http_response_code(404) ;
                $_SESSION['flashes'][] = ['message' => 'L\'auteur n\'existe pas', 'style' => 'danger'];
                header('Location: /authors') ;
                exit ;
            }

            if (!Form::cancel($_POST)) {
                if (Form::validate($_POST, ['lastName'])) {
                    $lastName = strip_tags($_POST['lastName']) ;
                    $firstName = strip_tags(rtrim($_POST['firstName']).' ') ;

                    $authorModel->hydrate([
                        'id' => $id, 
                        'firstName' => ucfirst($firstName),
                        'lastName' => ucfirst($lastName)
                    ]) ;

                    $authorModel->update() ;
                    $_SESSION['flashes'][] = ['message' => 'Auteur modifié.', 'style' => 'success'] ;

                    header('Location: /authors/filter/'.mb_strtoupper($lastName[0])) ;
                    exit ;
                }
                else {
                    if ($_POST) {
                        $_SESSION['flashes'][] = ['message' => 'Le nom est obligatoire', 'style' => 'danger'];
                    }
                    $lastName = isset($_POST['lastName']) ? strip_tags($_POST['lastName']) : $author->last_name ;
                    $firstName = isset($_POST['firstName']) ? strip_tags($_POST['firstName']) : $author->first_name ;
                }
            }
            else {
                header('Location: /authors/view/'.$id) ;
                exit ;
            }


            $form = new Form() ;
            $form->startForm()
                ->addInput('text', 'lastName', 'Nom', [
                    'class' => 'form-control required', 
                    'value' => $author->last_name
                ])
                ->addInput('text', 'firstName', 'Prénom', [
                    'class' => 'form-control',
                    'value' => $author->first_name
                    ])
                ->addFooterEdit()
                ->endForm();

            // $_SESSION['flashes'][] = ['message' => 'Coucou', 'style' => 'danger'] ;

            $this->render('admin/authors/edit', [
                'form' => $form->create(),
            ], 'admin') ;
        }
        else header('Location: /') ;
    }

    public function filter($initial) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $authorModel = new Author() ;
            $authors = $authorModel->findBy([
                'lcase(left(last_name, 1))' => strtolower($initial)
            ], ['last_name']) ;

            $initials = $authorModel->findInitials('last_name') ;

            $toolBar = new ToolBarBuilder() ;
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un auteur', ['href' => '/authors/add'])
                ->endToolBar();

            $this->render('admin/authors', [
                'authors' => $authors, 
                'initials' => $initials,
                'activeInitial' => $initial,
                'nbAuthors' => count($authors),
                'toolBar' => $toolBar->create(),
            ],
            'admin') ;
        }
        else header('Location: /') ;
    }

    public function index() 
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $authorModel = new Author() ;
            $authors = $authorModel->findAll(['last_name, first_name']) ;
            $nbAuthors = $authorModel->count() ;
            $initials = $authorModel->findInitials('last_name') ;

            $toolBar = new ToolBarBuilder() ;
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un auteur', ['href' => '/authors/add'])
                ->endToolBar();

            $this->render('admin/authors',
                [
                    'authors' => $authors,
                    'initials' => $initials,
                    'nbAuthors' => $nbAuthors,
                    'toolBar' => $toolBar->create(),
                ],
                'admin') ;
        }
        else header('Location: /') ;
    }

    public function view($id) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $authorModel = new Author() ;
            $author = $authorModel->find($id) ;

            if ($author) {
                $games = $authorModel->findGames($id) ;

                $toolBar = new ToolBarBuilder() ;
                $toolBar->startToolBar(['class' => 'mt-2 mb-3'])
                    ->addButton('list', 'Retour à la liste', ['href' => '/authors/filter/'.$author->last_name[0]])
                    ->addButton('edit', 'Modifier l\'auteur', ['href' => '/authors/edit/'.$author->id]) ;

                if (!count($games)) {
                    $toolBar->addButton('delete', 'Supprimer l\'auteur', ['data-bs-toggle' => 'modal',  'data-bs-target' => '#deleteModal']) ;
                }

                $toolBar->endToolBar() ;
                
                $this->render('admin/authors/index', [
                    'author' => $author, 
                    'games' => $games,
                    'toolBar' => $toolBar->create(),
                    'modalDelete' => [
                        'model' => 'authors',
                        'code' => $id, 
                        'label' => $author->first_name.$author->last_name, 
                    ]
                ],
                'admin') ;
            }
            else header('Location: /authors') ;
        }
        else header('Location: /') ;
    }
}