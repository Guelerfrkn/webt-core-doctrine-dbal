-- db/schema.sql
-- Um sicherzustellen, dass du mit einem sauberen Tisch startest, wenn du die Tabelle neu erstellst:
-- DROP TABLE IF EXISTS games;

CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player1 VARCHAR(255) NOT NULL,
    symbol_player1 ENUM('rock', 'paper', 'scissors') NOT NULL,
    player2 VARCHAR(255) NOT NULL,
    symbol_player2 ENUM('rock', 'paper', 'scissors') NOT NULL,
    game_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);