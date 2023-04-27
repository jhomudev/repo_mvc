<?php
require_once "./config/APP.php";
require_once "./Controllers/ViewController.php";

$template = new ViewController();
$template->getTemplateController();
