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
            
            while(isset($_POST['collaborateurNom'.$cptCollab.'']) && $_POST['collaborateurNom'.$cptCollab.'']!=""){
                //cherche l'etudiant dans la bdd et crée la dto associé
                if(isset($_POST['collaborateurPrenom'.$cptCollab.'']) && $_POST['collaborateurPrenom'.$cptCollab.'']!=""){
                    
                    $dtoEtudiant = $daoEtudiant->getByNomEtudiant($_POST['collaborateurNom'.$cptCollab],$_POST['collaborateurPrenom'.$cptCollab]);
                    
                    if($dtoEtudiant!=null){
                        array_push($arrayCollab,$dtoEtudiant);
                        $_SESSION['test']=$arrayCollab;
                    }
                }
                $cptCollab++;
            }
        }
    }

    #gere les taches de la convention
//    if(isset($_POST['intituleTache1']) && $_POST['intituleTache1']!=""){
//        if(isset($_POST['quantite1']) && $_POST['quantite1']!=""){
//            if(isset($_POST['prixHT1']) && $_POST['prixHT1']!=""){
//                //crée une DTO tache
//                $arrayTache = array();
//                
//
//                $daoTache = new DaoTache("localhost","junior","root","");
//
//                $daoTache->insertTache($dtoTache);
//                $cpt=2;
//                while(!empty($_POST['intituleTache'.$cpt] && $_POST['intituleTache'.$cpt]!="")){
//                    if(!empty($_POST['quantite'.$cpt] && $_POST['quantite'.$cpt]!="")){
//                        if(!empty($_POST['prixHT'.$cpt] && $_POST['prixHT'.$cpt]!="")){
//                            //crée des DTO tache
//                        }
//                    }
//                }              
//            }
//        }
//    }

  
    
        
    if(isset($_POST['dateDebut'])){
        
        $arrayDateDebut = date_parse($_POST['dateDebut']);
        
        if(checkdate($arrayDateDebut['month'],$arrayDateDebut['day'],$arrayDateDebut['year'])){
            
            if(isset($_POST['dateFin'])){
                
                $arrayDateFin = date_parse($_POST['dateFin']);
                
                if(checkdate($arrayDateFin['month'],$arrayDateFin['day'],$arrayDateFin['year'])){
                    
                    if($dtoClient!=null){
                        
                        if(sizeof($arrayCollab)>0){
                            
                           // if(sizeof($arrayTache)>0){
                                
                                if(isset($_POST['accompte']) && $_POST['accompte']!=""){
                                    //avec accompte
                                    $daoConvention = new DaoConvention("localhost","junior","root","");
                                    
                                    
                                    $dtoConvention = new DtoConvention(
                                        $_POST['NomProjet'],
                                        $dtoClient->getIdClient(),
                                        $_POST['dateDebut'],
                                        $_POST['dateFin'],
                                        $_POST['totalHT'],
                                        $_POST['TotalTTC'],
                                        $_POST['accompte'],
                                        $_POST['tva'],
                                        false,
                                        $_POST['commentaire']
                                    );
                                    
                                    $daoConvention->insertTabConvention($dtoConvention);
                                    $_SESSION['dtoConvention']=$dtoConvention;
                                    
                                }else{
                                    //sans accompte
                                     $daoConvention = new DaoConvention("localhost","junior","root","");
                                    
                                    
                                    $dtoConvention = new DtoConvention(
                                        $_POST['NomProjet'],
                                        $dtoClient->getIdClient(),
                                        $_POST['dateDebut'],
                                        $_POST['dateFin'],
                                        $_POST['totalHT'],
                                        $_POST['TotalTTC'],
                                        0,
                                        $_POST['tva'],
                                        false,
                                        $_POST['commentaire']
                                    );
                                    
                                    $daoConvention->insertTabConvention($dtoConvention);
                                    $_SESSION['dtoConvention']=$dtoConvention;
                                }
                           // }
                        }
                    }
                }
            }
        }          
    }
    
    
 var_dump($_SESSION);
    

    include("../View/layout.php");

    