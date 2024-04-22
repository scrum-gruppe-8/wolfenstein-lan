<?php

class database{

   public static array $databaseInfo = [
       "servername" => "localhost",
       "username" => "root",
       "password" => "Admin",
       "dbname" => "wolfenstein_lan",
   ];

    public static function getDatabaseConnection (): PDO | PDOException
    {
        $db = &self::$databaseInfo;

        try {
            $conn = new PDO(
                "mysql:host=" . $db["servername"] . ";".
                "dbname=" . $db["dbname"],
                $db["username"], $db["password"]
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Tilkobling feilet: " . $e->getMessage();
            return $e;
        }
    }

    public static function setUpDatabase(): void
    {

        $db = database::getDatabaseConnection();

        $db->query("
            create table paamelding
            (
                id        int auto_increment,
                fornavn   tinytext not null,
                etternavn tinytext not null,
                email     tinytext not null,
                constraint paamelding_pk
                    primary key (id)
            );
        ")->execute();
    }

}