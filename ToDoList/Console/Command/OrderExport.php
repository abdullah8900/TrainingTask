<?php
declare(strict_types=1);

namespace RLTSquare\ToDoList\Console\Command;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class for Export Order at Flower shop
 */
class OrderExport extends Command
{
    /**
     * Constant variable for customer id
     */
    const ARG_CUSTOMER_ID = 'customer-id';
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $orderCollection;

    /**
     * @param CollectionFactory $orderCollection
     * @param string|null $name
     */
    public function __construct(
        CollectionFactory $orderCollection,
        string $name = null
    ) {
        parent::__construct($name);
        $this->orderCollection = $orderCollection;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('order-todoList:run')
            ->setDescription('Test Feature')
            ->addArgument(
                self::ARG_CUSTOMER_ID,
                InputArgument::REQUIRED,
                "Customer ID"
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customerId = (int)$input->getArgument(self::ARG_CUSTOMER_ID);
        $exportDetailsCollection = $this->orderCollection->create()
            ->addFieldToFilter('customer_id', $customerId);
        $output->writeln(print_r($exportDetailsCollection->getData(), true));
    }
}
