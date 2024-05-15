<?php

namespace App\tests\Unit\Controller;

use App\Service\MessageHelper;
use DateTime;
use DateTimeZone;
use Exception;
use PHPUnit\Framework\TestCase;

class MessageHelperTest extends TestCase
{
    private MessageHelper $messageHelper;

    protected function setUp(): void
    {
        $this->messageHelper = new MessageHelper();
    }

    /**
     * @throws Exception
     */
    public function testTimeMessage(): void
    {
        $messageObject = $this->messageHelper->setTimeMessage(null);
        $messageString = $messageObject->getMessage();

        // get the date time from New York and compare with the message
        $timezone = new DateTimeZone('Europe/Berlin');
        $timeNow = new DateTime('now', $timezone);

        $minute = intval($timeNow->format('i'));
        $ampm = $timeNow->format('a');

        if ($minute > 30) {
            $this->assertStringContainsString('to', $messageString);
        } else {
            $this->assertStringContainsString('past', $messageString);
        }

        $this->assertStringContainsString($ampm, $messageString);
    }
}
