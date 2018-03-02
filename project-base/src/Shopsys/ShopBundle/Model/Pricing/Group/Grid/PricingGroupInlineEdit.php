<?php

namespace Shopsys\FrameworkBundle\Model\Pricing\Group\Grid;

use Shopsys\FrameworkBundle\Component\Domain\AdminDomainTabsFacade;
use Shopsys\FrameworkBundle\Component\Grid\InlineEdit\AbstractGridInlineEdit;
use Shopsys\FrameworkBundle\Form\Admin\Pricing\Group\PricingGroupFormType;
use Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupData;
use Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupFacade;
use Symfony\Component\Form\FormFactory;

class PricingGroupInlineEdit extends AbstractGridInlineEdit
{
    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupFacade
     */
    private $pricingGroupFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Component\Domain\AdminDomainTabsFacade
     */
    private $adminDomainTabsFacade;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    private $formFactory;

    public function __construct(
        PricingGroupGridFactory $pricingGroupGridFactory,
        PricingGroupFacade $pricingGroupFacade,
        AdminDomainTabsFacade $adminDomainTabsFacade,
        FormFactory $formFactory
    ) {
        parent::__construct($pricingGroupGridFactory);
        $this->pricingGroupFacade = $pricingGroupFacade;
        $this->adminDomainTabsFacade = $adminDomainTabsFacade;
        $this->formFactory = $formFactory;
    }

    /**
     * @param \Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupData $pricingGroupData
     * @return int
     */
    protected function createEntityAndGetId($pricingGroupData)
    {
        $pricingGroup = $this->pricingGroupFacade->create($pricingGroupData, $this->adminDomainTabsFacade->getSelectedDomainId());

        return $pricingGroup->getId();
    }

    /**
     * @param int $pricingGroupId
     * @param \Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupData $pricingGroupData
     */
    protected function editEntity($pricingGroupId, $pricingGroupData)
    {
        $this->pricingGroupFacade->edit($pricingGroupId, $pricingGroupData);
    }

    /**
     * @param int|null $pricingGroupId
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm($pricingGroupId)
    {
        $pricingGroupData = new PricingGroupData();

        if ($pricingGroupId !== null) {
            $pricingGroupId = (int)$pricingGroupId;
            $pricingGroup = $this->pricingGroupFacade->getById($pricingGroupId);
            $pricingGroupData->setFromEntity($pricingGroup);
        }

        return $this->formFactory->create(PricingGroupFormType::class, $pricingGroupData);
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return self::class;
    }
}
