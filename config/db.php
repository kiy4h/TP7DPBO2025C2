<?php
// class Database untuk koneksi ke database
class Database {
    private $host     = "localhost";
    private $username = "root"; // sesuaikan dengan username database di localhost
    private $password = "";
    private $dbname   = "pet_adoption_db"; // sesuaikan dengan nama database di localhost
    public $conn;

    // konstruktor untuk menginisialisasi koneksi database menggunakan PDO
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage(); // tampilkan pesan error jika koneksi gagal
        }
    }
}
