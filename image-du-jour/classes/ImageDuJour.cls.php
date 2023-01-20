<?php
class ImageDuJour extends AccesBd
{

     // Identifiant d'un commentaire.
    private string $jour;

    function __construct()
    {
        parent::__construct();
      
    }


/**
     * Obtenir l'image du jour
     * 
     * @return object Objet représentant l'enregistrement retourné 
     */
    public function unParDate(string $date) : object
    {
        $sql = "SELECT * FROM image
        WHERE img_jour = '$date'";
        return $this->lireUn($sql); 
    }

/**
     * Obtenir la date de la première image de la BD
     * 
     * @return object Objet représentant l'enregistrement retourné 
     */
    public function datePremiereImage() 
    {
        $sql = "SELECT * 
                FROM image
                WHERE img_jour = (SELECT MIN(img_jour) FROM image)";
        return $this->lireUn($sql); 
    }

}