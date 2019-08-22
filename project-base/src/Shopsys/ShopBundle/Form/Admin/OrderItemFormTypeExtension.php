<?php

namespace Shopsys\ShopBundle\Form\Admin;

use Shopsys\FrameworkBundle\Form\Admin\Order\OrderItemFormType;
use Shopsys\ShopBundle\Model\Order\Item\OrderItemData;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class OrderItemFormTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('randomColumn', TextType::class, [
            'constraints' => [
                new Constraints\Length(['max' => 32]),
            ],
            'error_bubbling' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('data_class', OrderItemData::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return OrderItemFormType::class;
    }
}
