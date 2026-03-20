<?php

declare(strict_types=1);

class AccessLog
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function create(int $idShortCut, string $ipAddress, string $country): bool
    {
        $sql = "INSERT INTO AccessLog (id_short_cut, ip_address, country) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;

        $ipAddress = mb_substr($ipAddress, 0, 45);
        $country = mb_substr($country, 0, 45);

        $stmt->bind_param("iss", $idShortCut, $ipAddress, $country);
        $ok = $stmt->execute();

        $stmt->close();
        return $ok;
    }

    public function getByShortCutId(int $idShortCut, int $limit = 100): array
    {
        $limit = max(1, min($limit, 1000));

        $sql = "SELECT id_access_log, id_short_cut, ip_address, country, access_date
                FROM AccessLog
                WHERE id_short_cut = ?
                ORDER BY access_date DESC
                LIMIT $limit";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) return [];

        $stmt->bind_param("i", $idShortCut);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();
        return $rows;
    }

    public function countByShortCutId(int $idShortCut): int
    {
        $sql = "SELECT COUNT(*) AS total FROM AccessLog WHERE id_short_cut = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return 0;

        $stmt->bind_param("i", $idShortCut);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;

        $stmt->close();
        return (int)($row['total'] ?? 0);
    }
}