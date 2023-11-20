<?php
/**
 * Description of RouterController
 *
 * @author jan
 */
class RouterController extends Controller {
    
    protected Controller $controller;
    
    public function process(array $parameters): void
    {
        $parsedURL = $this->parseURL($parameters[0]);

        if (empty($parsedURL[0]) || $parsedURL[0] === 'index.php') {
            $this->redirect('customers');
        }
            
        $classOfController = $this->hyphensIntoCamelCase(array_shift($parsedURL)) . 'Controller';
        
        if (file_exists('controllers/' . $classOfController . '.php')) {
            $this->controller = new $classOfController;            
        } else {
            $this->redirect('error');
        }
        
        $this->controller->process($parsedURL);
        
        $this->data['title'] = $this->controller->head['title'];
	$this->data['description'] = $this->controller->head['description'];
	$this->data['keywords'] = $this->controller->head['keywords'];
        
        $this->view = 'layout';
    }
    
    private function parseURL(string $url): array
    {
        $parsedURL = parse_url($url);
        $parsedURL["path"] = ltrim($parsedURL["path"], "/");
        $parsedURL["path"] = trim($parsedURL["path"]);
        
        $splittedPath = explode("/", $parsedURL["path"]);
        
        return $splittedPath;
    }
    
    private function hyphensIntoCamelCase(string $text): string
    {
        $sentence = str_replace('-', ' ', $text);
        $sentence = ucwords($sentence);
        $sentence = str_replace(' ', '', $sentence);
        
        return $sentence;
    }
}
