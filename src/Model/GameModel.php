<?php

namespace Furka\WebtCoreDoctrineDbal\Model;

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

    public function getAllGames(): array
    {
        $qb = $this->db->createQueryBuilder();

        $qb->select('id', 'player1', 'symbol_player1', 'player2', 'symbol_player2', 'game_date')
           ->from('games')
           ->orderBy('game_date', 'DESC');

        return $qb->fetchAllAssociative();
    }

    public function getGameById(int $id): array|false
    {
        $qb = $this->db->createQueryBuilder();

        $qb->select('id', 'player1', 'symbol_player1', 'player2', 'symbol_player2', 'game_date')
           ->from('games')
           ->where('id = :id_placeholder')
           ->setParameter('id_placeholder', $id);

        return $qb->fetchAssociative();
    }

    public function addGame(string $player1, string $symbolPlayer1, string $player2, string $symbolPlayer2, ?string $gameDate = null): int
    {
        $data = [
            'player1'        => $player1,
            'symbol_player1' => $symbolPlayer1,
            'player2'        => $player2,
            'symbol_player2' => $symbolPlayer2,
        ];

        if ($gameDate !== null) {
            $data['game_date'] = $gameDate;
        }

        return $this->db->insert('games', $data);
    }

    public function deleteGame(int $id): int
    {
        $qb = $this->db->createQueryBuilder();

        $qb->delete('games')
           ->where('id = :id_val')
           ->setParameter('id_val', $id);

        return $qb->executeStatement();
    }
}