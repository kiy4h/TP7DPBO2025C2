<?php
require_once 'config/db.php';
require_once 'class/Pet.php';

class Adoption {
    private $db;

    // constructor
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // fungsi untuk mengambil semua data adopsi
    public function getAllAdoptions() {
        $stmt = $this->db->query("SELECT adoptions.*, pets.name as pet_name, adopters.name as adopter_name
                                 FROM adoptions
                                 JOIN pets ON adoptions.pet_id = pets.id
                                 JOIN adopters ON adoptions.adopter_id = adopters.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mengambil data adopsi berdasarkan ID
    // (not used for now)
    public function getAdoptionById($id) {
        $stmt = $this->db->prepare("SELECT adoptions.*, pets.name as pet_name, adopters.name as adopter_name
                                   FROM adoptions
                                   JOIN pets ON adoptions.pet_id = pets.id
                                   JOIN adopters ON adoptions.adopter_id = adopters.id
                                   WHERE adoptions.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // fungsi untuk mencari data adopsi berdasarkan nama hewan atau nama pengadopsi
    public function searchAdoptions($keyword) {
        $keyword = "%$keyword%";
        $stmt    = $this->db->prepare("SELECT adoptions.*, pets.name as pet_name, adopters.name as adopter_name
                                   FROM adoptions
                                   JOIN pets ON adoptions.pet_id = pets.id
                                   JOIN adopters ON adoptions.adopter_id = adopters.id
                                   WHERE pets.name LIKE ? OR adopters.name LIKE ?");
        $stmt->execute([$keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // fungsi untuk menambahkan data adopsi baru
    // $pet_id: ID hewan yang diadopsi
    // $adopter_id: ID pengadopsi
    // $notes: catatan tambahan (opsional)
    public function adoptPet($pet_id, $adopter_id, $notes = '') {
        $stmt = $this->db->prepare("INSERT INTO adoptions (pet_id, adopter_id, adoption_date, notes) VALUES (?, ?, CURDATE(), ?)");
        $pet  = new Pet();
        $pet->updateStatus($pet_id, 'Adopted');
        return $stmt->execute([$pet_id, $adopter_id, $notes]);
    }

    // fungsi untuk menghapus data adopsi
    public function deleteAdoption($id) {
        // tampung ID hewan dari data adopsi yang akan dihapus
        $adoption = $this->db->prepare("SELECT pet_id FROM adoptions WHERE id = ?");
        $adoption->execute([$id]);
        $result = $adoption->fetch(PDO::FETCH_ASSOC);

        // hapus data adopsi berdasarkan ID yang diberikan
        $stmt    = $this->db->prepare("DELETE FROM adoptions WHERE id = ?");
        $success = $stmt->execute([$id]);

        // jika penghapusan berhasil dan ada ID hewan, ubah status hewan menjadi Tersedia
        // (jika tidak ada ID hewan, tidak perlu mengubah status hewan)
        if ($success && $result) {
            $pet = new Pet();
            $pet->updateStatus($result['pet_id'], 'Available');
        }

        return $success;
    }
}
