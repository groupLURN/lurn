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
		$originalFilesDb 	= count($project->projects_files) > 0 ? $project->projects_files : [];
		
		$duplicateKeys = [];
		for ($i = 0; $i < count($files['files']); $i++) {
			$fileInfo 		= pathinfo($files['files'][$i]['name']);
			$fileName 		= $fileInfo['filename'];
			$fileNameFull 	= $fileInfo['basename'];
			for ($j = 0; $j < count($files['files']); $j++) {
				if ($i < $j) {
					$fileInfo2 		= pathinfo($files['files'][$j]['name']);
					$fileName2 		= $fileInfo2['filename'];
					$fileNameFull2 	= $fileInfo2['basename'];

					if ($fileNameFull == $fileNameFull2) {
						array_push($duplicateKeys, $j);
					}			
				}
			}

		}

		foreach ($duplicateKeys as $duplicateKey) {
			unset($files['files'][$duplicateKey]);
		}

		if(isset($options['update']) && $options['update'])
		{
			$originalFiles 			= isset($options['uploaded_files']) 
				? $options['uploaded_files'] : [];
			$originalFilesLabels 	= isset($options['uploaded_file_labels']) 
				? $options['uploaded_file_labels'] : [];

			$deleteFromDb 	= $originalFiles;

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
						$fileId = $value;
						if (!in_array($fileDb->id, $deleteFromDb))
						{	
							$directory = $fileDb->file_location
								.$fileDb->file_name.'.'
								.$fileDb->file_type;

							$this->ProjectsFiles->delete($fileDb);
							unset($fileDb);
							$this->delete($directory);

							unset($originalFiles[$key]);
							unset($originalFilesLabels[$key]);
						}
					}
				}
			}

			foreach ($files['files'] as $file)
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

							$this->ProjectsFiles->delete($fileDb);
							unset($fileDb);
							$this->delete($directory);
						}
					}
				}
			}

			foreach ($originalFilesDb as $fileDb)
			{	
				if (count($originalFiles) != 0) 
				{
					foreach ($originalFiles as $key => $value)
					{	
						$file 		= $value;	
						$fileLabel 	= $originalFilesLabels[$key];
						if ($file == $fileDb->id && $fileDb->file_label != $fileLabel)
						{	
							$fileDb->file_label = $fileLabel;
							$this->ProjectsFiles->save($fileDb);
						}
					}
				}
			}
		}

		$i = 0;
		foreach ($files['files'] as $file) {
			if ($file['name'] === '') 
			{
				$this->Flash->error(__('One or more of the file inputs has no file to upload.'));
			} else if ($files['file_labels'][$i] === '') 
			{
				$this->Flash->error(__('One or more of the file inputs has no file label.'));
			}else 
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
					$projectFile->file_label = $files['file_labels'][$i];
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
			++$i;
		}
	}
}