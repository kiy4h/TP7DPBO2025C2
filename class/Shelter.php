<?php
require_once 'config/db.php';

class Shelter {
    private $db;

    // konstruktor untuk menginisialisasi koneksi database
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // fungsi untuk mendapatkan semua shelter
    public function getAllShelters() {
        $stmt = $this->db->query("SELECT * FROM shelters");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mendapatkan shelter berdasarkan ID
    // (not used for now)
    public function getShelterById($id) {
        $stmt = $this->db->prepare("SELECT * FROM shelters WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mencari shelter berdasarkan nama, alamat, atau email
    public function searchShelters($keyword) {
        $keyword = "%$keyword%";
        $stmt    = $this->db->prepare("SELECT * FROM shelters WHERE name LIKE ? OR address LIKE ? OR email LIKE ?");
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk menambahkan shelter baru
    public function addShelter($name, $address, $phone, $email) {
        $stmt = $this->db->prepare("INSERT INTO shelters (name, address, phone, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $address, $phone, $email]);
    }

    // fungsi untuk mengupdate shelter yang sudah ada
    public function updateShelter($id, $name, $address, $phone, $email) {
        $stmt = $this->db->prepare("UPDATE shelters SET name = ?, address = ?, phone = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $address, $phone, $email, $id]);
    }

    // fungsi untuk menghapus shelter berdasarkan ID
    public function deleteShelter($id) {
        $stmt = $this->db->prepare("DELETE FROM shelters WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
