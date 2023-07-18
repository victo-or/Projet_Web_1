<?php

/**
 * Classe de l'entité Timbre
 *
 */
class Timbre extends Entite
{
    protected $timbre_id;
    protected $timbre_nom;
    protected $timbre_date_creation;
    protected $timbre_condition;
    protected $timbre_tirage;
    protected $timbre_longueur;
    protected $timbre_largeur;
    protected $timbre_certifie;
    protected $timbre_description;
    protected $timbre_pays;
    protected $timbre_couleur;
    protected $timbre_image_principale;
    protected $image_fichier;

    const VALEURS_POSSIBLES_CONDITION = ["parfaite", "excellente", "bonne", "moyenne", "endommage"];
    const VALEURS_POSSIBLES_COULEUR = ["rouge", "orange", "jaune", "vert", "bleu", "mauve", "rose", "multicolore", "noir/blanc", "gris", "brun", "beige", "or", "argent"];
	const VALEURS_POSSIBLES_PAYS = ["Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola", "Antigua-et-Barbuda", "Arabie saoudite", "Argentine", "Arménie", "Australie", "Autriche", "Azerbaïdjan", "Bahamas", "Bahreïn", "Bangladesh", "Barbade", "Belgique", "Belize", "Bénin", "Bhoutan", "Biélorussie", "Birmanie", "Bolivie", "Bosnie-Herzégovine", "Botswana", "Brésil", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge", "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "Congo", "Corée du Nord", "Corée du Sud", "Costa Rica", "Côte d'Ivoire", "Croatie", "Cuba", "Danemark", "Djibouti", "Dominique", "Égypte", "Émirats arabes unis", "Équateur", "Érythrée", "Espagne", "Estonie", "États-Unis", "Éthiopie", "Fidji", "Finlande", "France", "Gabon", "Gambie", "Géorgie", "Ghana", "Grèce", "Grenade", "Guatemala", "Guinée", "Guinée-Bissau", "Guinée équatoriale", "Guyana", "Haïti", "Honduras", "Hongrie", "Îles Cook", "Îles Marshall", "Îles Salomon", "Inde", "Indonésie", "Iran", "Iraq", "Irlande", "Islande", "Israël", "Italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan", "Kenya", "Kirghizistan", "Kiribati", "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Libéria", "Libye", "Liechtenstein", "Lituanie", "Luxembourg", "Macédoine du Nord", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali", "Malte", "Maroc", "Maurice", "Mauritanie", "Mexique", "Micronésie", "Moldavie", "Monaco", "Mongolie", "Monténégro", "Mozambique", "Namibie", "Nauru", "Népal", "Nicaragua", "Niger", "Nigeria", "Niue", "Norvège", "Nouvelle-Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palaos", "Palestine", "Panama", "Papouasie-Nouvelle-Guinée", "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pologne", "Portugal", "Qatar", "République centrafricaine", "République démocratique du Congo", "République dominicaine", "République tchèque", "Roumanie", "Royaume-Uni", "Russie", "Rwanda", "Saint-Christophe-et-Niévès", "Sainte-Lucie", "Saint-Marin", "Saint-Vincent-et-les-Grenadines", "Salvador", "Samoa", "Sao Tomé-et-Principe", "Sénégal", "Serbie", "Seychelles", "Sierra Leone", "Singapour", "Slovaquie", "Slovénie", "Somalie", "Soudan", "Soudan du Sud", "Sri Lanka", "Suède", "Suisse", "Suriname", "Eswatini", "Syrie", "Tadjikistan", "Tanzanie", "Tchad", "Thaïlande", "Timor oriental", "Togo", "Tonga", "Trinité-et-Tobago", "Tunisie", "Turkménistan", "Turquie", "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Venezuela", "Viêt Nam", "Yémen", "Zambie", "Zimbabwe"];


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
     * Accesseur magique d'une propriété de l'objet
     * @param string $prop, nom de la propriété
     * @return property value
     */     
    public function __get($prop) {
        return $this->$prop;
    }

    /**
     * Mutateur magique qui exécute le mutateur de la propriété en paramètre 
     * @param string $prop, nom de la propriété
     * @param $val, contenu de la propriété à mettre à jour
     */   
    public function __set($prop, $val) {
        $setProperty = 'set'.ucfirst($prop);
        $this->$setProperty($val);
    }


    /**
     * Mutateur de la propriété timbre_id 
     * @param int $timbre_id
     * @return $this
     */    
    public function setTimbre_id($timbre_id) {
        unset($this->erreurs['timbre_id']);
        $regExp = '/^[1-9]\d*$/';
        if (!preg_match($regExp, $timbre_id)) {
            $this->erreurs['timbre_id'] = 'Numéro de timbre incorrect.';
        }
        $this->timbre_id = $timbre_id;
        return $this;
    }    

    /**
     * Mutateur de la propriété timbre_nom 
     * @param string $timbre_nom
     * @return $this
     */
    public function setTimbre_nom($timbre_nom) {
        $this->erreurs = []; // Réinitialisation des erreurs
        $timbre_nom = trim($timbre_nom);
        $regExp = '/^.+$/';
        if (empty($timbre_nom)) {
            $this->erreurs['timbre_nom'] = "Saisie obligatoire.";
        }
        else if (!preg_match($regExp, $timbre_nom)) {
            $this->erreurs['timbre_nom'] = 'Au moins un caractère.';
        }
        $this->timbre_nom = mb_strtoupper($timbre_nom);
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_date_creation
     * @param string $timbre_date_creation
     * @return $this
     */    
    public function setTimbre_date_creation($timbre_date_creation) {
        unset($this->erreurs['timbre_date_creation']);
        $regExp = '/^\d{4}-\d{2}-\d{2}$/';
        if (empty($timbre_date_creation)) {
            $this->erreurs['timbre_date_creation'] = "Saisie obligatoire.";
        }
        else if (!preg_match($regExp, $timbre_date_creation)) {
        $this->erreurs['timbre_date_creation'] = "Format de date incorrect.";
        }
        $this->timbre_date_creation = $timbre_date_creation;
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_condition
     * @param string $timbre_condition
     * @return $this
     */    
    public function setTimbre_condition($timbre_condition) {
        unset($this->erreurs['timbre_condition']);
        $timbre_condition = trim($timbre_condition);
        if (empty($timbre_condition) || $timbre_condition === 'Choisir une option') {
            $this->erreurs['timbre_condition'] = "Saisie obligatoire.";
        }
        else if (!in_array($timbre_condition, self::VALEURS_POSSIBLES_CONDITION)) {
            $this->erreurs['timbre_condition'] = "La condition du timbre doit être l'une des valeurs suivantes : parfaite, excellente, bonne, moyenne ou endommage.";
        }
        $this->timbre_condition = $timbre_condition;
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_tirage
     * @param int|null $timbre_tirage
     * @return $this
     */    
    public function setTimbre_tirage($timbre_tirage) {
        unset($this->erreurs['timbre_tirage']);

        if ($timbre_tirage !== null) {
            $timbre_tirage = intval($timbre_tirage);
            if ($timbre_tirage < 0) {
                $this->erreurs['timbre_tirage'] = "Le tirage doit être un nombre entier positif";
            }
        }
        $this->timbre_tirage = $timbre_tirage;
        return $this;
    }


    /**
     * Mutateur de la propriété timbre_longueur
     * @param float $timbre_longueur
     * @return $this
     */
    public function setTimbre_longueur($timbre_longueur)
    {
        unset($this->erreurs['timbre_longueur']);

        $timbre_longueur = round(floatval($timbre_longueur), 2);
        if (empty($timbre_longueur)) {
            $this->erreurs['timbre_longueur'] = "Saisie obligatoire.";
        }
        else if ($timbre_longueur <= 0) {
            $this->erreurs['timbre_longueur'] = "La longueur doit être un nombre positif";
        }

        $this->timbre_longueur = $timbre_longueur;
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_largeur
     * @param float $timbre_largeur
     * @return $this
     */
    public function setTimbre_largeur($timbre_largeur)
    {
        unset($this->erreurs['timbre_largeur']);

        $timbre_largeur = round(floatval($timbre_largeur), 2);
        if (empty($timbre_largeur)) {
            $this->erreurs['timbre_largeur'] = "Saisie obligatoire.";
        }
        else if ($timbre_largeur <= 0) {
            $this->erreurs['timbre_largeur'] = "La largeur doit être un nombre positif";
        }

        $this->timbre_largeur = $timbre_largeur;
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_certifie
     * @param int|bool $timbre_certifie
     * @return $this
     */    
    public function setTimbre_certifie($timbre_certifie) {
        unset($this->erreurs['timbre_certifie']);

        // // Vérifier si la valeur est un booléen ou un entier
        // if (!is_bool($timbre_certifie) && !is_int($timbre_certifie)) {
        //     $this->erreurs['timbre_certifie'] = "La valeur de certifié doit être un booléen ou un entier (0 ou 1).";
        // }

        // Si la valeur est un entier, vérifier qu'elle est soit 0, soit 1
        if (is_int($timbre_certifie) && $timbre_certifie !== 0 && $timbre_certifie !== 1) {
            $this->erreurs['timbre_certifie'] = "La valeur de certifié doit être 0 (non certifié) ou 1 (certifié).";
        }

        // if (!is_bool($timbre_certifie)) {
        //     $this->erreurs['timbre_certifie'] = "La valeur de certifié doit être un booléen (true ou false).";
        // }

        $this->timbre_certifie = $timbre_certifie;
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_description
     * @param string $timbre_description
     * @return $this
     */    
    public function setTimbre_description($timbre_description) {
        unset($this->erreurs['timbre_description']);
        $timbre_description = trim($timbre_description);
        $regExp = '/^\S+(\s+\S+){4,}$/';
        if (empty($timbre_description)) {
            $this->erreurs['timbre_description'] = "Saisie obligatoire.";
        }
        else if (!preg_match($regExp, $timbre_description)) {
            $this->erreurs['timbre_description'] = 'Au moins 5 mots.';
        }
        else if (mb_strlen($timbre_description) > 500) {
            $this->erreurs['timbre_description'] = 'La description ne doit pas dépasser 500 caractères.';
        }
        $this->timbre_description = $timbre_description;
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_pays
     * @param string $timbre_pays
     * @return $this
     */    
    public function setTimbre_pays($timbre_pays) {
        unset($this->erreurs['timbre_pays']);
        $timbre_pays = trim($timbre_pays);
        if (empty($timbre_pays) || $timbre_pays === 'Choisir une option') {
            $this->erreurs['timbre_pays'] = "Saisie obligatoire.";
        }
        else if (!in_array($timbre_pays, self::VALEURS_POSSIBLES_PAYS)) {
            $this->erreurs['timbre_pays'] = "Veuillez sélectionner un pays de la liste.";
        }
        $this->timbre_pays = $timbre_pays;
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_couleur
     * @param string $timbre_couleur
     * @return $this
     */    
    public function setTimbre_couleur($timbre_couleur) {
        unset($this->erreurs['timbre_couleur']);
        $timbre_couleur = trim($timbre_couleur);
        if (empty($timbre_couleur) || $timbre_couleur === 'Choisir une option') {
            $this->erreurs['timbre_couleur'] = "Saisie obligatoire.";
        }
        else if (!in_array($timbre_couleur, self::VALEURS_POSSIBLES_COULEUR)) {
            $this->erreurs['timbre_couleur'] = "La couleur du timbre doit être l'une des valeurs suivantes : rouge, orange, jaune, vert, bleu, mauve, rose, multicolore, noir/blanc, gris, brun, beige, or, argent";
        }
        $this->timbre_couleur = $timbre_couleur;
        return $this;
    }

    /**
     * Mutateur de la propriété timbre_image_principale
     * @param string $timbre_image_principale
     * @return $this
     */    
    public function setTimbre_image_principale($timbre_image_principale) {
        unset($this->erreurs['timbre_image_principale']);
        $timbre_image_principale = trim($timbre_image_principale);
        $regExp = '/^.+\.(jpg|webp)$/i'; // Accepte les fichiers avec les extensions jpg et webp (insensible à la casse)
        if (empty($timbre_image_principale)) {
            $this->erreurs['timbre_image_principale'] = "Saisie obligatoire.";
        }
        else if (!preg_match($regExp, $timbre_image_principale)) {
        $this->erreurs['timbre_image_principale'] = "Vous devez téléverser un fichier de type jpg ou webp.";
        }
        $this->timbre_image_principale = $timbre_image_principale;
        return $this;
    }

    /**
     * Mutateur de la propriété image_fichier
     * @param string $image_fichier
     * @return $this
     */    
    public function setImage_fichier($image_fichier) {
        unset($this->erreurs['image_fichier']);
        $image_fichier = trim($image_fichier);
        $regExp = '/^.+\.(jpg|webp)$/i'; // Accepte les fichiers avec les extensions jpg et webp (insensible à la casse)
        if (!preg_match($regExp, $image_fichier)) {
        $this->erreurs['image_fichier'] = "Vous devez téléverser un fichier de type jpg ou webp.";
        }
        $this->image_fichier = $image_fichier;
        return $this;
    }
}