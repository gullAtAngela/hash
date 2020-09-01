<?php
include_once 'classes/Hash.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
$postExport = new Hash();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.6.3/css/foundation.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Hash E-Mail</title>
</head>
<body>
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="small-12 cell">
				<h1>Generate Hashed E-Mail Adresses</h1>
				<h4>Beschreibung:</h4>
				<p>Die im Import Verzeichnis abgelegte "customer_export.csv" wird eingelesen und die Spalte E-Mail in entsprechende Hashes codiert werden. Es kann zwischen MD5 oder SHA1 Hashes unterschieden werden. Aus Datenschutzgründen sollte die CSV Datei nur die ID und E-Mail enthalten. Die Ergebnisse werden direkt in eine neuen Datei im Ordner Exporte abgelegt.</p>
				<h4>Anleitung:</h4>
				<ul>
					<li>Öffnen des entsprechenden FTP Verzeichnis "Angela Intern"</li>
					<li>Kontakt-Exporte von Emarsys als "customer_export.csv" in den Ordner Import ablegen.</li>
					<li>Button "Generate Hashes" drücken</li>
					<li>Neue Datei mit den generierten Hashes aus dem Ordner Export entnehmen.</li>
				</ul>
			</div>
			<div class="small-12 cell">
				<form method="POST">
					<input type="submit" name="generate" value="Generate Hashes" class="button large float-right">
				</form>
				<?php
				if (isset($_POST['generate'])) {
					$postExport->hashList();
				}
				?>
			</div>
		</div>
	</div>
</body>
</html>