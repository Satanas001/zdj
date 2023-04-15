<?php
namespace App\Controllers ;

use App\Core\Form;
use App\Core\ToolBarBuilder;
use App\Models\Publisher;

class PublishersController extends Controller
{
    public function add() {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {

            if (!Form::cancel($_POST)) {
                if (Form::validate($_POST, ['name'])) {
                    $name = strip_tags($_POST['name']) ;
                    
                    $publisher = new Publisher() ;
                    
                    if (!empty($_FILES['imgfile']['name'])) {
                        $image = strtolower($_FILES['imgfile']['name']) ;
                        $result = move_uploaded_file($_FILES['imgfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/images/publishers/'.$image) ;
                        
                        if ($result) resizeImage('/assets/images/publishers/'.$image, 200, 200, true) ;
                    }
                    else {
                        $image = '' ;
                    }

                    $publisher->hydrate([
                        'name' => ucfirst($name),
                        'image' => $image
                        ]) ;
                    $publisher->create() ;

                    $_SESSION['flashes'][] = ['message' => 'Éditeur enregistré.', 'style' => 'success'] ;

                    header('Location: /publishers/view/'.$publisher->lastId()) ;
                    exit ;
                }
                else {
                    if ($_POST) {
                        $_SESSION['flashes'][] = ['message' => 'Le nom est obligatoire', 'style' => 'danger'];
                    }
                    $name = isset($_POST['name']) ? strip_tags($_POST['name']) : '' ;
                }
            }
            else {
                header('Location: /publishers') ;
                exit ;
            }

            $form = new Form() ;
            $form->startForm()
                ->addInput('text', 'name', 'Nom', [
                    'class' => 'form-control required', 
                    'value' => $name
                ])
                ->addInput('file', 'imgfile', 'Image', [
                    'class' => 'form-control',
                    ])
                ->addFooterAdd()
                ->endForm();

            $this->render('admin/publishers/add', [
                'form' => $form->create(),
            ], 'admin') ;
        }
        else header('Location: /') ;
    }

    public function delete(int $id) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $publisherModel = new Publisher() ;
            $publisher = $publisherModel->find($id) ;

            if (!$publisher) {
                http_response_code(404) ;
                $_SESSION['flashes'][] = ['message' => 'L\'éditeur n\'existe pas', 'style' => 'danger'];
                header('Location: /publishers') ;
                exit ;
            }

            $publisherModel->delete($id) ;
            unlink($_SERVER['DOCUMENT_ROOT'].'/assets/images/publishers/'.$publisher->image) ;

            header('Location: /publishers/filter/'.mb_strtoupper($publisher->name[0])) ;
        }
        else header('Location: /') ;
    }

    public function edit(int $id) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $publisherModel = new Publisher() ;
            $publisher = $publisherModel->find($id) ;

            if (!$publisher) {
                http_response_code(404) ;
                $_SESSION['flashes'][] = ['message' => 'L\'éditeur n\'existe pas', 'style' => 'danger'];
                header('Location: /publishers') ;
                exit ;
            }

            if (!Form::cancel($_POST)) {
                if (Form::validate($_POST, ['name'])) {
                    $name = strip_tags($_POST['name']) ;

                    if (!empty($_FILES['imgfile']['name'])) {
                        $image = strtolower($_FILES['imgfile']['name']) ;
                        $result = move_uploaded_file($_FILES['imgfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/images/publishers/'.$image) ;
                        
                        if ($result) resizeImage('/assets/images/publishers/'.$image, 200, 200, true) ;
                    }
                    else {
                        $image = '' ;
                    }
                    
                    $publisherModel->hydrate([
                        'id' => $id, 
                        'name' => ucfirst($name)
                    ]) ;

                    if ($image) {
                        $publisherModel->hydrate(['image' => $image]) ;
                    }

                    $publisherModel->update() ;
                    $_SESSION['flashes'][] = ['message' => 'Éditeur modifié.', 'style' => 'success'] ;

                    header('Location: /publishers/view/'.$id) ;
                    exit ;
                }
                else {
                    if ($_POST) {
                        $_SESSION['flashes'][] = ['message' => 'Le nom est obligatoire', 'style' => 'danger'];
                    }
                    $name = isset($_POST['name']) ? strip_tags($_POST['name']) : $publisher->name ;
                }
            }
            else {
                header('Location: /publishers/view/'.$id) ;
                exit ;
            }


            $form = new Form() ;
            $form->startForm()
                ->addInput('text', 'name', 'Nom', [
                    'class' => 'form-control required', 
                    'value' => $publisher->name
                ])
                ->addInput('file', 'imgfile', 'Image', [
                    'class' => 'form-control',
                ])
                ->addFooterEdit()
                ->endForm();

            // $_SESSION['flashes'][] = ['message' => 'Coucou', 'style' => 'danger'] ;

            $this->render('admin/publishers/edit', [
                'form' => $form->create(),
            ], 'admin') ;
        }
        else header('Location: /') ;
    }
    
    public function filter($initial) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $publisherModel = new Publisher() ;
            $publishers = $publisherModel->findBy([
                'lcase(left(name, 1))' => strtolower($initial)
            ], ['name']) ;

            $initials = $publisherModel->findInitials('name') ;

            $toolBar = new ToolBarBuilder() ;
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un éditeur', ['href' => '/publishers/add'])
                ->endToolBar();

            $this->render('admin/publishers', [
                'publishers' => $publishers, 
                'initials' => $initials,
                'activeInitial' => $initial,
                'nbPublishers' => count($publishers),
                'toolBar' => $toolBar->create(),
            ],
            'admin') ;
        }
        else header('Location: /') ;
    }

    public function index() 
    {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $publisherModel = new Publisher() ;
            $publishers = $publisherModel->findAll(['name']) ;
            $nbPublishers = $publisherModel->count() ;
            $initials = $publisherModel->findInitials('name') ;

            $toolBar = new ToolBarBuilder() ;
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un éditeur', ['href' => '/publishers/add'])
                ->endToolBar();

            $this->render('admin/publishers',
                [
                    'publishers' => $publishers,
                    'initials' => $initials,
                    'nbPublishers' => $nbPublishers,
                    'toolBar' => $toolBar->create(),
                ],
                'admin') ;
        }
        else header('Location: /') ;
    }

    public function view($id) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $publisherModel = new Publisher() ;
            $publisher = $publisherModel->find($id) ;

            if ($publisher) {
                $games = $publisherModel->findGames($id) ;

                $toolBar = new ToolBarBuilder() ;
                $toolBar->startToolBar(['class' => 'mt-2 mb-3'])
                    ->addButton('list', 'Retour à la liste', ['href' => '/publishers/filter/'.$publisher->name[0]])
                    ->addButton('edit', 'Modifier l\'éditeur', ['href' => '/publishers/edit/'.$publisher->id]) ;

                if (!count($games)) {
                    $toolBar->addButton('delete', 'Supprimer l\'éditeur', ['data-bs-toggle' => 'modal',  'data-bs-target' => '#deleteModal']) ;
                }

                $toolBar->endToolBar() ;
                
                $this->render('admin/publishers/index', [
                    'publisher' => $publisher, 
                    'games' => $games,
                    'toolBar' => $toolBar->create(),
                    'modalDelete' => [
                        'model' => 'publishers',
                        'code' => $id, 
                        'label' => $publisher->name, 
                    ]
                ],
                'admin') ;
            }
            else header('Location: /publishers') ;
        }
        else header('Location: /') ;
    }
}