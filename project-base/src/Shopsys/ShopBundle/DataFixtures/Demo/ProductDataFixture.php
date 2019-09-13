<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\DataFixtures\Demo;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Shopsys\FrameworkBundle\Component\DataFixture\AbstractReferenceFixture;
use Shopsys\FrameworkBundle\Component\Domain\Domain;
use Shopsys\FrameworkBundle\Component\Money\Money;
use Shopsys\FrameworkBundle\Model\Pricing\Currency\CurrencyFacade;
use Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupFacade;
use Shopsys\FrameworkBundle\Model\Product\Parameter\Parameter;
use Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterDataFactory;
use Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterFacade;
use Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterValueDataFactory;
use Shopsys\FrameworkBundle\Model\Product\Parameter\ProductParameterValueDataFactory;
use Shopsys\ShopBundle\Model\Product\Product;
use Shopsys\ShopBundle\Model\Product\ProductData;
use Shopsys\FrameworkBundle\Model\Product\ProductDataFactoryInterface;
use Shopsys\FrameworkBundle\Model\Product\ProductFacade;
use Shopsys\FrameworkBundle\Model\Product\ProductVariantFacade;

class ProductDataFixture extends AbstractReferenceFixture implements DependentFixtureInterface
{
    public const PRODUCT_PREFIX = 'product_';

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\ProductFacade
     */
    protected $productFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\ProductVariantFacade
     */
    protected $productVariantFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Component\Domain\Domain
     */
    protected $domain;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupFacade
     */
    protected $pricingGroupFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\ProductDataFactoryInterface
     */
    protected $productDataFactory;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Currency\CurrencyFacade
     */
    protected $currencyFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\Parameter\ProductParameterValueDataFactory
     */
    protected $productParameterValueDataFactory;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterValueDataFactory
     */
    protected $parameterValueDataFactory;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterFacade
     */
    protected $parameterFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterDataFactory
     */
    protected $parameterDataFactory;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\Parameter\Parameter[]
     */
    protected $parameters;

    /**
     * @var int
     */
    protected $productNo = 1;

    /**
     * @var \Shopsys\ShopBundle\Model\Product\Product[]
     */
    protected $productsByCatnum = [];

    /**
     * @param \Shopsys\FrameworkBundle\Model\Product\ProductFacade $productFacade
     * @param \Shopsys\FrameworkBundle\Model\Product\ProductVariantFacade $productVariantFacade
     * @param \Shopsys\FrameworkBundle\Component\Domain\Domain $domain
     * @param \Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupFacade $pricingGroupFacade
     * @param \Shopsys\FrameworkBundle\Model\Product\ProductDataFactoryInterface $productDataFactory
     * @param \Shopsys\FrameworkBundle\Model\Pricing\Currency\CurrencyFacade $currencyFacade
     * @param \Shopsys\FrameworkBundle\Model\Product\Parameter\ProductParameterValueDataFactory $productParameterValueDataFactory
     * @param \Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterValueDataFactory $parameterValueDataFactory
     * @param \Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterFacade $parameterFacade
     * @param \Shopsys\FrameworkBundle\Model\Product\Parameter\ParameterDataFactory $parameterDataFactory
     */
    public function __construct(
        ProductFacade $productFacade,
        ProductVariantFacade $productVariantFacade,
        Domain $domain,
        PricingGroupFacade $pricingGroupFacade,
        ProductDataFactoryInterface $productDataFactory,
        CurrencyFacade $currencyFacade,
        ProductParameterValueDataFactory $productParameterValueDataFactory,
        ParameterValueDataFactory $parameterValueDataFactory,
        ParameterFacade $parameterFacade,
        ParameterDataFactory $parameterDataFactory
    ) {
        $this->productFacade = $productFacade;
        $this->productVariantFacade = $productVariantFacade;
        $this->domain = $domain;
        $this->pricingGroupFacade = $pricingGroupFacade;
        $this->productDataFactory = $productDataFactory;
        $this->currencyFacade = $currencyFacade;
        $this->productParameterValueDataFactory = $productParameterValueDataFactory;
        $this->parameterValueDataFactory = $parameterValueDataFactory;
        $this->parameterFacade = $parameterFacade;
        $this->parameterDataFactory = $parameterDataFactory;
    }

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        /** @var \Shopsys\ShopBundle\Model\Product\ProductData $productData */
        $productData = $this->productDataFactory->create();

        $productData->catnum = '9177759';
        $productData->partno = 'SLE 22F46DM4';
        $productData->ean = '8845781245930';

        foreach ($this->domain->getAllLocales() as $locale) {
            $productData->name[$locale] = t('22" Sencor SLE 22F46DM4 HELLO KITTY', [], 'dataFixtures', $locale);
        }

        foreach ($this->domain->getAllIncludingDomainConfigsWithoutDataCreated() as $domain) {
            $productData->descriptions[$domain->getId()] = t('Television LED, 55 cm diagonal, 1920x1080 Full HD, DVB-T MPEG4 tuner with USB recording and playback (DivX, XviD, MP3, WMA, JPEG), HDMI, SCART, VGA, pink execution, energ. Class B', [], 'dataFixtures', $domain->getLocale());
            $productData->shortDescriptions[$domain->getId()] = t('Television LED, 55 cm diagonal, 1920x1080 Full HD, DVB-T MPEG4 tuner with USB recording and playback', [], 'dataFixtures', $domain->getLocale());
        }

        $parameterTranslations = [];
        foreach ($this->domain->getAllLocales() as $locale) {
            $i = 0;

            $this->addParameterTranslations($parameterTranslations, t('Screen size', [], 'dataFixtures', $locale), t('27"', [], 'dataFixtures', $locale), $locale, $i);
            $this->addParameterTranslations($parameterTranslations, t('Technology', [], 'dataFixtures', $locale), t('LED', [], 'dataFixtures', $locale), $locale, $i);
            $this->addParameterTranslations($parameterTranslations, t('Resolution', [], 'dataFixtures', $locale), t('1920x1080 (Full HD)', [], 'dataFixtures', $locale), $locale, $i);
            $this->addParameterTranslations($parameterTranslations, t('USB', [], 'dataFixtures', $locale), t('Yes', [], 'dataFixtures', $locale), $locale, $i);
            $this->addParameterTranslations($parameterTranslations, t('HDMI', [], 'dataFixtures', $locale), t('Yes', [], 'dataFixtures', $locale), $locale, $i);
        }

        $this->addParametersByTranslations($productData, $parameterTranslations);
        $this->addPriceForAllPricingGroups($productData, '2891.7');

        $productData->vat = $this->persistentReferenceFacade->getReference(VatDataFixture::VAT_HIGH);
        $this->setSellingFrom($productData, '16.1.2000');
        $this->setSellingTo($productData, null);
        $productData->usingStock = true;
        $productData->stockQuantity = 300;
        $productData->outOfStockAction = Product::OUT_OF_STOCK_ACTION_HIDE;

        $this->addUnit($productData, UnitDataFixture::UNIT_PIECES);
        $this->setAvailability($productData, AvailabilityDataFixture::AVAILABILITY_IN_STOCK);
        $this->addCategoriesForAllDomains($productData, [CategoryDataFixture::CATEGORY_ELECTRONICS, CategoryDataFixture::CATEGORY_TV]);
        $this->addFlags($productData, [FlagDataFixture::FLAG_TOP_PRODUCT, FlagDataFixture::FLAG_ACTION_PRODUCT]);

        $productData->sellingDenied = false;
        $this->setBrand($productData, BrandDataFixture::BRAND_SENCOR);

        $this->createProduct($productData);

//        $this->createVariants();
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @return \Shopsys\ShopBundle\Model\Product\Product
     */
    protected function createProduct(ProductData $productData): Product
    {
        /** @var \Shopsys\ShopBundle\Model\Product\Product $product */
        $product = $this->productFacade->create($productData);

        $this->addProductReference($product);

        return $product;
    }

    /**
     * @return array
     */
    protected function getProductsRelations(): array
    {
        return [
            '9176544M' => [
                '9176544',
                '9176588',
            ],
            '32PFL4400' => [
                '9176554',
                '9176578',
            ],
            '7700769XCX' => [
                '7700777',
                '7700769Z',
            ],
        ];
    }

    protected function createVariants(): void
    {
        $variantCatnumsByMainVariantCatnum = $this->getProductsRelations();

        foreach ($variantCatnumsByMainVariantCatnum as $mainVariantCatnum => $variantsCatnums) {
            /** @var \Shopsys\ShopBundle\Model\Product\Product $mainProduct */
            $mainProduct = $this->productsByCatnum[$mainVariantCatnum];

            $variants = [];
            foreach ($variantsCatnums as $variantCatnum) {
                $variants[] = $this->productsByCatnum[$variantCatnum];
            }

            $mainVariant = $this->productVariantFacade->createVariant($mainProduct, $variants);
            $this->addProductReference($mainVariant);
        }
    }

    /**
     * @param string[] $parameterNamesByLocale
     * @return \Shopsys\FrameworkBundle\Model\Product\Parameter\Parameter
     */
    protected function findParameterByNamesOrCreateNew(array $parameterNamesByLocale): Parameter
    {
        $cacheId = json_encode($parameterNamesByLocale);

        if (isset($this->parameters[$cacheId])) {
            return $this->parameters[$cacheId];
        }

        $parameter = $this->parameterFacade->findParameterByNames($parameterNamesByLocale);

        if ($parameter === null) {
            $visible = true;
            $parameterData = $this->parameterDataFactory->create();
            $parameterData->name = $parameterNamesByLocale;
            $parameterData->visible = $visible;
            $parameter = $this->parameterFacade->create($parameterData);
        }

        $this->parameters[$cacheId] = $parameter;

        return $parameter;
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param array $parametersTranslations
     */
    protected function addParametersByTranslations(ProductData $productData, array $parametersTranslations): void
    {
        foreach ($parametersTranslations as $paramaterTranslations) {
            $parameter = $this->findParameterByNamesOrCreateNew($paramaterTranslations['names']);

            foreach ($paramaterTranslations['values'] as $locale => $parameterValue) {
                $productParameterValueData = $this->productParameterValueDataFactory->create();
                $parameterValueData = $this->parameterValueDataFactory->create();
                $parameterValueData->text = $parameterValue;
                $parameterValueData->locale = $locale;
                $productParameterValueData->parameterValueData = $parameterValueData;
                $productParameterValueData->parameter = $parameter;

                $productData->parameters[] = $productParameterValueData;
            }
        }
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param string $price
     */
    protected function addPriceForAllPricingGroups(ProductData $productData, string $price): void
    {
        foreach ($this->domain->getAllIncludingDomainConfigsWithoutDataCreated() as $domain) {
            foreach ($this->pricingGroupFacade->getByDomainId($domain->getId()) as $pricingGroup) {
                $currency = $this->currencyFacade->getDomainDefaultCurrencyByDomainId($domain->getId());

                $productData->manualInputPricesByPricingGroupId[$pricingGroup->getId()] = Money::create((string)($price / $currency->getExchangeRate()));
            }
        }
    }

    /**
     * @param array $parameterTranslations
     * @param string $parameterName
     * @param string $parameterValue
     * @param string $locale
     * @param int $i
     */
    protected function addParameterTranslations(array $parameterTranslations, string $parameterName, string $parameterValue, string $locale, int &$i): void
    {
        $parameterTranslations[$i]['names'][$locale] = $parameterName;
        $parameterTranslations[$i]['values'][$locale] = $parameterValue;

        $i++;
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param string[] $categoryReferences
     */
    protected function addCategoriesForAllDomains(ProductData $productData, array $categoryReferences): void
    {
        foreach ($this->domain->getAllIds() as $domainId) {
            foreach ($categoryReferences as $categoryReference) {
                $productData->categoriesByDomainId[$domainId][] = $this->persistentReferenceFacade->getReference($categoryReference);
            }
        }
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param string[] $flagReferences
     */
    protected function addFlags(ProductData $productData, array $flagReferences): void
    {
        if (count($flagReferences) > 0) {
            foreach ($flagReferences as $flagReference) {
                $productData->flags[] = $this->persistentReferenceFacade->getReference($flagReference);
            }
        }
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param string $unitReference
     */
    protected function addUnit(ProductData $productData, string $unitReference): void
    {
        $productData->unit = $this->persistentReferenceFacade->getReference($unitReference);
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param string $availabilityReference
     */
    protected function setAvailability(ProductData $productData, string $availabilityReference): void
    {
        $productData->availability = $this->persistentReferenceFacade->getReference($availabilityReference);
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param string|null $date
     */
    protected function setSellingFrom(ProductData $productData, ?string $date): void
    {
        $productData->sellingFrom = $date === null ? null : new DateTime($date);
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param string|null $date
     */
    protected function setSellingTo(ProductData $productData, ?string $date): void
    {
        $productData->sellingTo = $date === null ? null : new DateTime($date);
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductData $productData
     * @param string|null $brandReference
     */
    protected function setBrand(ProductData $productData, ?string $brandReference): void
    {
        $productData->brand = $brandReference === null ? null : $this->persistentReferenceFacade->getReference($brandReference);
    }

    public function addProductReference(Product $product)
    {
        $this->addReference(self::PRODUCT_PREFIX . $this->productNo, $product);
        $this->productsByCatnum[$product->getCatnum()] = $product;
        $this->productNo++;
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies(): array
    {
        return [
            VatDataFixture::class,
            AvailabilityDataFixture::class,
            CategoryDataFixture::class,
            BrandDataFixture::class,
            UnitDataFixture::class,
            PricingGroupDataFixture::class,
        ];
    }
}
