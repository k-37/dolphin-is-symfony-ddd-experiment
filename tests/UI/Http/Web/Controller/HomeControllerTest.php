<?php

declare(strict_types=1);

namespace Tests\UI\Http\Web\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class HomeControllerTest extends WebTestCase
{
    private ?KernelBrowser $client;
    private ?Crawler $crawler;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->crawler = $this->client->request('GET', '/');
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function home_should_have_text(): void
    {
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', '🏎️ let\'s goooooooo for the 🏁!');
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function home_should_have_link_to_home_in_header(): void
    {
        $this->assertGreaterThan(0, $this->crawler->filter('header:contains(\'🐬 Dolphin\')')->count());
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function home_link_should_lead_to_home_page(): void
    {
        $link = $this->crawler->selectLink('🐬 Dolphin')->link();

        $crawler = $this->client->click($link);

        $this->assertStringEndsWith('/', $crawler->getUri());
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function home_should_have_link_to_sign_up_in_header(): void
    {
        $this->assertGreaterThan(0, $this->crawler->filter('header:contains(\'Sign up\')')->count());
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function sign_up_link_should_lead_to_sign_up_page(): void
    {
        $link = $this->crawler->selectLink('Sign up')->link();

        $crawler = $this->client->click($link);

        $this->assertStringEndsWith('/signup', $crawler->getUri());
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function home_should_have_footer(): void
    {
        $this->assertSelectorExists('footer', 'Footer doesn\'t exist');
    }
}
