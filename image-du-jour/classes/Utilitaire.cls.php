<?php
class Utilitaire
{

 
/**
     * Obtenir une date formatée
     * 
     * @return string : La date formatée
     */
    public static function dateFormatee(string $date) : string
    {
       setlocale(LC_TIME, 'fr_FR');
       // je sais c'est obsolète mais je n'ai pas trouvée autres solution qui fonctionne... :/
       return ucfirst(strftime("%A %d %B %G", strtotime($date)));



       // "date_default_timezone_set" may be required by your server
      /*  date_default_timezone_set( 'Europe/Paris' );

        // make a DateTime object 
        // the "now" parameter is for get the current date, 
        // but that work with a date recived from a database 
        // ex. replace "now" by '2022-04-04 05:05:05'
        $dateTimeObj = new DateTime('now', new DateTimeZone('Europe/Paris'));

        // format the date according to your preferences
        // the 3 params are [ DateTime object, ICU date scheme, string locale ]
        $dateFormatted = 
        IntlDateFormatter::formatObject( 
        $dateTimeObj, 
        'eee d MMMM y', 
        'fr' 
        );

        // test :
        return ucwords($dateFormatted);*/




    }

/**
     * Retourne le taux de vote positifs
     * 
     * @return float : 
     */
    public static function tauxVotesPositifs($votesPositifs,$votesNegatifs) : float
    {
        $totalVotes = $votesPositifs + $votesNegatifs;
        if ($totalVotes){
            $taux = $votesPositifs/$totalVotes;   
        }
        return $taux;
    }



    
}