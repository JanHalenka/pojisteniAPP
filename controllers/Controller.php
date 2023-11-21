<?php
/**
 * Abstraktni kontroler
 * 
 * @author jan
 */
abstract class Controller {
    
    protected array $data = array();
    protected string $view = "";
    protected array $head = array('title' => '', 'keywords' => '', 'description' => '');

    abstract function process(array $parameters): void;
    
    public function loadView(): void
    {
        if ($this->view) {
            extract($this->protectXSS($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("views/$this->view.phtml");
        }
    }
    
    public function redirect(string $url): never
    {
        header("Location: /$url");
        header("Connection: close");
    }
    
    private function protectXSS(mixed $x = null): mixed
    {
        if (!isset($x)) {
            return null;
        }
        elseif (is_string($x)) {
            return htmlspecialchars($x, ENT_QUOTES);
        }
        elseif (is_array($x)) {
            foreach($x as $k => $v) {
                $x[$k] = $this->protectXSS($v);
            }
            return $x;
        } else {
            return $x;
        }
    }

    public function addMessage(string $message): void
    {
        if (isset($_SESSION['messages'])) {
            $_SESSION['messages'][] = $message;
            
        } else {
            $_SESSION['messages'] = array($message);
        }
    }
    
    public function returnMessages(): array
    {
        if (isset($_SESSION['messages'])) {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $messages;
        } else {
            return array();
        }
    }
}
