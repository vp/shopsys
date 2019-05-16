<?php

namespace Shopsys\FrameworkBundle\Twig;

use Shopsys\FrameworkBundle\Component\Css\CssFacade;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CssExtension extends AbstractExtension
{
    /**
     * @var \Shopsys\FrameworkBundle\Component\Css\CssFacade
     */
    private $cssFacade;

    /**
     * @param \Shopsys\FrameworkBundle\Component\Css\CssFacade $cssFacade
     */
    public function __construct(CssFacade $cssFacade)
    {
        $this->cssFacade = $cssFacade;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('getCssVersion', [$this, 'getCssVersion']),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'css';
    }

    /**
     * @return string
     */
    public function getCssVersion()
    {
        return $this->cssFacade->getCssVersion();
    }
}
