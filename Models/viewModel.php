<?php

class viewModel
{

  // Modelo para obteber las vistas
  protected static function getViewModel($view)
  {
    $listOk = ["student", "instructor", "admin","project"];
    if (in_array($view, $listOk)) {
      if (is_file("./Views/contents/" . $view . "-view.php")) $content = $view;
      else $content = "404";
    } elseif ($view == "login" || $view == "index") $content = "login";
    else $content = "404";

    return $content;
  }
}
