<?php
/**
 * Abstraktní výchozí kontroler
 * 
 * @author Jan Halenka
 */
abstract class Controller {
    
    /**
     * Pole obsahující proměnné v šabloně
     * @var array
     */
    protected array $data = array();
    /**
     * 
     * @var string Název šablony bez přípony
     */
    protected string $view = "";
    /**
     * 
     * @var array Pole obsahující hlavičku html
     */
    protected array $head = array('title' => '', 'keywords' => '', 'description' => '');

    /**
     * Hlavní metoda kontroleru
     * @param array Pole vstupních parametrů
     */
    abstract function process(array $parameters): void;
    
    /**
     * Zobrazí požadovaný pohled
     * @return void
     */
    public function loadView(): void
    {
        if ($this->view) {
            extract($this->protectXSS($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("views/$this->view.phtml");
        }
    }
    
    /**
     * Přesměruje na zadanou url
     * @param string $url
     * @return never
     */
    public function redirect(string $url): never
    {
        header("Location: /$url");
        header("Connection: close");
    }
    
    /**
     * Ošetření uživatelem zadaných proměnných
     * @param mixed $x
     * @return mixed
     */
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

    /**
     * Přidá zprávu pro uživatele
     * @param string $message
     * @return void
     */
    public function addMessage(string $message): void
    {
        if (isset($_SESSION['messages'])) {
            $_SESSION['messages'][] = $message;
            
        } else {
            $_SESSION['messages'] = array($message);
        }
    }
    
    /**
     * Vrátí zprávy pro uživatele
     * @return array Pole uložených zpráv
     */
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
