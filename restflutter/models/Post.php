<?php
    class Post {

        //DB stuff
        private $conn;
        private $table = 'data';

        //POST properties
        public $id;
        public $name;
        public $email;
        public $age;

        //constructor for db

        public function __construct($db)
        {
            $this->conn = $db;   
        }

        //Get data
        public function read(){
            // create query
            //p and c are allias

            $query = 'SELECT * FROM data';
        

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;

        }

        // Get Single Post
    public function read_single() {
        // Create query
        $query = 'SELECT * FROM data WHERE id=?';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->age = $row['age'];
    }

    // Create Post
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name, 
        email = :email, 
        age = :age';


        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->age = htmlspecialchars(strip_tags($this->age));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':age', $this->age);


        // Execute query
        if($stmt->execute()) {
          return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

    // Update Post
    public function update() {
      // Create query
      $query = 'UPDATE ' . $this->table . ' SET name = :name, 
      email = :email, 
      age = :age
      WHERE
      id = :id';


      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->age = htmlspecialchars(strip_tags($this->age));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':age', $this->age);
      $stmt->bindParam(':id', $this->id);


      // Execute query
      if($stmt->execute()) {
        return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
}
  


  // Delete Post
  public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(1, $this->id);

        // Execute query
        if($stmt->execute()) {
          return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
  }
  
}
