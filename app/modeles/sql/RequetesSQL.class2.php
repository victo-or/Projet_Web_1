<?php

/**
 * Classe des requêtes SQL
 *
 */
class RequetesSQL extends RequetesPDO {

  // /**
  //  * Récupération des encheres à afficher dans la page catalogue
  //  * @return array tableau des lignes produites par la select   
  //  */ 
  // public function getEncheres($utilisateur_id = null) {
  //   $this->sql = '
  //   SELECT
  //     enchere.*,
  //     MAX(mise.mise_montant) AS offre_actuelle,
  //     COUNT(mise.mise_id) AS nb_mises,
  //     timbre.*,
  //     CONCAT(
  //       FLOOR(TIMESTAMPDIFF(HOUR, NOW(), enchere_date_fin) / 24),
  //       " jours, ",
  //       MOD(TIMESTAMPDIFF(HOUR, NOW(), enchere_date_fin), 24),
  //       " heures, ",
  //       MINUTE(TIMEDIFF(enchere_date_fin, NOW())),
  //       " minutes"
  //     ) AS temps_restant
  //   FROM
  //     enchere
  //   INNER JOIN timbre ON timbre_id = enchere.id_timbre
  //   LEFT JOIN mise ON mise.id_enchere = enchere_id
  //   WHERE TIMEDIFF(enchere_date_fin, NOW()) > 0
  //   GROUP BY enchere_id';
  //   return $this->getLignes();
  // }
  
  /**
   * Récupération des encheres à afficher dans la page catalogue
   * @return array tableau des lignes produites par la select   
   */ 
  public function getEncheres($params = []) {
    // $utilisateur_id = isset($params['utilisateur_id']) ? $params['utilisateur_id'] : null;
    // $keyword = isset($params['keyword']) ? $params['keyword'] : null;

    $this->sql = '
    SELECT
        enchere.*,
        MAX(mise.mise_montant) AS offre_actuelle,
        COUNT(mise.mise_id) AS nb_mises,
        timbre.*,
        timbre.timbre_nom,
        CONCAT(
            FLOOR(TIMESTAMPDIFF(HOUR, NOW(), enchere_date_fin) / 24),
            " jours, ",
            MOD(TIMESTAMPDIFF(HOUR, NOW(), enchere_date_fin), 24),
            " heures, ",
            MINUTE(TIMEDIFF(enchere_date_fin, NOW())),
            " minutes"
        ) AS temps_restant';
    if (isset($params['utilisateur_id'])) {
      $this->sql .= ', IF(favori.id_utilisateur IS NOT NULL, 1, 0) AS favori';
    }

    $this->sql .= '    
    FROM
        enchere
    INNER JOIN timbre ON timbre_id = enchere.id_timbre
    LEFT JOIN mise ON mise.id_enchere = enchere_id';

    if (isset($params['utilisateur_id'])) {
      $this->sql .= ' LEFT JOIN favori ON favori.id_utilisateur = :utilisateur_id AND favori.id_enchere = enchere.enchere_id';
    }

    $this->sql .= '
    WHERE
        TIMEDIFF(enchere_date_fin, NOW()) > 0';

    if (isset($params['keyword'])) {
        $this->sql .= ' AND timbre.timbre_nom LIKE :keyword';
    }

    $this->sql .= ' GROUP BY enchere_id';

    // $params['utilisateur_id'] = $utilisateur_id;

    if (isset($params['keyword'])) {
      $params['keyword'] = '%' . $params['keyword'] . '%';
    }
    // $params['keyword'] = '%' . $keyword . '%';

    return $this->getLignes($params);
  }

  // /**
  //  * Récupération des encheres à afficher dans la page catalogue
  //  * @return array tableau des lignes produites par la select   
  //  */ 
  // public function getEncheres($utilisateur_id = null) {
  //   $this->sql = '
  //   SELECT
  //     enchere.*,
  //     MAX(mise.mise_montant) AS offre_actuelle,
  //     COUNT(mise.mise_id) AS nb_mises,
  //     timbre.*,
  //     CONCAT(
  //       FLOOR(TIMESTAMPDIFF(HOUR, NOW(), enchere_date_fin) / 24),
  //       " jours, ",
  //       MOD(TIMESTAMPDIFF(HOUR, NOW(), enchere_date_fin), 24),
  //       " heures, ",
  //       MINUTE(TIMEDIFF(enchere_date_fin, NOW())),
  //       " minutes"
  //     ) AS temps_restant,
  //     IF(favori.id_utilisateur IS NOT NULL, 1, 0) AS favori
  //   FROM
  //     enchere
  //   INNER JOIN timbre ON timbre_id = enchere.id_timbre
  //   LEFT JOIN mise ON mise.id_enchere = enchere_id
  //   LEFT JOIN favori ON favori.id_utilisateur = :utilisateur_id AND favori.id_enchere = enchere.enchere_id
  //   WHERE TIMEDIFF(enchere_date_fin, NOW()) > 0
  //   GROUP BY enchere_id';

  //   return $this->getLignes(['utilisateur_id' => $utilisateur_id]);
  // }
  

  // /**
  //  * Récupération des encheres à afficher dans la page catalogue
  //  * @return array tableau des lignes produites par la select   
  //  */ 
  // public function getEncheres() {
  //   $this->sql = '
  //   SELECT
  //     enchere.*,
  //     (
  //       SELECT MAX(mise_montant)
  //       FROM mise
  //       WHERE id_enchere = enchere.enchere_id
  //     ) AS offre_actuelle,
  //     (
  //       SELECT COUNT(mise_id)
  //       FROM mise
  //       WHERE id_enchere = enchere.enchere_id
  //     ) AS nb_mises,
  //     timbre.*,
  //     DATE_FORMAT(TIMEDIFF(enchere_date_fin, NOW()), "%d jours, %H heures, %i minutes") AS temps_restant
  //   FROM
  //     enchere
  //   INNER JOIN timbre ON timbre_id = enchere.id_timbre
  //   WHERE TIMEDIFF(enchere_date_fin, NOW()) > 0
  //   GROUP BY enchere_id';
  //   return $this->getLignes();
  // }


  /**
   * Récupération d'une enchere
   * @param int $enchere_id, clé de l'enchère
   * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne  
   */ 
  public function getEnchere($enchere_id) {
    $this->sql = '
    SELECT 
      enchere.*, 
      timbre.*, 
      vendeur.utilisateur_pseudo AS pseudo_vendeur,
      MAX(mise.mise_montant) AS offre_actuelle,
      COUNT(mise.mise_id) AS nb_mises,
      miseur.utilisateur_id AS id_utilisateur_offre_actuelle,
      CONCAT(
        FLOOR(TIMESTAMPDIFF(HOUR, NOW(), enchere_date_fin) / 24),
        " jours, ",
        MOD(TIMESTAMPDIFF(HOUR, NOW(), enchere_date_fin), 24),
        " heures, ",
        MINUTE(TIMEDIFF(enchere_date_fin, NOW())),
        " minutes"
      ) AS temps_restant
    FROM enchere
    INNER JOIN timbre ON enchere.id_timbre = timbre.timbre_id
    INNER JOIN utilisateur as vendeur ON enchere.id_vendeur = vendeur.utilisateur_id
    LEFT JOIN mise ON mise.id_enchere = enchere.enchere_id
    LEFT JOIN utilisateur AS miseur ON miseur.utilisateur_id = (
      SELECT id_utilisateur
      FROM mise
      WHERE id_enchere = enchere.enchere_id
      ORDER BY mise_montant DESC
      LIMIT 1
    )
    WHERE enchere.enchere_id = :enchere_id';

    return $this->getLignes(['enchere_id' => $enchere_id], RequetesPDO::UNE_SEULE_LIGNE);
  }
  // /**
  //  * Récupération d'une enchere
  //  * @param int $enchere_id, clé de l'enchère
  //  * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne  
  //  */ 
  // public function getEnchere($enchere_id) {
  //   $this->sql = "
  //   SELECT 
  //     enchere.*, 
  //     timbre.*, 
  //     utilisateur.utilisateur_pseudo,
  //     mise.mise_montant AS offre_actuelle,
  //     COUNT(mise.mise_id) AS nb_mises,
  //     DATE_FORMAT(TIMEDIFF(enchere.enchere_date_fin, NOW()), '%d jours, %H heures, %i minutes') AS temps_restant
  //   FROM enchere
  //   INNER JOIN timbre ON enchere.id_timbre = timbre.timbre_id
  //   INNER JOIN utilisateur ON enchere.id_vendeur = utilisateur.utilisateur_id
  //   LEFT JOIN mise ON mise.id_enchere = enchere.enchere_id
  //   WHERE enchere.enchere_id = :enchere_id";

  //   return $this->getLignes(['enchere_id' => $enchere_id], RequetesPDO::UNE_SEULE_LIGNE);
  // }

  /**
   * Récupération des images supplémentaires à afficher dans la fiche d'enchère
   * @param int $enchere_id, clé de l'enchère
   * @return array tableau des lignes produites par la select
   */ 
  public function getImages($enchere_id) {
    $this->sql = '
    SELECT 
      image_fichier 
    FROM image 
    WHERE id_timbre IN (SELECT id_timbre FROM enchere WHERE enchere_id = :enchere_id)';
    return $this->getLignes(['enchere_id' => $enchere_id]);
  }

  /**
   * Contrôler si adresse courriel non déjà utilisée par un autre utilisateur que utilisateur_id
   * @param array $champs tableau utilisateur_courriel et utilisateur_id (0 si dans toute la table)
   * @return array|false utilisateur avec ce courriel, false si courriel disponible
   */ 
  public function controlerCourriel($champs) {
    $this->sql = 'SELECT utilisateur_id FROM utilisateur
                  WHERE utilisateur_courriel = :utilisateur_courriel AND utilisateur_id != :utilisateur_id';
    return $this->getLignes($champs, RequetesPDO::UNE_SEULE_LIGNE);
  }

  /**
   * Contrôler si pseudo non déjà utilisé par un autre utilisateur que utilisateur_id
   * @param array $champs tableau utilisateur_pseudo et utilisateur_id (0 si dans toute la table)
   * @return array|false utilisateur avec ce pseudo, false si pseudo disponible
   */ 
  public function controlerPseudo($champs) {
    $this->sql = 'SELECT utilisateur_id FROM utilisateur
                  WHERE utilisateur_pseudo = :utilisateur_pseudo AND utilisateur_id != :utilisateur_id';
    return $this->getLignes($champs, RequetesPDO::UNE_SEULE_LIGNE);
  }

  /**
   * Connecter un utilisateur
   * @param array $champs, tableau avec les champs utilisateur_courriel et utilisateur_mdp  
   * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne
   */ 
  public function connecter($champs) {
    $this->sql = "
      SELECT utilisateur_id, utilisateur_nom, utilisateur_prenom, utilisateur_pseudo,
             utilisateur_courriel, utilisateur_profil
      FROM utilisateur
      WHERE utilisateur_courriel = :utilisateur_courriel AND utilisateur_mdp = SHA2(:utilisateur_mdp, 512)";
    return $this->getLignes($champs, RequetesPDO::UNE_SEULE_LIGNE);
  }


  /**
   * Créer un compte utilisateur dans le frontend
   * @param array $champs tableau des champs de l'utilisateur 
   * @return int|string clé primaire de la ligne ajoutée, message d'erreur sinon
   */ 
  public function creerCompteClient($champs) {
    $utilisateur = $this->controlerCourriel(
      ['utilisateur_courriel' => $champs['utilisateur_courriel'], 'utilisateur_id' => 0]);
    if ($utilisateur !== false)
      return ['utilisateur_courriel' => Utilisateur::ERR_COURRIEL_EXISTANT];
    $utilisateur = $this->controlerPseudo(
      ['utilisateur_pseudo' => $champs['utilisateur_pseudo'], 'utilisateur_id' => 0]);
    if ($utilisateur !== false)
      return ['utilisateur_courriel' => Utilisateur::ERR_PSEUDO_EXISTANT];
    unset($champs['nouveau_mdp_bis']);  
    $this->sql = '
      INSERT INTO utilisateur SET
      utilisateur_nom            = :utilisateur_nom,
      utilisateur_prenom         = :utilisateur_prenom,
      utilisateur_pseudo         = :utilisateur_pseudo,
      utilisateur_courriel       = :utilisateur_courriel,
      utilisateur_mdp            = SHA2(:nouveau_mdp, 512)';
    // return $this->CUDLigne($champs);
    $result = $this->CUDLigne($champs);
    if(preg_match('/^[1-9]\d*$/', $result)){
      $id_utilisateur = $result;
      $this->sql = '
      INSERT INTO `role` SET
      id_utilisateur             = :id_utilisateur,
      role_nom                   = "client"';
      $this->CUDLigne(['id_utilisateur' => $id_utilisateur]);
    }

    var_dump($result);
    return $result;
  }


  // GESTION PROFIL ====================================================
  // ===================================================================

  /**
   * Récupération de toutes les enchères de l'utilisateur
   * @param int $utilisateur_id ID de l'utilisateur
   * @return array Tableau des lignes produites par la requête SELECT
   */ 
  public function getMesEncheres($utilisateur_id) {
    $this->sql = '
        SELECT 
            enchere.*,
            mise.mise_montant AS offre_actuelle,
            COUNT(mise.mise_id) AS nb_mises,
            timbre.*
        FROM enchere
        INNER JOIN timbre ON enchere.id_timbre = timbre.timbre_id
        LEFT JOIN mise ON mise.id_enchere = enchere_id
        WHERE id_vendeur = :utilisateur_id';
    return $this->getLignes(['utilisateur_id' => $utilisateur_id]);
  }


  /**
   * Ajouter un timbre et une enchère
   * @param array $champs tableau des champs du timbre et de l'enchère
   * @return int|string clé primaire de la ligne ajoutée, message d'erreur sinon
   */
  public function insererTimbreEtEnchere($champsTimbre, $champsEnchere)
  {
      try {
          var_dump($champsTimbre, $champsEnchere);
          $this->debuterTransaction();

          $this->sql = '
              INSERT INTO timbre SET
              id_utilisateur          = :id_utilisateur,
              timbre_nom              = :timbre_nom,
              timbre_date_creation    = :timbre_date_creation,
              timbre_condition        = :timbre_condition,
              timbre_tirage           = :timbre_tirage,
              timbre_longueur         = :timbre_longueur,
              timbre_largeur          = :timbre_largeur,
              timbre_certifie         = :timbre_certifie,
              timbre_description      = :timbre_description,
              timbre_pays             = :timbre_pays,
              timbre_couleur          = :timbre_couleur';

          $timbre_id = $this->CUDLigne($champsTimbre);
          var_dump($timbre_id);
          $this->modifierTimbreImagePrincipale($timbre_id);

          // Insertion des images supplémentaires dans la table "image"
          if (isset($_FILES['image_fichier'])) {
            $image_files = $_FILES['image_fichier'];
            $this->ajouterImagesSupplementaires($timbre_id, $image_files);
          }
          
          if ($timbre_id > 0) { // Vérification de la clé du timbre ajoutée
              $this->sql = '
                  INSERT INTO enchere SET
                  id_vendeur              = :id_vendeur,
                  enchere_prix_plancher   = :enchere_prix_plancher,
                  enchere_date_debut      = :enchere_date_debut,
                  enchere_date_fin        = :enchere_date_fin,
                  id_timbre               = :id_timbre';

              $champsEnchere['id_timbre'] = $timbre_id;
              var_dump($champsEnchere);
              $enchere_id = $this->CUDLigne($champsEnchere);

              $this->validerTransaction();
              return $enchere_id;
          } else {
              $this->annulerTransaction();
              return "Erreur lors de l'ajout du timbre.";
          }
      } catch (Exception $e) {
          $this->annulerTransaction();
          return $e->getMessage();
      }
  }



  /**
   * Modifier l'image principale du timbre
   * @param int $timbre_id
   * @return boolean true si téléversement, false sinon
   */ 
  public function modifierTimbreImagePrincipale($timbre_id) {
    if ($_FILES['timbre_image_principale']['tmp_name'] !== "") {
    // if (isset($_FILES['timbre_image_principale']) && $_FILES['timbre_image_principale']['tmp_name'] !== "") {
      $this->sql = 'UPDATE timbre SET timbre_image_principale = :timbre_image_principale WHERE timbre_id = :timbre_id';
      $champs['timbre_id']      = $timbre_id;
      $champs['timbre_image_principale'] = "medias/image_principale/ip-$timbre_id-".time().".jpg";
      $this->CUDLigne($champs);
      foreach (glob("medias/image_principale/ip-$timbre_id-*") as $fichier) {
        if (!@unlink($fichier)) 
          throw new Exception("Erreur dans la suppression de l'ancien fichier image de l'image principale du timbre.");
      } 
      if (!@move_uploaded_file($_FILES['timbre_image_principale']['tmp_name'], $champs['timbre_image_principale']))
        throw new Exception("Le stockage du fichier image de l'image principale du timbre a échoué.");
      return true; 
    }
    return false;
  }

  /**
   * Ajouter les images supplémentaires du timbre dans la table "image"
   * @param int $timbre_id
   * @param array $image_files
   * @return void
   */
  public function ajouterImagesSupplementaires($timbre_id, $image_files)
  {
      foreach ($image_files['name'] as $index => $filename) {
          // Vérifier si le fichier a été téléchargé avec succès
          if ($image_files['error'][$index] === UPLOAD_ERR_OK) {
              // Déplacer le fichier vers le dossier de destination
              $filename = "medias/image_supplementaire/is-$timbre_id-$index-" . time() . ".jpg";
              if (!move_uploaded_file($image_files['tmp_name'][$index], $filename)) {
                  throw new Exception("Le stockage du fichier image supplémentaire a échoué.");
              }

              // Insérer les informations de l'image dans la table "image"
              $this->sql = 'INSERT INTO image (timbre_id, image_fichier) VALUES (:timbre_id, :image_fichier)';
              $champs = [
                  'timbre_id' => $timbre_id,
                  'image_fichier' => $filename
              ];
              $this->CUDLigne($champs);
          } else {
              throw new Exception("Une erreur s'est produite lors du téléchargement de l'image supplémentaire.");
          }
      }
  }

  /**
   * Ajouter une mise
   * @param array $champs tableau des champs de la mise 
   * @return int|string clé primaire de la ligne ajoutée, message d'erreur sinon
   */ 
  public function ajouterMise($champs) {
    $this->sql = '
      INSERT INTO mise SET
      mise_montant    = :mise_montant,
      id_utilisateur = :id_utilisateur,
      id_enchere = :id_enchere';
    return $this->CUDLigne($champs);
  }

  /**
   * Ajouter ou enlève un favori.
   *
   * @param  int $enchere_id
   * @return int id du favori inséré dans la BD ou nombre d'enregistrements enlevés
   */
  public function favori($params) {

    // Vérifier si l'utilisateur a déjà mis en favori cette enchere
    $this->sql = '
      SELECT * FROM favori WHERE id_enchere = :enchere_id AND id_utilisateur = :utilisateur_id';
    $favoriExistant = $this->getLignes($params, RequetesPDO::UNE_SEULE_LIGNE);

    if($favoriExistant) {
    $this->sql = '
      DELETE 
      FROM favori 
      WHERE id_enchere = :enchere_id 
        AND id_utilisateur = :utilisateur_id';
      return $this->CUDLigne($params);
    }
    else {
    $this->sql = "INSERT INTO favori VALUES (NULL, :utilisateur_id, :enchere_id, NULL)";
      return $this->CUDLigne($params);
    }
  }

  /**
   * Trouver le id_utilisateur
   *
   * @param  int $timbre_id
   * @return int id de l'utilisateur, false si aucune ligne
   */
  public function trouveIdUtilisateur($timbre_id) {
  $this->sql = 'SELECT timbre.id_utilisateur FROM timbre WHERE timbre_id = :timbre_id'; 

    return $this->getLignes(['timbre_id' => $timbre_id], RequetesPDO::UNE_SEULE_LIGNE);
  }

  /**
   * Supprimer l'enchere/timbre
   */
  public function enleverEnchereTimbre($timbre_id) {
    $this->sql = '
      DELETE FROM timbre WHERE timbre_id = :timbre_id';
    return $this->CUDLigne(['timbre_id' => $timbre_id]);
  }
}