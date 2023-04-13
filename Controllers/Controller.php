<?php
namespace App\Controllers ;

abstract class Controller
{
    protected $template = 'default' ;

    public function render(string $file, array $data = [], string $template = '' )
    {
        if ($template) {
            $this->template = $template ;
        }

        extract($data) ;

        ob_start() ;
        // Path to the view file
        require_once ROOT . '/' . VIEWS_DIRECTORY . '/' . $file . '.php' ;
        
        // Transfère le buffer dans le $content
        // Transfer the buffer in $content
        $content = ob_get_clean() ;

        // Charge le template
        require_once ROOT . '/' . TEMPLATES_DIRECTORY . '/' . $this->template. '.php' ;
    }
}