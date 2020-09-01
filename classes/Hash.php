<?php
/**
 * Hash Generator
 *
 * This file is part of the Framie Framework.
 *
 * @link		$HeadURL$
 * @version     $Id$
 *
 * The Framie WAF/CMS is a modern web application framework and content
 * management system  written for  PHP 7.1 or  higher.  It is implemented
 * fully object-oriented and  takes advantage of the latest web standards
 * such as HTML5 and CSS3.  Thanks to the modular design  and the variety
 * of features,  the system can quickly be adapted to given requirements.
 *
 *               Copyright (c) 2019 - 2020 gullDesign
 *                         All rights reserved.
 *
 * THIS SOFTWARE IS PROVIDED  BY THE  COPYRIGHT HOLDERS  AND CONTRIBUTORS
 * "AS IS"  AND ANY  EXPRESS OR  IMPLIED  WARRANTIES,  INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE  ARE DISCLAIMED.  IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR  CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL,  EXEMPLARY,  OR  CONSEQUENTIAL  DAMAGES  (INCLUDING,  BUT NOT
 * LIMITED TO,  PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION)  HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY,  WHETHER IN CONTRACT,  STRICT LIABILITY,  OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE)  ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE,  EVEN IF ADVISED OF  THE POSSIBILITY OF SUCH DAMAGE.
 *
 *
 * @license		http://gulldesign.ch/license.txt
 * @copyright	Copyright (c) 2019 - 2020 gullDesign
 * @link		https://bitbucket.org/gulldesign/framie
 */

/**
 * Hash Generator
 *
 * Hiermit kann ein beliebiger Wert als Hash umgewandelt werden. Die
 * Funktionsweis ist so aufgebaut, dass eine CSV bestehend aus zwei
 * Spalten hochgeladen werden kann und dann in eine neue Datei
 * bestehend aus dem Hash Wert abgespeichert wird.
 */
class Hash
{

	private $importDir = "import/";
	private $exportDir = "export/";
	private $fileMode = 'r';

	private $salt;
	private $hash;
	
	public function __construct()
	{
		set_time_limit(120);
		$this->setImportPath();
		$this->setExportPath();
	}

	/**
	 * Gibt das Import Verzeichnis zurück.
	 *
	 * @return 	string
	 *         	Gibt das definierte Import Verzeichnis zurück. Default ist import/.
	 */
	public function getImportDir()
	{
		return $this->importDir;
	}

	/**
	 * Setzt ein neues Import Verzeichnis.
	 *
	 * @param 	string $importDir
	 *         	Das neu definierte Import Verzeichnis.
	 */
	public function setImportDir($importDir)
	{
		$this->importDir = $importDir;
	}

	/**
	 * Gibt das Eport Verzeichnis zurück.
	 *
	 * @return 	string
	 *         	Gibt das definierte Eport Verzeichnis zurück. Default ist eport/.
	 */
	public function getExportDir()
	{
		return $this->exportDir;
	}

	/**
	 * Setzt ein neues Export Verzeichnis.
	 *
	 * @param 	string $exportDir
	 *         	Das neu definierte Export Verzeichnis.
	 */
	public function setExportDir($exportDir)
	{
		$this->exportDir = $exportDir;
	}

	/**
	 * Holt sich den definierten File Handle Mode.
	 *
	 * @return 	string
	 *         	FileMode für die unterschiedlichen Dateihandler Methoden.
	 *			Default is readable.
	 */
	public function getFileMode()
	{
		return $this->fileMode;
	}

	/**
	 * Damit kann ein neuer File Handle Mode definiert werden. Um festzulegen
	 * wie eine Datei geöffnet werden soll. Lese- oder Schreibmodus.
	 *
	 * @param 	string $mode
	 *         	Definition des entsprechenden File Handle Modus.
	 */
	public function setFileMode($mode)
	{
		$this->fileMode = $mode;
	}

	/**
	 * Gibt den enstprechend gesetzten Salt-Wert zurück.
	 *
	 * @return 	string
	 *         	Der festgelegte Salt-Wert. Default is empty.
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Damit wird der Salt-Wert festgelegt, um einer Vershclüsselung noch etwas
	 * mehr Sicherheit zu geben.
	 *
	 * @param 	string $salt
	 *         	Der festgelegte Salt-Wert.
	 */
	public function setSalt($salt)
	{
		$this->salt = $salt;
	}

	/**
	 * Gibt den ganzen Import Pfad zurück.
	 *
	 * @return 	string
	 *         	Gibt den definierte Import Pfad zurück.
	 */
	public function getImportPath()
	{
		return $this->importPath;
	}

	/**
	 * Setzt einen neuen Import Pfad basierend auf dem ImportDir und dem 
	 * eingestellten Dateinamen. Die Tiefe kann damit frei definiert werden.
	 *
	 * @param 	string $filename
	 *         	Der enstprechende Dateiname für die Importdatei. Default ist
	 *			customer-export.csv.
	 */
	public function setImportPath($filename = 'customer-export.csv')
	{
		if ($filename) {
			# code...
		}
		$this->importPath = $this->getImportDir() . $filename;
	}

	/**
	 * Gibt den ganzen Export Pfad zurück.
	 *
	 * @return 	string
	 *         	Gibt den definierte Export Pfad zurück.
	 */
	public function getExportPath()
	{
		return $this->exportPath;
	}

	/**
	 * Setzt einen neuen Export Pfad basierend auf dem ExportDir und dem 
	 * eingestellten Dateinamen. Die Tiefe kann damit frei definiert werden.
	 *
	 * @param 	string $filename
	 *         	Der enstprechende Dateiname für die Exportdatei. Default ist
	 *			hash.csv.
	 */
	public function setExportPath($filename = 'hash.csv')
	{
		$this->exportPath = $this->getExportDir() . $filename;
	}

	/**
	 * Setzt die E-Mail bzw. der String in lowercase und generiert dann den Hash.
	 * Zudem wird ein Salt hinten angehängt, sofern dieser über die Methode
	 * {setSalt()} definiert wurde.
	 *
	 * @param 	string $mail
	 *         	Die E-Mail bzw. der String welcher für die Hash Generierung 
	 *			herangezogen wird.
	 *
	 * @param 	string $type
	 *         	Der Algorithmus welcher für den Hash verwendet werden soll. 
	 *			Default ist md5.
	 */
	public function hash($mail, $type = 'md5')
	{
		$mail = strtolower($mail);
		switch ($type) {
			case 'md5':
				return md5($mail . $this->getSalt());
				break;

			case 'sha1':
				return sha1($mail . $this->getSalt());
				break;
		}
	}

	private function readFileContent($filename = 'customer-export.csv')
	{	
		$file = fopen($this->getImportPath(), $this->getFileMode());
		$content = fread($file, filesize($this->getImportPath()));
		$lines = explode(PHP_EOL, $content);

		return $lines;
	}

	/**
	 * Arbeitet eine ganze CSV Datei mit 2 Spalten ab um die Hashes zu generieren.
	 * Die Spalten werden in ID und E-Mail aufgegliedert.
	 *
	 * @param 	bool $output
	 *         	Damit kann ein direkte Output der Hashes erzwungen werden.
	 *			Default ist FALSE.
	 */
	public function hashList($output = FALSE)
	{
		$lines = $this->readFileContent();
		$this->fileDelete();
		for ($i = 1; $i < count($lines); $i++) {
			if (!empty($lines[$i])) {
				list($id, $email) = explode(";", $lines[$i]);
				if ($output) {
					echo $this->hash($email) . "<br>";
				} else {
					$this->writeOut($this->hash($email) . PHP_EOL);
				}
			}
		}

		$this->success();
	}

	/**
	 * Prüft ob eine Datei am Export Path existiert und löscht diese anschliessend.
	 */
	private function fileDelete()
	{
		if (file_exists($this->getExportPath())) {
			unlink($this->getExportPath());
		}
	}

	/**
	 * Schreibt die gelesenen Werte in eine Datei am Export Path.
	 *
	 * @param 	string $writeInFile
	 *         	Der entsprechende Wert, welcher in die Datei geschrieben
	 * 			werden soll.
	 */
	private function writeOut($writeInFile)
	{
		file_put_contents($this->getExportPath(), $writeInFile, FILE_APPEND);
	}

	/**
	 * 
	 */
	private function success()
	{	
		if (file_exists($this->getExportPath()) && 
						filesize($this->getExportPath()) >= 1) {
			echo "<span class=\"message success\">Die Datei wurde erfolgreich verarbeitet.</span>";
		}
	}
}