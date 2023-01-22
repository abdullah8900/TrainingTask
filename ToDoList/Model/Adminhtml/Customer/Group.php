<?php
declare(strict_types=1);

namespace RLTSquare\ToDoList\Model\Adminhtml\Customer;

use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class for get customer groups
 */
class Group implements OptionSourceInterface
{

    protected $options;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $_groupCollectionFactory;

    /**
     * @param CollectionFactory $groupCollectionFactory
     */
    public function __construct(CollectionFactory $groupCollectionFactory)
    {
        $this->_groupCollectionFactory = $groupCollectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        if (!$this->options) {
            $this->options = $this->_groupCollectionFactory->create()->loadData()->toOptionArray();
        }
        return $this->options;
    }
}
