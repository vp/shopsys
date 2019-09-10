<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\Form\Admin;

use Shopsys\FrameworkBundle\Component\Domain\DomainFacade;
use Shopsys\FrameworkBundle\Form\Admin\PromoCode\PromoCodeFormType;
use Shopsys\FrameworkBundle\Model\Customer\CustomerFacade;
use Shopsys\FrameworkBundle\Model\Pricing\Currency\CurrencyFacade;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;

class PromoCodeFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Currency\CurrencyFacade
     */
    private $currencyFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Component\Domain\DomainFacade
     */
    private $domainFacade;

    /**
     * PromoCodeFormTypeExtension constructor.
     *
     * @param \Shopsys\FrameworkBundle\Model\Pricing\Currency\CurrencyFacade $currencyFacade
     * @param \Shopsys\FrameworkBundle\Component\Domain\DomainFacade $domainFacade
     */
    public function __construct(
        CurrencyFacade $currencyFacade,
        DomainFacade $domainFacade
    ) {
        $this->currencyFacade = $currencyFacade;
        $this->domainFacade = $domainFacade;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('percent', IntegerType::class, [
                'required' => false,
            ]);
        $builder
            ->add('price', MoneyType::class, [
                'required' => false,
            ]);
        $builder
            ->add('currency', ChoiceType::class, [
                'required' => false,
                'choices' => $this->currencyFacade->getAll(),
                'choice_label' => 'name',
                'choice_value' => 'id',
            ]);
        $builder
            ->add('domain', ChoiceType::class, [
                'required' => false,
                'choices' => $this->domainFacade->getAllDomainConfigs(),
                'choice_label' => 'name',
                'choice_value' => 'id',
            ]);
        $builder
            ->add('customer', ChoiceType::class, [
                'required' => false,
            ]);
        $builder
            ->add('isTransport', CheckboxType::class, [
                'required' => false,
            ]);
        $builder
            ->add('repeatsLeft', IntegerType::class, [
                'required' => false,
            ]);
    }

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return PromoCodeFormType::class;
    }
}
