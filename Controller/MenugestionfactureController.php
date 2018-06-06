<?php

    require_once('../model/DaoCompte.php');
    require_once('../model/DtoCompte.php');
    require_once('../model/DaoFacture.php');
    require_once('../model/DtoFacture.php');

    session_start();
    var_dump($_SESSION);

    $page = "menugestionfacture";
    $erreur = "";

    #empeche l'utilisateur de charger cette page sans compte
    if(!isset($_SESSION['DtoCompte'])){
        header('Location: ./FrontController.php');
    }

   if(isset($_POST['btnModifierEditerConvention'])){
        $page = "consulterediterfacture";
    }

    include("../View/layout.php");