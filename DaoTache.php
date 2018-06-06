<?php
    /* Authors :    Tayfun Ozturk
                    Julien Frillici
                    Bilge Ekinci
                    05-2018 / AppliSynth - Junior Entreprise
    Classe DAO Tache*/

class DaoTache{
    
     #attributs
    private $bdd;
    private $hote;
    private $UserName;
    private $Password;
    
    #constructeur
    public function __construct($hote, $base, $UserName, $Password){
        try{
            $this->hote=$hote;
            $this->UserName=$UserName;
            $this->Password=$Password;
            $this->bdd = new PDO('mysql:host='.$hote.';dbname='.$base.';charset=utf8', $UserName, $Password);
        }catch (Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    
    //Fonction qui ajoute une nouvelle tache dans la BDD:
    public function insertTache($DtoTache){
        
        $this->NumTache = $NumTache;
        $this->Intitule = $Intitule;
        $this->Quantite = $Quantite;
        $this->PrixHT = $PrixHT;
        
        $requete = 'INSERT INTO tache (NumTache, Intitule, Quantite, PrixHT) values(:t_NumTache, :t_Intitule, :t_Quantite, :t_PrixHT);';
        
        $req = $this->bdd->prepare($requete);
        $donnee = $req->execute( array(
            't_NumTache' => $DtoTache->getNumTache(),
            't_Intitule' => $DtoTache->getIntitule(),
            't_Quantite' => $DtoTache->getQuantite(),
            't_PrixHT' => $DtoTache->getPrixHT(),
            ));
        
        $DtoTache->setIdClient($donnee['NumTache']);
        
        $req->closeCursor();
        
        return true;
    } 
}