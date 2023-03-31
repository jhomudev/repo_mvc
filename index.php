<?php
require_once "./config/APP.php";
require_once "./Controllers/viewController.php";

$template=new viewController();
$template->getTemplateController();