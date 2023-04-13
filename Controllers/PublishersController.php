<?php
namespace App\Controllers ;

use App\Core\ToolBarBuilder;
use App\Models\Publisher;

class PublishersController extends Controller
{

    public function filter($initial) {
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            $publisherModel = new Publisher() ;
            $publishers = $publisherModel->findBy([
                'lcase(left(name, 1))' => strtolower($initial)
            ], ['name']) ;

            $initials = $publisherModel->findInitials('name') ;

            $toolBar = new ToolBarBuilder() ;
            $toolBar->startToolBar(['class' => 'mt-2'])
                ->addButton('add', 'Ajouter un éditeur', ['href' => 'publishers/add'])
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
                ->addButton('add', 'Ajouter un éditeur', ['href' => 'publishers/add'])
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
            ],
            'admin') ;
        }
        else header('Location: /') ;
    }
}