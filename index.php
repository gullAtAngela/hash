<?php
include_once 'classes/Hash.php';
$postExport = new Hash();
$pageTitle = "Generate Hashed E-Mail Adresses";
include_once '../_template/head.php';
?>
<body>
	<div class="container">
		<?php include_once '../_template/header.php'; ?>
		<div class="row">
			<div class="col-sm-12">
				<h1><?= $pageTitle ?></h1>
				<h4>Beschreibung:</h4>
				<p>Die im Import Verzeichnis abgelegte «customer-export.csv» wird eingelesen und die Spalte E-Mail wird verarbeitet und in die entsprechenden Hashes codiert. Es kann zwischen MD5 oder SHA1 Hashes unterschieden werden. Aus Datenschutzgründen sollte die CSV Datei nur die ID und E-Mail enthalten. Die Ergebnisse werden direkt in einer neuen Datei im Ordner Exporte abgelegt.</p>
				<h4>Anleitung:</h4>
				<ul>
					<li>Öffnen des entsprechenden FTP Verzeichnis</li>
					<li>Kontakt-Exporte von Emarsys als <strong>«customer-export.csv»</strong> in den Ordner <strong>Import</strong> ablegen.</li>
					<li>Button «Generate Hashes» drücken</li>
					<li>Neue erstellte Datei mit den generierten Hashes aus dem Ordner <strong>Export</strong> im gleichen FTP Verzeichnis entnehmen.</li>
				</ul>
			</div>
		</div>
		<div class="row justify-content-end mb-5">
			<div class="col-sm-2 text-end">
				<form method="post">
					<input class="btn btn-primary" type="submit" name="generate" value="Generate Hashes">
				</form>
				<?php
				if (isset($_POST['generate'])) {
					$postExport->hashList();
				}
				?>
			</div>
		</div>
	</div>
<?php include '../_template/footer.php'; ?>