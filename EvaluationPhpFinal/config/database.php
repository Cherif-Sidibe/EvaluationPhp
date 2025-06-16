<?php
function connectDB() {
    try {
        return new PDO("mysql:host=localhost;dbname=evaluationphp", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
