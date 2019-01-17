<?php
/**
*@package CMA_AutoDiag
*@version 1.0
*/

/*
Plugin Name: CMA AutoDiag
Plugin URI: https://quanticalsolutions.com
Description: Permet de créer un formulaire d'enquête au format QCM, générant des actions définies en fonction du score obtenu par le nombre de "OUI" cochés dans le formulaire.
Version: 1.0
Author: Quantical Solutions
Author URI: https://quanticalsolutions.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: autodiag
*/

/*-----------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
Vérifier que l'extension est appelée depuis WordPress et non directement via internet
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------*/

if ( !defined('ABSPATH') ) exit ('Faites demi-tour !');

/*-----------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
-------------------------AutoDiag Plugin CLass et Instances--------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------*/


class Autodiag
{
    public function __construct()
    {

        include_once plugin_dir_path( __FILE__ ).'/formulaire.php';
    	new Formulaire();

		register_activation_hook(__FILE__, array('Formulaire', 'install'));

		include_once plugin_dir_path( __FILE__ ).'/formfront.php';
        new Form_front();
    }
}

new Autodiag();