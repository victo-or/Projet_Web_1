<?php

/**
 * Classe de l'entité Enchere
 *
 */
class Enchere extends Entite
{
  protected $enchere_id;
  protected $id_vendeur;
  protected $id_timbre;
  protected $enchere_date_debut;
  protected $enchere_date_fin;
  protected $enchere_cdc_lord;
  protected $enchere_prix_plancher;

  /**
   * Constructeur de la classe 
   * @param array $proprietes, tableau associatif des propriétés 
   */ 
  public function __construct($proprietes = []) {
    foreach ($proprietes as $nom_propriete => $val_propriete) {
    $this->__set($nom_propriete, $val_propriete);
    } 
  }

  /**
   * Mutateur de la propriété enchere_id 
   * @param int $enchere_id
   * @return $this
   */    
  public function setEnchere_id($enchere_id) {
    unset($this->erreurs['enchere_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $enchere_id)) {
      $this->erreurs['enchere_id'] = "Numéro d'enchere incorrect.";
    }
    $this->enchere_id = $enchere_id;
    return $this;
  }    

  /**
   * Mutateur de la propriété id_vendeur 
   * @param int $id_vendeur
   * @return $this
   */    
  public function setId_vendeur($id_vendeur) {
    unset($this->erreurs['id_vendeur']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $id_vendeur)) {
      $this->erreurs['id_vendeur'] = "Numéro de vendeur incorrect.";
    }
    $this->id_vendeur = $id_vendeur;
    return $this;
  }    

  /**
   * Mutateur de la propriété id_timbre 
   * @param int $id_timbre
   * @return $this
   */    
  public function setId_timbre($id_timbre) {
    unset($this->erreurs['id_timbre']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $id_timbre)) {
      $this->erreurs['id_timbre'] = "Numéro de timbre incorrect.";
    }
    $this->id_timbre = $id_timbre;
    return $this;
  }    

  /**
   * Mutateur de la propriété enchere_date_debut
   * @param string $enchere_date_debut
   * @return $this
   */    
  public function setEnchere_date_debut($enchere_date_debut) {
    unset($this->erreurs['enchere_date_debut']);
    $regExp = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
    if (empty($enchere_date_debut)) {
      $this->erreurs['enchere_date_debut'] = "Saisie obligatoire.";
    }
    else if (!preg_match($regExp, $enchere_date_debut)) {
      $this->erreurs['enchere_date_debut'] = "Format de date incorrect. L'entrée doit être dans le format aaaa-mm-jj hh-mm-ss";
    } else {
      $dateDebut = new DateTime($enchere_date_debut);
      $dateFin = new DateTime($this->enchere_date_fin);
      $diff = $dateFin->diff($dateDebut);
      if ($diff->d < 1) {
        $this->erreurs['enchere_date_debut'] = "La date de début doit être au moins d'un jour après la date actuelle.";
      }
    }
    $this->enchere_date_debut = $enchere_date_debut;
    return $this;
  }

  /**
   * Mutateur de la propriété enchere_date_fin
   * @param string $enchere_date_fin
   * @return $this
   */    
  public function setEnchere_date_fin($enchere_date_fin) {
    unset($this->erreurs['enchere_date_fin']);
    $regExp = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
    if (empty($enchere_date_fin)) {
      $this->erreurs['enchere_date_fin'] = "Saisie obligatoire.";
    }
    else if (!preg_match($regExp, $enchere_date_fin)) {
      $this->erreurs['enchere_date_fin'] = "Format de date incorrect. L'entrée doit être dans le format aaaa-mm-jj hh-mm-ss";
    } else {
      $dateFin = new DateTime($enchere_date_fin);
      $dateDebut = new DateTime($this->enchere_date_debut);
      $diff = $dateFin->diff($dateDebut);
      if ($diff->d > 7) {
        $this->erreurs['enchere_date_fin'] = "La date de fin ne peut pas dépasser sept jours après la date de début.";
      }
    }
    $this->enchere_date_fin = $enchere_date_fin;
    return $this;
  }


  /**
   * Mutateur de la propriété enchere_cdc_lord
   * @param int $enchere_cdc_lord
   * @return $this
   */    
  public function setEnchere_cdc_lord($enchere_cdc_lord) {
    unset($this->erreurs['enchere_cdc_lord']);
    if ($enchere_cdc_lord !== 0 && $enchere_cdc_lord !== 1) {
        $this->erreurs['enchere_cdc_lord'] = "La valeur de enchere_cdc_lord doit être 0 ou 1.";
    }
    $this->enchere_cdc_lord = $enchere_cdc_lord;
    return $this;
  }


  /**
   * Mutateur de la propriété enchere_prix_plancher
   * @param float $enchere_prix_plancher
   * @return $this
   */    
  public function setEnchere_prix_plancher($enchere_prix_plancher) {
    unset($this->erreurs['enchere_prix_plancher']);
    $regExp = '/^\d{1,7}(\.\d{1,2})?$/';
    if (empty($enchere_prix_plancher)) {
      $this->erreurs['enchere_prix_plancher'] = "Saisie obligatoire.";
    }
    else if (!preg_match($regExp, $enchere_prix_plancher)) {
        $this->erreurs['enchere_prix_plancher'] = "Le prix plancher de l'enchère doit être un nombre valide (maximum 9 chiffres au total, avec 2 chiffres après la virgule).";
    }
    $this->enchere_prix_plancher = $enchere_prix_plancher;
    return $this;
  }


}