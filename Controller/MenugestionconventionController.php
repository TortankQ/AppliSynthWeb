<?php

    session_start();
    var_dump($_SESSION);

    $page = "menugestionconvention";
    $erreur = "";

    #empeche l'utilisateur de charger cette page sans compte
    if(!isset($_SESSION['DtoCompte'])){
        header('Location: ./FrontController.php');
    }
    
    if(isset($_POST['btnModifierEditerConvention'])){
        $page = "consultermodifierediterconvention";
    }

    include("../View/layout.php");