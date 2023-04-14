<?php
namespace App\Core ;

class Form
{
    private $formCode = '' ;

    /**
     * Ajoute les attributs envoyés à la balise
     *
     * @param array $attributes Tableau associatif
     * @return string   Chaine de caractère générée
     */
    private function addAttributes(array $attributes): string
    {
        // On initialise une chaine de caractères
        $str = '' ;

        // On liste les attributs "courts"
        $shorts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'] ;

        // On boucle sur le tableau d'attributs
        foreach ($attributes as $attribute => $value) {
            // Si l'attribut est dans la liste des attributs courts
            if (in_array($attribute, $shorts) && $value == true) {
                $str .= ' '.$attribute ;
            }
            else {
                // On ajoute attribut="valeur"
                $str .= ' '.$attribute . '="' . $value . '"' ;
            }
        }

        return $str ;
    }

    public function addButton(string $name, string $label, array $attributes = []): self
    {
        $this->formCode .= '<button name="'.$name.'"';
        
        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '' ;

        $this->formCode .= '>'.$label.'</button>' ;

        return $this ;
    }

    public function addFooterAdd(): self
    {
        $this->formCode .= '</div><div class="card-footer bg-primary bg-opacity-25">
	        <div class="text-end">
		        <input type="submit" class="btn btn-success text-white me-3" name="action" id="btnCancel" value="Annuler"/>
		        <input type="submit" class="btn btn-danger " name="action" id="btnAdd" value="Ajouter"/>
	        </div>' ;
        
        return $this ;
    }

    public function addFooterEdit(): self
    {
        $this->formCode .= '</div><div class="card-footer bg-primary bg-opacity-25">
	        <div class="text-end">
		        <input type="submit" class="btn btn-success text-white me-3" name="action" id="btnCancel" value="Annuler"/>
		        <input type="submit" class="btn btn-danger " name="action" id="btnEdit" value="Modifier"/>
	        </div>' ;
        
        return $this ;
    }

    public function addInput(string $type, string $name, string $labelFor = '', array $attributes = []): self
    {
        $this->formCode .= '<div class="mb-2">' ;
        
        if ($labelFor) {
            $this->formCode .= '<label for="'.$name.'" class="text-primary">'.$labelFor.'</label>' ;
        }
        // On ouvre la balise
        $this->formCode .= '<input type="' . $type . '" name="' . $name .'" id="' . $name .'"' ;

        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '' ;

        $this->formCode .= '>' ;
        $this->formCode .= '</div>' ;

        return $this ;
    }
    
    /**
     * Ajout d'un label
     *
     * @param string $for
     * @param string $text
     * @param array $attributes
     * @return self
     */
    public function addLabelFor(string $for, string $text, array $attributes = []): self
    {
        // On ouvre la balise
        $this->formCode .= '<label for="'.$for.'"' ;

        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '' ;

        // On ajoute le texte
        $this->formCode .= '>'.$text.'</label>' ;

        return $this ;
    }

    public function addSelect(string $name, array $options, array $attributes = []): self
    {
        // On ouvre la balise
        $this->formCode .= '<select name="'.$name.'"' ;
        
        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '' ;

        $this->formCode .= '>' ;

        // On ajout les options
        foreach ($options as $value => $label) {
            $this->formCode .= '<option value="'.$value.'">'.$label.'</option>' ;
        }

        $this->formCode .= '</select>' ;

        return $this ;
    }

    public function addTextarea(string $name, string $value, array $attributes = []): self
    {
        // On ouvre la balise
        $this->formCode .= '<textarea name="'.$name.'"' ;

        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '' ;

        // On ajoute le texte
        $this->formCode .= '>'.$value.'</textarea>' ;

        return $this ;
        return $this ;
    }

    public static function cancel(array $form): bool
    {
        if (isset($form['action']) && mb_strtolower($form['action']) == 'annuler') {
            return true ;
        }

        return false ;
    }

    /**
     * Génère le formulaire HTML
     *
     * @return void
     */
    public function create()
    {
        return $this->formCode ;
    }
    
    /**
     * Balise de fermeture du formulaire
     *
     * @return Form
     */
    public function endForm(): self
    {
        $this->formCode .= '</div>'
            . '</div>' ;
        $this->formCode .= '</form>' ;
        return $this ;
    }

    /**
     * Balise d'ouverture du formulaire
     *
     * @param string $method    Méthode du Formulaire ('post' ou 'get')
     * @param string $action    Action du formulaire
     * @param array $attributes Attributs
     * @return Form
     */
    public function startForm(string $method = 'post', string $action = '#', array $attributes = []): self
    {
        // On crée la balise FORM
        $this->formCode .= '<form action="'.$action.'" method="'.$method.'"' ;
        
        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '' ;
        
        $this->formCode .= ' enctype="multipart/form-data">' ;

        $this->formCode .= '<div class="card border shadow-sm">'
            . '<div class="card-body">' ;

        return $this ;
    }

    /**
     * Valide si tous les champs proposés sont remplis
     *
     * @param array $form   Tableau issu du formulaire
     * @param array $fields Tableau listant les champs obligatoires
     * @return bool
     */
    public static function validate(array $form, array $fields): bool
    {
        // On parcourt les champs
        foreach ($fields as $field) {
            // si le champ est absent ou vide dans le formulaire
            if (!isset($form[$field]) || empty($form[$field])) {
                // On sort en retournant false
                return false ;
            }
        }
        return true ;
    }
}