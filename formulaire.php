<?php

class Formulaire
{
    public function __construct()
    {

        add_action('wp_loaded', array($this, 'save_form'));
        add_action('wp_loaded', array($this, 'save_refs'));
        add_action('wp_loaded', array($this, 'save_setts'));
        add_action('wp_loaded', array($this, 'convertCsv'));
        add_action('admin_menu', array($this, 'add_admin_menu'), 20);

    }

    public static function install()
	{
	    global $wpdb;

	    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}autodiag (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, t2 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', t3 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', t4 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q1 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q2 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q3 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q4 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q5 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q6 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q7 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q8 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q9 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q10 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q11 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q12 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q13 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q14 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q15 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q16 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q17 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q18 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q19 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q20 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q21 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q22 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q23 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q24 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q25 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q26 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q27 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q28 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q29 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', q30 VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide');");

        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}autodiag_users (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, loaded INT NOT NULL DEFAULT 0, nom VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, societe VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, email VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, tel VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, siret BIGINT NOT NULL, rappel VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', score INT NOT NULL, form_id INT, questions VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);");

        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}autodiag_refs (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, r1 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', p1 INT NOT NULL, r2 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', p2 INT NOT NULL, r3 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', p3 INT NOT NULL, r4 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', p4 INT NOT NULL, r5 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'vide', p5 INT NOT NULL);");

        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}autodiag_settings (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, preset INT NOT NULL DEFAULT 20);");

        $wpdb->query("INSERT INTO {$wpdb->prefix}autodiag VALUES (1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0) ON DUPLICATE KEY UPDATE id = 1;");

        $wpdb->query("INSERT INTO {$wpdb->prefix}autodiag_refs VALUES (1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0) ON DUPLICATE KEY UPDATE id = 1;");
        $wpdb->query("INSERT INTO {$wpdb->prefix}autodiag_settings VALUES (1, 20) ON DUPLICATE KEY UPDATE id = 1;");

	}

    public function save_form()
    {
        global $wpdb;

        if (isset($_POST['q1']) && !empty($_POST['q1'])) {

            $tab = array();
            $tab2 = array();

            for ($i = 1; $i <= count($_POST); $i++) {

                if (isset($_POST['q' . $i])) {

                    $argQ = $_POST['q' . $i];

                    array_push($tab, $argQ);
                }

                if (isset($_POST['t' . $i])) {

                    $argT = $_POST['t' . $i];

                    array_push($tab2, $argT);
                }
            }

            $imptab = implode("', '", $tab);
            $imptab2 = implode("', '", $tab2);
                
            $wpdb->query("INSERT INTO {$wpdb->prefix}autodiag (t2, t3, t4, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17, q18, q19, q20, q21, q22, q23, q24, q25, q26, q27, q28, q29, q30) VALUES ('" . $imptab2 . "', '" . $imptab . "');");
        }
    }

    public function save_setts()
    {

    	if (isset($_POST['preset']) && !empty($_POST['preset'])) {
    		
    		$preset = $_POST['preset'];

    		global $wpdb;

    		$wpdb->query("DELETE FROM `{$wpdb->prefix}autodiag_settings` WHERE id = 1;");
    		$wpdb->query("INSERT INTO {$wpdb->prefix}autodiag_settings (id, preset) VALUES (1, '" . $preset . "');");
    	}
    }

    public function save_refs()
    {
        global $wpdb;

        if (isset($_POST['r1']) && !empty($_POST['r1'])) {

            $tab2 = array();

            for ($i = 1; $i <= count($_POST); $i++) {

                if (isset($_POST['r' . $i])) {

                    $argQ2 = $_POST['r' . $i];

                    array_push($tab2, $argQ2);
                }
            }

            $imptab2 = implode("', '", $tab2);

            $tab3 = array();

            for ($j = 1; $j <= count($_POST); $j++) {

                if (isset($_POST['p' . $j])) {

                    $argQ3 = $_POST['p' . $j];

                    array_push($tab3, $argQ3);
                }
            }

            $imptab3 = implode("', '", $tab3);

            if (!empty($tab2) && !empty($tab3)) {
                
                $wpdb->query("INSERT INTO {$wpdb->prefix}autodiag_refs (r1, r2, r3, r4, r5, p1, p2, p3, p4, p5) VALUES ('" . $imptab2 . "', '" . $imptab3 . "');");
            }
        }
    }

    public function add_admin_menu()
    {

        add_menu_page('AutoDiag', 'AutoDiag', 'manage_options', 'AutoDiag', array($this, 'accueil'), 'dashicons-align-left', 6);

        add_submenu_page('AutoDiag', 'Edition', 'Edition', 'manage_options', 'formulaire', array($this, 'formEditor'));

        add_submenu_page('AutoDiag', 'Export', 'Export', 'manage_options', 'export', array($this, 'export'));

       

        	/*<script>

        		window.onload = function() {

	        		var subMenuFloat = document.querySelectorAll('.wp-first-item');

	        		for (var sub = 0; sub < subMenuFloat.length; sub++) {

	        			if (subMenuFloat[sub].innerHTML == 'AutoDiag') {

	        				subMenuFloat[sub].innerHTML = 'Général';
	        			}
	        		}
	        	};

        	</script>*/

      
    }

    public function accueil()
    {
        ?>

        <style>

        #mainPres{
            width: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .presSides {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #logoSvg {
            width: 80%;
        }

        .presSides:last-child div {
            width: 50%;
        }

        .autoDiagHeader {
            margin: 50px 0 50px 30px;
        }

        @media (max-width: 790px) {

            .formback {
                flex-direction: column!important;
            }

            .mainFormBack {
                width: 90%!important;
            }

            #mainPres, #expContent {
                flex-direction: column!important;
            }

            .presSides, .userslist {
                width: 90%!important;
                margin: auto!important;
            }

            .presSides > div {
                width: 100%!important;
            }

            .headerForm {
                flex-direction: column!important;
            }

            .autoDiagHeader h1 {
                line-height: 1em!important;
            }
        }

        </style>
        <div class="autoDiagHeader">
            <h1>Présentation d'AutoDiag et fonctionnement</h1>
            <p>Bienvenue sur la page d'accueil du plugin.</p>
        </div>
        <hr>

        <div id="mainPres">
            <div class="presSides">
                <svg id="Calque_1" data-name="Calque 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 660 515"><defs><style>.cls-1{fill:#3c3c3c;}.cls-2{fill:beige;}.cls-3{fill:wheat;}.cls-4{fill:#fff;}.cls-5{opacity:0.34;}.cls-6{fill:none;}.cls-7{fill:#ccc;}</style></defs><rect class="cls-1" y="-1.5" width="660.75" height="518.25"/><path class="cls-1" d="M-91.45,157.11v243h827v-243ZM252.25,307.82l8.33-4.91a74.47,74.47,0,0,0,102,26.29l4.91,8.33A84.14,84.14,0,0,1,252.25,307.82Zm138.57-54.28-2,.34-5.6,1a59.22,59.22,0,1,0-48.31,68.41l1,5.6.34,2,1.09,6.32a73.32,73.32,0,1,1,59.82-84.7Zm23.53,26.23-.06.33-5.79-1a85.48,85.48,0,1,0-98.41,70.21l-.86,5.14a91,91,0,0,1-74.49-104.41l.05-.33a91,91,0,0,1,104.47-74.82l.33.05A91,91,0,0,1,414.35,279.77Z"/><path class="cls-2" d="M339.58,175l-.33-.05-1,5.79a85.48,85.48,0,0,1,70.21,98.41l5.79,1,.06-.33A91,91,0,0,0,339.58,175Z"/><path class="cls-3" d="M309.23,354.48l.86-5.14a85.48,85.48,0,0,1-70.21-98.41l-5.14-.86A91,91,0,0,0,309.23,354.48Z"/><path class="cls-4" d="M234.79,249.74l-.05.33,5.14.86a85.48,85.48,0,0,1,98.41-70.21l1-5.79A91,91,0,0,0,234.79,249.74Z"/><path class="cls-4" d="M313.53,199l-1.09-6.32a73.32,73.32,0,0,0-59.82,84.7l6.32-1.09,2-.34,5.6-1a59.22,59.22,0,0,1,48.31-68.41l-1-5.6Z"/><path class="cls-3" d="M258.95,276.25l-6.32,1.09a73.32,73.32,0,0,0,84.7,59.82l-1.09-6.32-.34-2-1-5.6a59.22,59.22,0,0,1-68.41-48.31l-5.6,1Z"/><path class="cls-3" d="M312.44,192.64l1.09,6.32.34,2,1,5.6a59.22,59.22,0,0,1,68.41,48.31l5.6-1,2-.34,6.32-1.09A73.32,73.32,0,0,0,312.44,192.64Z"/><path class="cls-4" d="M260.58,302.91l-8.33,4.91a84.14,84.14,0,0,0,115.22,29.71l-4.91-8.33A74.47,74.47,0,0,1,260.58,302.91Z"/><g class="cls-5"><path class="cls-2" d="M595.62,245.83l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,595.62,245.83Z"/><path class="cls-3" d="M552,243.44l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,552,243.44Z"/><path class="cls-4" d="M575,222.81l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,575,222.81Z"/><path class="cls-6" d="M595.78,242.15a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M572.3,229.53h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M569.77,230l-.4-1.39-.14-.49-.46-1.58A18.75,18.75,0,0,0,556,249.79l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,569.77,230Z"/><path class="cls-3" d="M578.72,261h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M568.76,226.57l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,568.76,226.57Z"/><path class="cls-4" d="M558.71,256.06l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,558.71,256.06Z"/><path class="cls-2" d="M625.51,295.57l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51H605l-.08,1.5A21.86,21.86,0,0,1,625.51,295.57Z"/><path class="cls-3" d="M581.86,293.17l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,581.86,293.17Z"/><path class="cls-4" d="M604.89,272.55,605,271a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,604.89,272.55Z"/><path class="cls-6" d="M625.67,291.89a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M602.19,279.27h0A15.14,15.14,0,0,0,588.81,296l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M599.66,279.77l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,599.66,279.77Z"/><path class="cls-3" d="M608.61,310.75h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M598.66,276.31l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,598.66,276.31Z"/><path class="cls-4" d="M588.6,305.8l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,588.6,305.8Z"/><path class="cls-2" d="M655.35,345.33l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,655.35,345.33Z"/><path class="cls-3" d="M611.7,342.94l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,611.7,342.94Z"/><path class="cls-4" d="M634.73,322.31l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,634.73,322.31Z"/><path class="cls-6" d="M655.51,341.65a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M632,329h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,632,329Z"/><path class="cls-4" d="M629.5,329.54l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,629.5,329.54Z"/><path class="cls-3" d="M638.45,360.52h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M628.5,326.07l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,628.5,326.07Z"/><path class="cls-4" d="M618.44,355.56l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,618.44,355.56Z"/><path class="cls-3" d="M641.66,392.63l-1.33-.07A23.27,23.27,0,0,0,662.21,417l.07-1.33A21.86,21.86,0,0,1,641.66,392.63Z"/><path class="cls-4" d="M664.68,372l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,664.68,372Z"/><path class="cls-6" d="M685.46,391.35A21.86,21.86,0,0,0,661.32,372l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M662,378.73h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,662,378.73Z"/><path class="cls-4" d="M659.45,379.23l-.4-1.39-.14-.49-.46-1.58A18.75,18.75,0,0,0,645.65,399l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,659.45,379.23Z"/><path class="cls-3" d="M668.41,410.21h0l-.14-.49-.4-1.39A15.14,15.14,0,0,1,649.11,398l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M658.45,375.77l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,658.45,375.77Z"/><path class="cls-4" d="M648.39,405.26l-2,1.48A21.51,21.51,0,0,0,676.54,411l-1.48-2A19,19,0,0,1,648.39,405.26Z"/><path class="cls-2" d="M629.82,188.65l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,629.82,188.65Z"/><path class="cls-3" d="M586.17,186.25l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,586.17,186.25Z"/><path class="cls-4" d="M609.19,165.62l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,609.19,165.62Z"/><path class="cls-6" d="M630,185a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,630,185l1.32-.15h0Z"/><path class="cls-6" d="M606.49,172.35h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M604,172.85l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,604,172.85Z"/><path class="cls-3" d="M612.92,203.83h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M603,169.38l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,603,169.38Z"/><path class="cls-4" d="M592.9,198.87l-2,1.48A21.51,21.51,0,0,0,621,204.65l-1.48-2A19,19,0,0,1,592.9,198.87Z"/><path class="cls-2" d="M659.71,238.38l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,659.71,238.38Z"/><path class="cls-3" d="M616.06,236l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,616.06,236Z"/><path class="cls-4" d="M639.08,215.36l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,639.08,215.36Z"/><path class="cls-6" d="M659.87,234.7a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M636.38,222.08h0A15.14,15.14,0,0,0,623,238.81l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M633.85,222.58l-.4-1.39-.14-.49-.46-1.58A18.75,18.75,0,0,0,620,242.34l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,633.85,222.58Z"/><path class="cls-3" d="M642.81,253.56h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M632.85,219.12l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,632.85,219.12Z"/><path class="cls-4" d="M622.79,248.61l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,622.79,248.61Z"/><path class="cls-3" d="M645.9,285.75l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,645.9,285.75Z"/><path class="cls-4" d="M668.92,265.12l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,668.92,265.12Z"/><path class="cls-6" d="M689.71,284.47a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M666.22,271.85h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M663.69,272.35l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,663.69,272.35Z"/><path class="cls-3" d="M672.65,303.33h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-4" d="M652.63,298.37l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,652.63,298.37Z"/><path class="cls-2" d="M665.49,125.64l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,665.49,125.64Z"/><path class="cls-3" d="M621.84,123.25l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,621.84,123.25Z"/><path class="cls-4" d="M644.86,102.62l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,644.86,102.62Z"/><path class="cls-6" d="M665.64,122a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,665.64,122l1.32-.15h0Z"/><path class="cls-6" d="M642.16,109.34h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M639.63,109.84l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,639.63,109.84Z"/><path class="cls-3" d="M648.59,140.82h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,649,142.4Z"/><path class="cls-3" d="M638.63,106.38l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,638.63,106.38Z"/><path class="cls-4" d="M628.57,135.87l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,628.57,135.87Z"/><path class="cls-3" d="M651.73,173l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,651.73,173Z"/><path class="cls-4" d="M674.75,152.35l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,674.75,152.35Z"/><path class="cls-6" d="M695.53,171.7a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M672,159.08h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,672,159.08Z"/><path class="cls-4" d="M669.52,159.58l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,669.52,159.58Z"/><path class="cls-3" d="M678.48,190.56h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-4" d="M658.46,185.6l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,658.46,185.6Z"/><path class="cls-3" d="M653.81,63.32l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,653.81,63.32Z"/><path class="cls-4" d="M676.83,42.69l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,676.83,42.69Z"/><path class="cls-6" d="M697.61,62a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,697.61,62l1.32-.15h0Z"/><path class="cls-6" d="M674.13,49.41h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M671.6,49.92l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,671.6,49.92Z"/><path class="cls-3" d="M680.56,80.9h0l-.14-.49L680,79a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,681,82.47Z"/><path class="cls-4" d="M660.54,75.94l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,660.54,75.94Z"/></g><g class="cls-5"><path class="cls-2" d="M24.44,489.06l1.5.08v-.08A23.27,23.27,0,0,0,4,464.54H3.89L3.81,466A21.86,21.86,0,0,1,24.44,489.06Z"/><path class="cls-3" d="M-19.21,486.66l-1.33-.07A23.27,23.27,0,0,0,1.34,511l.07-1.33A21.86,21.86,0,0,1-19.21,486.66Z"/><path class="cls-4" d="M3.81,466l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,3.81,466Z"/><path class="cls-6" d="M24.59,485.38A21.86,21.86,0,0,0,.45,466.07L.3,464.75h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M1.11,472.76h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,1.11,472.76Z"/><path class="cls-3" d="M7.54,504.24h0l-.14-.49L7,502.35A15.14,15.14,0,0,1-11.76,492l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,8,505.82Z"/><path class="cls-3" d="M-2.42,469.8l.46,1.58.14.49.4,1.39h0A15.14,15.14,0,0,1,17.33,483.6l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0-2.42,469.8Z"/><path class="cls-4" d="M-12.48,499.29l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1-12.48,499.29Z"/><path class="cls-2" d="M26.45,379.43l1.5.08v-.08A23.27,23.27,0,0,0,6,354.92H5.91l-.08,1.5A21.86,21.86,0,0,1,26.45,379.43Z"/><path class="cls-3" d="M-17.2,377l-1.33-.07A23.27,23.27,0,0,0,3.36,401.39l.07-1.33A21.86,21.86,0,0,1-17.2,377Z"/><path class="cls-4" d="M5.83,356.41l.08-1.5a23.27,23.27,0,0,0-24.43,22V377l1.33.07A21.86,21.86,0,0,1,5.83,356.41Z"/><path class="cls-6" d="M26.61,375.76a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M3.13,363.14h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,3.13,363.14Z"/><path class="cls-4" d="M.6,363.64l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,.6,363.64Z"/><path class="cls-3" d="M9.55,394.62h0l-.14-.49L9,392.73A15.14,15.14,0,0,1-9.74,382.39l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,10,396.19Z"/><path class="cls-3" d="M-.4,360.17l.46,1.58.14.49.4,1.39h0A15.14,15.14,0,0,1,19.35,374l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0-.4,360.17Z"/><path class="cls-4" d="M-10.46,389.66l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1-10.46,389.66Z"/><path class="cls-2" d="M56.41,429.13l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,56.41,429.13Z"/><path class="cls-3" d="M12.76,426.74l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,12.76,426.74Z"/><path class="cls-4" d="M35.78,406.11l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,35.78,406.11Z"/><path class="cls-6" d="M56.56,425.45a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M33.08,412.83h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M30.55,413.33l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,30.55,413.33Z"/><path class="cls-3" d="M39.51,444.31h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,40,445.89Z"/><path class="cls-3" d="M29.55,409.87l.46,1.58.14.49.4,1.39h0A15.14,15.14,0,0,1,49.3,423.67l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,29.55,409.87Z"/><path class="cls-4" d="M19.49,439.36l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,19.49,439.36Z"/><path class="cls-2" d="M1.2,223.75l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,1.2,223.75Z"/><path class="cls-6" d="M1.35,220.07a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,0,0-19.3,24.14,21.86,21.86,0,0,0,24.14,19.3,21.86,21.86,0,0,0,19.3-24.14l1.32-.15h0Z"/><path class="cls-2" d="M31.09,273.48l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,31.09,273.48Z"/><path class="cls-3" d="M-12.56,271.09l-1.33-.07A23.27,23.27,0,0,0,8,295.44l.07-1.33A21.86,21.86,0,0,1-12.56,271.09Z"/><path class="cls-4" d="M10.46,250.46l.08-1.5a23.27,23.27,0,0,0-24.43,22V271l1.33.07A21.86,21.86,0,0,1,10.46,250.46Z"/><path class="cls-6" d="M31.24,269.8A21.86,21.86,0,0,0,7.1,250.5L7,249.17H7l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M7.76,257.18h0A15.14,15.14,0,0,0-5.61,273.91l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,7.76,257.18Z"/><path class="cls-4" d="M5.23,257.68l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22L-7,277l.49-.14,1.39-.4A15.14,15.14,0,0,1,5.23,257.68Z"/><path class="cls-3" d="M14.19,288.66h0l-.14-.49-.4-1.39A15.14,15.14,0,0,1-5.11,276.43l-1.39.4h0L-7,277l-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M4.23,254.22l.46,1.58.14.49.4,1.39h0A15.14,15.14,0,0,1,24,268l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,4.23,254.22Z"/><path class="cls-4" d="M-5.83,283.71l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1-5.83,283.71Z"/><path class="cls-2" d="M60.93,323.24l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,60.93,323.24Z"/><path class="cls-3" d="M17.28,320.85l-1.33-.07A23.27,23.27,0,0,0,37.83,345.2l.07-1.33A21.86,21.86,0,0,1,17.28,320.85Z"/><path class="cls-4" d="M40.3,300.22l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,40.3,300.22Z"/><path class="cls-6" d="M61.08,319.57a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M37.6,306.95h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,37.6,306.95Z"/><path class="cls-4" d="M35.07,307.45l-.4-1.39-.14-.49L34.07,304a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,35.07,307.45Z"/><path class="cls-3" d="M44,338.43h0l-.14-.49-.4-1.39A15.14,15.14,0,0,1,24.73,326.2l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,44.48,340Z"/><path class="cls-3" d="M34.07,304l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,34.07,304Z"/><path class="cls-4" d="M24,333.47,22,335a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,24,333.47Z"/><path class="cls-2" d="M90.88,372.94l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,90.88,372.94Z"/><path class="cls-3" d="M47.24,370.55l-1.33-.07A23.27,23.27,0,0,0,67.79,394.9l.07-1.33A21.86,21.86,0,0,1,47.24,370.55Z"/><path class="cls-4" d="M70.26,349.92l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,70.26,349.92Z"/><path class="cls-6" d="M91,369.26A21.86,21.86,0,0,0,66.9,350l-.15-1.32h0L66.9,350A21.86,21.86,0,1,0,91,369.26l1.32-.15h0Z"/><path class="cls-6" d="M67.56,356.64h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M65,357.14l-.4-1.39-.14-.49L64,353.68a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,65,357.14Z"/><path class="cls-3" d="M74,388.12h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M64,353.68l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,64,353.68Z"/><path class="cls-4" d="M54,383.17l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,54,383.17Z"/><path class="cls-2" d="M27.16,165.39l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51H6.62l-.08,1.5A21.86,21.86,0,0,1,27.16,165.39Z"/><path class="cls-3" d="M-16.49,163l-1.33-.07A23.27,23.27,0,0,0,4.07,187.35L4.14,186A21.86,21.86,0,0,1-16.49,163Z"/><path class="cls-4" d="M6.53,142.37l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,6.53,142.37Z"/><path class="cls-6" d="M27.32,161.71a21.86,21.86,0,0,0-24.14-19.3L3,141.09H3l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M3.83,149.09h0A15.14,15.14,0,0,0-9.54,165.82L-11,166h0l1.44-.16A15.14,15.14,0,1,0,3.83,149.09Z"/><path class="cls-4" d="M1.31,149.6.9,148.2l-.14-.49L.3,146.13a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,1.31,149.6Z"/><path class="cls-3" d="M10.26,180.58h0l-.14-.49-.4-1.39A15.14,15.14,0,0,1-9,168.35l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M.3,146.13l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,.3,146.13Z"/><path class="cls-4" d="M-9.76,175.62l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1-9.76,175.62Z"/><path class="cls-2" d="M57.05,215.13l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,57.05,215.13Z"/><path class="cls-3" d="M13.4,212.73l-1.33-.07A23.27,23.27,0,0,0,34,237.09l.07-1.33A21.86,21.86,0,0,1,13.4,212.73Z"/><path class="cls-4" d="M36.42,192.11l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,36.42,192.11Z"/><path class="cls-6" d="M57.21,211.45a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M33.72,198.83h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M31.2,199.33l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,31.2,199.33Z"/><path class="cls-3" d="M40.15,230.31h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M30.19,195.87l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,30.19,195.87Z"/><path class="cls-4" d="M20.13,225.36l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,20.13,225.36Z"/><path class="cls-2" d="M86.89,264.89l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,86.89,264.89Z"/><path class="cls-3" d="M43.24,262.5l-1.33-.07A23.27,23.27,0,0,0,63.8,286.85l.07-1.33A21.86,21.86,0,0,1,43.24,262.5Z"/><path class="cls-4" d="M66.26,241.87l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,66.26,241.87Z"/><path class="cls-6" d="M87,261.21a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,87,261.21l1.32-.15h0Z"/><path class="cls-6" d="M63.56,248.59h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M61,249.1l-.4-1.39-.14-.49L60,245.63a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,61,249.1Z"/><path class="cls-3" d="M70,280.08h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M60,245.63l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,60,245.63Z"/><path class="cls-4" d="M50,275.12l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,50,275.12Z"/><path class="cls-2" d="M116.85,314.59l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51H96.3l-.08,1.5A21.86,21.86,0,0,1,116.85,314.59Z"/><path class="cls-3" d="M73.2,312.19l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,73.2,312.19Z"/><path class="cls-4" d="M96.22,291.57l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,96.22,291.57Z"/><path class="cls-6" d="M117,310.91a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,117,310.91l1.32-.15h0Z"/><path class="cls-6" d="M93.52,298.29h0A15.14,15.14,0,0,0,80.15,315l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M91,298.79l-.4-1.39-.14-.49L90,295.33a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,91,298.79Z"/><path class="cls-3" d="M99.95,329.77h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M90,295.33l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,90,295.33Z"/><path class="cls-4" d="M79.93,324.82l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,79.93,324.82Z"/></g><path class="cls-7" d="M350.24,317.7l-6.16-24.26h3.31l2.88,12.27c.72,3,1.37,6,1.8,8.39h.07c.4-2.41,1.15-5.29,2-8.42l3.24-12.24h3.28l3,12.31c.68,2.88,1.33,5.76,1.69,8.32h.07c.5-2.66,1.19-5.36,1.94-8.39l3.2-12.24h3.2l-6.87,24.26h-3.28l-3.06-12.63a72.68,72.68,0,0,1-1.58-7.92h-.07a75.59,75.59,0,0,1-1.87,7.92l-3.46,12.63Z"/><path class="cls-7" d="M376.74,293.73a36.29,36.29,0,0,1,6-.47c3.1,0,5.36.72,6.8,2a6.53,6.53,0,0,1,2.12,5.08,7.14,7.14,0,0,1-1.87,5.18c-1.66,1.76-4.36,2.66-7.42,2.66a10.8,10.8,0,0,1-2.52-.22v9.72h-3.13Zm3.13,11.7a10.52,10.52,0,0,0,2.59.25c3.78,0,6.08-1.84,6.08-5.18s-2.27-4.75-5.72-4.75a13.11,13.11,0,0,0-3,.25Z"/><path class="cls-7" d="M403.09,313.88a11.1,11.1,0,0,0,5.62,1.58c3.2,0,5.08-1.69,5.08-4.14,0-2.27-1.3-3.56-4.57-4.82-4-1.4-6.41-3.46-6.41-6.87,0-3.78,3.13-6.59,7.85-6.59a11,11,0,0,1,5.36,1.19l-.86,2.56a9.67,9.67,0,0,0-4.61-1.15c-3.31,0-4.57,2-4.57,3.64,0,2.27,1.48,3.38,4.82,4.68,4.1,1.58,6.19,3.56,6.19,7.13,0,3.74-2.77,7-8.49,7a12.53,12.53,0,0,1-6.19-1.55Z"/><path class="cls-7" d="M437.14,308.84c0,6.44-4.46,9.25-8.67,9.25-4.72,0-8.35-3.46-8.35-9,0-5.83,3.82-9.25,8.64-9.25C433.76,299.88,437.14,303.52,437.14,308.84Zm-13.82.18c0,3.82,2.2,6.69,5.29,6.69s5.29-2.84,5.29-6.77c0-3-1.48-6.7-5.22-6.7S423.32,305.71,423.32,309Z"/><path class="cls-7" d="M441.14,292.14h3.17V317.7h-3.17Z"/><path class="cls-7" d="M464.21,312.95c0,1.8,0,3.38.14,4.75h-2.81l-.18-2.84h-.07a6.56,6.56,0,0,1-5.76,3.24c-2.74,0-6-1.51-6-7.63V300.28h3.17v9.65c0,3.31,1,5.54,3.89,5.54a4.58,4.58,0,0,0,4.18-2.88A4.64,4.64,0,0,0,461,311V300.28h3.17Z"/><path class="cls-7" d="M473.29,295.27v5h4.54v2.41h-4.54v9.4c0,2.16.61,3.38,2.38,3.38a7,7,0,0,0,1.84-.22l.14,2.38a7.76,7.76,0,0,1-2.81.43,4.39,4.39,0,0,1-3.42-1.33c-.9-.94-1.22-2.48-1.22-4.54v-9.5h-2.7v-2.41h2.7V296.1Z"/><path class="cls-7" d="M484.92,295.38a2,2,0,0,1-3.92,0,1.93,1.93,0,0,1,2-2A1.88,1.88,0,0,1,484.92,295.38Zm-3.53,22.32V300.28h3.17V317.7Z"/><path class="cls-7" d="M505.58,308.84c0,6.44-4.46,9.25-8.67,9.25-4.71,0-8.35-3.46-8.35-9,0-5.83,3.82-9.25,8.64-9.25C502.19,299.88,505.58,303.52,505.58,308.84Zm-13.82.18c0,3.82,2.2,6.69,5.29,6.69s5.29-2.84,5.29-6.77c0-3-1.48-6.7-5.22-6.7S491.75,305.71,491.75,309Z"/><path class="cls-7" d="M509.58,305c0-1.8,0-3.28-.14-4.71h2.81l.18,2.88h.07a6.4,6.4,0,0,1,5.76-3.28c2.41,0,6.16,1.44,6.16,7.42v10.4h-3.17v-10c0-2.81-1-5.15-4-5.15a4.5,4.5,0,0,0-4.25,3.24,4.55,4.55,0,0,0-.22,1.48V317.7h-3.17Z"/><path class="cls-7" d="M529.12,314.46a8.3,8.3,0,0,0,4.18,1.26c2.3,0,3.38-1.15,3.38-2.59s-.9-2.34-3.24-3.2c-3.13-1.12-4.61-2.84-4.61-4.93,0-2.81,2.27-5.11,6-5.11a8.69,8.69,0,0,1,4.28,1.08l-.79,2.3a6.78,6.78,0,0,0-3.56-1c-1.87,0-2.92,1.08-2.92,2.38s1,2.09,3.31,3c3,1.15,4.57,2.66,4.57,5.26,0,3.06-2.38,5.22-6.52,5.22a9.94,9.94,0,0,1-4.9-1.19Z"/></svg>
            </div>
            <div class="presSides">
                <div>
                    <h2 style="font-size: 1.8em;">Présentation</h2>
                    <p>L'utilisation du plugin AutoDiag vous permet de :</p>
                    <ul>
                        <li>Customiser les formulaires de diagnostic.</li>
                        <li>Récupérer les informations sur les utilisateurs du formulaire.</li>
                        <li>De traiter les données récupérées en fonction de leur pertinence.</li>
                        <li>D'exporter par email les fichiers '.csv' des rapports d'utilisation du formulaire.</li>
                        <li>De pouvoir mettre à jour les emails des différents services concernés, selon le résultat du formulaire.</li>
                    </ul>
                </div>
                <div style="margin-top: 0px;">
                    <h2 style="font-size: 1.8em;">Fonctionnement</h2>
                    <p>Le fonctionnement du plugin <i><b>AutoDiag</b></i> est très simple.<br>Il vous suffit de copier le shortcode ci-dessous dans le module texte de n'importe quelle page de votre site Wordpress: <br><br><span style="font-size: 2em; font-weight: bold;">[AutoDiag]</span><br><br>Le formulaire apparaîtra sur la page concernée.</p>
                    <p><span style="color: red; font-weight: bold;">ATTENTION</span>, il est nécessaire pour que le plugin fonctionne correctement de configurer votre Wordpress pour utiliser le SMTP afin de pouvoir envoyer des mails en <a href="http://php.net/manual/fr/index.php" target="_blank">PHP</a> depuis votre site via le plugin <i><b>AutoDiag</b></i>.<br>Pour ce faire, il est conseillé de charger une extension tel que <a href="https://wpforms.com/" target="_blank">WP Mail SMTP</a>.</p>
                </div>
            </div>
        </div>
        <hr>

        <script>

        	document.querySelector('#toplevel_page_AutoDiag').children[1].children[1].children[0].innerHTML = 'Général';

       	</script>

        <?php
    }

    public function formEditor()
    {

        global $wpdb;

        $questions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag ORDER BY id DESC LIMIT 0, 1;");
        $referents = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag_refs ORDER BY id DESC LIMIT 0, 1;");
        
        ?>

            <style>

                .mainFormBack {
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                    width: 30%;
                    margin: 0 auto;
                }

                .mainFormBack h2 {
                    width: 100%;
                    text-align: center;
                    font-size: 1.8em;
                    font-weight: bold;
                    color: dimgrey;
                }

		        .mainFormBack h2 input {
		        	height: 40px;
				    font-size: 1em;
				    color: dimgrey;
				    border-radius: 5px;
				    padding-left: 10px;
		        }

                .mainFormBack div {
                    margin-bottom: 20px;
                }

                .mainFormBack div input {
                    width: 100%;
                }

                .formback {
                    display: flex;
                    flex-direction: row;
                    width: 100%;
                }

                #formDash, #refForm {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    flex-wrap: wrap;

                }

                .autoDiagHeader {
                    margin: 50px 0 50px 30px;
                }

                .mainFormBack #logoSvg {
                    width: 70%;
                    margin: 0 auto;
                }

                @media (max-width: 790px) {

                    .formback {
                        flex-direction: column!important;
                    }

                    .mainFormBack {
                        width: 90%!important;
                    }

                    .mainFormBack label {
                        width: 100%;
                    }

                    .mainFormBack > div {
                        display: flex!important;
                        flex-wrap: wrap!important;
                        align-items: center!important;
                    }

                    #mainPres, #expContent {
                        flex-direction: column!important;
                    }

                    .presSides, .userslist {
                        width: 90%!important;
                        margin: auto!important;
                    }

                    .presSides > div {
                        width: 100%!important;
                    }

                    .headerForm {
                        flex-direction: column!important;
                    }

                    .autoDiagHeader h1, .mainFormBack h2 {
                        line-height: 1em!important;
                    }
                }

            </style>
        <div class="autoDiagHeader">
            <h1>Edition du formulaire de diagnostic</h1>
            <p>Bienvenue sur la page d'édition du formulaire.</p>
        </div>
        <hr>
        <form id="formDash" method="post" action="">
            <h3 style="width: 100%; text-align: center;">Caractères interdits : <span style="color: red; filter: blur(0.4px);">~ " # ? { } [ ] / | \</span></h3>
            <hr style="width: 100%;">
            <div class="formback">
                <div class="mainFormBack">
                    <h2>Titre 1 <input type="text" name="t2" value="<?php echo $questions[0]->t2 ?>"></h2>
                    <div>
                        <label>Question 1</label>
                        <input type="text" name="q1" value="<?php echo $questions[0]->q1 ?>">
                    </div>
                    <div>
                        <label>Question 2</label>
                        <input type="text" name="q2" value="<?php echo $questions[0]->q2 ?>">
                    </div>
                    <div>
                        <label>Question 3</label>
                        <input type="text" name="q3" value="<?php echo $questions[0]->q3 ?>">
                    </div>
                    <div>
                        <label>Question 4</label>
                        <input type="text" name="q4" value="<?php echo $questions[0]->q4 ?>">
                    </div>
                    <div>
                        <label>Question 5</label>
                        <input type="text" name="q5" value="<?php echo $questions[0]->q5 ?>">
                    </div>
                    <div>
                        <label>Question 6</label>
                        <input type="text" name="q6" value="<?php echo $questions[0]->q6 ?>">
                    </div>
                    <div>
                        <label>Question 7</label>
                        <input type="text" name="q7" value="<?php echo $questions[0]->q7 ?>">
                    </div>
                    <div>
                        <label>Question 8</label>
                        <input type="text" name="q8" value="<?php echo $questions[0]->q8 ?>">
                    </div>
                    <div>
                        <label>Question 9</label>
                        <input type="text" name="q9" value="<?php echo $questions[0]->q9 ?>">
                    </div>
                    <div>
                        <label>Question 10</label>
                        <input type="text" name="q10" value="<?php echo $questions[0]->q10 ?>">
                    </div>
                </div>
                <div class="mainFormBack">
                    <h2>Titre 2 <input type="text" name="t3" value="<?php echo $questions[0]->t3 ?>"></h2>
                    <div>
                        <label>Question 11</label>
                        <input type="text" name="q11" value="<?php echo $questions[0]->q11 ?>">
                    </div>
                    <div>
                        <label>Question 12</label>
                        <input type="text" name="q12" value="<?php echo $questions[0]->q12 ?>">
                    </div>
                    <div>
                        <label>Question 13</label>
                        <input type="text" name="q13" value="<?php echo $questions[0]->q13 ?>">
                    </div>
                    <div>
                        <label>Question 14</label>
                        <input type="text" name="q14" value="<?php echo $questions[0]->q14 ?>">
                    </div>
                    <div>
                        <label>Question 15</label>
                        <input type="text" name="q15" value="<?php echo $questions[0]->q15 ?>">
                    </div>
                    <div>
                        <label>Question 16</label>
                        <input type="text" name="q16" value="<?php echo $questions[0]->q16 ?>">
                    </div>
                    <div>
                        <label>Question 17</label>
                        <input type="text" name="q17" value="<?php echo $questions[0]->q17 ?>">
                    </div>
                    <div>
                        <label>Question 18</label>
                        <input type="text" name="q18" value="<?php echo $questions[0]->q18 ?>">
                    </div>
                    <div>
                        <label>Question 19</label>
                        <input type="text" name="q19" value="<?php echo $questions[0]->q19 ?>">
                    </div>
                    <div>
                        <label>Question 20</label>
                        <input type="text" name="q20" value="<?php echo $questions[0]->q20 ?>">
                    </div>
                </div>
                <div class="mainFormBack">
                    <h2>Titre 3 <input type="text" name="t4" value="<?php echo $questions[0]->t4 ?>"></h2>
                    <div>
                        <label>Question 21</label>
                        <input type="text" name="q21" value="<?php echo $questions[0]->q21 ?>">
                    </div>
                    <div>
                        <label>Question 22</label>
                        <input type="text" name="q22" value="<?php echo $questions[0]->q22 ?>">
                    </div>
                    <div>
                        <label>Question 23</label>
                        <input type="text" name="q23" value="<?php echo $questions[0]->q23 ?>">
                    </div>
                    <div>
                        <label>Question 24</label>
                        <input type="text" name="q24" value="<?php echo $questions[0]->q24 ?>">
                    </div>
                    <div>
                        <label>Question 25</label>
                        <input type="text" name="q25" value="<?php echo $questions[0]->q25 ?>">
                    </div>
                    <div>
                        <label>Question 26</label>
                        <input type="text" name="q26" value="<?php echo $questions[0]->q26 ?>">
                    </div>
                    <div>
                        <label>Question 27</label>
                        <input type="text" name="q27" value="<?php echo $questions[0]->q27 ?>">
                    </div>
                    <div>
                        <label>Question 28</label>
                        <input type="text" name="q28" value="<?php echo $questions[0]->q28 ?>">
                    </div>
                    <div>
                        <label>Question 29</label>
                        <input type="text" name="q29" value="<?php echo $questions[0]->q29 ?>">
                    </div>
                    <div>
                        <label>Question 30</label>
                        <input type="text" name="q30" value="<?php echo $questions[0]->q30 ?>">
                    </div>
                </div>
            </div>
            <?php submit_button('Sauvegarder le formulaire') ?>
        </form>
        <hr>
        <form id="refForm" method="post" action="">
            <div class="formback">
                <div class="mainFormBack">
                    <h2>Les priorités</h2>
                    <p>L'ordre de priorité des adresses email à enregistrer va de paire avec la gravité de la situation de l'utilisateur du formulaire.<br><br>En fonction du résultat obtenu lors du remplissage du formulaire par l'utilisateur fait varier les protocoles de traitement par ordre d'urgence.<br><br>Voici la liste des 3 protocoles et la coorespondance des champs Email Référents :</p>
                    <ul>
                        <li style="color: green">- Moins de 2 "oui" au formulaire -> Email Référent 5</li>
                        <li style="color: orange">- Entre 2 et 5 "oui" au formulaire -> Email Référent 3 et 4</li>
                        <li style="color: red">- Plus de 5 "oui" au formulaire -> Email Référent 1 et 2</li>
                    </ul>
                </div>
                <div class="mainFormBack">
                    <h2>Emails par ordre de priorité :</h2>
                    <div>
                        <label style="color: red;">Email Référent 1</label>
                        <input type="email" name="r1" value="<?php echo $referents[0]->r1; ?>">
                        <input type="hidden" name="p1" value="1">
                    </div>
                    <div>
                        <label style="color: red;">Email Référent 2</label>
                        <input type="email" name="r2" value="<?php echo $referents[0]->r2; ?>">
                        <input type="hidden" name="p2" value="2">
                    </div>
                    <div>
                        <label style="color: orange;">Email Référent 3</label>
                        <input type="email" name="r3" value="<?php echo $referents[0]->r3; ?>">
                        <input type="hidden" name="p3" value="3">
                    </div>
                    <div>
                        <label style="color: orange;">Email Référent 4</label>
                        <input type="email" name="r4" value="<?php echo $referents[0]->r4; ?>">
                        <input type="hidden" name="p4" value="4">
                    </div>
                    <div>
                        <label style="color: green;">Email Référent 5</label>
                        <input type="email" name="r5" value="<?php echo $referents[0]->r5; ?>">
                        <input type="hidden" name="p5" value="5">
                    </div>
                </div>
                <div class="mainFormBack">
                    <svg id="Calque_1" data-name="Calque 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 660 515" style="margin: auto;"><defs><style>.cls-1{fill:#3c3c3c;}.cls-2{fill:beige;}.cls-3{fill:wheat;}.cls-4{fill:#fff;}.cls-5{opacity:0.34;}.cls-6{fill:none;}.cls-7{fill:#ccc;}</style></defs><rect class="cls-1" y="-1.5" width="660.75" height="518.25"/><path class="cls-1" d="M-91.45,157.11v243h827v-243ZM252.25,307.82l8.33-4.91a74.47,74.47,0,0,0,102,26.29l4.91,8.33A84.14,84.14,0,0,1,252.25,307.82Zm138.57-54.28-2,.34-5.6,1a59.22,59.22,0,1,0-48.31,68.41l1,5.6.34,2,1.09,6.32a73.32,73.32,0,1,1,59.82-84.7Zm23.53,26.23-.06.33-5.79-1a85.48,85.48,0,1,0-98.41,70.21l-.86,5.14a91,91,0,0,1-74.49-104.41l.05-.33a91,91,0,0,1,104.47-74.82l.33.05A91,91,0,0,1,414.35,279.77Z"/><path class="cls-2" d="M339.58,175l-.33-.05-1,5.79a85.48,85.48,0,0,1,70.21,98.41l5.79,1,.06-.33A91,91,0,0,0,339.58,175Z"/><path class="cls-3" d="M309.23,354.48l.86-5.14a85.48,85.48,0,0,1-70.21-98.41l-5.14-.86A91,91,0,0,0,309.23,354.48Z"/><path class="cls-4" d="M234.79,249.74l-.05.33,5.14.86a85.48,85.48,0,0,1,98.41-70.21l1-5.79A91,91,0,0,0,234.79,249.74Z"/><path class="cls-4" d="M313.53,199l-1.09-6.32a73.32,73.32,0,0,0-59.82,84.7l6.32-1.09,2-.34,5.6-1a59.22,59.22,0,0,1,48.31-68.41l-1-5.6Z"/><path class="cls-3" d="M258.95,276.25l-6.32,1.09a73.32,73.32,0,0,0,84.7,59.82l-1.09-6.32-.34-2-1-5.6a59.22,59.22,0,0,1-68.41-48.31l-5.6,1Z"/><path class="cls-3" d="M312.44,192.64l1.09,6.32.34,2,1,5.6a59.22,59.22,0,0,1,68.41,48.31l5.6-1,2-.34,6.32-1.09A73.32,73.32,0,0,0,312.44,192.64Z"/><path class="cls-4" d="M260.58,302.91l-8.33,4.91a84.14,84.14,0,0,0,115.22,29.71l-4.91-8.33A74.47,74.47,0,0,1,260.58,302.91Z"/><g class="cls-5"><path class="cls-2" d="M595.62,245.83l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,595.62,245.83Z"/><path class="cls-3" d="M552,243.44l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,552,243.44Z"/><path class="cls-4" d="M575,222.81l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,575,222.81Z"/><path class="cls-6" d="M595.78,242.15a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M572.3,229.53h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M569.77,230l-.4-1.39-.14-.49-.46-1.58A18.75,18.75,0,0,0,556,249.79l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,569.77,230Z"/><path class="cls-3" d="M578.72,261h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M568.76,226.57l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,568.76,226.57Z"/><path class="cls-4" d="M558.71,256.06l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,558.71,256.06Z"/><path class="cls-2" d="M625.51,295.57l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51H605l-.08,1.5A21.86,21.86,0,0,1,625.51,295.57Z"/><path class="cls-3" d="M581.86,293.17l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,581.86,293.17Z"/><path class="cls-4" d="M604.89,272.55,605,271a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,604.89,272.55Z"/><path class="cls-6" d="M625.67,291.89a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M602.19,279.27h0A15.14,15.14,0,0,0,588.81,296l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M599.66,279.77l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,599.66,279.77Z"/><path class="cls-3" d="M608.61,310.75h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M598.66,276.31l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,598.66,276.31Z"/><path class="cls-4" d="M588.6,305.8l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,588.6,305.8Z"/><path class="cls-2" d="M655.35,345.33l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,655.35,345.33Z"/><path class="cls-3" d="M611.7,342.94l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,611.7,342.94Z"/><path class="cls-4" d="M634.73,322.31l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,634.73,322.31Z"/><path class="cls-6" d="M655.51,341.65a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M632,329h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,632,329Z"/><path class="cls-4" d="M629.5,329.54l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,629.5,329.54Z"/><path class="cls-3" d="M638.45,360.52h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M628.5,326.07l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,628.5,326.07Z"/><path class="cls-4" d="M618.44,355.56l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,618.44,355.56Z"/><path class="cls-3" d="M641.66,392.63l-1.33-.07A23.27,23.27,0,0,0,662.21,417l.07-1.33A21.86,21.86,0,0,1,641.66,392.63Z"/><path class="cls-4" d="M664.68,372l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,664.68,372Z"/><path class="cls-6" d="M685.46,391.35A21.86,21.86,0,0,0,661.32,372l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M662,378.73h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,662,378.73Z"/><path class="cls-4" d="M659.45,379.23l-.4-1.39-.14-.49-.46-1.58A18.75,18.75,0,0,0,645.65,399l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,659.45,379.23Z"/><path class="cls-3" d="M668.41,410.21h0l-.14-.49-.4-1.39A15.14,15.14,0,0,1,649.11,398l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M658.45,375.77l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,658.45,375.77Z"/><path class="cls-4" d="M648.39,405.26l-2,1.48A21.51,21.51,0,0,0,676.54,411l-1.48-2A19,19,0,0,1,648.39,405.26Z"/><path class="cls-2" d="M629.82,188.65l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,629.82,188.65Z"/><path class="cls-3" d="M586.17,186.25l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,586.17,186.25Z"/><path class="cls-4" d="M609.19,165.62l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,609.19,165.62Z"/><path class="cls-6" d="M630,185a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,630,185l1.32-.15h0Z"/><path class="cls-6" d="M606.49,172.35h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M604,172.85l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,604,172.85Z"/><path class="cls-3" d="M612.92,203.83h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M603,169.38l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,603,169.38Z"/><path class="cls-4" d="M592.9,198.87l-2,1.48A21.51,21.51,0,0,0,621,204.65l-1.48-2A19,19,0,0,1,592.9,198.87Z"/><path class="cls-2" d="M659.71,238.38l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,659.71,238.38Z"/><path class="cls-3" d="M616.06,236l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,616.06,236Z"/><path class="cls-4" d="M639.08,215.36l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,639.08,215.36Z"/><path class="cls-6" d="M659.87,234.7a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M636.38,222.08h0A15.14,15.14,0,0,0,623,238.81l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M633.85,222.58l-.4-1.39-.14-.49-.46-1.58A18.75,18.75,0,0,0,620,242.34l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,633.85,222.58Z"/><path class="cls-3" d="M642.81,253.56h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M632.85,219.12l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,632.85,219.12Z"/><path class="cls-4" d="M622.79,248.61l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,622.79,248.61Z"/><path class="cls-3" d="M645.9,285.75l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,645.9,285.75Z"/><path class="cls-4" d="M668.92,265.12l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,668.92,265.12Z"/><path class="cls-6" d="M689.71,284.47a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M666.22,271.85h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M663.69,272.35l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,663.69,272.35Z"/><path class="cls-3" d="M672.65,303.33h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-4" d="M652.63,298.37l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,652.63,298.37Z"/><path class="cls-2" d="M665.49,125.64l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,665.49,125.64Z"/><path class="cls-3" d="M621.84,123.25l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,621.84,123.25Z"/><path class="cls-4" d="M644.86,102.62l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,644.86,102.62Z"/><path class="cls-6" d="M665.64,122a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,665.64,122l1.32-.15h0Z"/><path class="cls-6" d="M642.16,109.34h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M639.63,109.84l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,639.63,109.84Z"/><path class="cls-3" d="M648.59,140.82h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,649,142.4Z"/><path class="cls-3" d="M638.63,106.38l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,638.63,106.38Z"/><path class="cls-4" d="M628.57,135.87l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,628.57,135.87Z"/><path class="cls-3" d="M651.73,173l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,651.73,173Z"/><path class="cls-4" d="M674.75,152.35l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,674.75,152.35Z"/><path class="cls-6" d="M695.53,171.7a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M672,159.08h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,672,159.08Z"/><path class="cls-4" d="M669.52,159.58l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,669.52,159.58Z"/><path class="cls-3" d="M678.48,190.56h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-4" d="M658.46,185.6l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,658.46,185.6Z"/><path class="cls-3" d="M653.81,63.32l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,653.81,63.32Z"/><path class="cls-4" d="M676.83,42.69l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,676.83,42.69Z"/><path class="cls-6" d="M697.61,62a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,697.61,62l1.32-.15h0Z"/><path class="cls-6" d="M674.13,49.41h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M671.6,49.92l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,671.6,49.92Z"/><path class="cls-3" d="M680.56,80.9h0l-.14-.49L680,79a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,681,82.47Z"/><path class="cls-4" d="M660.54,75.94l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,660.54,75.94Z"/></g><g class="cls-5"><path class="cls-2" d="M24.44,489.06l1.5.08v-.08A23.27,23.27,0,0,0,4,464.54H3.89L3.81,466A21.86,21.86,0,0,1,24.44,489.06Z"/><path class="cls-3" d="M-19.21,486.66l-1.33-.07A23.27,23.27,0,0,0,1.34,511l.07-1.33A21.86,21.86,0,0,1-19.21,486.66Z"/><path class="cls-4" d="M3.81,466l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,3.81,466Z"/><path class="cls-6" d="M24.59,485.38A21.86,21.86,0,0,0,.45,466.07L.3,464.75h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M1.11,472.76h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,1.11,472.76Z"/><path class="cls-3" d="M7.54,504.24h0l-.14-.49L7,502.35A15.14,15.14,0,0,1-11.76,492l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,8,505.82Z"/><path class="cls-3" d="M-2.42,469.8l.46,1.58.14.49.4,1.39h0A15.14,15.14,0,0,1,17.33,483.6l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0-2.42,469.8Z"/><path class="cls-4" d="M-12.48,499.29l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1-12.48,499.29Z"/><path class="cls-2" d="M26.45,379.43l1.5.08v-.08A23.27,23.27,0,0,0,6,354.92H5.91l-.08,1.5A21.86,21.86,0,0,1,26.45,379.43Z"/><path class="cls-3" d="M-17.2,377l-1.33-.07A23.27,23.27,0,0,0,3.36,401.39l.07-1.33A21.86,21.86,0,0,1-17.2,377Z"/><path class="cls-4" d="M5.83,356.41l.08-1.5a23.27,23.27,0,0,0-24.43,22V377l1.33.07A21.86,21.86,0,0,1,5.83,356.41Z"/><path class="cls-6" d="M26.61,375.76a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M3.13,363.14h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,3.13,363.14Z"/><path class="cls-4" d="M.6,363.64l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,.6,363.64Z"/><path class="cls-3" d="M9.55,394.62h0l-.14-.49L9,392.73A15.14,15.14,0,0,1-9.74,382.39l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,10,396.19Z"/><path class="cls-3" d="M-.4,360.17l.46,1.58.14.49.4,1.39h0A15.14,15.14,0,0,1,19.35,374l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0-.4,360.17Z"/><path class="cls-4" d="M-10.46,389.66l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1-10.46,389.66Z"/><path class="cls-2" d="M56.41,429.13l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,56.41,429.13Z"/><path class="cls-3" d="M12.76,426.74l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,12.76,426.74Z"/><path class="cls-4" d="M35.78,406.11l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,35.78,406.11Z"/><path class="cls-6" d="M56.56,425.45a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M33.08,412.83h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M30.55,413.33l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,30.55,413.33Z"/><path class="cls-3" d="M39.51,444.31h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,40,445.89Z"/><path class="cls-3" d="M29.55,409.87l.46,1.58.14.49.4,1.39h0A15.14,15.14,0,0,1,49.3,423.67l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,29.55,409.87Z"/><path class="cls-4" d="M19.49,439.36l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,19.49,439.36Z"/><path class="cls-2" d="M1.2,223.75l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,1.2,223.75Z"/><path class="cls-6" d="M1.35,220.07a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,0,0-19.3,24.14,21.86,21.86,0,0,0,24.14,19.3,21.86,21.86,0,0,0,19.3-24.14l1.32-.15h0Z"/><path class="cls-2" d="M31.09,273.48l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,31.09,273.48Z"/><path class="cls-3" d="M-12.56,271.09l-1.33-.07A23.27,23.27,0,0,0,8,295.44l.07-1.33A21.86,21.86,0,0,1-12.56,271.09Z"/><path class="cls-4" d="M10.46,250.46l.08-1.5a23.27,23.27,0,0,0-24.43,22V271l1.33.07A21.86,21.86,0,0,1,10.46,250.46Z"/><path class="cls-6" d="M31.24,269.8A21.86,21.86,0,0,0,7.1,250.5L7,249.17H7l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M7.76,257.18h0A15.14,15.14,0,0,0-5.61,273.91l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,7.76,257.18Z"/><path class="cls-4" d="M5.23,257.68l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22L-7,277l.49-.14,1.39-.4A15.14,15.14,0,0,1,5.23,257.68Z"/><path class="cls-3" d="M14.19,288.66h0l-.14-.49-.4-1.39A15.14,15.14,0,0,1-5.11,276.43l-1.39.4h0L-7,277l-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M4.23,254.22l.46,1.58.14.49.4,1.39h0A15.14,15.14,0,0,1,24,268l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,4.23,254.22Z"/><path class="cls-4" d="M-5.83,283.71l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1-5.83,283.71Z"/><path class="cls-2" d="M60.93,323.24l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,60.93,323.24Z"/><path class="cls-3" d="M17.28,320.85l-1.33-.07A23.27,23.27,0,0,0,37.83,345.2l.07-1.33A21.86,21.86,0,0,1,17.28,320.85Z"/><path class="cls-4" d="M40.3,300.22l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,40.3,300.22Z"/><path class="cls-6" d="M61.08,319.57a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M37.6,306.95h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16A15.14,15.14,0,1,0,37.6,306.95Z"/><path class="cls-4" d="M35.07,307.45l-.4-1.39-.14-.49L34.07,304a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,35.07,307.45Z"/><path class="cls-3" d="M44,338.43h0l-.14-.49-.4-1.39A15.14,15.14,0,0,1,24.73,326.2l-1.39.4h0l-.49.14-1.58.46A18.75,18.75,0,0,0,44.48,340Z"/><path class="cls-3" d="M34.07,304l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,34.07,304Z"/><path class="cls-4" d="M24,333.47,22,335a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,24,333.47Z"/><path class="cls-2" d="M90.88,372.94l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,90.88,372.94Z"/><path class="cls-3" d="M47.24,370.55l-1.33-.07A23.27,23.27,0,0,0,67.79,394.9l.07-1.33A21.86,21.86,0,0,1,47.24,370.55Z"/><path class="cls-4" d="M70.26,349.92l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,70.26,349.92Z"/><path class="cls-6" d="M91,369.26A21.86,21.86,0,0,0,66.9,350l-.15-1.32h0L66.9,350A21.86,21.86,0,1,0,91,369.26l1.32-.15h0Z"/><path class="cls-6" d="M67.56,356.64h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M65,357.14l-.4-1.39-.14-.49L64,353.68a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,65,357.14Z"/><path class="cls-3" d="M74,388.12h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M64,353.68l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,64,353.68Z"/><path class="cls-4" d="M54,383.17l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,54,383.17Z"/><path class="cls-2" d="M27.16,165.39l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51H6.62l-.08,1.5A21.86,21.86,0,0,1,27.16,165.39Z"/><path class="cls-3" d="M-16.49,163l-1.33-.07A23.27,23.27,0,0,0,4.07,187.35L4.14,186A21.86,21.86,0,0,1-16.49,163Z"/><path class="cls-4" d="M6.53,142.37l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,6.53,142.37Z"/><path class="cls-6" d="M27.32,161.71a21.86,21.86,0,0,0-24.14-19.3L3,141.09H3l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M3.83,149.09h0A15.14,15.14,0,0,0-9.54,165.82L-11,166h0l1.44-.16A15.14,15.14,0,1,0,3.83,149.09Z"/><path class="cls-4" d="M1.31,149.6.9,148.2l-.14-.49L.3,146.13a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,1.31,149.6Z"/><path class="cls-3" d="M10.26,180.58h0l-.14-.49-.4-1.39A15.14,15.14,0,0,1-9,168.35l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M.3,146.13l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,.3,146.13Z"/><path class="cls-4" d="M-9.76,175.62l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1-9.76,175.62Z"/><path class="cls-2" d="M57.05,215.13l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,57.05,215.13Z"/><path class="cls-3" d="M13.4,212.73l-1.33-.07A23.27,23.27,0,0,0,34,237.09l.07-1.33A21.86,21.86,0,0,1,13.4,212.73Z"/><path class="cls-4" d="M36.42,192.11l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,36.42,192.11Z"/><path class="cls-6" d="M57.21,211.45a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32a21.86,21.86,0,1,0,24.14,19.3l1.32-.15h0Z"/><path class="cls-6" d="M33.72,198.83h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M31.2,199.33l-.4-1.39-.14-.49-.46-1.58a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,31.2,199.33Z"/><path class="cls-3" d="M40.15,230.31h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M30.19,195.87l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,30.19,195.87Z"/><path class="cls-4" d="M20.13,225.36l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,20.13,225.36Z"/><path class="cls-2" d="M86.89,264.89l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51h-.08l-.08,1.5A21.86,21.86,0,0,1,86.89,264.89Z"/><path class="cls-3" d="M43.24,262.5l-1.33-.07A23.27,23.27,0,0,0,63.8,286.85l.07-1.33A21.86,21.86,0,0,1,43.24,262.5Z"/><path class="cls-4" d="M66.26,241.87l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,66.26,241.87Z"/><path class="cls-6" d="M87,261.21a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,87,261.21l1.32-.15h0Z"/><path class="cls-6" d="M63.56,248.59h0a15.14,15.14,0,0,0-13.37,16.72l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M61,249.1l-.4-1.39-.14-.49L60,245.63a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,61,249.1Z"/><path class="cls-3" d="M70,280.08h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M60,245.63l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,60,245.63Z"/><path class="cls-4" d="M50,275.12l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,50,275.12Z"/><path class="cls-2" d="M116.85,314.59l1.5.08v-.08a23.27,23.27,0,0,0-22-24.51H96.3l-.08,1.5A21.86,21.86,0,0,1,116.85,314.59Z"/><path class="cls-3" d="M73.2,312.19l-1.33-.07a23.27,23.27,0,0,0,21.88,24.43l.07-1.33A21.86,21.86,0,0,1,73.2,312.19Z"/><path class="cls-4" d="M96.22,291.57l.08-1.5a23.27,23.27,0,0,0-24.43,22v.08l1.33.07A21.86,21.86,0,0,1,96.22,291.57Z"/><path class="cls-6" d="M117,310.91a21.86,21.86,0,0,0-24.14-19.3l-.15-1.32h0l.15,1.32A21.86,21.86,0,1,0,117,310.91l1.32-.15h0Z"/><path class="cls-6" d="M93.52,298.29h0A15.14,15.14,0,0,0,80.15,315l-1.44.16h0l1.44-.16a15.14,15.14,0,1,0,13.37-16.72Z"/><path class="cls-4" d="M91,298.79l-.4-1.39-.14-.49L90,295.33a18.75,18.75,0,0,0-12.8,23.22l1.58-.46.49-.14,1.39-.4A15.14,15.14,0,0,1,91,298.79Z"/><path class="cls-3" d="M99.95,329.77h0l-.14-.49-.4-1.39a15.14,15.14,0,0,1-18.75-10.34l-1.39.4h0l-.49.14-1.58.46a18.75,18.75,0,0,0,23.22,12.8Z"/><path class="cls-3" d="M90,295.33l.46,1.58.14.49.4,1.39h0a15.14,15.14,0,0,1,18.75,10.34l1.39-.4.49-.14h0l1.58-.46A18.75,18.75,0,0,0,90,295.33Z"/><path class="cls-4" d="M79.93,324.82l-2,1.48a21.51,21.51,0,0,0,30.12,4.29l-1.48-2A19,19,0,0,1,79.93,324.82Z"/></g><path class="cls-7" d="M350.24,317.7l-6.16-24.26h3.31l2.88,12.27c.72,3,1.37,6,1.8,8.39h.07c.4-2.41,1.15-5.29,2-8.42l3.24-12.24h3.28l3,12.31c.68,2.88,1.33,5.76,1.69,8.32h.07c.5-2.66,1.19-5.36,1.94-8.39l3.2-12.24h3.2l-6.87,24.26h-3.28l-3.06-12.63a72.68,72.68,0,0,1-1.58-7.92h-.07a75.59,75.59,0,0,1-1.87,7.92l-3.46,12.63Z"/><path class="cls-7" d="M376.74,293.73a36.29,36.29,0,0,1,6-.47c3.1,0,5.36.72,6.8,2a6.53,6.53,0,0,1,2.12,5.08,7.14,7.14,0,0,1-1.87,5.18c-1.66,1.76-4.36,2.66-7.42,2.66a10.8,10.8,0,0,1-2.52-.22v9.72h-3.13Zm3.13,11.7a10.52,10.52,0,0,0,2.59.25c3.78,0,6.08-1.84,6.08-5.18s-2.27-4.75-5.72-4.75a13.11,13.11,0,0,0-3,.25Z"/><path class="cls-7" d="M403.09,313.88a11.1,11.1,0,0,0,5.62,1.58c3.2,0,5.08-1.69,5.08-4.14,0-2.27-1.3-3.56-4.57-4.82-4-1.4-6.41-3.46-6.41-6.87,0-3.78,3.13-6.59,7.85-6.59a11,11,0,0,1,5.36,1.19l-.86,2.56a9.67,9.67,0,0,0-4.61-1.15c-3.31,0-4.57,2-4.57,3.64,0,2.27,1.48,3.38,4.82,4.68,4.1,1.58,6.19,3.56,6.19,7.13,0,3.74-2.77,7-8.49,7a12.53,12.53,0,0,1-6.19-1.55Z"/><path class="cls-7" d="M437.14,308.84c0,6.44-4.46,9.25-8.67,9.25-4.72,0-8.35-3.46-8.35-9,0-5.83,3.82-9.25,8.64-9.25C433.76,299.88,437.14,303.52,437.14,308.84Zm-13.82.18c0,3.82,2.2,6.69,5.29,6.69s5.29-2.84,5.29-6.77c0-3-1.48-6.7-5.22-6.7S423.32,305.71,423.32,309Z"/><path class="cls-7" d="M441.14,292.14h3.17V317.7h-3.17Z"/><path class="cls-7" d="M464.21,312.95c0,1.8,0,3.38.14,4.75h-2.81l-.18-2.84h-.07a6.56,6.56,0,0,1-5.76,3.24c-2.74,0-6-1.51-6-7.63V300.28h3.17v9.65c0,3.31,1,5.54,3.89,5.54a4.58,4.58,0,0,0,4.18-2.88A4.64,4.64,0,0,0,461,311V300.28h3.17Z"/><path class="cls-7" d="M473.29,295.27v5h4.54v2.41h-4.54v9.4c0,2.16.61,3.38,2.38,3.38a7,7,0,0,0,1.84-.22l.14,2.38a7.76,7.76,0,0,1-2.81.43,4.39,4.39,0,0,1-3.42-1.33c-.9-.94-1.22-2.48-1.22-4.54v-9.5h-2.7v-2.41h2.7V296.1Z"/><path class="cls-7" d="M484.92,295.38a2,2,0,0,1-3.92,0,1.93,1.93,0,0,1,2-2A1.88,1.88,0,0,1,484.92,295.38Zm-3.53,22.32V300.28h3.17V317.7Z"/><path class="cls-7" d="M505.58,308.84c0,6.44-4.46,9.25-8.67,9.25-4.71,0-8.35-3.46-8.35-9,0-5.83,3.82-9.25,8.64-9.25C502.19,299.88,505.58,303.52,505.58,308.84Zm-13.82.18c0,3.82,2.2,6.69,5.29,6.69s5.29-2.84,5.29-6.77c0-3-1.48-6.7-5.22-6.7S491.75,305.71,491.75,309Z"/><path class="cls-7" d="M509.58,305c0-1.8,0-3.28-.14-4.71h2.81l.18,2.88h.07a6.4,6.4,0,0,1,5.76-3.28c2.41,0,6.16,1.44,6.16,7.42v10.4h-3.17v-10c0-2.81-1-5.15-4-5.15a4.5,4.5,0,0,0-4.25,3.24,4.55,4.55,0,0,0-.22,1.48V317.7h-3.17Z"/><path class="cls-7" d="M529.12,314.46a8.3,8.3,0,0,0,4.18,1.26c2.3,0,3.38-1.15,3.38-2.59s-.9-2.34-3.24-3.2c-3.13-1.12-4.61-2.84-4.61-4.93,0-2.81,2.27-5.11,6-5.11a8.69,8.69,0,0,1,4.28,1.08l-.79,2.3a6.78,6.78,0,0,0-3.56-1c-1.87,0-2.92,1.08-2.92,2.38s1,2.09,3.31,3c3,1.15,4.57,2.66,4.57,5.26,0,3.06-2.38,5.22-6.52,5.22a9.94,9.94,0,0,1-4.9-1.19Z"/></svg>
                </div>
            </div>
            <?php submit_button('Enregistrer les référents') ?>
        </form>
        <hr>
        <script>

        	document.querySelector('#toplevel_page_AutoDiag').children[1].children[1].children[0].innerHTML = 'Général';

            var quests = document.querySelectorAll('.mainFormBack > div input');

            for (var q = 0; q < quests.length; q++) {

                quests[q].addEventListener('keyup', regex);
            }

            function regex(question) {

                var str = question.currentTarget.value;
                var patt = str.replace(/[~"#?\{\}\[\]/|\\]/g, "");
                question.currentTarget.value = patt;
            }

        </script>
        <?php
    }

    public function export()
    {
        ?>
        <style>

            .autoDiagHeader {
                margin: 50px 0 50px 30px;
            }

            #expContent {
                margin-bottom: 50px;
            }

            .dropDown {
                display: none;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-color: white;
                text-align: center;
            }

            .userslist {
                width: 40%;
            }

            .btns {

            }

            .userslist > div {
                height: 600px;
                overflow-y: scroll;
                background-color: rgba(0, 0, 0, 0.05);
                border-radius: 10px;
                padding: 0px 10px;
                box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            }

            .paraDrop {
                color: white;
                background-color: #3c3c3c;
                border-radius: 5px;
                padding: 1%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-left: 40px;
                cursor: pointer;
            }

            .spanners {
                cursor: pointer;
                text-decoration: underline;
                color: #0073aa;
            }

            .paraDrop span {
                margin-right: 30px;
            }

            .questionsYes {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 100%;
                text-align: center;
            }

            .odd-bg {
            	width: 80%;
                padding: 30px 5%;
            	box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1);
            	font-weight: bold;
            	border: 1px solid rgba(0, 0, 0, 0.1);
            	border-radius: 5px;
            	cursor: default;
            }

            .odd-bg:nth-child(odd) {
            	background-color: silver;
            	color: white;
            }

            .odd-bg:nth-child(even) {
            	background-color: white;
            	color: inherit;
            }

            #expContent {
            	display: flex;
            	flex-direction: row;
            	justify-content: space-around;
            	align-items: center;
            	width: 100%;
            }

            @media (max-width: 790px) {

                .formback {
                    flex-direction: column!important;
                }

                .mainFormBack {
                    width: 90%!important;
                }

                #mainPres, #expContent {
                    flex-direction: column!important;
                }

                .presSides, .userslist {
                    width: 90%!important;
                    margin: auto!important;
                }

                .presSides > div {
                    width: 100%!important;
                }

                .headerForm {
                    flex-direction: column!important;
                }

                .autoDiagHeader h1 {
                    line-height: 1em!important;
                }
            }

        </style>
    
        <div class="autoDiagHeader">
            <h1>Page d'export des rapports</h1>
            <p>Bienvenue sur la page d'export des données.</p>
        </div>
        <hr>
        <div id="expContent">

        <?php

        global $wpdb;

        $users = $wpdb->get_results("SELECT `{$wpdb->prefix}autodiag_users`.`id`, `{$wpdb->prefix}autodiag_users`.`nom`, `{$wpdb->prefix}autodiag_users`.`societe`, `{$wpdb->prefix}autodiag_users`.`email`, `{$wpdb->prefix}autodiag_users`.`tel`, `{$wpdb->prefix}autodiag_users`.`siret`, `{$wpdb->prefix}autodiag_users`.`rappel`, `{$wpdb->prefix}autodiag_users`.`score`, `{$wpdb->prefix}autodiag_users`.`form_id`, `{$wpdb->prefix}autodiag_users`.`questions`, `{$wpdb->prefix}autodiag_users`.`date`, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17, q18, q19, q20, q21, q22, q23, q24, q25, q26, q27, q28, q29, q30 FROM `{$wpdb->prefix}autodiag_users` INNER JOIN `{$wpdb->prefix}autodiag` ON `{$wpdb->prefix}autodiag_users`.`form_id` = `{$wpdb->prefix}autodiag`.`id`ORDER BY `{$wpdb->prefix}autodiag_users`.`id` DESC");

        $presetBank = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag_settings ORDER BY id DESC LIMIT 0, 1;");

        ?>

        <div class="userslist">
            <h2>Liste des derniers formulaires remplis</h2>
            <p style="font-style: italic; margin: 0 0 10px 0;">CLiquez sur les bandeaux pour voir les détails.</p>
            <div>
                
                <?php

                foreach ($users as $user) { 

                    $date = date_create($user->date);
                    $dateF = date_format($date, "d/m/Y");
                    

                    if ($user->score < 2) { ?>
                        
                        <p class="paraDrop" onclick="showDrop(this);"><?php echo $user->nom ?> | <?php echo $user->email ?> | le <?php echo $dateF; ?><span style="color: green; font-size: 1.6em; cursor: pointer;"><?php echo $user->score ?> oui</span></p>

            <?php } else if ($user->score >= 2 && $user->score <= 5) { ?>

                        <p class="paraDrop" onclick="showDrop(this);"><?php echo $user->nom ?> | <?php echo $user->email ?> | le <?php echo $dateF; ?><span style="color: orange; font-size: 1.6em; cursor: pointer;"><?php echo $user->score ?> oui</span></p>

            <?php } else if ($user->score > 5) { ?>

                        <p class="paraDrop" onclick="showDrop(this);"><?php echo $user->nom ?> | <?php echo $user->email ?> | le <?php echo $dateF; ?><span style="color: red; font-size: 1.6em; cursor: pointer;"><?php echo $user->score ?> oui</span></p>

            <?php } ?>
                    <div class="dropDown">
                        <h2>Formulaire n°<?php echo $user->form_id ?></h2>
                        <p><i>Validé le <?php echo $dateF; ?></i></p>
                        <ul>
                            <li><b>Nom :</b> <?php echo $user->nom ?></li>
                            <li><b>Société :</b> <?php echo $user->societe ?></li>
                            <li><b>Email :</b> <a href="mailto:<?php echo $user->email ?>" target="_blank"><?php echo $user->email ?></a></li>
                            <li><b>Tel :</b> <a href="tel:<?php echo $user->tel ?>" target="_blank"><?php echo $user->tel ?></a></li>
                            <li><b>SIRET :</b> <?php echo $user->siret ?></li>
                        </ul>
                        
                        <?php
                        if ($user->rappel == 'ok') {
                            
                            echo '<h3 style="color: green"><b><i>J\'accepte d\'être rappelé par la CMA</i></b></h3>';
                        } else {

                            echo '<h3 style="color: red"><b><i>Je n\'accepte pas d\'être rappelé par la CMA</i></b></h3>';
                        }
                        
                        if (isset($user->questions) && !empty($user->questions)) {

                        $exp = explode(',', $user->questions); ?>

                        <h3>Liste des questions dont la réponse est "OUI"</h3>

                            <div class="questionsYes">
                                
                       <?php    for ($q = 0; $q < count($exp); $q++) {

                                    $ex = $exp[$q]; ?>

                                   <p class="odd-bg" style="font-style: italic;"><?php echo $user->$ex; ?> ?</p>

                            <?php } ?>

                            </div>
                            
                <?php   } else { ?>

                        <div class="questionsYes">
                            <h3>Pas de question dont le réslutat est OUI pour ce contact.</h3>
                        </div>

                <?php } ?>
                        <p class="spanners" onclick="hideDrop(this);">FERMER</p>
                    </div>
            <?php   } ?>
            </div>
        </div>
        <div class="userslist btns">
            <h2>Options d'export manuel</h2>
            <br>
            <hr>
	        <form id="expForm" name="expForm" method="POST" action="">
	        	<p><i>Pour pouvoir exporter le rapport général contenant tous les utilisateurs ainsi que les formulaires et les résultats correspondants, veullez cliquer sur le bouton ci-dessous.</i></p>
	        	<input type="hidden" name="convert" value="csv">
	        	<?php submit_button('Exporter en CSV') ?>
	        </form>
            <hr>
	        <form id="expForm" name="expForm" method="POST" action="">
	        	<p><i>Vous pouvez également envoyer un rapport contenant les nouvelles données saisies depuis le dernier rapport ayant été émis automatiquement. Saisissez l'email du destinataire dans le champs ci-dessous.</i></p>
	        	<label for="singleMail">Adresse Email </label>
	        	<input id="singleMail" type="email" name="singleMail" value="" required>
	        	<input type="hidden" name="convert" value="csv_send">
	        	<?php submit_button('Envoyer en CSV') ?>
	        </form>
            <hr>
            <form id="expForm2" name="expForm2" method="POST" action="">
                <p><i>Export du formulaire actif au format PDF.</i></p>
                <input type="hidden" name="convert" value="pdf">
                <?php submit_button('Exporter en PDF') ?>
            </form>
            <hr>
            <hr>
            <form id="expForm3" name="expForm3" method="POST" action="">
                <p><i>Choix des intervalles d'exports automatiques en nombre d'incrit.</i></p>
                <label for="preset">Nombre de contacts par export </label>
                <input type="number" name="preset" value="<?php echo $presetBank[0]->preset ?>" min="10" max="50">
                <?php submit_button('Valider') ?>
            </form>
            <hr>
            <section>
                <p><i>Des mises à jours seront bientôt disponible sur <a href="http://www.dee-web.fr" target="_blank">le site du plugin AutoDiag</a>.</i></p>
            </section>
	    </div>
    </div>
    <hr>
        <script>

        	document.querySelector('#toplevel_page_AutoDiag').children[1].children[1].children[0].innerHTML = 'Général';
                    
            function showDrop(x) {

                x.nextElementSibling.style.display = 'flex';
            }

            function hideDrop(y) {

                y.parentElement.style.display = 'none';
            }

        </script> <?php
	}

	public function convertCsv()
	{
		if (isset($_POST['convert']) && !empty($_POST['convert'])) {

            global $wpdb;

            if ($_POST['convert'] == "csv") {

                $usersForms = $wpdb->get_results("SELECT `{$wpdb->prefix}autodiag_users`.`id`, `{$wpdb->prefix}autodiag_users`.`nom`, `{$wpdb->prefix}autodiag_users`.`societe`, `{$wpdb->prefix}autodiag_users`.`email`, `{$wpdb->prefix}autodiag_users`.`tel`, `{$wpdb->prefix}autodiag_users`.`siret`, `{$wpdb->prefix}autodiag_users`.`rappel`, `{$wpdb->prefix}autodiag_users`.`score`, `{$wpdb->prefix}autodiag_users`.`form_id`, `{$wpdb->prefix}autodiag_users`.`questions`, `{$wpdb->prefix}autodiag_users`.`date`, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17, q18, q19, q20, q21, q22, q23, q24, q25, q26, q27, q28, q29, q30 FROM `{$wpdb->prefix}autodiag_users` INNER JOIN `{$wpdb->prefix}autodiag` ON `{$wpdb->prefix}autodiag_users`.`form_id` = `{$wpdb->prefix}autodiag`.`id` ORDER BY `{$wpdb->prefix}autodiag_users`.`id` DESC");

                include('FichierExcel.php');

                $uforms = $usersForms[0];

                $date = date('d-m-Y') . ' à ' . date('H') . 'h' . date('i');
                $date2 = date('d/m/Y');

                $fichier = new FichierExcel();

                $finalKey = '';
                $cnt = 0;
                foreach ($uforms as $key => $forms) {
                    
                    if (!empty($forms)) {

                        $part = ';' . $key;
                        $finalKey .= $part;
                        $cnt++;
                    }
                }

                $keyString = substr($finalKey, 1);

                $fichier->Colonne($keyString);

                for ($i=0; $i < count($usersForms); $i++) {
                    
                    if (!empty($usersForms[$i])) {

                        $finalValue = '';

                        foreach ($usersForms[$i] as $key => $value) {
                            
                            $impVal = ';' . utf8_decode($value);
                            $finalValue .= $impVal;
                        }

                        $valueString = substr($finalValue, 1);
                        $fichier->Insertion($valueString);
                    }
                }

            } else if ($_POST['convert'] == "csv_send") {


                $usersForms = $wpdb->get_results("SELECT `{$wpdb->prefix}autodiag_users`.`id`, `{$wpdb->prefix}autodiag_users`.`loaded`, `{$wpdb->prefix}autodiag_users`.`nom`, `{$wpdb->prefix}autodiag_users`.`societe`, `{$wpdb->prefix}autodiag_users`.`email`, `{$wpdb->prefix}autodiag_users`.`tel`, `{$wpdb->prefix}autodiag_users`.`siret`, `{$wpdb->prefix}autodiag_users`.`rappel`, `{$wpdb->prefix}autodiag_users`.`score`, `{$wpdb->prefix}autodiag_users`.`form_id`, `{$wpdb->prefix}autodiag_users`.`questions`, `{$wpdb->prefix}autodiag_users`.`date`, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17, q18, q19, q20, q21, q22, q23, q24, q25, q26, q27, q28, q29, q30 FROM `{$wpdb->prefix}autodiag_users` INNER JOIN `{$wpdb->prefix}autodiag` ON `{$wpdb->prefix}autodiag_users`.`form_id` = `{$wpdb->prefix}autodiag`.`id` WHERE `{$wpdb->prefix}autodiag_users`.`loaded` = 0 ORDER BY `{$wpdb->prefix}autodiag_users`.`id` DESC");

                include('FichierExcel.php');

                $uforms = $usersForms[0];

                $date = date('d-m-Y') . ' à ' . date('H') . 'h' . date('i');
                $date2 = date('d/m/Y');

                $fichier = new FichierExcel();

                $finalKey = '';
                $cnt = 0;
                foreach ($uforms as $key => $forms) {
                    
                    if (!empty($forms)) {

                        $part = ';' . $key;
                        $finalKey .= $part;
                        $cnt++;
                    }
                }

                $keyString = substr($finalKey, 1);

                $fichier->Colonne($keyString);

                for ($i=0; $i < count($usersForms); $i++) {
                    
                    if (!empty($usersForms[$i])) {

                        $finalValue = '';

                        foreach ($usersForms[$i] as $key => $value) {
                            
                            $impVal = ';' . utf8_decode($value);
                            $finalValue .= $impVal;
                        }

                        $valueString = substr($finalValue, 1);
                        $fichier->Insertion($valueString);
                    }
                }

            }

			if (isset($_POST['convert']) && $_POST['convert'] == 'csv') {

				$fichier->exportToCsv('Rapport AutoDiag Complet au ' . $date, $usersForms);

			} else if (isset($_POST['convert']) && $_POST['convert'] == 'csv_send') {

				$email = $_POST['singleMail'];

				$content = 'Export manuel du rapport Autodiag depuis la dernière émission jusqu\'au ' . $date2;

				$fichier->sendCsvByMail('Rapport AutoDiag au ' . $date, $email, $content, $usersForms);

			} else if (isset($_POST['convert']) && $_POST['convert'] == 'pdf') {
                
                global $wpdb;

                $activeForm = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag ORDER BY id DESC LIMIT 0, 1;");

                $active = $activeForm[0];

                require('pdf.php');

                $pdf = new PDF();

                $pdf->AddPage();
                $pdf->SetFont('Arial','B',16);
                $pdf->SetFontSize(20);
                $titleForm = '<p>Formulaire AutoDiag n°' . $activeForm[0]->id . '</p><br><br><br>';
                $pdf->WriteHTML(utf8_decode($titleForm));
                $pdf->SetFontSize(14);

                $pdf->WriteHTML(utf8_decode('<p><u>' . $active->t2 . ' :</u></p><br><br>'));
                $pdf->SetFontSize(12);

                foreach ($active as $key => $value) { 

                    if (!empty($value) && $value != 'vide' && ($key == 'q1' || $key == 'q2' || $key == 'q3' || $key == 'q4' || $key == 'q5' || $key == 'q6' || $key == 'q7' || $key == 'q8' || $key == 'q9' || $key == 'q10')) {
                            
                           $cont = '<p>' . $value . ' ?</p><br><br>';
                           $pdf->WriteHTML(utf8_decode($cont));
                    }
                }

                $pdf->SetFontSize(14);
                $pdf->WriteHTML(utf8_decode('<p><u>' . $active->t3 . ' :</u></p><br><br>'));
                $pdf->SetFontSize(12);

                foreach ($active as $key => $value) { 

                    if (!empty($value) && $value != 'vide' && ($key == 'q11' || $key == 'q12' || $key == 'q13' || $key == 'q14' || $key == 'q15' || $key == 'q16' || $key == 'q17' || $key == 'q18' || $key == 'q19' || $key == 'q20')) {
                            
                           $cont = '<p>' . $value . ' ?</p><br><br>';
                           $pdf->WriteHTML(utf8_decode($cont));
                    }
                }

                $pdf->SetFontSize(14);
                $pdf->WriteHTML(utf8_decode('<p><u>' . $active->t4 . ' :</u></p><br><br>'));
                $pdf->SetFontSize(12);

                foreach ($active as $key => $value) { 

                    if (!empty($value) && $value != 'vide' && ($key == 'q21' || $key == 'q22' || $key == 'q23' || $key == 'q24' || $key == 'q25' || $key == 'q26' || $key == 'q27' || $key == 'q28' || $key == 'q29' || $key == 'q30')) {
                            
                           $cont = '<p>' . $value . ' ?</p><br><br>';
                           $pdf->WriteHTML(utf8_decode($cont));
                    }
                }

                $date3 = date('d-m-Y');
                
                $head = 'Formulaire AutoDiag ' . $activeForm[0]->id . ' export du ' . $date3 . '.pdf';
                $pdf->Output('D', $head);
            }
		}
	}
}
