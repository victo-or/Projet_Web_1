<?php

/**
 * Classe Contrôleur des requêtes de l'interface frontend
 * 
 */

class Frontend extends Routeur {

  // pour le profil
  private $methodes = [
    'enchere' => [
      'l' => ['methode' => 'listerMesEncheres'],
      'a' => ['methode' => 'ajouterEnchere'],
      'm' => ['methode' => 'modifierEnchere'],
      's' => ['methode' => 'supprimerEnchere']
    ],
    'favori' => [
      'l' => ['methode' => 'listerMesFavoris'],
      // 'a' => ['methode' => 'ajouterLivre'],
      's' => ['methode' => 'supprimerLivre']
    ],
    'mise' => [
      'l' => ['methode' => 'listerMesMises']
    ]
  ];

  private $entite;
  private $action;
  private $enchere_id;
  private $oUtilConn;
  
  private $classRetour = "fait";
  private $messageRetourAction = "";

  /**
   * Constructeur qui initialise des propriétés à partir du query string
   * et la propriété oRequetesSQL déclarée dans la classe Routeur
   * 
   */
  public function __construct() {
    $this->oUtilConn = $_SESSION['oUtilConn'] ?? null; 
    $this->enchere_id   = $_GET['enchere_id'] ?? null; 

    // gestion profil
    $this->entite    = $_GET['entite']    ?? null;
    $this->action    = $_GET['action']    ?? null;
    $this->enchere_id = $_GET['enchere_id'] ?? null;

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



  // /**
  //  * Gérer l'interface profil 
  //  */  
  // public function gererProfil() {
  //   if (isset($_SESSION['oUtilConn'])) {
  //     $this->oUtilConn = $_SESSION['oUtilConn'];
  //     if (isset($this->methodes[$this->entite])) {
  //       if (isset($this->methodes[$this->entite][$this->action])) {
  //         $methode = $this->methodes[$this->entite][$this->action]['methode'];

  //         // TODO contrôler les droits de cette action et provoquer une exception HTTP 403
  //         // si l'utilisateur connecté n'a pas un profil dans cette liste de droits
  //         // (remplace tous les contrôles effectuées au début de chaque méthode)

  //         $this->$methode();
  //       } else {
  //         throw new Exception("L'action $this->action de l'entité $this->entite n'existe pas.");
  //       }
  //     } else {
  //       throw new Exception("L'entité $this->entite n'existe pas.");
  //     }
  //   } else {
  //     $this->connecter();
  //   }
  // }
  
  // GESTION PROFIL =======================================================
  // ======================================================================

  /**
   * Gérer l'interface profil 
   */  
  public function gererProfil() {
    if (isset($_SESSION['oUtilConn'])) {
        $this->oUtilConn = $_SESSION['oUtilConn'];
        if (isset($this->methodes[$this->entite])) {
            if (isset($this->methodes[$this->entite][$this->action])) {
                $methode = $this->methodes[$this->entite][$this->action]['methode'];

                // Contrôler les droits de cette action et provoquer une exception HTTP 403
                // si l'utilisateur connecté n'a pas un profil dans cette liste de droits

                $this->$methode();
            } else {
                throw new Exception("L'action $this->action de l'entité $this->entite n'existe pas.");
            }
        } elseif ($this->entite === null && $this->action === null) {
            $this->voirProfil(); // Appel de la méthode voirProfil()
        } else {
            throw new Exception("L'entité $this->entite n'existe pas.");
        }
    } else {
        $this->connecter();
    }
  }

  /**
   * Lister les encheres dans le profil utilisateur
   */
  public function listerMesEncheres() {
    $utilisateur_id = $this->oUtilConn->utilisateur_id;
    $mesEncheres = $this->oRequetesSQL->getMesEncheres($utilisateur_id);

    new Vue('vProfilEncheres',
            array(
              'oUtilConn'           => $this->oUtilConn,
              'titre'               => 'Gestion de mes enchères',
              'mesEncheres'             => $mesEncheres,
              'classRetour'         => $this->classRetour, 
              'messageRetourAction' => $this->messageRetourAction
            ),
            'gabarit-frontend');
  }

  // /**
  //  * Ajouter une enchère
  //  */
  // public function ajouterEnchere() {
  //   $enchere  = [];
  //   $erreurs = [];
  //   if (count($_POST) !== 0) {
  //     // retour de saisie du formulaire
  //     $enchere = $_POST;
  //     $oEnchere = new Enchere($enchere); // création d'un objet Enchere pour contrôler la saisie
  //     $oTimbre = new Timbre($enchere);
  //     $erreurs = $oEnchere->erreurs;
  //     if (count($erreurs) === 0) { // aucune erreur de saisie -> requête SQL d'ajout
  //       $id_vendeur = $this->oUtilConn->utilisateur_id;
  //       $enchere_id = $this->oRequetesSQL->ajouterEnchere([
  //         'id_vendeur'     => $id_vendeur,
  //         'enchere_debut'    => $oEnchere->enchere_date_debut,
  //         'enchere_date_fin' => $oEnchere->enchere_date_fin
  //       ]);
  //       if ( $enchere_id > 0) { // test de la clé de l'enchere ajouté
  //         $this->messageRetourAction = "Ajout de l'enchere numéro $enchere_id effectué.";
  //       } else {
  //         $this->classRetour = "erreur";
  //         $this->messageRetourAction = "Ajout de l'enchere non effectué.";
  //       }
  //       $this->listerMesEncheres(); // retour sur la page de liste des encheres dans le profil utilisateur
  //       exit;
  //     }
  //   }
    
  //   new Vue('vProfilAjouterEnchere',
  //           array(
  //             'oUtilConn' => $this->oUtilConn,
  //             'titre'     => 'Ajouter un enchere',
  //             'enchere'    => $enchere,
  //             'erreurs'   => $erreurs
  //           ),
  //           'gabarit-frontend');
  // }


  /**
  * Ajouter une enchère
  */
  public function ajouterEnchere()
  {
    $donneesFormulaire = [];
    $erreursEnchere = [];
    $erreursTimbre = [];

    if (count($_POST) !== 0) {
        // Retour de saisie du formulaire
        $donneesFormulaire = $_POST;
        $oEnchere = new Enchere($donneesFormulaire);
        $erreursEnchere = $oEnchere->erreurs;
        $oTimbre = new Timbre($donneesFormulaire);
        $oTimbre->setTimbre_image_principale($_FILES['timbre_image_principale']['name']); // pour contrôler le suffixe
        if (isset($_FILES['image_fichier'])) {
          $image_files = $_FILES['image_fichier'];
      
          foreach ($image_files['name'] as $filename) {
              $oTimbre->setImage_fichier($filename);
          }
      
          $erreursTimbre = $oTimbre->erreurs;
        }
      


        if (count($erreursEnchere) === 0 && count($erreursTimbre) === 0) { // Aucune erreur de saisie -> requête SQL d'ajout
            $id_vendeur = $this->oUtilConn->utilisateur_id;

            // Insertion de l'enchère dans la table "enchere"
            $enchere_id = $this->oRequetesSQL->ajouterEnchere([
                'id_vendeur' => $id_vendeur,
                'enchere_debut' => $oEnchere->enchere_date_debut,
                'enchere_date_fin' => $oEnchere->enchere_date_fin
            ]);

            if ($enchere_id > 0) { // Vérification de la clé de l'enchère ajoutée
                // Insertion des autres informations dans les tables associées
                $timbre_id = $this->oRequetesSQL->ajouterTimbre([
                    'timbre_nom' => $oTimbre->timbre_nom,
                    'timbre_date_creation' => $oTimbre->timbre_date_creation,
                    'timbre_condition' => $oTimbre->timbre_condition,
                    'timbre_tirage' => $oTimbre->timbre_tirage,
                    'timbre_longueur' => $oTimbre->timbre_longueur,
                    'timbre_largeur' => $oTimbre->timbre_largeur,
                    'timbre_certifie' => $oTimbre->timbre_certifie,
                    'timbre_description' => $oTimbre->timbre_description,
                    'timbre_couleur' => $oTimbre->timbre_couleur,
                    'timbre_image_principale' => $oTimbre->timbre_image_principale
                ]);

                // Insertion des images supplémentaires dans la table "image"
                if (isset($_FILES['image_fichier'])) {
                    $image_files = $_FILES['image_fichier'];
                    $this->oRequetesSQL->ajouterImages($timbre_id, $image_files);
                }

                $this->messageRetourAction = "Ajout de l'enchère numéro $enchere_id effectué.";
            } else {
                $this->classRetour = "erreur";
                $this->messageRetourAction = "Ajout de l'enchère non effectué.";
            }

            $this->listerMesEncheres(); // Retour sur la page de liste des enchères dans le profil utilisateur
            exit;
        }
    }

    new Vue(
        'vProfilAjouterEnchere',
        array(
            'oUtilConn' => $this->oUtilConn,
            'titre' => 'Ajouter une enchère',
            'donneesFormulaire' => $donneesFormulaire,
            'erreursEnchere' => $erreursEnchere,
            'erreursTimbre' => $erreursTimbre
        ),
        'gabarit-frontend'
    );
  }







}