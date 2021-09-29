<?php


namespace Everis\HolaMundo\Model\Resource\EverisHolamundoDbschema;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            'Everis\HolaMundo\Model\EverisHolamundoDbschema',
            'Everis\HolaMundo\Model\Resource\EverisHolaMundoDbschema');
    }
}
