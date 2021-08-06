<?php 

class AltfolderStorage implements StorageController
{
    function isEnabled()
    {
        return (defined('ALT_FOLDER') && ALT_FOLDER && is_dir(ALT_FOLDER));
    }
    
    function hashExists($hash)
    {
        $altname=ALT_FOLDER.DS.$hash;
		return file_exists($altname);
    }

    function getItems($dev=false)
    {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ALT_FOLDER.DS));
        $files = array(); 

        foreach ($rii as $file) {
            if ($file->isDir())
                continue;
            $files[] = $file->getFilename(); 
        }

        return $files;
    }

    function pullFile($hash,$location)
    {
	// Have the puller grab the original folder/file structure instead of just files. 
        $altname=ALT_FOLDER.DS.$hash.DS.$hash;
		if(file_exists($altname))
		{
            copy($altname,$location);
		}
    }

    function pushFile($source,$hash)
    {
	// We don't want to push. Other jobs handle this 
        //$altname=ALT_FOLDER.DS.$hash;
	//	if(!$this->hashExists($hash))
	//	{
        //   copy($source,$altname);
        //    return true;
        //}
        
        return false;
    }

    function deleteFile($hash)
    {
        $altname=ALT_FOLDER.DS.$hash;
		if(file_exists($altname))
		{
			unlink($altname);
		}
    }
}
