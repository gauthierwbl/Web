<?php

class Database {
    public static function getConnection() {
        return new PDO("mysql:host=localhost;dbname=cesi_ton_stage;charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}