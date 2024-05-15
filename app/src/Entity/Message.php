<?php

declare(strict_types=1);

namespace App\Entity;

class Message
{
    private ?string $message = null;

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): Message
    {
        $this->message = $message;

        return $this;
    }
}
