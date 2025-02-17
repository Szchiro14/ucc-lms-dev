<?php
class Program
{
    private $conn;
    private $table_name = "programs"; // Adjust based on your table name

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Check if program exists by program code
    public function checkProgramExists($program_code, $program_name)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE program_code = :program_code OR program_name = :program_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':program_code', $program_code);
        $stmt->bindParam(':program_name', $program_name);
        $stmt->execute();

        return $stmt->rowCount() > 0; // Return true if the program already exists
    }


    // Add program to the database
    public function addProgram($data)
    {
        // Check if program exists
        if ($this->checkProgramExists($data['program_code'], $data['program_name'])) {
            return "Program already exists."; // Return message if program exists
        }

        $query = "INSERT INTO " . $this->table_name . " (program_code, program_name, program_description, educational_level, program_image) 
                  VALUES (:program_code, :program_name, :program_description, :educational_level, :program_image)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':program_code', $data['program_code']);
        $stmt->bindParam(':program_name', $data['program_name']);
        $stmt->bindParam(':program_description', $data['program_description']);
        $stmt->bindParam(':educational_level', $data['educational_level']);
        $stmt->bindParam(':program_image', $data['program_image'], PDO::PARAM_LOB); // Use PDO::PARAM_LOB for large objects

        return $stmt->execute(); // Return true if successful, false otherwise
    }

    // Get all programs
    public function getAllPrograms()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
    }


}
?>