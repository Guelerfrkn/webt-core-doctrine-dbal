<?php
// src/Controller/GameController.php

namespace Furka\WebtCoreDoctrineDbal\Controller; // Stelle sicher, dass dieser Namespace mit deiner composer.json übereinstimmt

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
        // Pfad zum View-Ordner relativ zum Controller
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
            $this->showError("Fehler beim Laden der Spiele: " . $e->getMessage());
        }
    }

    public function showAddForm(): void
    {
        $this->render('game_form'); // Die View game_form.php muss angepasst werden
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

        // Erweiterte Validierung
        $errors = [];
        if (empty($player1)) $errors['player1'] = "Name für Spieler 1 ist erforderlich.";
        if (empty($symbolPlayer1) || !in_array($symbolPlayer1, ['rock', 'paper', 'scissors'])) $errors['symbol_player1'] = "Gültiges Symbol für Spieler 1 ist erforderlich.";
        if (empty($player2)) $errors['player2'] = "Name für Spieler 2 ist erforderlich.";
        if (empty($symbolPlayer2) || !in_array($symbolPlayer2, ['rock', 'paper', 'scissors'])) $errors['symbol_player2'] = "Gültiges Symbol für Spieler 2 ist erforderlich.";
        if (!empty($player1) && !empty($player2) && $player1 === $player2) $errors['player_names'] = "Spieler 1 und Spieler 2 dürfen nicht denselben Namen haben.";


        if (!empty($errors)) {
            // Formular erneut anzeigen mit Fehlermeldungen und alten Werten
            $this->render('game_form', ['errors' => $errors, 'old_values' => $_POST]);
            return;
        }

        try {
            $this->gameModel->addGame($player1, $symbolPlayer1, $player2, $symbolPlayer2, $gameDate);
            $this->redirect('index.php?action=list&status=added'); // Status für Erfolgsmeldung
        } catch (Exception $e) {
            // Formular erneut anzeigen mit Fehlermeldung und alten Werten
            $this->render('game_form', ['errors' => ['db_error' => "Fehler beim Speichern des Spiels: " . $e->getMessage()], 'old_values' => $_POST]);
        }
    }

     public function showDeleteForm(): void
     {
         $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
         if (!$id) {
             $this->showError("Ungültige oder fehlende ID zum Löschen.");
             return;
         }
         try {
             $game = $this->gameModel->getGameById($id);
             if (!$game) {
                 $this->showError("Spiel mit ID $id nicht gefunden.");
                 return;
             }
             // Die View delete_game.php muss die neuen Felder anzeigen können
             $this->render('delete_game', ['game' => $game]);
         } catch (Exception $e) {
             $this->showError("Fehler beim Laden des Spiels zum Löschen: " . $e->getMessage());
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
            $this->showError("Ungültige oder fehlende ID zum Löschen.");
            return;
        }
        try {
            $deletedRows = $this->gameModel->deleteGame($id);
            if ($deletedRows === 0) {
                $this->showError("Spiel mit ID $id konnte nicht gefunden oder gelöscht werden.");
                return;
            }
            $this->redirect('index.php?action=list&status=deleted'); // Status für Erfolgsmeldung
        } catch (Exception $e) {
            $this->showError("Fehler beim Löschen des Spiels: " . $e->getMessage());
        }
    }

    private function render(string $viewName, array $data = []): void
    {
        extract($data); // Macht Array-Schlüssel zu Variablen
        $filePath = $this->viewPath . $viewName . '.php';
        if (file_exists($filePath)) {
            require $filePath;
        } else {
            $this->showError("View '$viewName' nicht gefunden.");
        }
    }

    private function showError(string $message): void
    {
        // Eine einfache Fehleranzeige, kann verbessert werden
        echo "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px; background-color: #ffebeb;'>"
             . "<strong>Fehler:</strong> " . htmlspecialchars($message)
             . "<br><a href='javascript:history.back()'>Zurück</a>"
             . "</div>";
    }

    private function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }
}