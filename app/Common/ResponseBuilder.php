<?php

namespace App\Common;

class ResponseBuilder
{
    private const SUCCESS_KEY = 'success';
    private const ERRORS_KEY = 'errors';
    private const PAYLOAD_KEY = 'data';

    private array $response;

    public function success(): static
    {
        $this->response[static::SUCCESS_KEY] = true;
        return $this;
    }

    public function failed(): static
    {
        $this->response[static::SUCCESS_KEY] = false;
        return $this;
    }

    public function errors(array $errors): static
    {
        $this->response[static::ERRORS_KEY] = $errors;
        return $this;
    }

    public function errorAsString(string $message): static
    {
        $this->response[static::ERRORS_KEY] = $message;
        return $this;
    }

    public function payload(mixed $data): static
    {
        $this->response[static::PAYLOAD_KEY] = $data;
        return $this;
    }

    public function get(): array
    {
        return $this->response;
    }
}
