<?php

declare(strict_types=1);

namespace Tests\ShopBundle\Test\Codeception\Helper;

use Codeception\Module;
use Codeception\TestInterface;
use CommerceGuys\Intl\Currency\CurrencyRepositoryInterface;
use CommerceGuys\Intl\Formatter\NumberFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Shopsys\FrameworkBundle\Component\CurrencyFormatter\CurrencyFormatterFactory;
use Shopsys\FrameworkBundle\Component\Domain\Domain;
use Shopsys\FrameworkBundle\Component\Money\Money;
use Shopsys\FrameworkBundle\Component\Router\DomainRouterFactory;
use Shopsys\FrameworkBundle\Model\Localization\Localization;
use Shopsys\FrameworkBundle\Model\Pricing\Currency\CurrencyFacade;
use Shopsys\FrameworkBundle\Model\Pricing\PriceConverter;
use Shopsys\FrameworkBundle\Model\Pricing\Rounding;
use Shopsys\FrameworkBundle\Model\Product\Unit\UnitFacade;
use Shopsys\FrameworkBundle\Twig\NumberFormatterExtension;
use Tests\ShopBundle\Test\Codeception\Module\StrictWebDriver;

class LocalizationHelper extends Module
{
    /**
     * @var \Shopsys\FrameworkBundle\Model\Localization\Localization
     */
    private $localization;

    /**
     * @var \Shopsys\FrameworkBundle\Component\Domain\Domain
     */
    private $domain;

    /**
     * @var \Shopsys\FrameworkBundle\Component\Router\DomainRouterFactory
     */
    private $domainRouterFactory;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Currency\CurrencyFacade
     */
    private $currencyFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Component\CurrencyFormatter\CurrencyFormatterFactory
     */
    private $currencyFormatterFactory;

    /**
     * @var \CommerceGuys\Intl\Currency\CurrencyRepositoryInterface
     */
    private $intlCurrencyRepository;

    /**
     * @var \Tests\ShopBundle\Test\Codeception\Module\StrictWebDriver
     */
    private $webDriver;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\Unit\UnitFacade
     */
    private $unitFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Twig\NumberFormatterExtension
     */
    private $numberFormatterExtension;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\PriceConverter
     */
    private $priceConverter;

    /**
     * @var \CommerceGuys\Intl\Formatter\NumberFormatter
     */
    private $numberFormatter;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Rounding
     */
    private $rounding;

    /**
     * @param \Codeception\TestInterface $test
     */
    public function _before(TestInterface $test): void
    {
        /** @var \Tests\ShopBundle\Test\Codeception\Helper\SymfonyHelper $symfonyHelper */
        $symfonyHelper = $this->getModule(SymfonyHelper::class);
        /** @var \Tests\ShopBundle\Test\Codeception\Module\StrictWebDriver $strictWebDriver */
        $strictWebDriver = $this->getModule(StrictWebDriver::class);
        $this->webDriver = $strictWebDriver;
        $this->localization = $symfonyHelper->grabServiceFromContainer(Localization::class);
        $this->domain = $symfonyHelper->grabServiceFromContainer(Domain::class);
        $this->domainRouterFactory = $symfonyHelper->grabServiceFromContainer(DomainRouterFactory::class);
        $this->currencyFacade = $symfonyHelper->grabServiceFromContainer(CurrencyFacade::class);
        $this->currencyFormatterFactory = $symfonyHelper->grabServiceFromContainer(CurrencyFormatterFactory::class);
        $this->intlCurrencyRepository = $symfonyHelper->grabServiceFromContainer(CurrencyRepositoryInterface::class);
        $this->unitFacade = $symfonyHelper->grabServiceFromContainer(UnitFacade::class);
        $this->numberFormatterExtension = $symfonyHelper->grabServiceFromContainer(NumberFormatterExtension::class);
        $this->priceConverter = $symfonyHelper->grabServiceFromContainer(PriceConverter::class);
        $this->numberFormatter = new NumberFormatter(new NumberFormatRepository());
        $this->rounding = $symfonyHelper->grabServiceFromContainer(Rounding::class);
    }

    /**
     * @param string $id
     * @param string $domain
     * @param array $parameters
     */
    public function seeTranslationFrontend(string $id, string $domain = 'messages', array $parameters = []): void
    {
        $translatedMessage = t($id, $parameters, $domain, $this->getFrontendLocale());
        $this->webDriver->see(strip_tags($translatedMessage));
    }

    /**
     * @param string $id
     * @param string $domain
     * @param array $parameters
     */
    public function dontSeeTranslationFrontend(string $id, string $domain = 'messages', array $parameters = []): void
    {
        $translatedMessage = t($id, $parameters, $domain, $this->getFrontendLocale());
        $this->webDriver->dontSee(strip_tags($translatedMessage));
    }

    /**
     * @param string $id
     * @param string $domain
     * @param array $parameters
     */
    public function seeTranslationAdmin(string $id, string $domain = 'messages', array $parameters = []): void
    {
        $translatedMessage = t($id, $parameters, $domain, $this->getAdminLocale());
        $this->webDriver->see(strip_tags($translatedMessage));
    }

    /**
     * @param string $id
     * @param string $css
     * @param string $domain
     * @param array $parameters
     */
    public function seeTranslationAdminInCss(string $id, string $css, string $domain = 'messages', array $parameters = []): void
    {
        $translatedMessage = t($id, $parameters, $domain, $this->getAdminLocale());
        $this->webDriver->seeInCss(strip_tags($translatedMessage), $css);
    }

    /**
     * @param string $id
     * @param string $domain
     * @param array $parameters
     * @param \Facebook\WebDriver\WebDriverBy|\Facebook\WebDriver\WebDriverElement|null $contextSelector
     */
    public function clickByTranslationAdmin(string $id, string $domain = 'messages', array $parameters = [], $contextSelector = null): void
    {
        $translatedMessage = t($id, $parameters, $domain, $this->getAdminLocale());
        $this->webDriver->clickByText(strip_tags($translatedMessage), $contextSelector);
    }

    /**
     * @param string $id
     * @param string $domain
     * @param array $parameters
     * @param \Facebook\WebDriver\WebDriverBy|\Facebook\WebDriver\WebDriverElement|null $contextSelector
     */
    public function clickByTranslationFrontend(string $id, string $domain = 'messages', array $parameters = [], $contextSelector = null): void
    {
        $translatedMessage = t($id, $parameters, $domain, $this->getFrontendLocale());
        $this->webDriver->clickByText(strip_tags($translatedMessage), $contextSelector);
    }

    /**
     * @param string $id
     * @param string $domain
     * @param array $parameters
     */
    public function checkOptionByLabelTranslationFrontend(string $id, string $domain = 'messages', array $parameters = []): void
    {
        $translatedMessage = t($id, $parameters, $domain, $this->getFrontendLocale());
        $this->webDriver->checkOptionByLabel($translatedMessage);
    }

    /**
     * @return string
     */
    public function getAdminLocale(): string
    {
        return $this->localization->getAdminLocale();
    }

    /**
     * @return string
     */
    public function getFrontendLocale(): string
    {
        return $this->domain->getDomainConfigById(1)->getLocale();
    }

    /**
     * @param string $routeName
     * @param array $parameters
     * @return string
     */
    private function getLocalizedPathOnFirstDomainByRouteName(string $routeName, array $parameters = []): string
    {
        $router = $this->domainRouterFactory->getRouter(1);

        return $router->generate($routeName, $parameters);
    }

    /**
     * @param string $routeName
     * @param array $parameters
     */
    public function amOnLocalizedRoute(string $routeName, array $parameters = [])
    {
        $this->webDriver->amOnPage($this->getLocalizedPathOnFirstDomainByRouteName($routeName, $parameters));
    }

    /**
     * Inspired by formatCurrency() method, {@see \Shopsys\FrameworkBundle\Twig\PriceExtension}
     * @param \Shopsys\FrameworkBundle\Component\Money\Money $price
     * @return string
     */
    public function getFormattedPriceWithCurrencySymbolOnFrontend(Money $price): string
    {
        $firstDomainDefaultCurrency = $this->currencyFacade->getDomainDefaultCurrencyByDomainId(1);
        $firstDomainLocale = $this->getFrontendLocale();
        $currencyFormatter = $this->currencyFormatterFactory->create($firstDomainLocale);

        $intlCurrency = $this->intlCurrencyRepository->get($firstDomainDefaultCurrency->getCode(), $firstDomainLocale);

        $formattedPriceWithCurrencySymbol = $currencyFormatter->format(
            $this->rounding->roundPriceWithVat($price)->getAmount(),
            $intlCurrency->getCurrencyCode()
        );

        return $this->normalizeSpaces($formattedPriceWithCurrencySymbol);
    }

    /**
     * Inspired by formatCurrency() method, {@see \Shopsys\FrameworkBundle\Twig\PriceExtension}
     * @param \Shopsys\FrameworkBundle\Component\Money\Money $price
     * @return string
     */
    public function getFormattedPriceOnFrontend(Money $price): string
    {
        $firstDomainDefaultCurrency = $this->currencyFacade->getDomainDefaultCurrencyByDomainId(1);
        $firstDomainLocale = $this->getFrontendLocale();
        $currencyFormatter = $this->currencyFormatterFactory->create($firstDomainLocale);

        $intlCurrency = $this->intlCurrencyRepository->get($firstDomainDefaultCurrency->getCode(), $firstDomainLocale);

        $formattedPriceWithCurrencySymbol = $currencyFormatter->format(
            $this->rounding->roundPriceWithVat($price)->getAmount(),
            $intlCurrency->getCurrencyCode()
        );

        return $this->normalizeSpaces($formattedPriceWithCurrencySymbol);
    }

    /**
     * @return string
     */
    public function getDefaultUnitName(): string
    {
        return $this->unitFacade->getDefaultUnit()->getName($this->getFrontendLocale());
    }

    /**
     * @param string $number
     * @return string
     */
    public function getFormattedPercentAdmin(string $number): string
    {
        $formattedNumberWithPercentSymbol = $this->numberFormatterExtension->formatPercent($number, $this->getAdminLocale());

        return $this->normalizeSpaces($formattedNumberWithPercentSymbol);
    }

    /**
     * It is not possible to use this method for converting total prices of an order or in cart (because of the price calculation)
     * @param string $price
     * @return string
     */
    public function getPriceWithVatConvertedToDomainDefaultCurrency(string $price): string
    {
        $money = $this->priceConverter->convertPriceWithVatToPriceInDomainDefaultCurrency(Money::create($price), 1);

        return $money->getAmount();
    }

    /**
     * The output of the CurrencyFormatter::format() method may contain non-breaking spaces that are not recognized by Codeception
     * so we need to replace them with regular spaces here.
     * See https://stackoverflow.com/questions/12837682/non-breaking-utf-8-0xc2a0-space-and-preg-replace-strange-behaviour
     *
     * @param string $text
     * @return string
     */
    private function normalizeSpaces(string $text): string
    {
        return preg_replace('~\x{00a0}~siu', ' ', $text);
    }

    /**
     * @param string $number
     * @param string $locale
     * @return string
     */
    public function getNumberFromLocalizedFormat(string $number, string $locale): string
    {
        return $this->numberFormatter->parse($number, ['locale' => $locale]);
    }
}
