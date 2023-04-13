<?php
namespace App\Models ;

class User extends Model
{
    protected $id ;
    protected $firstName ;
    protected $name ;
    protected $login ;
    protected $password ;
    protected $roles ;
    protected $mail ;

    public function __construct()
    {
        // $class = str_replace(__NAMESPACE__.'\\', '', __CLASS__) ;
        // $this->table = strtolower(str_replace('Model', '', $class));
        $this->table = 'users' ;
    }

    /**
     * Récupérer un utilisateur à partir de son e-mail
     * @param string $login login de l'utilisateur
     */
    public function findOneByLogin(string $login)
    {
        return $this->sqlQuery('select * from users where login = ?', [$login])->fetch() ;
    }

    /**
     * Crée la session de l'utilisateur
     *
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id, 
            'roles' => $this->roles
        ] ;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of mail
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER' ;
        
        return array_unique($roles) ;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = json_decode($roles) ;

        return $this;
    }
}