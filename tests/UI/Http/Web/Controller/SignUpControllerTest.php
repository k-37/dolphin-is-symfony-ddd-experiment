<?php

declare(strict_types=1);

namespace Tests\UI\Http\Web\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class SignUpControllerTest extends WebTestCase
{
    private ?KernelBrowser $client;
    private ?Crawler $crawler;

    private function createUser(string $email, string $password = 'testtest'): void
    {
        $this->submitForm($email, $password);
        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();
        $this->assertSelectorExists("h2:contains('Hello $email')");
        $this->assertStringContainsStringIgnoringCase('/signedup?', $crawler->getUri());
    }

    private function submitForm(string $email, string $password = 'testtest'): void
    {
        self::ensureKernelShutdown();
        $this->setUp();

        $this->client->submitForm('Submit', [
            'sign_up[email]' => $email,
            'sign_up[password]' => $password,
        ]);
    }

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->crawler = $this->client->request('GET', '/signup');
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function signup_should_have_text(): void
    {
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('label', 'Email');
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function signup_should_have_link_to_home_in_header(): void
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
    public function signup_should_have_link_to_sign_up_in_header(): void
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
    public function signup_should_have_footer(): void
    {
        $this->assertSelectorExists('footer', 'Footer doesn\'t exist');
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function user_should_be_created_on_form_submit(): void
    {
        $this->createUser('test@example.com');
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function user_should_not_be_created_with_same_data_on_next_form_submit(): void
    {
        $this->createUser('test@example.com');
        $this->submitForm('test@example.com');

        $this->assertSelectorExists('main:contains(\'Email already registered.\')');
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function user_should_not_be_created_with_invalid_email(): void
    {
        $this->submitForm('test@invalid');

        $this->assertSelectorExists('main:contains(\'This value is not a valid email address.\')');
    }

    /**
     * @test
     *
     * @group e2e
     */
    public function user_should_not_be_created_with_short_password(): void
    {
        $this->submitForm('test@example.com', '12345');

        $this->assertSelectorExists('main:contains(\'This value is too short. It should have 6 characters or more.\')');
    }
}
