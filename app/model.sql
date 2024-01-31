create database languagesolution;


CREATE TABLE StudyFormat (
    format_id INT AUTO_INCREMENT PRIMARY KEY,
    format_name VARCHAR(255),
    price DECIMAL(10, 2)
)ENGINE=InnoDB;

INSERT INTO StudyFormat (format_id, format_name, price)
VALUES
(1, 'Online Course', 99.99),
(2, 'In-Person Workshop', 199.99),
(3, 'Self-Paced Video', 49.99),
(4, 'Live Webinar', 149.99),
(5, 'Group Coaching', 249.99),
(6, 'Interactive Virtual Lab', 79.99),
(7, 'E-book', 29.99),
(8, 'One-on-One Mentoring', 299.99),
(9, 'Hybrid Course', 149.99),
(10, 'Study Group', 0.00);



CREATE TABLE Language (
    language_id INT AUTO_INCREMENT PRIMARY KEY,
    language_name VARCHAR(255)
)ENGINE=InnoDB;


INSERT INTO Language (language_id, language_name)
VALUES
(1, 'English'),
(2, 'Spanish'),
(3, 'French'),
(4, 'German'),
(5, 'Chinese'),
(6, 'Japanese'),
(7, 'Russian'),
(8, 'Arabic'),
(9, 'Portuguese'),
(10, 'Italian');



CREATE TABLE IF NOT EXISTS users (
    users_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    role ENUM('user', 'admin', 'manager') NOT NULL DEFAULT 'user'
)ENGINE=InnoDB;

INSERT INTO users (username, name, surname, email, password, dob, gender, role)
VALUES
('vladimir', 'Vladimir', 'Nicic', 'vladimir.nicic@email.com', 'pass123', '1990-05-15', 'male', 'admin'),
('vlad', 'vlad', 'Ere', 'vlad.ere@email.com', 'password1', '1985-11-25', 'male', 'manager'),
('alex_turner', 'Alex', 'Turner', 'alex.turner@email.com', 'qwerty123', '1987-02-10', 'male', 'user'),
('sara_jones', 'Sara', 'Jones', 'sara.jones@email.com', 'myp@ssword', '1995-09-03', 'female', 'user'),
('mike_jackson', 'Mike', 'Jackson', 'mike.jackson@email.com', 'securepw123', '1982-07-20', 'male', 'user'),
('emily_brown', 'Emily', 'Brown', 'emily.brown@email.com', 'hello123', '1992-12-30', 'female', 'user'),
('chris_adams', 'Chris', 'Adams', 'chris.adams@email.com', 'pa$$w0rd', '1988-03-18', 'male', 'user'),
('lisa_smith', 'Lisa', 'Smith', 'lisa.smith@email.com', 'pass1234', '1998-06-05', 'female', 'user'),
('ryan_clark', 'Ryan', 'Clark', 'ryan.clark@email.com', 'rclark456', '1993-04-12', 'male', 'user'),
('jessica_wilson', 'Jessica', 'Wilson', 'jessica.wilson@email.com', 'jw12345', '1991-08-22', 'female', 'user');



CREATE TABLE UserChoice (
    user_choice_id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT,
    format_id INT,
    language_id INT,
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES Users(users_id),
    FOREIGN KEY (format_id) REFERENCES StudyFormat(format_id),
    FOREIGN KEY (language_id) REFERENCES Language(language_id)
)ENGINE=InnoDB;

INSERT INTO UserChoice (user_choice_id, users_id, format_id, language_id, submission_date)
VALUES
(1, 1, 3, 1, CURRENT_TIMESTAMP),
(2, 2, 1, 5, CURRENT_TIMESTAMP),
(3, 3, 2, 2, CURRENT_TIMESTAMP),
(4, 4, 4, 3, CURRENT_TIMESTAMP),
(5, 5, 6, 4, CURRENT_TIMESTAMP),
(6, 6, 8, 6, CURRENT_TIMESTAMP),
(7, 7, 5, 7, CURRENT_TIMESTAMP),
(8, 8, 7, 8, CURRENT_TIMESTAMP),
(9, 9, 9, 9, CURRENT_TIMESTAMP),
(10, 10, 10, 10, CURRENT_TIMESTAMP);

CREATE TABLE UserSuggestions (
    suggestion_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    suggestion_text TEXT,
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(users_id)
) ENGINE=InnoDB;

INSERT INTO UserSuggestions (user_id, suggestion_text)
VALUES
    (1, 'I suggest offering more intermediate-level language courses.'),
    (2, 'It would be great to have a conversation practice group for advanced learners.'),
    (3, 'How about introducing a mobile app for easier access to course materials?'),
    (4, 'I recommend adding more cultural insights to the curriculum.'),
    (5, 'I enjoy the current format of lessons, but more interactive quizzes would be nice.'),
    (6, 'I d like to see a course focused on slang and informal language.'),
    (7, 'Please consider offering courses on lesser-known languages.'),
    (8, 'It would be helpful to have a pronunciation guide for each language.'),
    (9, 'I suggest organizing online language exchange events between learners.'),
    (10, 'I recommend adding a feature for tracking progress and setting language goals.');


									