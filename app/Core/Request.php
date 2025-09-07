<?php

namespace App\Core;

use RuntimeException;

class Request
{
    private array $get;
    private array $post;
    private array $files;
    private array $server;

    protected array $errors = [];

    public function __construct()
    {
        $this->get    = $_GET;
        $this->post   = $_POST;
        $this->files  = $_FILES;
        $this->server = $_SERVER;

        if (method_exists($this, 'rules')) {
            $this->validate();
        }
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        return parse_url($this->server['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function hasFile(string $key): bool
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    public function file(string $key): ?array
    {
        return $this->hasFile($key) ? $this->files[$key] : null;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function validate(): bool
    {
        $this->errors = [];
        $rules = $this->rules();

        foreach ($rules as $field => $validators) {
            $value = $this->input($field);

            foreach ($validators as $validator) {
                $method = "validate" . ucfirst($validator);
                if (!method_exists($this, $method)) {
                    throw new RuntimeException("Validator $validator not implemented");
                }
                $this->$method($field, $value);
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    protected function validateRequired(string $field, $value): void
    {
        if ($value === null || $value === '') {
            $this->errors[$field][] = "Поле $field обязательно";
        }
    }

    protected function validateInteger(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $this->errors[$field][] = "Поле $field должно быть числом";
        }
    }

    protected function validateBoolean(string $field, $value): void
    {
        if (!in_array($value, [0, 1, true, false, "0", "1"], true)) {
            $this->errors[$field][] = "Поле $field должно быть булевым";
        }
    }

    protected function rules(): array
    {
        return [];
    }
}