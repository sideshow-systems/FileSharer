<?php
namespace de\sideshowsystems\filesharer;

use \Exception;
use \InvalidArgumentException;

use de\sideshowsystems\exception\IOException;

/**
 * An entry object represents a complete uploaded object information about name, file size, upload time, e.g.
 */
class Entry {
	const JSON_VERSION = 'version';
	const JSON_KEY = 'key';
	const JSON_REALNAME = 'realname';
	const JSON_FILESIZE = 'filesize';
	const JSON_MIMETYPE = 'mimetype';
	const JSON_UPLOADTIME = 'uploadtime';
	const JSON_MAXDOWNLOADS = 'maxdownloads';
	const JSON_LASTDATE = 'lastdate';
	const JSON_CONSUMERINFO = 'consumerinfo';
	const CURRENT_VERSION = '0.1';
	
	/**
	 * The version of this entry object.
	 * The version could be used to read files dependant on their version.
	 *
	 * @var versionnumber
	 */
	protected $version = self::CURRENT_VERSION;
	
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
	 * When set to a positive integer, the entry may be downloaded only n times.
	 * (This feature is not fully implemented at this time.)
	 *
	 * @var int
	 */
	protected $maxDownloads = null;
	
	/**
	 * When set to a valid timestamp, the last time the download will be accepted.
	 * (This feature is not fully implemented at this time.)
	 *
	 * @var timestamp
	 */
	protected $lastDate = null;
	
	/**
	 * The list consume operations.
	 *
	 * @var array
	 */
	protected $consumerInfo = array();

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
				if (empty($data[self::JSON_VERSION])) {
					throw new Exception("Version attribute is missing in entry data!");
				}
				switch ($data[self::JSON_VERSION]) {
					case self::CURRENT_VERSION:
						$result = new Entry($key, $data[self::JSON_REALNAME], $data[self::JSON_UPLOADTIME], $data[self::JSON_CONSUMERINFO]);
						break;
					default:
						throw new Exception("Unknown data format version " . $data[self::JSON_VERSION] . "!");
				}
			} else {
				throw new InvalidArgumentException("Invalid metadata content!");
			}
		} else {
			throw new InvalidArgumentException("Metadata file is not readable!");
		}
		
		return $result;
	}

	/**
	 *
	 * @param String $dataDir        	
	 * @param String $fileName        	
	 * @param String $realName        	
	 * @param String $mimeType        	
	 * @param timestamp $uploadTime        	
	 * @throws IOException
	 */
	public static function generateAndStore($dataDir, $fileName, $realName, $mimeType = null, $uploadTime = null) {
		if (is_file($fileName)) {
			if (empty($uploadTime)) {
				// assume now as upload time
				$uploadTime = time();
			}
			
			// generate hash key
			$fileSize = filesize($fileName);
			$key = md5($fileSize . '---' . $realName . '---' . $uploadTime);
			
			$entryDir = $dataDir . '/' . $key;
			$success = mkdir($entryDir);
			if ($success === false) {
				throw new IOException("Error: could not create directory " . $entryDir . "!");
			}
			
			// move content file
			$destination = $entryDir . '/content.bin';
			$success = move_uploaded_file($fileName, $destination);
			if ($success !== true) {
				throw new IOException("Error: uploaded file " . $fileName . " could not be moved to " . $destination . "!");
			}
			
			// write descriptor
			$entry = new Entry($key, $realName, $fileSize, $mimeType, $uploadTime);
			$metaDataContent = $entry->asJsonString();
			$descriptorFile = $entryDir . '/meta.json';
			$success = file_put_contents($descriptorFile, $metaDataContent);
			if ($success === false) {
				throw new IOException("Error: metadata descriptor could not be written!");
			}

			return $key;
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

	public function getMaxDownloads() {
		return $this->maxDownloads;
	}

	public function getLastDate() {
		return $this->lastDate;
	}

	public function getConsumerInfo() {
		return $this->consumerInfo;
	}

	protected function asJsonString() {
		return json_encode(array(
			self::JSON_VERSION => $this->version,
			self::JSON_KEY => $this->key,
			self::JSON_REALNAME => $this->realName,
			self::JSON_FILESIZE => $this->fileSize,
			self::JSON_MIMETYPE => $this->mimeType,
			self::JSON_UPLOADTIME => $this->uploadTime,
			self::JSON_MAXDOWNLOADS => $this->maxDownloads,
			self::JSON_LASTDATE => $this->lastDate,
			self::JSON_CONSUMERINFO => $this->consumerInfo
		));
	}
}