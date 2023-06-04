<?php

namespace App\Tests\E2E;

use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\PantherTestCase;

class LikeTest extends PantherTestCase
{
    const GLOBAL_ELEMENT_SELECTOR = 'div[data-type="post"] a[data-action="like"]';
    const FILLED_SVG_SELECTOR = 'div[data-type="post"] a[data-action="like"] svg.filled';
    const UNFILLED_SVG_SELECTOR = 'div[data-type="post"] a[data-action="like"] svg.unfilled';

    public function testLikePostWorks(): void
    {
        $client = self::createPantherClient([
            'browser' => PantherTestCase::CHROME
        ]);

        $crawler = $client->request('GET', '/connexion');
        $form = $crawler->filter('form[name=login]')->form([
            '_username' => 'emilien@symblog.fr',
            '_password' => 'password'
        ]);

        $client->submit($form);

        $elt = $client->getWebDriver()->findElement(WebDriverBy::cssSelector(
            self::GLOBAL_ELEMENT_SELECTOR
        ));

        $filledSvg = $client->getWebDriver()->findElement(WebDriverBy::cssSelector(
            self::FILLED_SVG_SELECTOR
        ));

        $classes = explode(' ', $filledSvg->getAttribute('class'));

        if(in_array('hidden', $classes)) {
            $this->assertSelectorIsNotVisible(self::FILLED_SVG_SELECTOR);
            $this->assertSelectorIsVisible(self::UNFILLED_SVG_SELECTOR);
        }else {
            $this->assertSelectorIsVisible(self::FILLED_SVG_SELECTOR);
            $this->assertSelectorIsNotVisible(self::UNFILLED_SVG_SELECTOR);
        }

        $elt->click();

        if(in_array('hidden', $classes)) {
            $client->waitForVisibility(self::FILLED_SVG_SELECTOR);
            $this->assertSelectorIsVisible(self::FILLED_SVG_SELECTOR);
            $this->assertSelectorIsNotVisible(self::UNFILLED_SVG_SELECTOR);
        }else {
            $client->waitForVisibility(self::UNFILLED_SVG_SELECTOR);
            $this->assertSelectorIsVisible(self::UNFILLED_SVG_SELECTOR);
            $this->assertSelectorIsNotVisible(self::FILLED_SVG_SELECTOR);
        }
    }

    public function testLikePostsIfUserNotLoggedIn(): void
    {
        $client = self::createPantherClient([
            'browser' => PantherTestCase::CHROME
        ]);

        $client->request('GET', '/connexion');
        $this->assertSelectorNotExists(self::GLOBAL_ELEMENT_SELECTOR);
    }
}