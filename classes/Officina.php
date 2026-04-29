<?php


class Officina
{

    private $conn;


    public function __construct()
    {

        require_once __DIR__ . "/DatabaseManager.php";
        $db = new DatabaseManager();
        $this->conn = $db->getConnection();
    }




    public function getServizi()
    {
        $result = $this->conn->query("SELECT id_servizio, descrizione, costo_orario FROM servizio");
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

        public function getPezziRicambio()
    {
        $result = $this->conn->query("SELECT id_pezzo, descrizione, costo_unitario FROM pezzo_ricambio");
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

        public function getAccessori()
    {
        $result = $this->conn->query("SELECT id_accessorio, descrizione, costo_unitario FROM accessorio");
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

        public function getOfficine()
    {
        $result = $this->conn->query("SELECT id_officina, denominazione, indirizzo FROM officina");
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //metodi per aggiungere nuovi elementi
    public function addServizio($descrizione, $costo_orario)
    {
        $stmt = $this->conn->prepare("INSERT INTO servizio (descrizione, costo_orario) VALUES (?, ?)");
        $stmt->bind_param("sd", $descrizione, $costo_orario);
        return $stmt->execute();
    }

    public function addAccessorio($descrizione, $costo_unitario)
    {
        $stmt = $this->conn->prepare("INSERT INTO accessorio (descrizione, costo_unitario) VALUES (?, ?)");
        $stmt->bind_param("sd", $descrizione, $costo_unitario);
        return $stmt->execute();
    }

    public function addPezzoRicambio($descrizione, $costo_unitario)
    {
        $stmt = $this->conn->prepare("INSERT INTO pezzo_ricambio (descrizione, costo_unitario) VALUES (?, ?)");
        $stmt->bind_param("sd", $descrizione, $costo_unitario);
        return $stmt->execute();
    }

    //metodi per associare a officine
    public function associaServizioAOfficina($id_officina, $id_servizio)
    {
        $stmt = $this->conn->prepare("INSERT IGNORE INTO offre (id_officina, id_servizio) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_officina, $id_servizio);
        return $stmt->execute();
    }

    public function associaAccessorioAOfficina($id_officina, $id_accessorio, $quantita)
    {
        $stmt = $this->conn->prepare("INSERT INTO magazzino_accessori (id_officina, id_accessorio, quantita) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantita = quantita + VALUES(quantita)");
        $stmt->bind_param("iii", $id_officina, $id_accessorio, $quantita);
        return $stmt->execute();
    }

    public function associaPezzoAOfficina($id_officina, $id_pezzo, $quantita)
    {
        $stmt = $this->conn->prepare("INSERT INTO magazzino_pezzi (id_officina, id_pezzo, quantita) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantita = quantita + VALUES(quantita)");
        $stmt->bind_param("iii", $id_officina, $id_pezzo, $quantita);
        return $stmt->execute();
    }

    //metodi per ottenere associazioni esistenti
    public function getServiziPerOfficina($id_officina)
    {
        $stmt = $this->conn->prepare("SELECT s.id_servizio, s.descrizione, s.costo_orario FROM servizio s JOIN offre o ON s.id_servizio = o.id_servizio WHERE o.id_officina = ?");
        $stmt->bind_param("i", $id_officina);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAccessoriPerOfficina($id_officina)
    {
        $stmt = $this->conn->prepare("SELECT a.id_accessorio, a.descrizione, a.costo_unitario, ma.quantita FROM accessorio a JOIN magazzino_accessori ma ON a.id_accessorio = ma.id_accessorio WHERE ma.id_officina = ?");
        $stmt->bind_param("i", $id_officina);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getPezziPerOfficina($id_officina)
    {
        $stmt = $this->conn->prepare("SELECT pr.id_pezzo, pr.descrizione, pr.costo_unitario, mp.quantita FROM pezzo_ricambio pr JOIN magazzino_pezzi mp ON pr.id_pezzo = mp.id_pezzo WHERE mp.id_officina = ?");
        $stmt->bind_param("i", $id_officina);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}