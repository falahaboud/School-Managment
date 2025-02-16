CREATE DATABASE School;
USE School;


CREATE TABLE course (
  course_id INT(11) NOT NULL AUTO_INCREMENT,
  course_name VARCHAR(255) NOT NULL,
  description TEXT,
  PRIMARY KEY (course_id)
);

INSERT INTO course (course_name, description) VALUES
('PHP', 'PHP Hypertext Preprocessor'),
('CSS', 'Cascading Stylesheets');

