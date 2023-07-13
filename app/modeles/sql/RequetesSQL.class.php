<?php

/**
 * Classe des requêtes SQL
 *
 */
class RequetesSQL extends RequetesPDO {

  /**
   * Récupération des encheres à afficher dans la page catalogue
   * @return array tableau des lignes produites par la select   
   */ 
  public function getEncheres() {
    $this->sql = '
    SELECT
      enchere.*,
      mise.mise_montant AS offre_actuelle,
      COUNT(mise.mise_id) AS nb_mises,
      timbre.*,
      DATE_FORMAT(TIMEDIFF(enchere_date_fin, NOW()), "%d jours, %H heures, %i minutes") AS temps_restant
    FROM
      enchere
    INNER JOIN timbre ON timbre_id = enchere.id_timbre
    LEFT JOIN mise ON mise.id_enchere = enchere_id
    WHERE TIMEDIFF(enchere_date_fin, NOW()) > 0
    GROUP BY enchere_id';
    return $this->getLignes();
  }

  /**
   * Récupération d'une enchere
   * @param int $enchere_id, clé de l'enchère
   * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne  
   */ 
  public function getEnchere($enchere_id) {
    $this->sql = "
    SELECT 
      enchere.*, 
      timbre.*, 
      utilisateur.utilisateur_pseudo,
      mise.mise_montant AS offre_actuelle,
      COUNT(mise.mise_id) AS nb_mises,
      DATE_FORMAT(TIMEDIFF(enchere.enchere_date_fin, NOW()), '%d jours, %H heures, %i minutes') AS temps_restant
    FROM enchere
    INNER JOIN timbre ON enchere.id_timbre = timbre.timbre_id
    INNER JOIN utilisateur ON enchere.id_vendeur = utilisateur.utilisateur_id
    LEFT JOIN mise ON mise.id_enchere = enchere.enchere_id
    WHERE enchere.enchere_id = :enchere_id";

    return $this->getLignes(['enchere_id' => $enchere_id], RequetesPDO::UNE_SEULE_LIGNE);
  }

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
      utilisateur_mdp            = SHA2(:nouveau_mdp, 512),
      utilisateur_profil         = "'.Utilisateur::PROFIL_CLIENT.'"';
    return $this->CUDLigne($champs);
  }


}