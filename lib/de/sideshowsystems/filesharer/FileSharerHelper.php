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

	protected function ensureWritable() {
		if (! is_dir($this->config->getDataDir()) || ! is_writable($this->config->getDataDir())) {
			throw new IOException("Error: data directory " . $this->config->getDataDir() . " is not writable!");
		}
	}
}