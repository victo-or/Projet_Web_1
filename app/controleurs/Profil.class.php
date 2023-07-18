<?php

require 'Profil.class';

/**
 * Classe Contrôleur des requêtes de l'application profil
 */

class Profil extends Routeur {

  private $entite;
  private $action;
  private $auteur_id;
  private $livre_id;

  private $oUtilConn;

  private $methodes = [
    'enchere' => [
      'l' => ['methode' => 'listerMesEncheres'],
      'a' => ['methode' => 'ajouterEnchere'],
      'm' => ['methode' => 'modifierEnchere'],
      's' => ['methode' => 'supprimerEnchere']
    ],
    'favori' => [
      'l' => ['methode' => 'listerFavoris'],
      // 'a' => ['methode' => 'ajouterLivre'],
      's' => ['methode' => 'supprimerLivre']
    ],
    'mise' => [
      'l' => ['methode' => 'listerMesMises']
    ]
    // ,
    // 'utilisateur' => [
    //   'd' => ['methode' => 'deconnecter']
    // ]
  ];

  private $classRetour = "fait";
  private $messageRetourAction = "";

  /**
   * Constructeur qui initialise le contexte du contrôleur  
   */  
  public function __construct() {
    $this->entite    = $_GET['entite']    ?? 'auteur';
    $this->action    = $_GET['action']    ?? 'l';
    $this->auteur_id = $_GET['auteur_id'] ?? null;
    $this->livre_id  = $_GET['livre_id']  ?? null;
    $this->oRequetesSQL = new RequetesSQL;
  }

  /**
   * Gérer l'interface d'administration 
   */  
  public function gererAdmin() {
    if (isset($_SESSION['oUtilConn'])) {
      $this->oUtilConn = $_SESSION['oUtilConn'];
      if (isset($this->methodes[$this->entite])) {
        if (isset($this->methodes[$this->entite][$this->action])) {
          $methode = $this->methodes[$this->entite][$this->action]['methode'];

          // TODO contrôler les droits de cette action et provoquer une exception HTTP 403
          // si l'utilisateur connecté n'a pas un profil dans cette liste de droits
          // (remplace tous les contrôles effectuées au début de chaque méthode)

          $this->$methode();
        } else {
          throw new Exception("L'action $this->action de l'entité $this->entite n'existe pas.");
        }
      } else {
        throw new Exception("L'entité $this->entite n'existe pas.");
      }
    } else {
      $this->connecter();
    }
  }



  /**
   * Lister les auteurs
   */
  public function listerAuteurs() {
    if ($this->oUtilConn->utilisateur_profil == Utilisateur::CLIENT) {
      throw new Exception(self::ERROR_FORBIDDEN);
    }
    $auteurs = $this->oRequetesSQL->getAuteurs();

    new Vue('vAdminAuteurs',
            array(
              'oUtilConn'           => $this->oUtilConn,
              'titre'               => 'Gestion des auteurs',
              'auteurs'             => $auteurs,
              'classRetour'         => $this->classRetour, 
              'messageRetourAction' => $this->messageRetourAction
            ),
            'gabarit-admin');
  }

  /**
   * Ajouter un auteur
   */
  public function ajouterAuteur() {
    if ($this->oUtilConn->utilisateur_profil == Utilisateur::CLIENT || $this->oUtilConn->utilisateur_profil == Utilisateur::CORRECTEUR) {
      throw new Exception(self::ERROR_FORBIDDEN);
    }
    $auteur  = [];
    $erreurs = [];
    if (count($_POST) !== 0) {
      // retour de saisie du formulaire
      $auteur = $_POST;
      $oAuteur = new Auteur($auteur); // création d'un objet Auteur pour contrôler la saisie
      $erreurs = $oAuteur->erreurs;
      if (count($erreurs) === 0) { // aucune erreur de saisie -> requête SQL d'ajout
        $auteur_id = $this->oRequetesSQL->ajouterAuteur([
          'auteur_nom'    => $oAuteur->auteur_nom,
          'auteur_prenom' => $oAuteur->auteur_prenom
        ]);
        if ( $auteur_id > 0) { // test de la clé de l'auteur ajouté
          $this->messageRetourAction = "Ajout de l'auteur numéro $auteur_id effectué.";
        } else {
          $this->classRetour = "erreur";
          $this->messageRetourAction = "Ajout de l'auteur non effectué.";
        }
        $this->listerAuteurs(); // retour sur la page de liste des auteurs
        exit;
      }
    }
    
    new Vue('vAdminAuteurAjouter',
            array(
              'oUtilConn' => $this->oUtilConn,
              'titre'     => 'Ajouter un auteur',
              'auteur'    => $auteur,
              'erreurs'   => $erreurs
            ),
            'gabarit-admin');
  }

  /**
   * Modifier un auteur identifié par sa clé dans la propriété auteur_id
   */
  public function modifierAuteur() {
    if ($this->oUtilConn->utilisateur_profil == Utilisateur::CLIENT) {
      throw new Exception(self::ERROR_FORBIDDEN);
    }
    if (count($_POST) !== 0) {
      $auteur = $_POST;
      $oAuteur = new Auteur($auteur);
      $erreurs = $oAuteur->erreurs;
      if (count($erreurs) === 0) {
        if($this->oRequetesSQL->modifierAuteur([
          'auteur_id'     => $oAuteur->auteur_id,
          'auteur_nom'    => $oAuteur->auteur_nom,
          'auteur_prenom' => $oAuteur->auteur_prenom
        ])) {
          $this->messageRetourAction = "Modification de l'auteur numéro $this->auteur_id effectuée.";
        } else {
          $this->classRetour = "erreur";
          $this->messageRetourAction = "modification de l'auteur numéro $this->auteur_id non effectuée.";
        }
        $this->listerAuteurs();
        exit;
      }

    } else {
      // chargement initial du formulaire
      // initialisation des champs dans la vue formulaire avec les données SQL de cet auteur  
      $auteur  = $this->oRequetesSQL->getAuteur($this->auteur_id);
      if (!$auteur) throw new Exception('Auteur inexistant.');
      $erreurs = [];
    }
    
    new Vue('vAdminAuteurModifier',
            array(
              'oUtilConn' => $this->oUtilConn,
              'titre'     => "Modifier l'auteur numéro $this->auteur_id",
              'auteur'    => $auteur,
              'erreurs'   => $erreurs
            ),
            'gabarit-admin');
  }
  
  /**
   * Supprimer un auteur identifié par sa clé dans la propriété auteur_id
   */
  public function supprimerAuteur() {
    if ($this->oUtilConn->utilisateur_profil == Utilisateur::CLIENT || $this->oUtilConn->utilisateur_profil == Utilisateur::CORRECTEUR) {
      throw new Exception(self::ERROR_FORBIDDEN);
    }
    if ($this->oRequetesSQL->supprimerAuteur($this->auteur_id)) {
      $this->messageRetourAction = "Suppression de l'auteur numéro $this->auteur_id effectuée.";
    } else {
      $this->classRetour = "erreur";
      $this->messageRetourAction = "Suppression de l'auteur numéro $this->auteur_id non effectuée.";
    }
    $this->listerAuteurs();
  }

  /**
   * Lister les livres
   */
  public function listerLivres() {
    if ($this->oUtilConn->utilisateur_profil == Utilisateur::CLIENT) {
      throw new Exception(self::ERROR_FORBIDDEN);
    }
    $livres = $this->oRequetesSQL->getLivres('livre_id', 'DESC');

    new Vue('vAdminLivres',
            array(
              'oUtilConn'           => $this->oUtilConn,
              'titre'               => 'Gestion des livres',
              'livres'              => $livres,
              'classRetour'         => $this->classRetour, 
              'messageRetourAction' => $this->messageRetourAction
            ),
            'gabarit-admin');
  }

  /**
   * Ajouter un livre
   */
  public function ajouterLivre() {
    if ($this->oUtilConn->utilisateur_profil == Utilisateur::CLIENT || $this->oUtilConn->utilisateur_profil == Utilisateur::CORRECTEUR) {
      throw new Exception(self::ERROR_FORBIDDEN);
    }
    $auteurs = $this->oRequetesSQL->getAuteurs('auteur_nom', 'ASC');
    $livre   = [];
    $erreurs = [];
    if (count($_POST) !== 0) {
      // retour de saisie du formulaire
      $livre = $_POST;
      $oLivre = new Livre($livre); // création d'un objet Livre pour contrôler la saisie
      $erreurs = $oLivre->erreurs;
      if (count($erreurs) === 0) { // aucune erreur de saisie -> requête SQL d'ajout
        $livre_id = $this->oRequetesSQL->ajouterLivre([
          'livre_titre'     => $oLivre->livre_titre,
          'livre_annee'     => $oLivre->livre_annee,
          'livre_resume'    => $oLivre->livre_resume,
          'livre_auteur_id' => $oLivre->livre_auteur_id
        ]);
        if ( $livre_id > 0) { // test de la clé du livre ajouté
          $this->messageRetourAction = "Ajout du livre numéro $livre_id effectué.";
        } else {
          $this->classRetour = "erreur";
          $this->messageRetourAction = "Ajout du livre non effectué.";
        }
        $this->listerLivres(); // retour sur la page de liste des livres
        exit;
      }
    }
    
    new Vue('vAdminLivreAjouter',
            array(
              'oUtilConn' => $this->oUtilConn,
              'titre'     => 'Ajouter un livre',
              'livre'     => $livre,
              'auteurs'   => $auteurs,
              'erreurs'   => $erreurs
            ),
            'gabarit-admin');
  }

  /**
   * Modifier un livre identifié par sa clé dans la propriété livre_id
   */
  public function modifierLivre() {
    if ($this->oUtilConn->utilisateur_profil == Utilisateur::CLIENT) {
      throw new Exception(self::ERROR_FORBIDDEN);
    }
    $auteurs = $this->oRequetesSQL->getAuteurs('auteur_nom', 'ASC');
    if (count($_POST) !== 0) {
      $livre = $_POST;
      $oLivre = new Livre($livre);
      $erreurs = $oLivre->erreurs;
      if (count($erreurs) === 0) {
        if($this->oRequetesSQL->modifierLivre([
          'livre_id'        => $oLivre->livre_id,
          'livre_titre'     => $oLivre->livre_titre,
          'livre_annee'     => $oLivre->livre_annee,
          'livre_resume'    => $oLivre->livre_resume,
          'livre_auteur_id' => $oLivre->livre_auteur_id
        ])) {
          $this->messageRetourAction = "Modification du livre numéro $this->livre_id effectuée.";
        } else {
          $this->classRetour = "erreur";
          $this->messageRetourAction = "modification du livre numéro $this->livre_id non effectuée.";
        }
        $this->listerLivres();
        exit;
      }

    } else {
      // chargement initial du formulaire
      // initialisation des champs dans la vue formulaire avec les données SQL de cet auteur  
      $livre   = $this->oRequetesSQL->getLivre($this->livre_id);
      if (!$livre) throw new Exception('Livre inexistant.');
      $erreurs = [];
    }
    
    new Vue('vAdminLivreModifier',
            array(
              'oUtilConn' => $this->oUtilConn,
              'titre'     => "Modifier le livre numéro $this->livre_id",
              'livre'     => $livre,
              'auteurs'   => $auteurs,
              'erreurs'   => $erreurs
            ),
            'gabarit-admin');
  }
  
  /**
   * Supprimer un livre identifié par sa clé dans la propriété livre_id
   */
  public function supprimerLivre() {
    if ($this->oUtilConn->utilisateur_profil == Utilisateur::CLIENT || $this->oUtilConn->utilisateur_profil == Utilisateur::CORRECTEUR) {
      throw new Exception(self::ERROR_FORBIDDEN);
    }
    if ($this->oRequetesSQL->supprimerLivre($this->livre_id)) {
      $this->messageRetourAction = "Suppression du livre numéro $this->livre_id effectuée.";
    } else {
      $this->classRetour = "erreur";
      $this->messageRetourAction = "Suppression du livre numéro $this->livre_id non effectuée.";
    }
    $this->listerLivres();
  }
}