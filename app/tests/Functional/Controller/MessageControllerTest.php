<?php

namespace Functional\Controller;

use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageControllerTest extends WebTestCase
{
    /**
     * @var array|string[]
     */
    private array $postData;
    private KernelBrowser $client;
    private string $ampm;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->postData = ['city' => 'new york'];

        $timezone = new DateTimeZone('America/New_York');
        $time = new DateTime('now', $timezone);

        $this->ampm = $time->format('a');
    }

    public function testPostTimeMessage(): void
    {
        // call the POST request
        $request = $this->client->request('POST', '/api/whattimeisit/in', [], [], ['HTTP_X-API-KEY' => 'symfony'], json_encode($this->postData));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertStringContainsString($this->ampm, $responseData['data']);
    }

    public function testPostTimeMessageSendWithoutCity(): void
    {
        // call the POST request
        $this->client->request('POST', '/api/whattimeisit/in');

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $responseData);
    }
}
