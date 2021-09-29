<?php


namespace Everis\HolaMundo\Model;

use Magento\Framework\Model\AbstractModel;


class EverisHolamundoDbschema extends AbstractModel
{

    public function _construct()
    {
        $this->_init('Everis\HolaMundo\Model\Resource\EverisHolamundoDbschema');
    }

}
