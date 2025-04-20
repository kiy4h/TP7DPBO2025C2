<?php
require_once 'config/db.php';

class Pet {
    private $db;

    // konstruktor untuk menginisialisasi koneksi database
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // fungsi untuk mendapatkan semua data hewan peliharaan dengan nama penampungannya
    public function getAllPets() {
        $stmt = $this->db->query("SELECT pets.*, shelters.name as shelter_name
                                 FROM pets
                                 JOIN shelters ON pets.shelter_id = shelters.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mendapatkan semua data hewan peliharaan berdasarkan ID
    // (not used for now)
    public function getPetById($id) {
        $stmt = $this->db->prepare("SELECT pets.*, shelters.name as shelter_name
                                   FROM pets
                                   JOIN shelters ON pets.shelter_id = shelters.id
                                   WHERE pets.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mendapatkan semua data hewan peliharaan yang tersedia untuk diadopsi
    public function getAvailablePets() {
        $stmt = $this->db->query("SELECT pets.*, shelters.name as shelter_name
                                 FROM pets
                                 JOIN shelters ON pets.shelter_id = shelters.id
                                 WHERE adoption_status = 'Available'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mencari hewan peliharaan berdasarkan kata kunci pada field name, species, breed
    public function searchPets($keyword) {
        $keyword = "%$keyword%";
        $stmt    = $this->db->prepare("SELECT pets.*, shelters.name as shelter_name
                                   FROM pets
                                   JOIN shelters ON pets.shelter_id = shelters.id
                                   WHERE pets.name LIKE ? OR pets.species LIKE ? OR pets.breed LIKE ?");
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk menambahkan hewan peliharaan baru ke dalam database
    public function addPet($name, $species, $breed, $age, $gender, $description, $shelter_id) {
        $stmt = $this->db->prepare("INSERT INTO pets (name, species, breed, age, gender, description, shelter_id, adoption_status)
                                  VALUES (?, ?, ?, ?, ?, ?, ?, 'Available')");
        return $stmt->execute([$name, $species, $breed, $age, $gender, $description, $shelter_id]);
    }

    // fungsi untuk mengupdate data hewan peliharaan berdasarkan ID
    public function updatePet($id, $name, $species, $breed, $age, $gender, $description, $shelter_id, $adoption_status) {
        $stmt = $this->db->prepare("UPDATE pets SET name = ?, species = ?, breed = ?, age = ?, gender = ?,
                                  description = ?, shelter_id = ?, adoption_status = ? WHERE id = ?");
        return $stmt->execute([$name, $species, $breed, $age, $gender, $description, $shelter_id, $adoption_status, $id]);
    }

    // fungsi untuk menghapus hewan peliharaan berdasarkan ID
    public function deletePet($id) {
        $stmt = $this->db->prepare("DELETE FROM pets WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // fungsi untuk mengupdate status adopsi hewan peliharaan berdasarkan ID
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE pets SET adoption_status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}
