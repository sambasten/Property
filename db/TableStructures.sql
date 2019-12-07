 CREATE TABLE property_type (
     id INT(11) AUTO_INCREMENT PRIMARY KEY,
     title VARCHAR(100) NOT NULL,
     description TEXT NOT NULL
 );

 CREATE TABLE property (
     id INT(11) AUTO_INCREMENT PRIMARY KEY,
     uuid VARCHAR(100) NOT NULL,
     county VARCHAR(100) NOT NULL,
     country VARCHAR(100) NOT NULL,
     town VARCHAR(100) NOT NULL,
     description TEXT NOT NULL,
     full_details_url VARCHAR(100) NOT NULL,
     displayable_address VARCHAR(100) NOT NULL,
     image_url VARCHAR(100) NOT NULL,
     thumbnail_url VARCHAR(100) NOT NULL,
     latitude VARCHAR(100) NOT NULL,
     longitude VARCHAR(100) NOT NULL,
     number_of_bedrooms VARCHAR(100) NOT NULL,
     number_of_bathrooms VARCHAR(100) NOT NULL,
     price float(10, 2) NOT NULL,
     property_type_id INT(11) NOT NULL,
     property_status INT(1) DEFAULT 0 COMMENT '0. For Sale 1. For rent'
 );