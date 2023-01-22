<?php
declare(strict_types=1);

namespace RLTSquare\ToDoList\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Magento\Customer\Model\Group;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;


/**
 * class for add delivery note in checkout page
 */
class LayoutProcessorPlugin
{

    public const XML_PATH_CUSTOMER_GROUP = 'customer_group/general/ToDoList_customer_group';
    /**
     * @var Session
     */
    protected Session $_customerSession;
    /**
     * @var Group
     */
    protected Group $_customerGroupCollection;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;


    /**
     * @param Session $customerSession
     * @param Group $customerGroupCollection
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Session $customerSession,
        Group $customerGroupCollection,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_customerSession = $customerSession;
        $this->_customerGroupCollection = $customerGroupCollection;
        $this->scopeConfig = $scopeConfig;

    }

    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ) {
        $specific_group = $this->getCustomerGroupId();
        if ($this->getGroupId() == $specific_group) {
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['before-form']['children']['delivery_note'] = [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input',
                    'options' => [],
                    'id' => 'delivery_note'
                ],
                'dataScope' => 'shippingAddress.delivery_note',
                'label' => __('Delivery Date'),
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 200,
                'id' => 'delivery_note'
            ];

            return $jsLayout;
        }
        return $jsLayout;
    }

    /**
     * @return mixed
     */
    public function getCustomerGroupId()
    {
        $customerGroupId = $this->scopeConfig->getValue(self::XML_PATH_CUSTOMER_GROUP);
        return $customerGroupId;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        $this->_customerSession->isLoggedIn();
        //Get current group
        return $this->_customerSession->getCustomer()->getGroupId();
    }

}
