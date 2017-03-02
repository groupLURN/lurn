<?php
namespace App\Utility;

class FileConstants
{
	const FILESTORAGEPATH = 'uploads'.DS;
	const FILEIMAGESTORAGE = FileConstants::FILESTORAGEPATH.'img'.DS;
	const FILEDOCSTORAGE = FileConstants::FILESTORAGEPATH.'doc'.DS;
	const FILEMISCSTORAGE = FileConstants::FILESTORAGEPATH.'misc'.DS;
}