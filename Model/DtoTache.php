<?php
    /* Authors :    Tayfun Ozturk
                    Julien Frillici
                    Bilge Ekinci
                    05-2018 / AppliSynth - Junior Entreprise
    Classe DTO Tache*/


class DtoTache{
    
    #attributs
    private $NumTache;
    private $Intitule;
    private $Quantite;
    private $PrixHT;
    
    #constructeur
    public function __construct($NumTache, $Intitule, $Quantite, $PrixHT){
        $this->NumTache = $NumTache;
        $this->Intitule = $Intitule;
        $this->Quantite = $Quantite;
        $this->PrixHT = $PrixHT;
    }
    
    #getters
    public function getNumTache(){return $this->NumTache;}
    public function getIntitule(){return $this->Intitule;}
    public function getQuantite{return $this->Quantite;}
    public function getPrixHT(){return $this->PrixHT;}
    
    #setters
    public function setNumTache($Numtache){$this->NumTache = $NumTache;}
    public function setIntitule($Intitule){$this->Intitule = $Intitule;}
    public function setQuantite($Quantite){$this->Quantite = $Quantite;}
    public function setPrix($Prix){$this->Prix = $Prix;}
}