<?php

namespace app\models\Loggers;

class SearchLog
{
	protected $logFile;

	public function __construct($file)
	{
		$this->logFile = $file;

	}

	public function log($data)
	{

		file_put_contents($this->logFile, $data, FILE_APPEND);
	}
}
