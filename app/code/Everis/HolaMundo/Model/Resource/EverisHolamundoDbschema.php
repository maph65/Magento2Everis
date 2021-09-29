<?php


namespace Everis\HolaMundo\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class EverisHolamundoDbschema extends AbstractDb
{
    public function _construct()
    {
        $this->_init('everis_holamundo_dbschema','entity_id');
    }
}
