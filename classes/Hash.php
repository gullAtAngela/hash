<?php

/**
 * Hash
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
	 * @return mixed
	 */
	public function getImportDir()
	{
		return $this->importDir;
	}

	/**
	 * @param mixed $importDir
	 */
	public function setImportDir($importDir)
	{
		$this->importDir = $importDir;
	}

	/**
	 * @return mixed
	 */
	public function getExportDir()
	{
		return $this->exportDir;
	}

	/**
	 * @param mixed $exportDir
	 */
	public function setExportDir($exportDir)
	{
		$this->exportDir = $exportDir;
	}

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

	/**
	 * @return $fileMode Default is readable.
	 */
	public function getFileMode()
	{
		return $this->fileMode;
	}

	/**
	 * @param string $mode
	 */
	public function setFileMode($mode)
	{
		$this->fileMode = $mode;
	}

	/**
	 * @return $fileMode Default is readable.
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * @param string $salt
	 */
	public function setSalt($salt)
	{
		$this->salt = $salt;
	}

	private function readFileContent($filename = 'customer-export.csv')
	{	
		$file = fopen($this->getImportPath(), $this->getFileMode());
		$content = fread($file, filesize($this->getImportPath()));
		$lines = explode(PHP_EOL, $content);

		return $lines;
	}

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

	public function getImportPath()
	{
		return $this->importPath;
	}

	public function setImportPath($filename = 'customer-export.csv')
	{
		$this->importPath = $this->getImportDir() . $filename;
	}

	public function getExportPath()
	{
		return $this->exportPath;
	}

	public function setExportPath($filename = 'hash.csv')
	{
		$this->exportPath = $this->getExportDir() . $filename;
	}

	private function fileDelete()
	{
		if (file_exists($this->getExportPath())) {
			unlink($this->getExportPath());
		}
	}

	private function writeOut($writeInFile)
	{
		file_put_contents($this->getExportPath(), $writeInFile, FILE_APPEND);
	}

	private function success()
	{	
		if (file_exists($this->getExportPath()) && filesize($this->getExportPath()) >= 1) {
			echo "<span class=\"message success\">Die Datei wurde erfolgreich verarbeitet.</span>";
		}
	}
}