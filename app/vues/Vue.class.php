<?php

class Vue {

  /**
   * Générer et afficher la page html complète associée à la vue
   * -----------------------------------------------------------
   * @param string $vue 
   * @param array $donnees, variables à insérer dans la page
   * @param string $gabarit
   */
  public function __construct($vue, $donnees=array(), $gabarit="gabarit-frontend") {
    require_once 'app/vues/vendor/autoload.php';
    $loader = new \Twig\Loader\FilesystemLoader('app/vues/templates');
    $twig = new \Twig\Environment($loader, [
      // 'cache' => 'app/vues/templates/cache',
    ]);

    $donnees['templateMain'] = "$vue.twig";
    $html = $twig->render("$gabarit.twig", $donnees);
    echo $html;
  }
}