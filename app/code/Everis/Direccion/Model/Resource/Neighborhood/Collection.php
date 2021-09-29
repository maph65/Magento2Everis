<?php

namespace Everis\Direccion\Model\Resource\Neighborhood;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            'Everis\Direccion\Model\Neighborhood',
            'Everis\Direccion\Model\Resource\Neighborhood');
    }
}
