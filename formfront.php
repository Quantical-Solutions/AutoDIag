<?php

class Form_front
{
	
    public function __construct()
    {

        add_shortcode('AutoDiag', array($this, 'formFront_html'));
    }

	public function formFront_html()
	{

		global $wpdb;

        $questions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag ORDER BY id DESC LIMIT 0, 1;");

        if (isset($_POST['nom']) && !empty($_POST['nom'])) {

        	global $wpdb;

            $tableau = $wpdb->get_results("SELECT `{$wpdb->prefix}autodiag_users`.`id`,`{$wpdb->prefix}autodiag_users`.`loaded`, `{$wpdb->prefix}autodiag_users`.`nom`, `{$wpdb->prefix}autodiag_users`.`societe`, `{$wpdb->prefix}autodiag_users`.`email`, `{$wpdb->prefix}autodiag_users`.`tel`, `{$wpdb->prefix}autodiag_users`.`siret`, `{$wpdb->prefix}autodiag_users`.`rappel`, `{$wpdb->prefix}autodiag_users`.`score`, `{$wpdb->prefix}autodiag_users`.`form_id`, `{$wpdb->prefix}autodiag_users`.`questions`, `{$wpdb->prefix}autodiag_users`.`date`, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17, q18, q19, q20, q21, q22, q23, q24, q25, q26, q27, q28, q29, q30 FROM `{$wpdb->prefix}autodiag_users` INNER JOIN `{$wpdb->prefix}autodiag` ON `{$wpdb->prefix}autodiag_users`.`form_id` = `{$wpdb->prefix}autodiag`.`id` WHERE `{$wpdb->prefix}autodiag_users`.`loaded` = 0 ORDER BY `{$wpdb->prefix}autodiag_users`.`id` DESC");

            $recipients = $wpdb->get_results("SELECT r1, r2, r3, r4, r5 FROM {$wpdb->prefix}autodiag_refs ORDER BY id DESC LIMIT 0, 1;");

            $presetBank = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag_settings ORDER BY id DESC LIMIT 0, 1;");

	        	$activForm = $tableau[0];
	        	$preset = (int)$presetBank[0]->preset;

		        $object = 'Rapport Automatique AutoDiag';
		        $content = 'Cet email contient en pièce jointe le dernier rapport AutoDiag des derniers formulaires remplis.';
		        $header = 'From: no-reply@cmai-autodiag.com';

		        foreach ($recipients as $_recipient) {

		        	if (count($tableau) >= $preset) {

			            $email1 = $_recipient->r1;
			            $email2 = $_recipient->r2;

			            $date = date('d-m-Y') . ' à ' . date('H') . 'h' . date('i');
	 		
				 		$fp = fopen(plugin_dir_path( __FILE__ ).'/temp/Rapport Automatique AutoDiag au ' . $date . '.csv', 'w');

				 		fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				 		$delimiteur = " ";
				 		$delimiteurSep = " ";
				 		$sep = array('========================');
				 		$marge = array('');
				 		$fiche = array('    FICHE CONTACT');
				 		$fin = array('          FIN');
				 		
				 		for ($i=0; $i < count($tableau); $i++) {

				 			fputcsv($fp, $marge, $delimiteurSep);
				 			fputcsv($fp, $sep, $delimiteurSep);
				 			fputcsv($fp, $fiche, $delimiteurSep);
				 			fputcsv($fp, $sep, $delimiteurSep);
				 			fputcsv($fp, $marge, $delimiteurSep);
				 			fputcsv($fp, $marge, $delimiteurSep);

							foreach ($tableau[$i] as $key => $ligne) {
								
								if ($ligne != 'vide' && !empty($ligne) && $key != 'loaded') {
								
									$retour = "\r\t";
									$ligne = $key . ' = ' . $ligne . $retour;
									$row = explode(';', utf8_decode($ligne));
									fputcsv($fp, $row, $delimiteur);
								}
							}

							fputcsv($fp, $marge, $delimiteurSep);
				 			fputcsv($fp, $sep, $delimiteurSep);
				 			fputcsv($fp, $fin, $delimiteurSep);
				 			fputcsv($fp, $sep, $delimiteurSep);
				 			fputcsv($fp, $marge, $delimiteurSep);
				 			fputcsv($fp, $marge, $delimiteurSep);
						}
					
				 		fclose($fp);

						$attachments = array(plugin_dir_path( __FILE__ ).'/temp/Rapport Automatique AutoDiag au ' . $date . '.csv');

						$result1 = wp_mail($email1, $object, $content, $header, $attachments);
						$result2 = wp_mail($email2, $object, $content, $header, $attachments);

						$file = plugin_dir_path( __FILE__ ).'/temp/Rapport Automatique AutoDiag au ' . $date . '.csv';

						unlink($file);

						$wpdb->query("UPDATE `{$wpdb->prefix}autodiag_users` SET loaded = 1 WHERE loaded = 0;");
					}
			}

        	$nom = $_POST['nom'];
        	$societe = $_POST['company'];
        	$email = $_POST['email'];
        	$score = $_POST['score'];
        	$siret = $_POST['siret'];
        	$tel = $_POST['tel'];
        	$rappel = $_POST['rappel'];
        	$form_id = $_POST['form_id'];
        	$questionsArray = array();

        	for ($i=1; $i <= 30; $i++) { 
        		
        		if (isset($_POST['question_q' . $i]) && !empty($_POST['question_q' . $i])) {
        			
        			$q = $_POST['question_q' . $i];
        			array_push($questionsArray, $q);
        		}
        	}
        	
        	$quest = implode(',', $questionsArray);

        	$wpdb->query("INSERT INTO {$wpdb->prefix}autodiag_users (nom, societe, email, tel, siret, rappel, score, form_id, questions) VALUES ('" . $nom . "', '" . $societe . "', '" . $email . "', '" . $tel . "', '" . $siret . "', '" . $rappel . "', '" . $score . "', '" . $form_id . "', '" . $quest . "');");
        }

        if (isset($_POST['score']) && $_POST['score'] != 0) {

        	$scoreUser = (int)$_POST['score'];

	        $recipients = $wpdb->get_results("SELECT r1, r2, r3, r4, r5 FROM {$wpdb->prefix}autodiag_refs ORDER BY id DESC LIMIT 0, 1;");

	        if ($_POST['rappel'] == 'ok') {


	        	$rap = 'La CMA a l\'autorisation de rappeler pour prendre des informations supplémentaires au ' . $_POST['tel'] . '.';
		        
	        } else {

	        	$rap = 'La CMA n\'a pas l\'autorisation de rappeler pour prendre des informations supplémentaires.';
	        }

	        if ($scoreUser < 2) {

	        	global $wpdb;

	        	$form = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag ORDER BY id DESC LIMIT 0, 1");

	        	$activForm = $form[0];

		        $object = 'Rapport Automatique AutoDiag positif';
		        $content = 'Vous recevez cet email car la société ' . $_POST['company'] . ', SIRET : ' . $_POST['siret'] . ' dont le gérant est ' . $_POST['nom'] . ' ne nécessite aucune intervention.' . $rap;
		        $header = 'From: no-reply@cmai-autodiag.com';

		        foreach ($recipients as $_recipient) {

		            $email1 = $_recipient->r5;

		            $date = date('d-m-Y') . ' à ' . date('H') . 'h' . date('i');
			 		
					$fp = fopen(plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv', 'w');

					fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

					$delimiteur = " ";
					$delimiteurSep = " ";
					$sep = array('========================');
					$marge = array('');
					$fiche = array('    FICHE CONTACT');
					$fin = array('          FIN');
					$details = array(

						"nom" => $_POST['nom'],
						"societe" => $_POST['company'],
						"email" => $_POST['email'],
						"score" => $_POST['score'],
						"siret" => $_POST['siret'],
						"tel" => $_POST['tel'],
						"rappel" => $_POST['rappel'],
						"form_id" => $_POST['form_id']

						 		);
					$questString = '';

					foreach ($_POST as $key => $value) {
			
						for ($i=1; $i <= 30; $i++) {

							$quest = 'q' . $i;

							if ($value == $quest) {
							
								$questString .= ',' . $value;
								$valueString = substr($questString, 1);

							}
						}
					}

					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $fiche, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);

					foreach ($details as $key => $ligne) {
										
						if ($ligne != 'vide' && !empty($ligne)) {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					$questionsArray = array("oui aux questions" => $valueString);

					foreach ($questionsArray as $key => $ligne) {
										
						if (!empty($ligne)) {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					foreach ($activForm as $key => $ligne) {
							
						if ($ligne != 'vide' && !empty($ligne) && $key != 'id' && $key != 't2' && $key != 't3' && $key != 't4') {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $fin, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
							
					fclose($fp);

					$attachments = array(plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv');

					$result1 = wp_mail($email1, $object, $content, $header, $attachments);

					$file = plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv';

					unlink($file);
		        }

		    } else if ($scoreUser >= 2 && $scoreUser < 6) {

		    	global $wpdb;

	        	$form = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag ORDER BY id DESC LIMIT 0, 1");

	        	$activForm = $form[0];

		        $object = 'Rapport Automatique AutoDiag moyen';
		        $content = 'Vous recevez cet email car la société ' . $_POST['company'] . ', SIRET : ' . $_POST['siret'] . ' dont le gérant est ' . $_POST['nom'] . ' commence à connaître des difficultés.' . $rap;
		        $header = 'From: no-reply@cmai-autodiag.com';

		        foreach ($recipients as $_recipient) {

		            $email1 = $_recipient->r3;
		            $email2 = $_recipient->r4;

		            $date = date('d-m-Y') . ' à ' . date('H') . 'h' . date('i');
			 		
					$fp = fopen(plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv', 'w');

					fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

					$delimiteur = " ";
					$delimiteurSep = " ";
					$sep = array('========================');
					$marge = array('');
					$fiche = array('    FICHE CONTACT');
					$fin = array('          FIN');
					$details = array(

						"nom" => $_POST['nom'],
						"societe" => $_POST['company'],
						"email" => $_POST['email'],
						"score" => $_POST['score'],
						"siret" => $_POST['siret'],
						"tel" => $_POST['tel'],
						"rappel" => $_POST['rappel'],
						"form_id" => $_POST['form_id']

						 		);
					$questString = '';

					foreach ($_POST as $key => $value) {
			
						for ($i=1; $i <= 30; $i++) {

							$quest = 'q' . $i;

							if ($value == $quest) {
							
								$questString .= ',' . $value;
								$valueString = substr($questString, 1);

							}
						}
					}

					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $fiche, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);

					foreach ($details as $key => $ligne) {
										
						if ($ligne != 'vide' && !empty($ligne)) {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					$questionsArray = array("oui aux questions" => $valueString);

					foreach ($questionsArray as $key => $ligne) {
										
						if (!empty($ligne)) {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					foreach ($activForm as $key => $ligne) {
							
						if ($ligne != 'vide' && !empty($ligne) && $key != 'id' && $key != 't2' && $key != 't3' && $key != 't4') {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $fin, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
							
					fclose($fp);

					$attachments = array(plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv');

					$result1 = wp_mail($email1, $object, $content, $header, $attachments);
					$result2 = wp_mail($email2, $object, $content, $header, $attachments);

					$file = plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv';

					unlink($file);
		            
		        }

		    } else if ($scoreUser >= 6) {

		    	global $wpdb;

	        	$form = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}autodiag ORDER BY id DESC LIMIT 0, 1");

	        	$activForm = $form[0];

		        $object = 'Rapport Automatique AutoDiag URGENCE';
		        $content = 'Vous recevez cet email car la société ' . $_POST['company'] . ', SIRET : ' . $_POST['siret'] . ' dont le gérant est ' . $_POST['nom'] . ' connaît une URGENCE professionnelle.' . $rap;
		        $header = 'From: no-reply@cmai-autodiag.com';

		        foreach ($recipients as $_recipient) {

		            $email1 = $_recipient->r1;
		            $email2 = $_recipient->r2;

		            $date = date('d-m-Y') . ' à ' . date('H') . 'h' . date('i');
			 		
					$fp = fopen(plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv', 'w');

					fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

					$delimiteur = " ";
					$delimiteurSep = " ";
					$sep = array('========================');
					$marge = array('');
					$fiche = array('    FICHE CONTACT');
					$fin = array('          FIN');
					$details = array(

						"nom" => $_POST['nom'],
						"societe" => $_POST['company'],
						"email" => $_POST['email'],
						"score" => $_POST['score'],
						"siret" => $_POST['siret'],
						"tel" => $_POST['tel'],
						"rappel" => $_POST['rappel'],
						"form_id" => $_POST['form_id']

						 		);
					$questString = '';

					foreach ($_POST as $key => $value) {
			
						for ($i=1; $i <= 30; $i++) {

							$quest = 'q' . $i;

							if ($value == $quest) {
							
								$questString .= ',' . $value;
								$valueString = substr($questString, 1);

							}
						}
					}

					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $fiche, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);

					foreach ($details as $key => $ligne) {
										
						if ($ligne != 'vide' && !empty($ligne)) {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					$questionsArray = array("oui aux questions" => $valueString);

					foreach ($questionsArray as $key => $ligne) {
										
						if (!empty($ligne)) {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					foreach ($activForm as $key => $ligne) {
							
						if ($ligne != 'vide' && !empty($ligne) && $key != 'id' && $key != 't2' && $key != 't3' && $key != 't4') {
										
							$retour = "\r\t";
							$ligne = $key . ' = ' . $ligne . $retour;
							$row = explode(';', utf8_decode($ligne));
							fputcsv($fp, $row, $delimiteur);
						}
					}

					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $fin, $delimiteurSep);
					fputcsv($fp, $sep, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
					fputcsv($fp, $marge, $delimiteurSep);
							
					fclose($fp);

					$attachments = array(plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv');

					$result1 = wp_mail($email1, $object, $content, $header, $attachments);
					$result2 = wp_mail($email2, $object, $content, $header, $attachments);

					$file = plugin_dir_path( __FILE__ ).'/temp/Rapport au fil AutoDiag au ' . $date . '.csv';

					unlink($file);
		        }
		    }
	    }
	

	    ob_start(); ?> 

	    <style>
	    	
	    	#formFront {
	    		display: flex;
	    		flex-direction: column;
	    		justify-content: center;
	    		align-items: center;
	    		width: 90%;
	    		margin: 20px auto;

	    	}

	    	#formFront h1,
	    	#formFront h2,
	    	#formFront h3,
	    	#formFront h4,
	    	#formFront h5,
	    	#formFront h6 {
	    		color: #3c3c3c;
	    	}

	    	.headerForm h3 {
	    		margin-bottom: 20px;
	    		width: 100%;
	    	}

	    	.formfrontSection {
	    		width: 100%;
	    		display: flex;
	    		flex-direction: column;
	    		justify-content: flex-start;
	    		margin: 20px 0;
	    		border-radius: 10px;
	    		background-color: white;
	    		box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
	    		padding: 2%;
	    	}

	    	.headerForm {
	    		display: flex;
	    		justify-content: space-around;
	    		align-items: center;
	    		flex-wrap: wrap;
	    		width: 100%;
	    		margin: 20px 0;
	    		border-radius: 10px;
	    		background-color: white;
	    		box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
	    		padding: 2%;
	    	}

	    	.formfrontSection2 {
	    		width: 50%;
	    		display: flex;
	    		flex-direction: column;
	    		justify-content: flex-start;
	    		
	    	}

	    	.qestSection {
	    		width: 100%;
	    		display: flex;
	    		flex-direction: row;
	    		justify-content: space-around;
	    		align-items: flex-start;
	    		margin: 5px 0;
	    	}

	    	.qestSection2 {
	    		width: 100%;
	    		display: flex;
	    		flex-direction: row;
	    		align-items: flex-start;
	    		margin: 10px 0;
	    	}

	    	.qestSection > div {
	    		display: flex;
			    justify-content: space-around;
			    width: 20%;
			    align-items: center;
			}

			.qestSection > div div {
				display: flex;
				align-items: center;
			}

			.qestSection p {
				width: 70%;
				margin-right: 10%;
			}

			#formFront button {
				background-color: transparent;
				border: 2px solid silver;
				color: inherit;
				border-radius: 5px;
				transition: all ease-in-out 0.3s;
				cursor: pointer;
			    font-size: 1.4em;
			    padding: 1% 2%;
			}

			#formFront button:hover {
				border: 2px solid orange;
				color: orange;
			}

			#formFront button:focus {
				outline: none;
			}

			.qestSection2 input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
			  color: silver;
			  opacity: 0.6;
			  font-style: italic;
			}
			.qestSection2 input::-moz-placeholder { /* Firefox 19+ */
			  color: silver;
			  opacity: 0.6;
			  font-style: italic;
			}
			.qestSection2 input:-ms-input-placeholder { /* IE 10+ */
			  color: silver;
			  opacity: 0.6;
			  font-style: italic;
			}
			.qestSection2 input:-moz-placeholder { /* Firefox 18- */
			  color: silver;
			  opacity: 0.6;
			  font-style: italic;
			}

			@media (max-width: 790px) {

				.headerForm {
					flex-direction: column!important;
				}

				.autoDiagHeader h1 {
				    line-height: 1em!important;
				}

				.formfrontSection, .formfrontSection2 {
					width: auto!important;
				    flex-wrap: wrap!important;
				}

				.formfrontSection h3 {
					text-align: center!important;
				}

				#formFront {
				    flex-wrap: wrap!important;
				    flex-direction: row!important;
				}

				.qestSection {
				    width: auto!important;
				    flex-wrap: wrap!important;
				    margin-bottom: 5%;
				}

				.qestSection p {
					width: 100%!important;
				    word-break: break-word!important;
				    margin-left: 10%!important;
				    text-align: center!important;
				}

				.questSection > div {
					justify-content: center!important;
				    width: 100%!important;
				    align-items: center!important;
				}
			}

	    </style>

	    <?php 
	    
		if (empty($_POST['nom'])) { ?>

	    <form id="formFront" action="" method="post">
	    	<input id="score" type="hidden" name="score" value="0">
	    	<input id="form_id" type="hidden" name="form_id" value="<?php echo $questions[0]->id; ?>">
	    	<div class="headerForm">
	    		<h3>Fiche de renseignements : </h3>
	    		<br>
		    	<div class="formfrontSection2">
		    		<div class="qestSection2">
		        		<div>
			        		<div>
					        	<label for="nom">Votre nom </label>
					            <input type="text" name="nom" value="" placeholder="ex : Jean DUPONT" required>
					        </div>
					    </div>
					</div>
					<div class="qestSection2">
		        		<div>
		        			<div>
					        	<label for="societe">Votre société </label>
					            <input type="text" name="company" value="" placeholder="ex : maSociété" required>
					        </div>
					    </div>
					</div>
					<div class="qestSection2">
		        		<div>
					        <div>
					        	<label for="email">Votre email </label>
					            <input type="email" name="email" value="" placeholder="ex : jean.d@exemple.ex" required>
					        </div>
					    </div>
			        </div>
			    </div>
			    <div class="formfrontSection2">
			        <div class="qestSection2">
		        		<div>
					        <div>
					        	<label for="email">Votre téléphone </label>
					            <input type="tel" name="tel" value="" placeholder="ex : 0123456789" required>
					        </div>
					    </div>
			        </div>
			        <div class="qestSection2">
		        		<div>
					        <div>
					        	<label for="email">Votre SIRET </label>
					            <input type="text" name="siret" value="" placeholder="ex : 12345678912345" required>
					        </div>
					    </div>
			        </div>
			        <div class="qestSection2">
		        		<div>
					        <div>
					        	<input type="checkbox" name="rappel" value="ok" checked>
					        	<label for="rappel"> J’accepte d’être rappelé par la CMA (pas d'usage commercial)</label>
					        </div>
					    </div>
			        </div>
		    	</div>
		    </div>
	        <div class="formfrontSection">
	        	<h3><?php echo $questions[0]->t2; ?> :</h3>
	        	<br>

	        	<?php
	        	
	        	
	        	for ($i=1; $i <= 30; $i++) {

	        		if ($i < 11) {

	        			$cnt = 'q'.$i;

	        			if (!empty($questions[0]->$cnt) && $questions[0]->$cnt != 'vide') { ?>
	        		 	
		        		 	<div class="qestSection">
				        		<p><?php echo $questions[0]->$cnt; ?> ?</p>
				        		<div>
				        			<input id="<?php echo $cnt ?>" type="hidden" name="question_<?php echo $cnt ?>" value="">
					        		<div>
							        	<label>oui</label>
							            <input class="inputCheckForm yes" type="radio" value="1" name="<?php echo $cnt ?>">
							        </div>
							        <div>
							            <input class="inputCheckForm no" type="radio" value="0" name="<?php echo $cnt; ?>" checked>
							            <label>non</label>
							        </div>
							    </div>
					        </div>
				<?php   }

					}
				}

	        	?>
	        </div>	
	        <div class="formfrontSection">
	        	<h3><?php echo $questions[0]->t3; ?> : </h3>
	        	<br>
	        	<?php

	        	for ($i=1; $i <= 30; $i++) {

	        		if ($i >= 11 && $i < 21) {

	        			$cnt = 'q'.$i;

	        			if (!empty($questions[0]->$cnt) && $questions[0]->$cnt != 'vide') { ?>
	        		 	
		        		 	<div class="qestSection">
				        		<p><?php echo $questions[0]->$cnt; ?> ?</p>
				        		<div>
				        			<input id="<?php echo $cnt ?>" type="hidden" name="question_<?php echo $cnt ?>" value="">
					        		<div>
							        	<label>oui</label>
							            <input class="inputCheckForm yes" type="radio" value="1" name="<?php echo $cnt; ?>">
							        </div>
							        <div>
							            <input class="inputCheckForm no" type="radio" value="0" name="<?php echo $cnt; ?>" checked>
							            <label>non</label>
							        </div>
							    </div>
					        </div>
				<?php   }

	        		}
	        	}

	        	?>
	        </div>
	        <div class="formfrontSection">
	        	<h3><?php echo $questions[0]->t4; ?> :</h3>
	        	<br>
	        	<?php 

	        	for ($i=1; $i <= 30; $i++) {

	        		if ($i >= 21) {

	        			$cnt = 'q'.$i;

	        			if (!empty($questions[0]->$cnt) && $questions[0]->$cnt != 'vide') { ?>
	        		 	
		        		 	<div class="qestSection">
				        		<p><?php echo $questions[0]->$cnt; ?> ?</p>
				        		<div>
				        			<input id="<?php echo $cnt ?>" type="hidden" name="question_<?php echo $cnt ?>" value="">
					        		<div>
							        	<label>oui</label>
							            <input class="inputCheckForm yes" type="radio" value="1" name="<?php echo $cnt; ?>">
							        </div>
							        <div>
							            <input class="inputCheckForm no" type="radio" value="0" name="<?php echo $cnt; ?>" checked>
							            <label>non</label>
							        </div>
							    </div>
					        </div>
				<?php   }
					}
				}

	        	?>
	        </div>
	        <button type="submit" value="Envoyer">Envoyer</button>
	    </form>

		<script>
			
			var somme = document.querySelectorAll('.inputCheckForm');

			for (var i = 0; i < somme.length; i++) {

				somme[i].addEventListener('change', checkResult);
				somme[i].addEventListener('change', checkRowResult);
			}

			function checkResult(res) {

				var check = res.currentTarget;

				var cnt = 0;

				for (var j = 0; j < somme.length; j++) {

					if (somme[j].checked) {

						cnt = cnt + parseInt(somme[j].value);
					}
				}

				var total = document.querySelector('#score');
				total.value = cnt;
			}

			function checkRowResult(row) {

				var check2 = row.currentTarget;

				var parent = check2.parentElement.parentElement.children[0];

				if (check2.value == 1) {

					parent.value = parent.id;
				} else {

					parent.value = null;
				}
			}

		</script>

		<?php

	    return ob_get_clean();

		} else if (isset($_POST['nom']) && !empty($_POST['nom'])) { 

			ob_start(); ?>

	    <style>
	    	
	    	#formFront {
	    		display: flex;
	    		flex-direction: column;
	    		justify-content: center;
	    		align-items: center;
	    		width: 90%;
	    		margin: auto;

	    	}

	    	.formfrontSection2 {
	    		width: 100%;
	    		display: flex;
	    		flex-direction: column;
	    		justify-content: flex-start;
	    		margin: 20px 0;
	    		border-radius: 10px;
	    		box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
	    		padding: 2%;
	    	}

	    </style>


<?php	if ($_POST['score'] < 2) { ?>

	    <div id="formFront">
	    	<div class="formfrontSection2">
	    		<h3>Le formulaire de diagnostic a bien été envoyé.</h3><br><br>
	    		<p>Votre entreprise ne paraît pas connaître actuellement des difficultés. Néanmoins, afin d’éviter tout risque, vous devriez vérifier avec vos partenaires (conseiller CMA, expert-comptable…) que vous utilisez les bons outils de suivi permettant de vous mettre en alerte et de réagir rapidement. En effet, il est conseillé de mettre en place dans toute entreprise : </p><br>
	    		<ul>
	    			<li>Un système de suivi de facturation</li>
	    			<li>Un plan de trésorerie</li>
	    			<li>Un système de relance client plus fréquent</li>
	    			<li>Un outil de suivi de vos clients</li>
	    		</ul>
	    		<a href="#">LIEN VERS LE CATALOGUE DE FORMATION</a>
			</div>
		</div>

<?php	} else if ($_POST['score'] >= 2 && ($_POST['score'] <= 5)) { ?>

		<div id="formFront">
	    	<div class="formfrontSection2">
	    		<h3>Le formulaire de diagnostic a bien été envoyé.</h3><br><br>
	    		<p>Votre entreprise semble connaître des difficultés structurelles. Il est important d’agir rapidement pour déterminer le niveau de difficulté que vous traversez et agir en fonction. Vous pouvez contacter :</p><br>
	    		<ul>
	    			<li>Votre expert-comptable</li>
	    			<li>Le CIP (Centre d’Information sur la Prévention)</li>
	    			<li>Le centre des Impôts, la banque, l’URSSAF ou le RSI si votre dette relève d’un de ces organismes</li>
	    			<li>Votre Chambre de Métiers et de l’Artisanat </li>
	    		</ul>
	    		<p><b>Prenez conseil ! Contactez-nous très vite !</b></p>
	    		<p><b>Service de Développement des Entreprises : <a href="tel:+33556999772">05 56 99 97 72</a></b></p>
			</div>
		</div>

<?php	} else if ($_POST['score'] > 5) { ?>

		<div id="formFront">
	    	<div class="formfrontSection2">
	    		<h3>Le formulaire de diagnostic a bien été envoyé.</h3><br><br>
	    		<p>Des difficultés sont avérées. Il est nécessaire de vérifier si votre entreprise est ou non en état de cessation de paiement.</p><br>
	    		<p><b>La Chambre de Métiers et de l’Artisanat va prendre contact avec vous pour vous conseiller, vous orienter et vous accompagner vers nos différents partenaires.</b></p>
			</div>
		</div>

<?php	} ?>

			<?php
			return ob_get_clean();
		}
	}
}
