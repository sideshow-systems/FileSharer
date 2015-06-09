<?php
namespace de\sideshowsystems\filesharer;

use de\sideshowsystems\exception\IOException;

class FileSharerHelper {
	private $config;

	public function __construct(FileSharerConfig $config) {
		$this->config = $config;
	}

	public function consumeUpload($fileName, $realName, $mimeType = null, $uploadTime = null, $isUpload = true) {
		$result = null;
		
		$this->ensureWritable();
		
		if (is_file($fileName)) {
			$result = Entry::generateAndStore($this->config->getDataDir(), $fileName, $realName, $mimeType, $uploadTime, $isUpload);
		}
		
		return $result;
	}

	public function deliverContent($key) {
		$entry = Entry::loadFromKey($this->config->getDataDir(), $key);
		if (! empty($entry)) {
			$entry->sendBytes($this->config->getDataDir());
		}
	}

	protected function ensureWritable() {
		if (! is_dir($this->config->getDataDir()) || ! is_writable($this->config->getDataDir())) {
			throw new IOException("Error: data directory " . $this->config->getDataDir() . " is not writable!");
		}
	}
	
	public function generateArchiveForMultipleFiles($uploadData) {
		$tmpNum = time() . '_' . mt_rand(10, 1000);
		$tmpBaseDir = $this->config->getDataDir();
		
		// Generate tmp dir
		$tmpDir = $tmpBaseDir . "/fs_tmparchive_" . $tmpNum;
		mkdir($tmpDir, 0777);
		
		
		$zipFileName = 'archive.zip';
		$zipFilePath = $tmpDir . '/' . $zipFileName;
		$dirToZipName = 'archive';
		$dirToZipPath = $tmpDir . '/' . $dirToZipName;
		
		mkdir($dirToZipPath, 0777);
		
		// Build file list
//		$elementsNum = count($uploadData['name']);
		$keys = array();
		$values = array();
		foreach ($uploadData as $key => $file) {
			$keys[] = $key;
			$values[] = $file;
		}
		$combArray = array_combine($keys, $values);
//		error_log(print_r($combArray, true));
		if (!empty($combArray) && !empty($combArray['name'])) {
			$files = $combArray['name'];
			$i = 0;
			foreach ($files as $item) {
				if ($combArray['error'][$i] == UPLOAD_ERR_OK) {
					move_uploaded_file($combArray['tmp_name'][$i], $dirToZipPath . '/' . $item);
				}
				$i++;
			}
		}
		
		// Pack files
		exec("zip -rj --no-dir-entries " . $zipFilePath . " " . $dirToZipPath);
		return $zipFilePath;
	}
}