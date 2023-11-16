<?php

class ErrorController extends Controller
{
    public function process(array $parameters): void
    {
        header("HTTP/1.0 404 Not Found");
        
        $this->head['title'] = 'Chyba 404';
        
        $this->view = 'error';
    }
}

