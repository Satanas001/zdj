<?php
namespace App\Controllers ;

use App\Core\Form ;
use App\Models\Game ;
use App\Models\Author ;
use App\Models\Publisher ;
use App\Models\User;

class AdminController extends Controller
{   
    public function index()
    {
        if ($this->isAdmin()) {
            $authorModel = new Author() ;
            $publisherModel = new Publisher() ;
            $gameModel = new Game() ;

            $nbAuthors = $authorModel->count() ;
            $nbPublishers = $publisherModel->count() ;
            $nbGames = $gameModel->count() ;

            $this->render('admin/index', 
                [
                    'nbAuthors' => $nbAuthors, 
                    'nbPublishers' => $nbPublishers,
                    'nbGames' => $nbGames
                ],
                'admin') ;
        }
    }

    /**
     * control if the user is logged in and the role is admin
     *
     * @return boolean
     */
    private function isAdmin()
    {
        // On vérifie si on est connecté et si "ROLE_ADMIN" est dans nos roles
        if (isset($_SESSION['user'])) {
            if(in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
                return true ;
            }
            else header('Location: /') ;
        }
        else {
            header('Location: /admin/login') ;
        }
    }


    public function login()
    {
        // On vérifie si le formulaire est valide
        if (Form::validate($_POST, ['login', 'password'])) {
            
            // Le formulaire est complet
            // On va chercher dans la base de données l'utilisateur avec l'email entré
            $usersModel = new User() ;
            $userData = $usersModel->findOneByLogin(strip_tags($_POST['login'])) ;

            // Si l'utilisateur n'existe pas dans la base de données
            if (!$userData) {
                $_SESSION['flashes'][] = [
                    'message' => 'Le login et/ou le mot de passe est incorrect',
                    'style' => 'danger'
                ] ;
                header('Location: /admin/login') ;
                exit ;
            }

            // L'utilisateur existe
            $user = $usersModel->hydrate($userData) ;
            
            // On vérifie si le mot de passe est correct
            if (password_verify($_POST['password'], $user->getPassword())) {
                // Le mot de passe est bon
                $user->setSession() ;
                header('Location: /admin') ;
                exit ;
            }
            else {
                // Mauvais mot de passe 
                $_SESSION['flashes'][] = [
                    'message' => 'Le login et/ou le mot de passe est incorrect',
                    'style' => 'danger'
                ] ;
                header('Location: /admin/login') ;
                exit ;
            }
        }

        $form = new Form() ;
        $form->startForm()
            ->addInput('text','login','Login', ['class' => 'form-control'])
            ->addInput('password','password','Mot de passe', ['class' => 'form-control'])
            ->addButton('action', 'Connexion', ['class' => 'btn btn-primary w-100 mt-2' ])
            ->endForm() ;

        $this->render('admin/login', ['loginForm' => $form->create()]) ;
    }

    public function logout()
    {
        unset($_SESSION['user']) ;
        // header('Location: '.$_SERVER['HTTP_REFERER']) ;
        header('Location: /games') ;
    }
}