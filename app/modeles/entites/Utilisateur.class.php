<?php

/**
 * Classe de l'entité Utilisateur
 *
 */
class Utilisateur extends Entite
{
  protected $utilisateur_id = 0;
  protected $utilisateur_nom;
  protected $utilisateur_prenom;
  protected $utilisateur_pseudo;
  protected $utilisateur_courriel;
  protected $utilisateur_mdp;
  protected $utilisateur_profil;

  protected $nouveau_mdp;
  protected $nouveau_mdp_bis;

  const PROFIL_ADMINISTRATEUR = "administrateur";
  // const PROFIL_EDITEUR        = "editeur";
  // const PROFIL_CORRECTEUR     = "correcteur";
  const PROFIL_CLIENT         = "client";
  
  const ERR_COURRIEL_EXISTANT = "Courriel déjà utilisé.";
  const ERR_PSEUDO_EXISTANT = "Pseudo déjà utilisé.";

  // Getters explicites nécessaires au moteur de templates TWIG
  public function getUtilisateur_id()       { return $this->utilisateur_id; }
  public function getUtilisateur_nom()      { return $this->utilisateur_nom; }
  public function getUtilisateur_prenom()   { return $this->utilisateur_prenom; }
  public function getUtilisateur_pseudo()   { return $this->utilisateur_pseudo; }
  public function getUtilisateur_courriel() { return $this->utilisateur_courriel; }
  public function getUtilisateur_mdp()      { return $this->utilisateur_mdp; }
  public function getUtilisateur_profil()   { return $this->utilisateur_profil; }
  public function getErreurs()              { return $this->erreurs; }
  
  /**
   * Mutateur de la propriété utilisateur_id 
   * @param int $utilisateur_id
   * @return $this
   */    
  public function setUtilisateur_id($utilisateur_id) {
    unset($this->erreurs['utilisateur_id']);
    $regExp = '/^\d+$/';
    if (!preg_match($regExp, $utilisateur_id)) {
      $this->erreurs['utilisateur_id'] = 'Numéro incorrect.';
    }
    $this->utilisateur_id = $utilisateur_id;
    return $this;
  }    

  /**
   * Mutateur de la propriété utilisateur_nom 
   * @param string $utilisateur_nom
   * @return $this
   */    
  public function setUtilisateur_nom($utilisateur_nom) {
    unset($this->erreurs['utilisateur_nom']);
    $utilisateur_nom = trim($utilisateur_nom);
    $regExp = '/^[a-zÀ-ÖØ-öø-ÿ]{2,}( [a-zÀ-ÖØ-öø-ÿ]{2,})*$/i';
    if (!preg_match($regExp, $utilisateur_nom)) {
      $this->erreurs['utilisateur_nom'] = 'Au moins 2 caractères alphabétiques pour chaque mot.';
    }
    $this->utilisateur_nom = $utilisateur_nom;
    return $this;
  }

  /**
   * Mutateur de la propriété utilisateur_prenom 
   * @param string $utilisateur_prenom
   * @return $this
   */    
  public function setUtilisateur_prenom($utilisateur_prenom) {
    unset($this->erreurs['utilisateur_prenom']);
    $utilisateur_prenom = trim($utilisateur_prenom);
    $regExp = '/^[a-zÀ-ÖØ-öø-ÿ]{2,}( [a-zÀ-ÖØ-öø-ÿ]{2,})*$/i';
    if (!preg_match($regExp, $utilisateur_prenom)) {
      $this->erreurs['utilisateur_prenom'] = 'Au moins 2 caractères alphabétiques pour chaque mot.';
    }
    $this->utilisateur_prenom = $utilisateur_prenom;
    return $this;
  }

  /**
   * Mutateur de la propriété utilisateur_pseudo 
   * @param string $utilisateur_pseudo
   * @return $this
   */    
  public function setUtilisateur_pseudo($utilisateur_pseudo) {
    unset($this->erreurs['utilisateur_pseudo']);
    $utilisateur_pseudo = trim($utilisateur_pseudo);
    $regExp = '/^[a-z0-9_-]{3,20}$/i';
    if (!preg_match($regExp, $utilisateur_pseudo)) {
      $this->erreurs['utilisateur_pseudo'] = 'Le pseudo doit comporter de 3 à 20 caractères alphanumériques, soulignés (_) ou tirets (-).';
    }
    $this->utilisateur_pseudo = $utilisateur_pseudo;
    return $this;
  }

  /**
   * Mutateur de la propriété utilisateur_courriel
   * @param string $utilisateur_courriel
   * @return $this
   */    
  public function setUtilisateur_courriel($utilisateur_courriel) {
    unset($this->erreurs['utilisateur_courriel']);
    $utilisateur_courriel = trim(strtolower($utilisateur_courriel));
    if (!filter_var($utilisateur_courriel, FILTER_VALIDATE_EMAIL)) {
      $this->erreurs['utilisateur_courriel'] = 'Format incorrect.';
    }
    $this->utilisateur_courriel = $utilisateur_courriel;
    return $this;
  }

  // /**
  //  * Mutateur de la propriété utilisateur_mdp
  //  * @return $this
  //  */    
  // public function setUtilisateur_mdp($utilisateur_mdp) {
  //   unset($this->erreurs['utilisateur_mdp']);
  //   $regExp = '/^(?=.*[%!:=].*)(?=.*\d.*)(?=.*[A-Z].*)(?=.*[a-z].*)\S{10,}$/';
  //   if (!preg_match($regExp, $utilisateur_mdp)) {
  //     $this->erreurs['utilisateur_mdp'] = 'Au moins 10 car., un car. parmi %!:=, une majuscule, une minuscule et un chiffre.';
  //   }
  //   $this->utilisateur_mdp = $utilisateur_mdp;
  //   return $this;
  // }

    /**
   * Mutateur de la propriété utilisateur_mdp
   * @param string $utilisateur_mdp
   * @return $this
   */    
  public function setUtilisateur_mdp($utilisateur_mdp) {
    $this->utilisateur_mdp = $utilisateur_mdp;
    return $this;
  }

  /**
   * Mutateur de la propriété utilisateur_profil
   * @param string $utilisateur_profil
   * @return $this
   */    
  public function setUtilisateur_profil($utilisateur_profil) {
    unset($this->erreurs['utilisateur_profil']);
    if ($utilisateur_profil !== self::PROFIL_ADMINISTRATEUR &&
        $utilisateur_profil !== self::PROFIL_CLIENT) {
      $this->erreurs['utilisateur_profil'] = 'Profil incorrect.';
    }
    $this->utilisateur_profil = $utilisateur_profil;
    return $this;
  }

  /**
   * Mutateur de la propriété nouveau_mdp
   * @param string $nouveau_mdp
   * @return $this
   */    
  public function setNouveau_mdp($nouveau_mdp) {
    unset($this->erreurs['nouveau_mdp']);
    $regExp = '/^(?=.*[%!:&].*)(?=.*\d.*)(?=.*[A-Z].*)(?=.*[a-z].*)\S{10,}$/';
    if (!preg_match($regExp, $nouveau_mdp)) {
      $this->erreurs['nouveau_mdp'] =
        'Minimum 10 caractères,
         avec au moins un caractère spécial non alphanumérique (comme par exemple: %!:&),
         une lettre majuscule, une lettre minuscule et un chiffre.';
    }
    $this->nouveau_mdp = $nouveau_mdp;
    return $this;
  }

  /**
   * Mutateur de la propriété nouveau_mdp_bis
   * @param string $nouveau_mdp_bis
   * @return $this
   */    
  public function setNouveau_mdp_bis($nouveau_mdp_bis) {
    unset($this->erreurs['nouveau_mdp_bis']);
    if ($this->nouveau_mdp && !isset($this->erreurs['nouveau_mdp']) && $nouveau_mdp_bis !== $this->nouveau_mdp) {
      $this->erreurs['nouveau_mdp_bis'] = 'Doit être identique au précédent.';
    }
    $this->nouveau_mdp_bis = $nouveau_mdp_bis;
    return $this;
  }  

  /**
   * Controler l'existence du pseudo 
   */    
  public function pseudoExiste() {
    if (!isset($this->erreurs['utilisateur_pseudo'])) {
      $retour = (new RequetesSQL)->controlerPseudo(['utilisateur_pseudo' => $this->utilisateur_pseudo,
                                                      'utilisateur_id'       => $this->utilisateur_id
                                                     ]);
      if ($retour) $this->erreurs['utilisateur_pseudo'] = self::ERR_PSEUDO_EXISTANT;
    }
  }

  /**
   * Controler l'existence du courriel 
   */    
  public function courrielExiste() {
    if (!isset($this->erreurs['utilisateur_courriel'])) {
      $retour = (new RequetesSQL)->controlerCourriel(['utilisateur_courriel' => $this->utilisateur_courriel,
                                                      'utilisateur_id'       => $this->utilisateur_id
                                                     ]);
      if ($retour) $this->erreurs['utilisateur_courriel'] = self::ERR_COURRIEL_EXISTANT;
    }
  } 

}