<?php

declare(strict_types=1);

namespace Tests\ShopBundle\Acceptance\acceptance;

use Tests\ShopBundle\Acceptance\acceptance\PageObject\Admin\LoginPage;
use Tests\ShopBundle\Test\Codeception\AcceptanceTester;
use Tests\ShopBundle\Test\Codeception\Helper\LocalizationHelper;

class LoginAsCustomerCest
{
    /**
     * @param \Tests\ShopBundle\Test\Codeception\AcceptanceTester $me
     * @param \Tests\ShopBundle\Acceptance\acceptance\PageObject\Admin\LoginPage $loginPage
     * @param \Tests\ShopBundle\Test\Codeception\Helper\LocalizationHelper $localizationHelper
     * @throws \Shopsys\FrameworkBundle\Component\Domain\Exception\InvalidDomainIdException
     */
    public function testLoginAsCustomer(AcceptanceTester $me, LoginPage $loginPage, LocalizationHelper $localizationHelper)
    {
        $me->wantTo('login as a customer from admin');
        $loginPage->loginAsAdmin();
        $me->amOnPage('/admin/customer/edit/2');
        $me->clickByTranslationAdmin('Log in as user');
        $me->switchToLastOpenedWindow();
        $me->seeCurrentPageEquals('/');
        $me->seeTranslationFrontend('Attention! You are administrator logged in as the customer.');
        $me->see('Igor Anpilogov');
    }
}
