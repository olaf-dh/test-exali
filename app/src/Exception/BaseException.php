<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

abstract class BaseException extends Exception
{
    /**
     * @var array<mixed>
     */
    protected array $data;

    /**
     * @param string $message
     * @param array<mixed> $data
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', array $data = [], int $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    public function setData(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function getExtraData(): mixed
    {
        if (count($this->data) === 0) {
            return $this->data;
        }
        return json_decode(json_encode($this->data), true);
    }

}
