<?php

namespace Shopsys\FrameworkBundle\Twig;

use CommerceGuys\Intl\Formatter\NumberFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepositoryInterface;
use Shopsys\FrameworkBundle\Model\Localization\Localization;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NumberFormatterExtension extends AbstractExtension
{
    /** @access protected */
    const MINIMUM_FRACTION_DIGITS = 0;
    /** @access protected */
    const MAXIMUM_FRACTION_DIGITS = 10;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Localization\Localization
     */
    private $localization;

    /**
     * @var \CommerceGuys\Intl\NumberFormat\NumberFormatRepositoryInterface
     */
    private $numberFormatRepository;

    /**
     * @param \Shopsys\FrameworkBundle\Model\Localization\Localization $localization
     * @param \CommerceGuys\Intl\NumberFormat\NumberFormatRepositoryInterface $numberFormatRepository
     */
    public function __construct(
        Localization $localization,
        NumberFormatRepositoryInterface $numberFormatRepository
    ) {
        $this->localization = $localization;
        $this->numberFormatRepository = $numberFormatRepository;
    }

    /**
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter(
                'formatNumber',
                [$this, 'formatNumber']
            ),
            new TwigFilter(
                'formatDecimalNumber',
                [$this, 'formatDecimalNumber']
            ),
            new TwigFilter(
                'formatPercent',
                [$this, 'formatPercent']
            ),
        ];
    }

    /**
     * @param mixed $number
     * @param string|null $locale
     * @return string
     */
    public function formatNumber($number, $locale = null)
    {
        $numberFormat = $this->numberFormatRepository->get($this->getLocale($locale));
        $numberFormatter = new NumberFormatter($numberFormat, NumberFormatter::DECIMAL);
        $numberFormatter->setMinimumFractionDigits(static::MINIMUM_FRACTION_DIGITS);
        $numberFormatter->setMaximumFractionDigits(static::MAXIMUM_FRACTION_DIGITS);

        return $numberFormatter->format($number);
    }

    /**
     * @param mixed $number
     * @param int $minimumFractionDigits
     * @param string|null $locale
     * @return string
     */
    public function formatDecimalNumber($number, $minimumFractionDigits, $locale = null)
    {
        $numberFormat = $this->numberFormatRepository->get($this->getLocale($locale));
        $numberFormatter = new NumberFormatter($numberFormat, NumberFormatter::DECIMAL);
        $numberFormatter->setMinimumFractionDigits($minimumFractionDigits);
        $numberFormatter->setMaximumFractionDigits(static::MAXIMUM_FRACTION_DIGITS);

        return $numberFormatter->format($number);
    }

    /**
     * @param mixed $number
     * @param string|null $locale
     * @return string
     */
    public function formatPercent($number, $locale = null)
    {
        $numberFormat = $this->numberFormatRepository->get($this->getLocale($locale));
        $numberFormatter = new NumberFormatter($numberFormat, NumberFormatter::PERCENT);
        $numberFormatter->setMinimumFractionDigits(static::MINIMUM_FRACTION_DIGITS);
        $numberFormatter->setMaximumFractionDigits(static::MAXIMUM_FRACTION_DIGITS);

        return $numberFormatter->format($number);
    }

    /**
     * @param string|null $locale
     * @return string
     */
    private function getLocale($locale = null)
    {
        if ($locale === null) {
            $locale = $this->localization->getLocale();
        }

        return $locale;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'number_formatter_extension';
    }
}
