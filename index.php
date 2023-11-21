<?php

session_start();

mb_internal_encoding("UTF-8");

/**
 * Callback funkce pro automaticke nacitani kontroleru a modelu
 * @param string $class Nazev tridy k nacteni
 * @return void
 */
function autoloadFunction(string $class): void
{
    if (preg_match('/Controller$/', $class)) {	
	require("controllers/" . $class . ".php");
    } else {
	require("models/" . $class . ".php");
    }
}
//ini_set("display_errors", "1");
// Registrace callbacku
spl_autoload_register("autoloadFunction");

// Připojení k databázi
Db::connect("127.0.0.1", "root", "", "insurance_db");

// Vytvoření routeru, zpracování URL
$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));

//Výpis základního pohledu
$router->loadView();