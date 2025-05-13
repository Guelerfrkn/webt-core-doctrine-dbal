-- db/schema.sql
CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player VARCHAR(255) NOT NULL,
    symbol ENUM('rock', 'paper', 'scissors') NOT NULL,
    game_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);