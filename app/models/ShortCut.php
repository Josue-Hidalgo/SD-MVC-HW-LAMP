<?php

declare(strict_types=1);

class ShortCut
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function create(string $shortCode, string $originalUrl, string $baseUrl): ?int
    {
        $sql = "INSERT INTO ShortCut (short_code, original_url, base_url) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return null;

        $shortCode = mb_substr($shortCode, 0, 10);
        $originalUrl = mb_substr($originalUrl, 0, 2048);
        $baseUrl = mb_substr($baseUrl, 0, 255);

        $stmt->bind_param("sss", $shortCode, $originalUrl, $baseUrl);

        if (!$stmt->execute()) {
            $stmt->close();
            return null;
        }

        $id = $this->db->insert_id;
        $stmt->close();

        return $id > 0 ? (int)$id : null;
    }

    public function getById(int $idShortCut): ?array
    {
        $sql = "SELECT id_short_cut, short_code, original_url, base_url, creation_date
                FROM ShortCut
                WHERE id_short_cut = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param("i", $idShortCut);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;

        $stmt->close();
        return $row ?: null;
    }

    public function getByCode(string $shortCode): ?array
    {
        $sql = "SELECT id_short_cut, short_code, original_url, base_url, creation_date
                FROM ShortCut
                WHERE short_code = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) return null;

        $shortCode = mb_substr($shortCode, 0, 10);
        $stmt->bind_param("s", $shortCode);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;

        $stmt->close();
        return $row ?: null;
    }

    public function existsCode(string $shortCode): bool
    {
        $sql = "SELECT 1 FROM ShortCut WHERE short_code = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;

        $shortCode = mb_substr($shortCode, 0, 10);
        $stmt->bind_param("s", $shortCode);
        $stmt->execute();

        $result = $stmt->get_result();
        $exists = $result && $result->num_rows > 0;

        $stmt->close();
        return $exists;
    }

    public function delete(int $idShortCut): bool
    {
        $sql = "DELETE FROM ShortCut WHERE id_short_cut = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("i", $idShortCut);
        $ok = $stmt->execute();

        $stmt->close();
        return $ok;
    }
}