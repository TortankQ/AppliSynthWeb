<?php
    require_once('../model/DaoCompte.php');
    require_once('../model/DtoCompte.php');
    require_once('../model/DaoConvention.php');
    require_once('../model/DtoConvention.php');
    require_once('../model/DaoClient.php');
    require_once('../model/DtoClient.php');
    require_once('../model/DaoEtudiant.php');
    require_once('../model/DtoEtudiant.php');
    
    session_start();
    //session_unset();
   

    $page = "formulaire_convention";
    $erreur = "";

    #empeche l'utilisateur de charger cette page sans compte
    if(!isset($_SESSION['DtoCompte'])){
        header('Location: ./FrontController.php');
    }

    #gere la creation du client dans la bdd
    if(isset($_POST['valider'])){
        if(isset($_POST['nomProjet']) && $_POST['nomProjet']!=""){
            if(isset($_POST['nomClient']) && $_POST['nomClient']!=""){
                if(isset($_POST['clientTel']) && $_POST['clientTel']!=""){
                //creation dtoClient + insert bdd
                    $dtoClient = new DtoClient($_POST['nomClient'],$_POST['numeroRue'],$_POST['rue'],$_POST['codePostal'],$_POST['clientMail'],$_POST['clientTel'],$_POST['numSiret']);
                    
                    $daoClient = new DaoClient("localhost","junior","root","");
                    
                    $daoClient->insertClient($dtoClient);
                }                
            }
        }
    }


    #gere les collaborateur de la convention
    if(isset($_POST['collaborateurNom1']) && $_POST['collaborateurNom1']!=""){
        if(isset($_POST['collaborateurPrenom1']) && $_POST['collaborateurPrenom1']!=""){
            
            $arrayCollab = array();
            //cherche l'etudiant dans la bdd et crée la dto associé arraylist

            $daoEtudiant = new DaoEtudiant("localhost","junior","root","");

            $dtoEtudiant = $daoEtudiant->getByNomEtudiant($_POST['collaborateurNom1'],$_POST['collaborateurPrenom1']);
            
            if($dtoEtudiant!=null){
                array_push($arrayCollab,$dtoEtudiant);
            }
            $cptCollab=2;
            
            while(isset($_POST['collaborateurNom'.$cpt.'']) && $_POST['collaborateurNom'.$cpt.'']!=""){
                //cherche l'etudiant dans la bdd et crée la dto associé
                if(isset($_POST['collaborateurPrenom'.$cpt.'']) && $_POST['collaborateurPrenom'.$cpt.'']!=""){
                    
                    $dtoEtudiant = $daoEtudiant->getByNomEtudiant($_POST['collaborateurNom'.$cpt.''],$_POST['collaborateurPrenom'.$cpt.'']);
                    
                    //if($dtoEtudiant!=null){
                        array_push($arrayCollab,$dtoEtudiant);
                    //}
                }
                $cptCollab++;
            }
        }
    }

    #gere les taches de la convention
    if(isset($_POST['intituleTache1']) && $_POST['intituleTache1']!=""){
        if(isset($_POST['quantite1']) && $_POST['quantite1']!=""){
            if(isset($_POST['prixHT1']) && $_POST['prixHT1']!=""){
                //crée une DTO tache
                $arrayTache = array();
                

                $daoTache = new DaoTache("localhost","junior","root","");

                $daoTache->insertTache($dtoTache);
                $cpt=2;
                while(!empty($_POST['intituleTache'.$cpt] && $_POST['intituleTache'.$cpt]!="")){
                    if(!empty($_POST['quantite'.$cpt] && $_POST['quantite'.$cpt]!="")){
                        if(!empty($_POST['prixHT'.$cpt] && $_POST['prixHT'.$cpt]!="")){
                            //crée des DTO tache
                        }
                    }
                }              
            }
        }
    }
 var_dump($_SESSION);
  
    if(isset($_POST['accompte']) && $_POST['accompte']!=""){
        //avec accompte
        
        if(isset($_POST['dateDebut'])){
            $arrayDateDebut = date_parse($_POST['dateDebut']);
            if(checkdate($arrayDateDebut['month'],$arrayDateDebut['day'],$arrayDateDebut['year'])){
                if(isset($_POST['dateFin'])){
                    $arrayDateFin = date_parse($_POST['dateFin']);
                    if(checkdate($arrayDateFin['month'],$arrayDateFin['day'],$arrayDateFin['year'])){
                        var_dump($_POST['dateFin']);
                    }
                }
            }
        }
    }else{
        //pas d'accompte
        if(isset($_POST['dateDebut'])){
            $arrayDateDebut = date_parse($_POST['dateDebut']);
            if(checkdate($arrayDateDebut['month'],$arrayDateDebut['day'],$arrayDateDebut['year'])){
                if(isset($_POST['dateFin'])){
                    $arrayDateFin = date_parse($_POST['dateFin']);
                    if(checkdate($arrayDateFin['month'],$arrayDateFin['day'],$arrayDateFin['year'])){
                        var_dump($_POST['dateFin']);
                    }
                }
            }
        }            
    }
    
    

    

    include("../View/layout.php");

    