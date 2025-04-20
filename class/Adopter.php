<?php
require_once 'config/db.php';

class Adopter {
    private $db;

    // konstruktor untuk menginisialisasi koneksi database
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // fungsi untuk mendapatkan semua data adopter
    public function getAllAdopters() {
        $stmt = $this->db->query("SELECT * FROM adopters");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mendapatkan data adopter berdasarkan ID
    // (not used for now)
    public function getAdopterById($id) {
        $stmt = $this->db->prepare("SELECT * FROM adopters WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mencari adopter berdasarkan nama, email, atau telepon
    public function searchAdopters($keyword) {
        $keyword = "%$keyword%";
        $stmt    = $this->db->prepare("SELECT * FROM adopters WHERE name LIKE ? OR email LIKE ? OR phone LIKE ?");
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk menambahkan data adopter baru
    public function addAdopter($name, $email, $phone, $address) {
        $stmt = $this->db->prepare("INSERT INTO adopters (name, email, phone, address) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $address]);
    }

    // fungsi untuk memperbarui data adopter berdasarkan ID
    public function updateAdopter($id, $name, $email, $phone, $address) {
        $stmt = $this->db->prepare("UPDATE adopters SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $phone, $address, $id]);
    }

    // fungsi untuk menghapus data adopter berdasarkan ID
    public function deleteAdopter($id) {
        $stmt = $this->db->prepare("DELETE FROM adopters WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
