<?php
namespace App\Models ;

use App\Core\Db ;

class Model extends Db
{
    // Table de la base de données
    protected $table ;

    // Instance de Db
    private $db ;

    public function count()
    {
        $query = $this->sqlQuery('select count(*) nb from '.$this->table) ;
        
        return $query->fetchColumn() ;
    }

    public function create()
    {
        $fields = [] ;
        $interrogations = [] ;
        $values = [] ;

        // On boucle pour éclater le tableau
        foreach ($this as $field => $value) {
            // on filtre les champs
            if ($value !== null && $field != 'db' && $field != 'table') {
                $field = strtolower(preg_replace('/(?<!^)([A-Z][a-z]|(?<=[a-z])[^a-z]|(?<=[A-Z])[0-9_])/', '_$1', $field)) ;
                $fields[] = $field ;
                $interrogations[] = '?' ;
                $values[] = $value ;
            }
        }
        
        // On transforme le tableau fields en une chaine de caractères
        $fieldList = implode(', ', $fields) ;
        $interrogationList = implode(', ', $interrogations) ;

        // On exécute la requête
        return $this->sqlQuery('insert into '.$this->table.' ('.$fieldList.') values ('.$interrogationList.')', $values) ;
    }

    public function delete(int $id)
    {
        return $this->sqlQuery('delete from '.$this->table.' where id = ?', [$id]) ;
    }

    public function find(int $id)
    {
        return $this->sqlQuery('select * from '.$this->table.' where id =' . $id)->fetch() ;
    }

    public function findAll(array $orderBy = [])
    {
        $sort = '' ;
        
        if (!empty($orderBy)) {
            $sort = implode(', ', $orderBy) ;
        }

        $query = $this->sqlQuery('select * from '.$this->table . ($sort ? ' order by '.$sort : '')) ;
        
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
        $query = 'select * from '.$this->table.' where '.$fieldList . ($sort ? ' order by '.$sort : '') ;
        return $this->sqlQuery($query, $values)->fetchAll() ;
    }

    public function findInitials(string $field, array $criteria = [])
    {
        $fields = [] ;
        $values = [] ;
        $fieldList = '' ;
        
        if ($criteria) {
            $fieldList = ' where ' ;
            
            foreach ($criteria as $key => $value) {
                $fields[] = $key . ' = ?' ;
                $values[] = $value ;
            }
            $fieldList .= implode(' and ', $fields) ;
        }

        $query = 'select distinct ucase(left('.$field.',1)) initial from '.$this->table . $fieldList . ' order by initial' ;
        
        return $this->sqlQuery($query, $values)->fetchAll() ;
    }

    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            // On récupère le nom du setter correspondant à la clé (key)
            $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            // On vérifie si le setter existe 
            if (method_exists($this, $method)) {
                $this->$method($value) ;
            }
        }

        return $this ;
    }

    protected function sqlQuery(string $sql, array $attributs = null)
    {
        // On récupère l'instance de Db
        $this->db = Db::getInstance() ;

        // On vérifie si on a des attributs
        if ($attributs !== null) {
            // Requête préparée
            $res = $this->db->prepare($sql) ;
            $res->execute($attributs) ;

            return $res ;
        }
        else {
            // Requête simple
            return $this->db->query($sql) ;
        }
    }
    
    public function update()
    {
        $fields = [] ;
        $values = [] ;

        // On boucle pour éclater le tableau
        foreach ($this as $field => $value) {
            // on filtre les champs
            if ($value !== null && $field != 'db' && $field != 'table') {
                $field = strtolower(preg_replace('/(?<!^)([A-Z][a-z]|(?<=[a-z])[^a-z]|(?<=[A-Z])[0-9_])/', '_$1', $field)) ;
                $fields[] = $field . ' = ?';
                $values[] = $value ;
            }
        }
        $values[] = $this->id ;

        // On transforme le tableau fields en une chaine de caractères
        $fieldList = implode(', ', $fields) ;

        // On exécute la requête
        return $this->sqlQuery('update '.$this->table.' set '.$fieldList.' where id = ?', $values) ;
    }

    
}