<?php
namespace de\sideshowsystems\filesharer;

class FileSharerHelper {

	private $config;

	public function __construct(FileSharerConfig $config) {
		$this->config = $config;
	}

	public function consumeUpload($fileName, $realname, $mimeType = null) {
		$result = null;
		
		$this->ensureWritable();
		
		if (is_file($fileName)) {
			$result = Entry :: generateAndStore($this->config->getDataDir(), $fileName, $realName, $mimeType);
		}
		
		return $result;
	}

	protected function ensureWritable() {
		if (! is_dir($this->config->getDataPath()) || ! is_writable($this->config->getDataPath())) {
			throw new \RuntimeException("Error: data directory " . $this->config->getDataPath() . " is not writable!");
		}
	}
}