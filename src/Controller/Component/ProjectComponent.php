<?php
namespace App\Controller\Component;

use App\Utility\FileConstants;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ProjectComponent extends Component
{
	public $components = [];

	public function initialize(array $config)
	{
		$this->Projects = TableRegistry::get('Projects');
		$this->ProjectsFiles = TableRegistry::get('ProjectsFiles');
	}

	private function delete($dir) {
		$dir = WWW_ROOT.$dir;

	   	$files = array_diff(scandir($dir), array('.','..'));

	    foreach ($files as $file) {
	      (is_dir($dir.DS.$file)) ? $this->delete($dir.DS.$file) : unlink($dir.DS.$file);
	    }

	    return rmdir($dir);
	} 

	public function uploadFiles($files = [], $project = null, $options = [])
	{
		if(isset($options['update']) && $options['update'])
		{			
			$originalFiles = $this->ProjectsFiles->find('byProjectId', ['project_id' => $project->id])->toArray();
			$fileLocation	= FileConstants::FILEIMAGESTORAGE.'projects'.DS.$project->id;
			if (file_exists($fileLocation)) {
				$this->delete($fileLocation);
			}

			$fileLocation	= FileConstants::FILEDOCSTORAGE.'projects'.DS.$project->id;
			if (file_exists($fileLocation)) {
				$this->delete($fileLocation);
			}
			
			$fileLocation	= FileConstants::FILEMISCSTORAGE.'projects'.DS.$project->id;
			if (file_exists($fileLocation)) {
				$this->delete($fileLocation);
			}
			
		}

		foreach ($files as $file) {
			$fileInfo 		= pathinfo($file['name']);
			$fileName 		= $fileInfo['filename'];
			$fileNameFull 	= $fileInfo['basename'];
			$fileTemp 		= $file['tmp_name'];
			$fileType 		= $fileInfo['extension'];
			$fileLocation		= '';

			switch ($fileType) {
				case 'bmp':
				case 'gif':
				case 'ico':
				case 'jpeg':
				case 'jpg':
				case 'png':
					$fileLocation	= FileConstants::FILEIMAGESTORAGE;
					break;
				case 'calc':
				case 'doc':
				case 'docx':
				case 'pdf':
				case 'ppt':
				case 'xls':
				case 'xlsx':
					$fileLocation	= FileConstants::FILEDOCSTORAGE;
					break;
				
				default:
					$fileLocation	= FileConstants::FILEMISCSTORAGE;
					break;
			}

			$fileLocation .= 'projects'.DS.$project->id.DS;

			if (!file_exists($fileLocation)) {
				mkdir($fileLocation, 0777, true);
			}

			if (move_uploaded_file($fileTemp,$fileLocation.$fileNameFull)) {
				$projectFile = $this->ProjectsFiles->newEntity();
				$projectFile->project_id = $project->id;
				$projectFile->file_name = $fileName;
				$projectFile->file_location = $fileLocation;
				$projectFile->file_type = $fileType;

				$this->ProjectsFiles->save($projectFile);
			} else {
				$this->Flash->error(__($filenameFull.' cannot be uploaded.'));
			}
		}
	}
}