<?php

/**
 * Classe de l'entité Enchere
 *
 */
class Enchere extends Entite
{
  protected $enchere_id;
  protected $enchere_titre;
  protected $enchere_duree;
  protected $enchere_annee_sortie;
  protected $enchere_resume;
  protected $enchere_affiche;
  protected $enchere_bande_annonce;
  protected $enchere_statut;
  protected $enchere_genre_id;

  const ANNEE_PREMIER_FILM = 1895;
  const DUREE_MIN = 1;
  const DUREE_MAX = 600;     
  const STATUT_INVISIBLE = 0;
  const STATUT_VISIBLE   = 1;
  const STATUT_ARCHIVE   = 2;

  /**
   * Mutateur de la propriété enchere_id 
   * @param int $enchere_id
   * @return $this
   */    
  public function setEnchere_id($enchere_id) {
    unset($this->erreurs['enchere_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $enchere_id)) {
      $this->erreurs['enchere_id'] = 'Numéro de enchere incorrect.';
    }
    $this->enchere_id = $enchere_id;
    return $this;
  }    

  /**
   * Mutateur de la propriété enchere_titre 
   * @param string $enchere_titre
   * @return $this
   */    
  public function setEnchere_titre($enchere_titre) {
    unset($this->erreurs['enchere_titre']);
    $enchere_titre = trim($enchere_titre);
    $regExp = '/^.+$/';
    if (!preg_match($regExp, $enchere_titre)) {
      $this->erreurs['enchere_titre'] = 'Au moins un caractère.';
    }
    $this->enchere_titre = mb_strtoupper($enchere_titre);
    return $this;
  }

  /**
   * Mutateur de la propriété enchere_duree 
   * @param int $enchere_duree, en minutes
   * @return $this
   */        
  public function setEnchere_duree($enchere_duree) {
    unset($this->erreurs['enchere_duree']);
    if (!preg_match('/^[1-9]\d*$/', $enchere_duree) || $enchere_duree < self::DUREE_MIN || $enchere_duree > self::DUREE_MAX) {
      $this->erreurs['enchere_duree'] = "Entre ".self::DUREE_MIN." et ".self::DUREE_MAX.".";
    }
    $this->enchere_duree = $enchere_duree;
    return $this;
  }

  /**
   * Mutateur de la propriété enchere_annee_sortie 
   * @param int $enchere_annee_sortie
   * @return $this
   */        
  public function setEnchere_annee_sortie($enchere_annee_sortie) {
    unset($this->erreurs['enchere_annee_sortie']);
    if (!preg_match('/^\d+$/', $enchere_annee_sortie) ||
        $enchere_annee_sortie < self::ANNEE_PREMIER_FILM  || 
        $enchere_annee_sortie > date("Y")) {
      $this->erreurs['enchere_annee_sortie'] = "Entre ".self::ANNEE_PREMIER_FILM." et l'année en cours.";
    }
    $this->enchere_annee_sortie = $enchere_annee_sortie;
    return $this;
  }

  /**
   * Mutateur de la propriété enchere_resume
   * @param string $enchere_resume
   * @return $this
   */    
  public function setEnchere_resume($enchere_resume) {
    unset($this->erreurs['enchere_resume']);
    $enchere_resume = trim($enchere_resume);
    $regExp = '/^\S+(\s+\S+){4,}$/';
    if (!preg_match($regExp, $enchere_resume)) {
      $this->erreurs['enchere_resume'] = 'Au moins 5 mots.';
    }
    $this->enchere_resume = $enchere_resume;
    return $this;
  }

  /**
   * Mutateur de la propriété enchere_affiche
   * @param string $enchere_affiche
   * @return $this
   */    
  public function setEnchere_affiche($enchere_affiche) {
    unset($this->erreurs['enchere_affiche']);
    $enchere_affiche = trim($enchere_affiche);
    $regExp = '/^.+\.jpg$/';
    if (!preg_match($regExp, $enchere_affiche)) {
      $this->erreurs['enchere_affiche'] = "Vous devez téléverser un fichier de type jpg.";
    }
    $this->enchere_affiche = $enchere_affiche;
    return $this;
  }

  /**
   * Mutateur de la propriété enchere_bande_annonce
   * @param string $enchere_bande_annonce
   * @return $this
   */    
  public function setEnchere_bande_annonce($enchere_bande_annonce) {
    unset($this->erreurs['enchere_bande_annonce']);
    $enchere_bande_annonce = trim($enchere_bande_annonce);
    $regExp = '/^.+\.mp4$/';
    if (!preg_match($regExp, $enchere_bande_annonce)) {
      $this->erreurs['enchere_bande_annonce'] = "Vous devez téléverser un fichier de type mp4.";
    }
    $this->enchere_bande_annonce = $enchere_bande_annonce;
    return $this;
  }

  /**
   * Mutateur de la propriété enchere_statut
   * @param int $enchere_statut
   * @return $this
   */        
  public function setEnchere_statut($enchere_statut) {
    unset($this->erreurs['enchere_statut']);
    if ($enchere_statut != Enchere::STATUT_INVISIBLE &&
        $enchere_statut != Enchere::STATUT_VISIBLE   && 
        $enchere_statut != Enchere::STATUT_ARCHIVE) {
      $this->erreurs['enchere_statut'] = 'Statut incorrect.';
    }
    $this->enchere_statut = $enchere_statut;
    return $this;
  }

  /**
   * Mutateur de la propriété enchere_genre_id 
   * @param int $enchere_genre_id
   * @return $this
   */    
  public function setEnchere_genre_id($enchere_genre_id) {
    unset($this->erreurs['enchere_genre_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $enchere_genre_id)) {
      $this->erreurs['enchere_genre_id'] = 'Numéro de genre incorrect.';
    }
    $this->enchere_genre_id = $enchere_genre_id;
    return $this;
  }    
}