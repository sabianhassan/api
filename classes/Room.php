<?php
require_once "Database.php";

class Room {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add Room
    public function addRoom($room_type, $price, $status) {
        $query = "INSERT INTO rooms (room_type, price, status) VALUES (?, ?, ?)";
        return $this->db->executeQuery($query, [$room_type, $price, $status]);
    }

    // Get All Rooms
    public function getRooms() {
        $query = "SELECT * FROM rooms";
        return $this->db->fetchAll($query);
    }

    // Update Room
    public function updateRoom($room_id, $room_type, $price, $status) {
        $query = "UPDATE rooms SET room_type=?, price=?, status=? WHERE id=?";
        return $this->db->executeQuery($query, [$room_type, $price, $status, $room_id]);
    }

    // Delete Room
    public function deleteRoom($room_id) {
        $query = "DELETE FROM rooms WHERE id=?";
        return $this->db->executeQuery($query, [$room_id]);
    }

    // Book a Room
    public function bookRoom($room_id, $customer_name, $checkin_date, $checkout_date) {
        $query = "INSERT INTO reservations (room_id, customer_name, checkin_date, checkout_date) VALUES (?, ?, ?, ?)";
        if ($this->db->executeQuery($query, [$room_id, $customer_name, $checkin_date, $checkout_date])) {
            // Update room status to "Booked"
            $this->updateRoom($room_id, null, null, 'Booked');
            return true;
        }
        return false;
    }
}
?>
