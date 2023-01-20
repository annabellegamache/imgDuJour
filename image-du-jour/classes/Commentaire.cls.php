<?php
class Commentaire extends AccesBd
{

    // Identifiant d'un commentaire.
    private int $idldj;

    function __construct($idldj)
    {
        parent::__construct();
        $this->idldj = $idldj;
    }


/**
     * Obtenir le nomdre de commentaires aimés
     * 
     * @return int : 
     */
    public function obtenirNombreAime() : int
    {
        $sql = "SELECT * FROM commentaire
        JOIN image 
        ON commentaire.com_img_id_ce = image.img_id
        WHERE img_id = '$this->idldj'";
        $res =  $this->lireTout($sql);
        return count($res);
    }

/**
     * Obtenir tous les commentaires de l'image du jour
     * 
     * @return array : 
     */
    public function toutSansVote() : array
    {
        $sql = "SELECT * FROM commentaire
        JOIN image 
        ON commentaire.com_img_id_ce = image.img_id
        WHERE img_id = '$this->idldj'";
        return $this->lireTout($sql); 
    }

/**
     * Obtenir tous les commentaires de l'image du jour avec leur nombre de vote
     * 
     * @return array : 
     */
    public function toutAvecVote() : array
    {
        $sql = "SELECT *
        FROM commentaire
        JOIN vote 
        ON commentaire.com_id = vote.vot_com_id_ce
        JOIN image
        ON commentaire.com_img_id_ce = image.img_id
        WHERE img_id = '$this->idldj'";
        // Bloquée...je vais oublier les points bonis
        return $this->lireTout($sql); 
    }

    
}