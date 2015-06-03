<?php
namespace de\sideshowsystems\filesharer;

use de\sideshowsystems\exception\IOException;

class FileSharerHelper {
	private $config;

	public function __construct(FileSharerConfig $config) {
		$this->config = $config;
	}

	public function consumeUpload($fileName, $realName, $mimeType = null) {
		$result = null;
		
		$this->ensureWritable();
		
		if (is_file($fileName)) {
			$result = Entry::generateAndStore($this->config->getDataDir(), $fileName, $realName, $mimeType);
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
		
		$filename = 'archive.zip';
		$tmpDirName = 'tozip_' . mt_rand(1000, 100000);
		$tmpArchivePath = '/tmp/' . $tmpDirName;
		
		mkdir($tmpArchivePath, 0777);
		
		exec("zip -r /tmp/mep " . $tmpArchivePath);
		
		
		// Build file list
		
		$elementsNum = count($uploadData['name']);
		error_log("elements: " . $elementsNum);
		
		
		
		foreach ($array as $file) {
			error_log(print_r($file, true));
			error_log("-----------------");
		}
	}
}