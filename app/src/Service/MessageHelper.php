<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Message;
use App\Exception\NotFoundException;
use DateTime;
use DateTimeZone;
use Exception;
use Throwable;

class MessageHelper
{
    const HELLO_MESSAGE = 'hello';
    const FEEL_MESSAGE = 'I\'m fine';
    const TIME_MESSAGE = 'It\'s ';
    const MINUTES_PER_HOUR = 60;

    public function setTextMessage(string $name): Message
    {
        $messageObject = new Message();
        
        if ($name == 'hello') {
            $messageObject->setMessage(self::HELLO_MESSAGE);
        } else {
            $messageObject->setMessage(self::FEEL_MESSAGE);
        }

        return $messageObject;
    }

    /**
     * @throws Exception
     */
    public function setTimeMessage(?string $city = null): Message
    {
        $messageObject = new Message();

        // Set first letters to upper case and default city if not set
        if (isset($city)) {
            $city = ucwords($city);
        } else {
            $city = 'Berlin';
        }

        try {
            $timeZone = $this->getTimeZoneOfCity($city);
            $messageObject->setMessage(self::TIME_MESSAGE . $this->customTimeFormat($timeZone) . ' in ' . $city);
        } catch (Throwable $e) {
            throw new NotFoundException(
                sprintf('A timezone for this city: %s was not found', $city)
            );
        }

        return $messageObject;
    }

    /**
     * @throws Exception
     */
    private function getTimeZoneOfCity(string $city): DateTimeZone
    {
        // replace space with an underscore
        $cityString = str_contains($city, ' ') ? str_replace(' ', '_', $city) : $city;

        $timeZones = DateTimeZone::listIdentifiers();
        $timezone = null;

        foreach ($timeZones as $tz) {

            if (str_contains($tz, $cityString)) {
                $timezone = $tz;
                break;
            }
        }

        return new DateTimeZone($timezone);
    }

    /**
     * @throws Exception
     */
    private function customTimeFormat(DateTimeZone $timeZone): string
    {
        $time = new DateTime('now', $timeZone);

        $hour = intval($time->format('g'));
        $minute = intval($time->format('i'));
        $ampm = $time->format('a');

        $minuteStr = $minute < 30 ? $minute : self::MINUTES_PER_HOUR - $minute;
        $nextHour = $hour === 12 ? 1 : $hour + 1;

        switch ($minute) {
            case 0:
                return "{$hour} {$ampm}";
            case 15:
                return "quarter past {$hour} {$ampm}";
            case 30:
                return "half past {$hour} {$ampm}";
            case 45:
                return "quarter to {$nextHour} {$ampm}";
            case $minute < 30:
                return "{$minuteStr} past {$hour} {$ampm}";
            default:
                return "{$minuteStr} to {$nextHour} {$ampm}";
        }
    }
}
