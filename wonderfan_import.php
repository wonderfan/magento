<?php 

class WonderFan_MyImport_Model_Import extends Mage_ImportExport_Model_Import
{

    public function uploadSource(){
     $uploader  = Mage::getModel('core/file_uploader', self::FIELD_NAME_SOURCE_FILE);
     $result    = $uploader->save(self::getWorkingDir());
     $this->_getSourceAdapter($sourceFile);
    }


}
