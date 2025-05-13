<?php
// src/Model/GameModel.php

namespace Furka\WebtCoreDoctrineDbal\Model; // Namespace gemäß deiner composer.json

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Exception;

class GameModel
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Holt alle Spielrunden aus der Datenbank, sortiert nach Datum absteigend.
     * @return array<int, array<string, mixed>>
     * @throws Exception
     */
    public function getAllGames(): array
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('id', 'player', 'symbol', 'game_date')
           ->from('games')
           ->orderBy('game_date', 'DESC');

        return $qb->fetchAllAssociative();
    }

    /**
     * Holt eine spezifische Spielrunde anhand der ID.
     * @param int $id
     * @return array<string, mixed>|false
     * @throws Exception
     */
    public function getGameById(int $id): array|false
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('id', 'player', 'symbol', 'game_date')
           ->from('games')
           ->where('id = :id')
           ->setParameter('id', $id);

        return $qb->fetchAssociative();
    }

    /**
     * Fügt eine neue Spielrunde hinzu.
     * @param string $player
     * @param string $symbol
     * @param string|null $gameDate (Format YYYY-MM-DD HH:MM:SS oder null für jetzt)
     * @return int Die Anzahl der eingefügten Zeilen (sollte 1 sein)
     * @throws Exception
     */
    public function addGame(string $player, string $symbol, ?string $gameDate = null): int
    {
        $qb = $this->db->createQueryBuilder();

        // Wenn kein Datum übergeben wird, nimm das aktuelle Datum/Zeit der DB
        $dateToInsert = $gameDate ?? $this->db->fetchOne('SELECT CURRENT_TIMESTAMP');

        $qb->insert('games')
           ->values([
               'player' => ':player',
               'symbol' => ':symbol',
               'game_date' => ':game_date'
           ])
           ->setParameters([
               'player' => $player,
               'symbol' => $symbol,
               'game_date' => $dateToInsert
           ]);

        return $qb->executeStatement();
    }

    /**
     * Löscht eine Spielrunde anhand der ID.
     * @param int $id
     * @return int Die Anzahl der gelöschten Zeilen (sollte 1 sein)
     * @throws Exception
     */
    public function deleteGame(int $id): int
    {
        $qb = $this->db->createQueryBuilder();
        $qb->delete('games')
           ->where('id = :id')
           ->setParameter('id', $id);

        return $qb->executeStatement();
    }
}