/*positions*/
CREATE TABLE categories (id int(2) AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20));
/*candidates*/
CREATE TABLE candidates (id int(2) AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(15) NOT NULL, last_name VARCHAR(15) NOT NULL,
middle_name VARCHAR(15), contesting_for int(2) NOT NULL, code VARCHAR(4),
image VARCHAR(10) NOT NULL, FOREIGN KEY (contesting_for) REFERENCES categories(id));
/*voters*/
CREATE TABLE voters (id int(7) AUTO_INCREMENT PRIMARY KEY, identity_key VARCHAR(15));
/*preferences*/
CREATE TABLE preferences (id int(2) AUTO_INCREMENT PRIMARY KEY,
key_name VARCHAR(15), key_value VARCHAR(15));
/*ballot_box*/
CREATE TABLE ballot_box (id int(7) AUTO_INCREMENT, candidate int(2) NOT NULL,
voter VARCHAR(15) NOT NULL, category int(2), PRIMARY KEY (category, voter),
FOREIGN KEY (voter) REFERENCES voters(identity_key));
/*users*/
CREATE TABLE users (id int(1) PRIMARY KEY AUTO_INCREMENT,
usersname VARCHAR(15) NOT NULL, password TEXT NOT NULL,
last_login DATETIME);
/*Insertions*/
INSERT INTO preferences (key_name, key_value) VALUES ("election", "SUG Election");
INSERT INTO preferences (key_name, key_value) VALUES ("in_session", "false");
INSERT INTO preferences (key_name, key_value) VALUES ("module_connected", "false");
