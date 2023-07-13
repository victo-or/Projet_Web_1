<?php

/**
 * Classe Contrôleur des requêtes de l'interface frontend
 * 
 */

class Frontend extends Routeur {

  private $enchere_id;
  private $oUtilConn;
  
  /**
   * Constructeur qui initialise des propriétés à partir du query string
   * et la propriété oRequetesSQL déclarée dans la classe Routeur
   * 
   */
  public function __construct() {
    $this->oUtilConn = $_SESSION['oUtilConn'] ?? null; 
    $this->enchere_id   = $_GET['enchere_id']       ?? null; 
    $this->oRequetesSQL = new RequetesSQL;
  }

  /**
   * Connecter un utilisateur
   */
  public function connecter() {
    $utilisateur = $this->oRequetesSQL->connecter($_POST);
    if ($utilisateur !== false) {
      $_SESSION['oUtilConn'] = new Utilisateur($utilisateur);
    }
    echo json_encode($utilisateur);
  }

  /**
   * Créer un compte utilisateur
   */
  public function creerCompte() {
    $oUtilisateur = new Utilisateur($_POST);
    var_dump($oUtilisateur);
    $erreurs = $oUtilisateur->erreurs;
    if (count($erreurs) > 0) {
      $retour = $erreurs;
    } else {
      $retour = $this->oRequetesSQL->creerCompteClient($_POST);
      if (!is_array($retour) && preg_match('/^[1-9]\d*$/', $retour)) {
        $oUtilisateur->profil = Utilisateur::PROFIL_CLIENT;
        $_SESSION['oUtilConn'] = $oUtilisateur;
      } 
    }
    // var_dump($retour);
    echo json_encode($retour);
  }

  /**
   * Déconnecter un utilisateur
   */
  public function deconnecter() {
    unset ($_SESSION['oUtilConn']);
    echo json_encode(true);
  }

  /**
   * Page d'accueil
   */  
  public function voirAccueil() {
    // ===> à compléter
    new Vue(
      'vAccueil',
      [
        'oUtilConn' => $this->oUtilConn,
        'titre'    => "Accueil"
      ]
    );
  }

  /**
   * Page profil
   */  
  public function voirProfil() {
    // ===> à compléter
    new Vue(
      'vProfil',
      [
        'oUtilConn' => $this->oUtilConn,
        'titre'    => "Profil"
      ]
    );
  }

  /**
   * Lister les encheres dans la page catalogue
   * 
   */  
  public function listerEncheres() {
    $encheres = $this->oRequetesSQL->getEncheres();
    new Vue("vListeEncheres",
            array(
              'oUtilConn' => $this->oUtilConn,
              'titre'  => "Catalogue des enchères",
              'encheres' => $encheres
            ),
            "gabarit-frontend");
  }

    /**
   * Voir les informations d'une enchere
   * 
   */  
  public function voirEnchere() {
    $enchere = false;
    if (!is_null($this->enchere_id)) {
      $enchere  = $this->oRequetesSQL->getEnchere($this->enchere_id);
      $images    = $this->oRequetesSQL->getImages($this->enchere_id);

    }
    if (!$enchere) throw new Exception("Enchere inexistante.");

    new Vue("vEnchere",
            array(
              'oUtilConn' => $this->oUtilConn,
              'titre'        => "Fiche d'enchère",
              'enchere'      => $enchere,
              'images'        => $images
            ),
            "gabarit-frontend");
  }
}