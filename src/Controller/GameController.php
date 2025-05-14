<?php

namespace Furka\WebtCoreDoctrineDbal\Controller;

use Furka\WebtCoreDoctrineDbal\Model\GameModel;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class GameController
{
    private GameModel $gameModel;
    private string $viewPath;

    public function __construct(Connection $db)
    {
        $this->gameModel = new GameModel($db);
        $this->viewPath = __DIR__ . '/../View/';
    }

    public function list(): void
    {
        try {
            $games = $this->gameModel->getAllGames();
            $tournamentName = "USARPS Championship Comeback";
            $currentDate = date('d.m.Y');

            $this->render('game_list', [
                'games' => $games,
                'tournamentName' => $tournamentName,
                'currentDate' => $currentDate
            ]);
        } catch (Exception $e) {
            die(htmlspecialchars("Fehler beim Laden der Spiele: " . $e->getMessage()));
        }
    }

    public function showAddForm(): void
    {
        $this->render('game_form');
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=list');
            return;
        }

        $player1 = trim($_POST['player1'] ?? '');
        $symbolPlayer1 = trim($_POST['symbol_player1'] ?? '');
        $player2 = trim($_POST['player2'] ?? '');
        $symbolPlayer2 = trim($_POST['symbol_player2'] ?? '');
        $gameDate = !empty(trim($_POST['game_date'] ?? '')) ? trim($_POST['game_date']) : null;

        $this->gameModel->addGame($player1, $symbolPlayer1, $player2, $symbolPlayer2, $gameDate);
        $this->redirect('index.php?action=list&status=added');
    }

    public function showDeleteForm(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            die(htmlspecialchars("Ungültige oder fehlende ID zum Löschen."));
        }
        try {
            $game = $this->gameModel->getGameById($id);
            if (!$game) {
                die(htmlspecialchars("Spiel mit ID $id nicht gefunden."));
            }
            $this->render('delete_game', ['game' => $game]);
        } catch (Exception $e) {
            die(htmlspecialchars("Fehler beim Laden des Spiels zum Löschen: " . $e->getMessage()));
        }
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=list');
            return;
        }
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            die(htmlspecialchars("Ungültige oder fehlende ID zum Löschen."));
        }
        try {
            $deletedRows = $this->gameModel->deleteGame($id);
            if ($deletedRows === 0) {
                die(htmlspecialchars("Spiel mit ID $id konnte nicht gefunden oder gelöscht werden."));
            }
            $this->redirect('index.php?action=list&status=deleted');
        } catch (Exception $e) {
            die(htmlspecialchars("Fehler beim Löschen des Spiels: " . $e->getMessage()));
        }
    }

    private function render(string $viewName, array $data = []): void
    {
        extract($data);
        $filePath = $this->viewPath . $viewName . '.php';
        if (file_exists($filePath)) {
            require $filePath;
        } else {
            die(htmlspecialchars("View '$viewName' nicht gefunden."));
        }
    }

    private function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }
}