<?php
namespace App\Models ;

class Author extends Model
{
    protected $id ;
    protected $lastName ;
    protected $firstName ;

    public function __construct()
    {
        $this->table = 'authors' ;
    }

    public function findAll(array $orderBy = [])
    {
        $sort = '' ;
        
        if (!empty($orderBy)) {
            $sort = implode(', ', $orderBy) ;
        }

        $query = $this->sqlQuery('select '.$this->table.'.*, count(game_id) nb from '.$this->table .' left join game_authors on id = author_id group by id '. ($sort ? ' order by '.$sort : '')) ;
        
        return $query->fetchAll() ;
    }

    public function findBy(array $criteria, array $orderBy = []) 
    {
        $sort = '' ;
        
        if (!empty($orderBy)) {
            $sort = implode(', ', $orderBy) ;
        }

        $fields = [] ;
        $values = [] ;

        // On boucle pour éclater le tableau
        foreach ($criteria as $field => $value) {
            $fields[] = $field . ' = ?' ;
            $values[] = $value ;
        }
        
        // On transforme le tableau fields en une chaine de caractères
        $fieldList = implode(' and ', $fields) ;

        // On exécute la requête
        $query = 'select '.$this->table.'.*, count(game_id) nb from '.$this->table.' left join game_authors on id = author_id where '.$fieldList . ' group by id '.($sort ? ' order by '.$sort : '') ;
        return $this->sqlQuery($query, $values)->fetchAll() ;
    }

    /**
     * Finds the games of the author
     *
     * @param int $id   Id of the author
     */
    public function findGames(int $id)
    {
        return $this->sqlQuery('select games.*, is_author, is_illustrator from game_authors join games on game_authors.game_id = games.id where author_id = ? order by title', [$id])->fetchAll() ;
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
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

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
}