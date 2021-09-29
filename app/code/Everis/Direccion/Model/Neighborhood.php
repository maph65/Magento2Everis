<?php


namespace Everis\Direccion\Model;

use Magento\Framework\Model\AbstractModel;


class Neighborhood extends AbstractModel
{

    public function _construct()
    {
        $this->_init('Everis\Direccion\Model\Resource\Neighborhood');
    }

}
