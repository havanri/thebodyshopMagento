<?php

namespace SnaptecHue\Snaptec\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Filesystem\Io\File;
class Brand extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('snaptechue_snaptec_brand', 'brand_id');
    }
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $image = $object->getData('image');
        if ($image != null) {
            // $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get('SnaptecHue\Snaptec\BrandImageUpload');
            // $imageUploader->moveFileFromTmp($image);
            $file = new File();
            $sourcePath = 'pub/media/brand/tmp/images/' . $image;
            $destinationPath = 'pub/media/brand/images/' . $image;
            $file->cp($sourcePath, $destinationPath);
            // $file->rm($sourcePath);
        }
        return $this;
    }
}
