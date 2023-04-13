<?php
namespace App\Models ;

class Publisher extends Model
{
    protected $id ;
    protected $name ;
    protected $image ;

    public function __construct()
    {
        $this->table = 'publishers' ;
    }
    
    public function findAll(array $orderBy = [])
    {
        $sort = '' ;
        
        if (!empty($orderBy)) {
            $sort = implode(', ', $orderBy) ;
        }

        $query = $this->sqlQuery('select '.$this->table.'.*, count(game_id) nb from '.$this->table .' left join game_publishers on id = publisher_id group by id '. ($sort ? ' order by '.$sort : '')) ;
        
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
        $query = 'select '.$this->table.'.*, count(game_id) nb from '.$this->table.' left join game_publishers on id = publisher_id where '.$fieldList . ' group by id '.($sort ? ' order by '.$sort : '') ;
        return $this->sqlQuery($query, $values)->fetchAll() ;
    }

    /**
     * Finds the games of the publisher
     *
     * @param int $id   Id of the publisher
     */
    public function findGames(int $id)
    {
        return $this->sqlQuery('select games.* from games join game_publishers on game_id = id where publisher_id = ? order by title', [$id])->fetchAll() ;
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
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
}