<?php
namespace App\Controller\Component;

use App\Utility\FileConstants;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ProjectComponent extends Component
{
	public $components = ['Flash'];

	public function initialize(array $config)
	{
		$this->Projects = TableRegistry::get('Projects');
		$this->ProjectsFiles = TableRegistry::get('ProjectsFiles');
	}

	private function delete($dir) 
	{
		$dir = WWW_ROOT.$dir;

	   	// $files = array_diff(scandir($dir), array('.','..'));

	    // foreach ($files as $file) {
	    //   (is_dir($dir.DS.$file)) ? $this->delete($dir.DS.$file) : unlink($dir.DS.$file);
	    // }

	    // return rmdir($dir);
	    if (file_exists($dir))
	    {
			chmod($dir, 0644);
		    return unlink($dir);
	    }

	    return true;
	} 

	public function uploadFiles($files = [], $project = null, $options = [])
	{
		$originalFilesDb 	= $project->projects_files;
		if(isset($options['update']) && $options['update'])
		{
			$originalFiles 	= isset($options['uploaded_files']) ? $options['uploaded_files'] : [];

			$deleteFromDb 			= $originalFiles;

			foreach ($deleteFromDb as $key => $value)
			{	
				$file = $value;	
				foreach ($originalFilesDb as $fileDb)
				{					
					if ($file == $fileDb->id)
					{	
						unset($deleteFromDb[$key]);
					}
				}	
			}

			foreach ($originalFilesDb as $fileDb)
			{	
				if (count($originalFiles) === 0) 
				{
					$directory = $fileDb->file_location
						.$fileDb->file_name.'.'
						.$fileDb->file_type;
					$this->ProjectsFiles->delete($fileDb);
					unset($fileDb);
					$this->delete($directory);
				} else 
				{
					foreach ($deleteFromDb as $key => $value)
					{	
						$file = $value;			
						if ($file == $fileDb->id)
						{	
							$directory = $fileDb->file_location
								.$fileDb->file_name.'.'
								.$fileDb->file_type;
							$this->ProjectsFiles->delete($fileDb);
							unset($fileDb);
							$this->delete($directory);
						}
					}
				}
			}

			foreach ($files as $file)
			{	
				if ($file['name'] != '') 
				{
					$fileInfo 		= pathinfo($file['name']);
					$fileName 		= $fileInfo['filename'];
					$fileNameFull 	= $fileInfo['basename'];
					$fileTemp 		= $file['tmp_name'];
					$fileType 		= $fileInfo['extension'];

					foreach ($originalFilesDb as $fileDb)
					{
						if ($fileDb->file_name == $fileName)
						{	
							$directory = $fileDb->file_location
								.$fileDb->file_name.'.'
								.$fileDb->file_type;
							unset($fileDb);
							$this->delete($directory);
						}
					}
				}
			}
		}

		foreach ($files as $file) {
			if ($file['name'] != '') 
			{
				$fileInfo 		= pathinfo($file['name']);
				$fileName 		= $fileInfo['filename'];
				$fileNameFull 	= $fileInfo['basename'];
				$fileTemp 		= $file['tmp_name'];
				$fileType 		= $fileInfo['extension'];
				$fileLocation	= '';

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

				$fileLocation .= 'projects/'.$project->id.'/';

				if (!file_exists($fileLocation)) {
					mkdir($fileLocation, 0777, true);
				}

				if (move_uploaded_file($fileTemp,$fileLocation.$fileNameFull)) {
					$projectFile = $this->ProjectsFiles->newEntity();
					$projectFile->project_id = $project->id;
					$projectFile->file_label = $fileName;
					$projectFile->file_name = $fileName;
					$projectFile->file_location = $fileLocation;
					$projectFile->file_type = $fileType;
					$save = true;

					foreach ($originalFilesDb as $fileDb)
					{	
						if (count($fileDb->file_name === $fileName) === 0) 
						{
							$save = false;
						} 
					}	

					if ($save) 
					{
						$this->ProjectsFiles->save($projectFile);
					}
				} else {
					$this->Flash->error(__($filenameFull.' cannot be uploaded.'));
				}
			}
		}
	}
}