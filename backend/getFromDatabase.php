<?php
class getFromDatabase {

    public static function stmtFetchAssocToArray(&$stmt, string $primaryKey = "id"): array {
        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (isset($row[$primaryKey])) {
                $result[$row[$primaryKey]] = $row;
            } else {
                $result[] = $row;
            }
        }
        return $result;
    }

    public static function query(string $sql, string $primaryKey = "id"): array
    {
        try {
            include_once "backend/database.php";
            $conn = database::getDatabaseConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return self::stmtFetchAssocToArray($stmt, $primaryKey);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return [];
    }

    public static function table(string $table, string $primaryKey = "id"): array
    {
        $sql = "SELECT * FROM $table;";
        return self::query($sql, $primaryKey);
    }

    public static function tables(): array
    {
        $sql = "SHOW TABLES;";
        $rawData = self::query($sql);

        $result = [];
        foreach ($rawData as $redundant) {
            foreach ($redundant as $item) $result[] = $item;
        }

        return $result;
    }

    public static function columns(string $tableName): array
    {
        include_once "backend/database.php";
        $schema = &database::$databaseInfo["dbname"];
        $sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName' AND TABLE_SCHEMA = '$schema';";
        $rawData = self::query($sql);

        $result = [];
        foreach ($rawData as $row) {
            $result[] = $row["COLUMN_NAME"];
        }

        return $result;
    }
}