<?php

include_once("db.php"); // Include the file with the Database class

class StudentDetails {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a student detail entry and link it to a student
    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO student_details(student_id, contact_number, street, zip_code, town_city, province) 
                    VALUES(:student_id, :contact_number, :street, :zip_code, :town_city, :province)";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':student_id', $data['student_id']);
            $stmt->bindParam(':contact_number', $data['contact_number']);
            $stmt->bindParam(':street', $data['street']);
            $stmt->bindParam(':zip_code', $data['zip_code']);
            $stmt->bindParam(':town_city', $data['town_city']);
            $stmt->bindParam(':province', $data['province']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Log and re-throw the exception for higher-level handling
            error_log("Error creating student details: " . $e->getMessage());
            throw $e;
        }
    }

    // Retrieve student details based on student ID
    public function read($student_id) {
        try {
            $sql = "SELECT * FROM student_details WHERE student_id = :student_id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->execute();

            // Fetch the student data as an associative array
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Log and re-throw the exception for higher-level handling
            error_log("Error reading student details: " . $e->getMessage());
            throw $e;
        }
    }

    // Update student details based on student ID
    public function update($student_id, $data) {
        try {
            $sql = "UPDATE student_details SET
                    contact_number = :contact_number,
                    street = :street,
                    town_city = :town_city,
                    province = :province,
                    zip_code = :zip_code
                    WHERE student_id = :student_id";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':contact_number', $data['contact_number']);
            $stmt->bindParam(':street', $data['street']);
            $stmt->bindParam(':town_city', $data['town_city']);
            $stmt->bindParam(':province', $data['province']);
            $stmt->bindParam(':zip_code', $data['zip_code']);

            // Execute the query
            $stmt->execute();

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Log and re-throw the exception for higher-level handling
            error_log("Error updating student details: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
