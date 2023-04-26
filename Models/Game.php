<?php
namespace App\Models ;

class Game extends Model
{
    protected $id ;
    protected $title ;
    protected $article ;
    protected $playersMin ;
    protected $playersMax ;
    protected $age ;
    protected $durationMin ;
    protected $durationMax ;
    protected $image ;
    protected $melodice ;
    protected $description ;
    protected $goal ;
    protected $active ;
    protected $prefix ;

    public function __construct()
    {
        $this->table = 'games' ;
    }

    public function addAuthorBy(array $criteria)
    {
        // On boucle pour éclater le tableau
        foreach ($criteria as $field => $value) {
            $fields[] = $field . ' = ?' ;
            $values[] = $value ;
            $insertFields[] = $field ;
            $interrogations[] = '?' ;
        }

        // On transforme le tableau fields en une chaine de caractères
        $fieldList = implode(' and ', $fields) ;
        $insertFieldsList = implode(', ', $insertFields) ;
        $interrogationList = implode(', ', $interrogations) ;

        $nb = $this->sqlQuery('select is_author + is_illustrator from game_authors where '.$fieldList, $values)->fetchColumn() ;

        if ($nb) {
            if (in_array('is_author', $criteria)) {
                $this->sqlQuery('update game_authors set is_author = 1 where '.$fieldList, $values) ;
            }
            else {
                $this->sqlQuery('update game_authors set is_illustrator = 1 where '.$fieldList, $values) ;
            }
        }
        else {
            $this->sqlQuery('insert into game_authors ('.$insertFieldsList.') values ('.$interrogationList.')', $values) ;
        }
    }

    public function deleteAuthorBy(array $criteria)
    {
        // On boucle pour éclater le tableau
        foreach ($criteria as $field => $value) {
            $fields[] = $field . ' = ?' ;
            $values[] = $value ;
        }

        // On transforme le tableau fields en une chaine de caractères
        $fieldList = implode(' and ', $fields) ;

        $nb = $this->sqlQuery('select is_author + is_illustrator from game_authors where '.$fieldList, $values)->fetchColumn() ;

        if ($nb > 1) {
            if (in_array('is_author', $criteria)) {
                $this->sqlQuery('update game_authors set is_author = 0 where '.$fieldList, $values) ;
            }
            else {
                $this->sqlQuery('update game_authors set is_illustrator = 0 where '.$fieldList, $values) ;
            }
        }
        else {
            $this->sqlQuery('delete from game_authors where '.$fieldList, $values) ;
            $this->sqlQuery('repair table game_authors') ;
        }
    }

    /**
     * Returns the list of authors who are not authors of this game
     *
     * @param array $criteria
     * @return void
     */
    public function findAvailableAuthorsBy(array $criteria):array
    {
        // On boucle pour éclater le tableau
        foreach ($criteria as $field => $value) {
            $fields[] = $field . ' = ?' ;
            $values[] = $value ;
        }

        // On transforme le tableau fields en une chaine de caractères
        $fieldList = implode(' and ', $fields) ;

        $query = 'select * from authors where id not in (select distinct author_id from game_authors where '.$fieldList.') order by last_name, first_name' ;

        return $this->sqlQuery($query, $values)->fetchAll() ;
    }

    /**
     * Finds the game authors of the game
     *
     * @param integer $id   Id of the game
     * @param array $criteria   Search criteria. e.g.: ['is_author' => 1]
     */
    public function findAuthorsBy(int $id, array $criteria)
    {
        $fields[] = 'game_id = ?' ;
        $values[] = $id ;

        // On boucle pour éclater le tableau
        foreach ($criteria as $field => $value) {
            $fields[] = $field . ' = ?' ;
            $values[] = $value ;
        }

        // On transforme le tableau fields en une chaine de caractères
        $fieldList = implode(' and ', $fields) ;

        $query = 'select authors.* from game_authors join authors on game_authors.author_id = authors.id where ' . $fieldList . ' order by last_name, first_name' ;
        
        return $this->sqlQuery($query, $values)->fetchAll() ;
    }

    /**
     * Finds the game publishers of the game
     *
     * @param int $id   Id of the game
     */
    public function findPublishers(int $id)
    {
        return $this->sqlQuery('select publishers.* from game_publishers join publishers on game_publishers.publisher_id = publishers.id where game_id = ? order by name', [$id])->fetchAll() ;
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
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of article
     */ 
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set the value of article
     *
     * @return  self
     */ 
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get the value of playersMin
     */ 
    public function getPlayersMin()
    {
        return $this->playersMin;
    }

    /**
     * Set the value of playersMin
     *
     * @return  self
     */ 
    public function setPlayersMin($playersMin)
    {
        $this->playersMin = $playersMin;

        return $this;
    }

    /**
     * Get the value of playersMax
     */ 
    public function getPlayersMax()
    {
        return $this->playersMax;
    }

    /**
     * Set the value of playersMax
     *
     * @return  self
     */ 
    public function setPlayersMax($playersMax)
    {
        $this->playersMax = $playersMax;

        return $this;
    }

    /**
     * Get the value of age
     */ 
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */ 
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of durationMin
     */ 
    public function getDurationMin()
    {
        return $this->durationMin;
    }

    /**
     * Set the value of durationMin
     *
     * @return  self
     */ 
    public function setDurationMin($durationMin)
    {
        $this->durationMin = $durationMin;

        return $this;
    }

    /**
     * Get the value of durationMax
     */ 
    public function getDurationMax()
    {
        return $this->durationMax;
    }

    /**
     * Set the value of durationMax
     *
     * @return  self
     */ 
    public function setDurationMax($durationMax)
    {
        $this->durationMax = $durationMax;

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

    /**
     * Get the value of melodice
     */ 
    public function getMelodice()
    {
        return $this->melodice;
    }

    /**
     * Set the value of melodice
     *
     * @return  self
     */ 
    public function setMelodice($melodice)
    {
        $this->melodice = $melodice;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of goal
     */ 
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * Set the value of goal
     *
     * @return  self
     */ 
    public function setGoal($goal)
    {
        $this->goal = $goal;

        return $this;
    }

    /**
     * Get the value of prefix
     */ 
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the value of prefix
     *
     * @return  self
     */ 
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    
}