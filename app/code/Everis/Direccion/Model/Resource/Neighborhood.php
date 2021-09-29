<?php
namespace Everis\Direccion\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Neighborhood extends AbstractDb
{
    public function _construct()
    {
        $this->_init('everis_neighborhood_by_cp','entity_id');
    }
}
