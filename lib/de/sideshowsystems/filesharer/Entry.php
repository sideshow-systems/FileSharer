<?php
namespace de\sideshowsystems\filesharer;

/**
 * An immutable entry object represents a complete uploaded object information about name, file size, upload time, e.g.
 */
class Entry {
	const JSON_KEY = 'key';
	const JSON_REALNAME = 'realname';
	const JSON_FILESIZE = 'filesize';
	const JSON_MIMETYPE = 'mimetype';
	const JSON_UPLOADTIME = 'uploadtime';
	const JSON_CONSUMERINFO = 'consumerinfo';
	
	/**
	 * Key where the entry is stored.
	 *
	 * @var String
	 */
	protected $key;
	
	/**
	 * The real name of the file.
	 *
	 * @var String
	 */
	protected $realName;
	
	/**
	 * The size of the file.
	 *
	 * @var int
	 */
	protected $fileSize;
	
	/**
	 * The mime type of the file.
	 *
	 * @var String
	 */
	protected $mimeType;
	
	/**
	 * When the file was uploaded.
	 *
	 * @var timestamp
	 */
	protected $uploadTime;
	
	/**
	 * The list consume operations.
	 *
	 * @var array
	 */
	protected $consumerInfo;

	/**
	 * Load an entry by key.
	 *
	 * @param String $dataDir
	 * @param String $key
	 * @throws \InvalidArgumentException
	 * @return \de\sideshowsystems\filesharer\Entry
	 */
	public static function loadFromKey($dataDir, $key) {
		$result = null;
		$contentFile = $dataDir . '/' . $key;
		
		if (file_exists($contentFile) && is_readable($contentFile)) {
			$content = file_get_contents($contentFile);
			if (! empty($content)) {
				$data = json_decode($content, true);
				$result = new Entry($key, $data[self::JSON_REALNAME], $data[self::JSON_UPLOADTIME], $data[self::JSON_CONSUMERINFO]);
			} else {
				throw new \InvalidArgumentException("Invalid metadata content!");
			}
		} else {
			throw new \InvalidArgumentException("Metadata file is not readable!");
		}
		
		return $result;
	}

	public static function generateAndStore($dataDir, $fileName, $realName, $mimeType = null, $uploadTime = null) {
		if (is_file($fileName)) {
			if (empty($uploadTime)) {
				// assume now as upload time
				$uploadTime = time();
			}
			
			// generate hash key
			$fileSize = filesize($fileName);
			$key = md5($fileSize . "---" . $realName . "---" . $uploadTime);
			
			$entry = new Entry($key, $realName, $fileSize, $mimeType, $uploadTime);
			$metaDataContent = $entry->asJsonString();
		}
	}

	public function __construct($key, $realName, $fileSize, $mimeType, $uploadTime, array $consumerInfo = null) {
		$this->key = $key;
		$this->realName = $realName;
		$this->fileSize = $fileSize;
		$this->mimeType = $mimeType;
		$this->uploadTime = $uploadTime;
		$this->consumerInfo = $consumerInfo;
	}

	public function getKey() {
		return $this->key;
	}

	public function getRealName() {
		return $this->realName;
	}

	public function getFileSize() {
		return $this->fileSize;
	}

	public function getMimeType() {
		return $this->mimeType;
	}

	public function getUploadTime() {
		return $this->uploadTime;
	}

	public function getConsumerInfo() {
		return $this->consumerInfo;
	}

	protected function asJsonString() {
		return json_encode(array(
			self::JSON_KEY => $this->key,
			self::JSON_REALNAME => $this->realName,
			self::JSON_FILESIZE => $this->fileSize,
			self::JSON_MIMETYPE => $this->mimeType,
			self::JSON_UPLOADTIME => $this->uploadTime,
			self::JSON_CONSUMERINFO => $this->consumerInfo
		));
	}
}