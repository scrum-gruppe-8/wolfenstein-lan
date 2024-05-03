<?php

class submitFunctions
{
    public static function generateInsertSqlQuery(string $tableName, array $valuesToInsert): string
    {
        // example of what this function returns:
        //     string "INSERT INTO tickets ( title, description, category_id, author_id ) VALUES ( :title, :description, :category_id, :author_id ) ;"


        $sqlStart = "INSERT INTO $tableName ";
        $sqlStart .= "(";
        $sqlEnd = "VALUES ";
        $sqlEnd .= "(";
        foreach ($valuesToInsert as $column => $_) {
            if ($_ === NULL) continue;
            $sqlStart .= " $column, ";
            $sqlEnd .= " :$column, ";
        }
        $sqlStart .= ") ";
        $sqlEnd .= ") ";

        // remove the last comma
        $sqlStartArray = str_split($sqlStart);
        $sqlEndArray = str_split($sqlEnd);
        array_splice($sqlStartArray, -4, 1);
        array_splice($sqlEndArray, -4, 1);
        $sqlStart = implode("", $sqlStartArray);
        $sqlEnd = implode("", $sqlEndArray);
        $sqlStartArray = null;
        $sqlEndArray = null;

        $sql = $sqlStart . $sqlEnd;

        $sql .= ";";
        return $sql;
    }

    public static function generateUpdateSqlQuery(string $tableName, array $primaryKey, array $valuesToChange): string
    {
        // example of what this function returns:
        //     string "UPDATE tickets set status_id = :statusId, category_id = :categoryId WHERE id = :ticketId ;"

        $sql = "UPDATE $tableName SET ";
        foreach ($valuesToChange as $column => $_) {
            if ($_ === NULL) continue;
            $sql .= " $column = :$column, ";
        }
        // remove the last comma
        $sqlArray = str_split($sql);
        array_splice($sqlArray, -2, 1);
        $sql = implode("", $sqlArray);
        $sqlArray = null;

        foreach ($primaryKey as $primaryKeyColumn => $_) {
            $sql .= " WHERE $primaryKeyColumn = :$primaryKeyColumn ";
            break;
        }

        $sql .= ";";
        return $sql;
    }

    public static function insertIntoTable(string $tableName, array $valuesToInsert): int
    {
        // Array valuesToInsert uses the format:
        //      [
        //          "nameOfColumn" => "Value",
        //          "nameOfAnotherColumn" => "anotherValue",
        //      ]
        // this is inserted into the table $tableName

        try {
            include_once "backend/database.php";
            $conn = database::getDatabaseConnection();

            $sql = self::generateInsertSqlQuery($tableName, $valuesToInsert);

            $stmt = $conn->prepare($sql);

            foreach ($valuesToInsert as $column => $value) {
                if ($value === NULL) continue;
                $stmt->bindParam(":$column", $valuesToInsert[$column]);
            }

            $stmt->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

    public static function updateTable(string $tableName, array $primaryKey, array $valuesToChange): void
    {
        // Array $primaryKey should just contain [ "nameOfPrimaryKeyColumn" => "PrimaryKeyValue" ]
        // Array valuesToChange uses the same format:
        //      [
        //          "nameOfColumn" => "newValue",
        //          "nameOfAnotherColumn" => "anotherNewValue",
        //      ]

        if (count($primaryKey) !== 1) {
            echo '$primaryKey array must only have one value formatted like [ "nameOfPrimaryKeyColumn" => "PrimaryKeyValue" ]';
        }

        try {
            include_once "backend/database.php";
            $conn = database::getDatabaseConnection();

            $sql = self::generateUpdateSqlQuery($tableName, $primaryKey, $valuesToChange);

            $stmt = $conn->prepare($sql);

            foreach ($primaryKey as $primaryKeyColumn => $value) {
                $stmt->bindParam(":$primaryKeyColumn", $primaryKey[$primaryKeyColumn]);
            }
            foreach ($valuesToChange as $column => $value) {
                if ($value === NULL) continue;
                $stmt->bindParam(":$column", $valuesToChange[$column]);
            }

            $stmt->execute();
            echo "Successfully updated table: $tableName";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    }
}
