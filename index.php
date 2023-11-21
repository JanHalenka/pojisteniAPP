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
ini_set("display_errors", "1");
spl_autoload_register("autoloadFunction");

Db::connect("127.0.0.1", "root", "", "insurance_db");

$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));

$router->loadView();