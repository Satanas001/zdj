<?php
namespace App\Core ;

class ToolBarBuilder 
{
    private $htmlCode ; 

    private const ADD = 'fa-solid fa-plus fa-fw';
    private const LIST = 'fa-solid fa-th-list fa-fw';
    private const EDIT = 'fa-solid fa-pencil-alt fa-fw';
    private const PASSWORD = 'fa-solid fa-unlock-alt fa-fw';
    private const PDF = 'fa-solid fa-file-pdf fa-fw';
    private const BACK = 'fa-solid fa-undo fa-fw';
    private const DELETE = 'fa-regular fa-trash-alt fa-fw';

    /**
     * Adda attributes to the element
     *
     * @param array $attributes     Associative array of attributes
     * @return string               Generated character string
     */
    private function addAttributes(array $attributes): string
    {
        $str = '' ;

        foreach ($attributes as $attribute => $value) {
            $str .= ' '.$attribute . '="' . $value . '"' ;
        }

        return $str ;
    }

    public function addButton(string $type, string $label, array $action = [], array $attributes = []): self
    {
        
        $this->htmlCode .= '<a class="btn btn-primary m-1" title="'.$label.'"' ;
        $this->htmlCode .= $action ? $this->addAttributes($action) : '' ;
        $this->htmlCode .= $attributes ? $this->addAttributes($attributes) : '' ;
        $this->htmlCode .= '>' ;
        
        if (defined('self::'.mb_strtoupper($type))) {
            $this->htmlCode .= '<i class="'. constant('self::'.mb_strtoupper($type)) .'"></i>' ;
        }
        else {
            $this->htmlCode .= $type ;
        }

        $this->htmlCode .= '</a>' ;
        
        return $this ;
    }

    /**
     * Generates the toolbar
     *
     * @return void
     */
    public function create()
    {
        return $this->htmlCode ;
    }

    /**
     * Closing tag of the toolbar
     *
     * @return self
     */
    public function endToolBar(): self
    {
        $this->htmlCode .= '</section>' ;

        return $this ;
    }

    /**
     * Opening tag of the toolbar
     *
     * @param array $attributes Attributes of the toolbar
     * @return self
     */
    public function startToolBar(array $attributes = []): self
    {
        $this->htmlCode .= '<section' ;
        $this->htmlCode .= $attributes ? $this->addAttributes($attributes) : '' ;
        $this->htmlCode .= '>' ;

        return $this ;
    }

    
}