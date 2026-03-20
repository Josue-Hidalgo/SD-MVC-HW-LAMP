<?php

declare(strict_types=1);

class ShortCutController
{
    private string $validCharacters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    private string $domain;

    private ShortCut $shortCutModel;
    private AccessLog $accessLogModel;

    public function __construct(ShortCut $shortCutModel, AccessLog $accessLogModel, ?string $domain = null)
    {
        $this->shortCutModel = $shortCutModel;
        $this->accessLogModel = $accessLogModel;
        $this->domain = $domain ?? $this->detectBaseUrl();
    }

    public function handleRequest(): void
    {
        if (isset($_GET['url']) && $_GET['url'] !== '') {
            $this->createSURL($_GET['url']);
            return;
        }

        if (isset($_POST['urlcode']) && $_POST['urlcode'] !== '') {
            $this->getURL($_POST['urlcode']);
            return;
        }
    }

    private function createSURL(string $url): void
    {
        $shortCode = $this->generateUniqueCode(8);
        $id = $this->shortCutModel->create($shortCode, $url, $this->domain);

        if ($id === null) {
            http_response_code(500);
            echo "error al crear la url";
            return;
        }

        echo "creo la nueva url: " . $shortCode;
    }

    private function getURL(string $urlCode): void
    {
        $row = $this->shortCutModel->getByCode($urlCode);

        if (!$row || empty($row['original_url'])) {
            http_response_code(404);
            echo "error URL no encontrada";
            return;
        }

        $ip = $this->getIP();
        $country = $this->getIPCountry($ip) ?? "N/A";

        $this->accessLogModel->create(
            (int)$row['id_short_cut'],
            $ip,
            $country
        );

        header('Location: ' . $row['original_url']);
        exit();
    }

    private function generateUniqueCode(int $length = 8): string
    {
        do {
            $code = '';
            $max = strlen($this->validCharacters) - 1;
            for ($i = 0; $i < $length; $i++) {
                $code .= $this->validCharacters[random_int(0, $max)];
            }
        } while ($this->shortCutModel->existsCode($code));

        return $code;
    }

    private function getIP(): string
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($parts[0]);
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    private function getIPCountry(string $ip): ?string
    {
        $ch = curl_init("https://ipinfo.io/{$ip}/json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return null;
        }

        $details = json_decode($response);
        return $details->country ?? null;
    }

    private function detectBaseUrl(): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $scheme . '://' . $host . '/';
    }
}