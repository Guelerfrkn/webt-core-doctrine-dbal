<?php
// src/Model/GameModel.php

namespace Furka\WebtCoreDoctrineDbal\Model; // Stelle sicher, dass dieser Namespace mit deiner composer.json übereinstimmt

use Doctrine\DBAL\Connection;
// QueryBuilder wird in diesem einfachen Model nicht explizit genutzt, aber ist gut zu wissen für komplexere Dinge
// use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Exception;

class GameModel
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Holt alle Spielrunden aus der Datenbank.
     * @return array<int, array<string, mixed>>
     * @throws Exception
     */
    public function getAllGames(): array
    {
        $sql = "SELECT id, player1, symbol_player1, player2, symbol_player2, game_date FROM games ORDER BY game_date DESC";
        $stmt = $this->db->executeQuery($sql);
        return $stmt->fetchAllAssociative();
    }

    /**
     * Holt eine spezifische Spielrunde anhand der ID.
     * @param int $id
     * @return array<string, mixed>|false
     * @throws Exception
     */
    public function getGameById(int $id): array|false
    {
        $sql = "SELECT id, player1, symbol_player1, player2, symbol_player2, game_date FROM games WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $result = $stmt->executeQuery();
        return $result->fetchAssociative();
    }

    /**
     * Fügt eine neue Spielrunde für zwei Spieler hinzu.
     * @param string $player1
     * @param string $symbolPlayer1
     * @param string $player2
     * @param string $symbolPlayer2
     * @param string|null $gameDate (Format YYYY-MM-DD HH:MM:SS oder null für aktuelle Zeit)
     * @return int Anzahl der eingefügten Zeilen (sollte 1 sein)
     * @throws Exception
     */
    public function addGame(string $player1, string $symbolPlayer1, string $player2, string $symbolPlayer2, ?string $gameDate = null): int
    {
        // Wenn kein Datum übergeben wird, verwende den Datenbank-Standard (CURRENT_TIMESTAMP)
        // oder setze es explizit auf die aktuelle Zeit der DB.
        // Hier lassen wir es die DB handhaben, wenn null.
        $data = [
            'player1' => $player1,
            'symbol_player1' => $symbolPlayer1,
            'player2' => $player2,
            'symbol_player2' => $symbolPlayer2,
        ];
        if ($gameDate !== null) {
            $data['game_date'] = $gameDate;
        }

        // Doctrine DBAL's insert Methode ist hierfür gut geeignet
        return $this->db->insert('games', $data);
    }

    /**
     * Löscht eine Spielrunde anhand der ID.
     * @param int $id
     * @return int Anzahl der gelöschten Zeilen (sollte 1 sein)
     * @throws Exception
     */
    public function deleteGame(int $id): int
    {
        return $this->db->delete('games', ['id' => $id]);
    }
}