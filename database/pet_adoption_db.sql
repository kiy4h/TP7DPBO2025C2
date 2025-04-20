CREATE DATABASE IF NOT EXISTS pet_adoption_db;
USE pet_adoption_db;

-- create shelters table
CREATE TABLE shelters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- create pets table
CREATE TABLE pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    species VARCHAR(50) NOT NULL,
    breed VARCHAR(50),
    age INT NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    description TEXT,
    shelter_id INT NOT NULL,
    adoption_status ENUM('Available', 'Adopted') NOT NULL DEFAULT 'Available',
    FOREIGN KEY (shelter_id) REFERENCES shelters(id)
);

-- create adopters table
CREATE TABLE adopters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL
);

-- create adoptions table
CREATE TABLE adoptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    adopter_id INT NOT NULL,
    adoption_date DATE NOT NULL,
    notes TEXT,
    FOREIGN KEY (pet_id) REFERENCES pets(id),
    FOREIGN KEY (adopter_id) REFERENCES adopters(id)
);

-- insert sample data for shelters
INSERT INTO shelters (name, address, phone, email) VALUES 
('Happy Paws Shelter', '123 Animal St, City', '555-1234', 'info@happypaws.org'),
('Second Chance Animal Rescue', '456 Pet Blvd, Town', '555-5678', 'help@secondchance.org'),
('Furry Friends Haven', '789 Rescue Ave, Village', '555-9012', 'adopt@furryfriends.org');

-- insert sample data for pets
INSERT INTO pets (name, species, breed, age, gender, description, shelter_id, adoption_status) VALUES
('Buddy', 'Dog', 'Golden Retriever', 3, 'Male', 'Friendly and energetic dog who loves to play fetch', 1, 'Available'),
('Whiskers', 'Cat', 'Siamese', 2, 'Female', 'Quiet and gentle cat who enjoys lounging in sunny spots', 1, 'Available'),
('Max', 'Dog', 'German Shepherd', 5, 'Male', 'Well-trained and protective dog who is great with kids', 2, 'Available'),
('Luna', 'Cat', 'Persian', 1, 'Female', 'Playful kitten who loves toys and climbing', 2, 'Available'),
('Rocky', 'Dog', 'Bulldog', 4, 'Male', 'Stubborn but lovable dog who enjoys short walks', 3, 'Available'),
('Bella', 'Cat', 'Maine Coon', 3, 'Female', 'Fluffy and affectionate cat who loves attention', 3, 'Available'),
('Charlie', 'Dog', 'Beagle', 2, 'Male', 'Curious and friendly dog with a great sense of smell', 1, 'Available'),
('Coco', 'Cat', 'Ragdoll', 4, 'Female', 'Calm and gentle cat who follows you everywhere', 2, 'Available');

-- insert sample data for adopters
INSERT INTO adopters (name, email, phone, address) VALUES
('John Smith', 'john@email.com', '555-1111', '123 Main St, Anytown'),
('Jane Doe', 'jane@email.com', '555-2222', '456 Oak Ave, Somewhere'),
('Bob Johnson', 'bob@email.com', '555-3333', '789 Pine Rd, Nowhere'),
('Alice Williams', 'alice@email.com', '555-4444', '321 Elm St, Anywhere');