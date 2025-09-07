<?php

namespace App\Core;

use RuntimeException;

class Storage
{
    private string $uploadDir;
    private string $baseUrl;

    public function __construct(string $uploadDir, string $baseUrl = '/uploads/')
    {
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
        $this->baseUrl = rtrim($baseUrl, '/') . '/';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function save(array $file): string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Ошибка загрузки файла');
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('file_', true) . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $this->uploadDir . $filename)) {
            throw new RuntimeException('Не удалось сохранить файл');
        }

        return $filename;
    }

    public function delete(string $filename): void
    {
        $path = $this->uploadDir . $filename;

        if (file_exists($path)) {
            unlink($path);
        } else {
            throw new RuntimeException('Файл не найден для удаления');
        }
    }

    public function url(string $filename): string
    {
        return $this->baseUrl . $filename;
    }
}