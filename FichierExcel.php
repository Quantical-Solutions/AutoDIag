<?php

class FichierExcel {
 
private $csv = Null;
	
	public function Colonne($file)
	{
 
		$this->csv.=$file."\n";
		return $this->csv;
 
	}
 
	public function Insertion($file)
	{
 
		$this->csv.=$file."\n";
		return $this->csv;
	}
 
	public function exportToCsv($Rapport, $tableau)
	{

		$date = date('d-m-Y') . ' à ' . date('H') . 'h' . date('i');
 		
 		$fp = fopen(plugin_dir_path( __FILE__ ).'/temp/Rapport AutoDiag du ' . $date . '.csv', 'w');

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

 		$file = plugin_dir_path( __FILE__ ).'/temp/Rapport AutoDiag du ' . $date . '.csv';
		
		header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($file).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));

	    readfile($file);
	    unlink($file);
	    exit;
	}

	public function sendCsvByMail($Rapport, $email, $content, $tableau)
	{

		$date = date('d-m-Y') . ' à ' . date('H') . 'h' . date('i');
 		
 		$fp = fopen(plugin_dir_path( __FILE__ ).'/rapports/Rapport AutoDiag au ' . $date . '.csv', 'w');

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

		$object = 'Rapport AutoDiag au ' . $date;
		$header = 'From: no-reply@cmai-autodiag.com';

		$attachments = array(plugin_dir_path( __FILE__ ).'/rapports/Rapport AutoDiag au ' . $date . '.csv');

        $result = wp_mail($email, $object, $content, $header, $attachments);
	}
}
