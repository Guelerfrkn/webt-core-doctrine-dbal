<?php
// src/Controller/GameController.php

namespace Furka\WebtCoreDoctrineDbal\Controller; // Namespace gemäß deiner composer.json

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

    /**
     * Zeigt die Liste aller Spiele an (User Story 1 & 4).
     */
    public function list(): void
    {
        try {
            $games = $this->gameModel->getAllGames();
            $tournamentName = "USARPS Championship Comeback"; // Beispielname
            $currentDate = date('d.m.Y'); // Aktuelles Datum

            // Lade die View und übergib die Daten
            $this->render('game_list', [
                'games' => $games,
                'tournamentName' => $tournamentName,
                'currentDate' => $currentDate
            ]);
        } catch (Exception $e) {
            $this->showError("Fehler beim Laden der Spiele: " . $e->getMessage());
        }
    }

    /**
     * Zeigt das Formular zum Hinzufügen eines Spiels (User Story 5).
     */
    public function showAddForm(): void
    {
        $this->render('game_form');
    }

    /**
     * Verarbeitet das Hinzufügen eines neuen Spiels (User Story 5).
     */
    public function add(): void
    {
        // Nur POST-Requests erlauben
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=list'); // Zurück zur Liste
            return;
        }

        $player = trim($_POST['player'] ?? '');
        $symbol = trim($_POST['symbol'] ?? '');
        // Optional: Datum aus Formular oder null für Standard
        $gameDate = !empty(trim($_POST['game_date'] ?? '')) ? trim($_POST['game_date']) : null;


        // Einfache Validierung
        if (empty($player) || !in_array($symbol, ['rock', 'paper', 'scissors'])) {
            // Im echten Projekt: Bessere Fehlerbehandlung/Feedback
             $this->showError("Ungültige Eingabe. Spieler und gültiges Symbol sind erforderlich.");
            return;
        }

        try {
            $this->gameModel->addGame($player, $symbol, $gameDate);
            // Nach Erfolg zur Liste weiterleiten
            $this->redirect('index.php?action=list');
        } catch (Exception $e) {
             $this->showError("Fehler beim Speichern des Spiels: " . $e->getMessage());
        }
    }

     /**
      * Zeigt die Bestätigungsseite zum Löschen eines Spiels (User Story 6).
      */
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
             $this->render('delete_game', ['game' => $game]);
         } catch (Exception $e) {
              $this->showError("Fehler beim Laden des Spiels zum Löschen: " . $e->getMessage());
         }
     }

    /**
     * Verarbeitet das Löschen eines Spiels (User Story 6).
     */
    public function delete(): void
    {
        // Nur POST-Requests erlauben
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
            // Nach Erfolg zur Liste weiterleiten
             $this->redirect('index.php?action=list');
        } catch (Exception $e) {
             $this->showError("Fehler beim Löschen des Spiels: " . $e->getMessage());
        }
    }

    /**
     * Hilfsfunktion zum Rendern einer View mit Daten.
     * @param string $viewName Name der View-Datei (ohne .php)
     * @param array<string, mixed> $data Daten, die in der View verfügbar sein sollen
     */
    private function render(string $viewName, array $data = []): void
    {
        // Macht die Array-Schlüssel zu Variablen in der View
        extract($data);

        // Binde die View-Datei ein
        $filePath = $this->viewPath . $viewName . '.php';
        if (file_exists($filePath)) {
            require $filePath;
        } else {
            $this->showError("View '$viewName' nicht gefunden.");
        }
    }

     /**
      * Einfache Fehleranzeige.
      * @param string $message
      */
     private function showError(string $message): void
     {
         // In einer echten Anwendung würdest du eine Fehler-View rendern oder loggen
         echo "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px;'>"
              . "<strong>Fehler:</strong> " . htmlspecialchars($message)
              . "</div>";
         // Optional: Script hier beenden
         // exit;
     }


    /**
     * Hilfsfunktion für Redirects.
     * @param string $url
     */
    private function redirect(string $url): void
    {
        header("Location: " . $url);
        exit; // Wichtig, um weitere Ausführung zu verhindern
    }
}