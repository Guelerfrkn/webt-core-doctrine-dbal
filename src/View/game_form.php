<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neues Spiel hinzufügen</title>
     <style>
        body { font-family: sans-serif; max-width: 650px; margin: 20px auto; padding: 15px; border: 1px solid #ccc; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="datetime-local"], select { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; box-sizing: border-box; border-radius: 4px; }
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button[type="button"] { background-color: #6c757d; margin-left: 10px;}
        .form-group { margin-bottom: 15px; }
        .player-section { border: 1px dashed #007bff; padding: 15px; margin-bottom: 20px; border-radius: 5px; background-color: #f8f9fa; }
        .player-section h3 { margin-top: 0; color: #0056b3; border-bottom: 1px solid #dee2e6; padding-bottom: 5px;}
    </style>
</head>
<body>
    <h1>Neues Spiel hinzufügen</h1>

    <form action="index.php?action=add" method="post">
        <div class="player-section">
            <h3>Spieler 1</h3>
            <div class="form-group">
                <label for="player1">Name Spieler 1:</label>
                <input type="text" id="player1" name="player1" value="" required>
            </div>
            <div class="form-group">
                <label for="symbol_player1">Symbol Spieler 1:</label>
                <select id="symbol_player1" name="symbol_player1" required>
                    <option value="">Bitte wählen</option>
                    <option value="rock">Stein (Rock)</option>
                    <option value="paper">Papier (Paper)</option>
                    <option value="scissors">Schere (Scissors)</option>
                </select>
            </div>
        </div>

        <div class="player-section">
            <h3>Spieler 2</h3>
            <div class="form-group">
                <label for="player2">Name Spieler 2:</label>
                <input type="text" id="player2" name="player2" value="" required>
            </div>
            <div class="form-group">
                <label for="symbol_player2">Symbol Spieler 2:</label>
                <select id="symbol_player2" name="symbol_player2" required>
                    <option value="">Bitte wählen</option>
                    <option value="rock">Stein (Rock)</option>
                    <option value="paper">Papier (Paper)</option>
                    <option value="scissors">Schere (Scissors)</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="game_date">Datum & Zeit (optional):</label>
            <input type="datetime-local" id="game_date" name="game_date" value="">
            <small>Leer lassen für aktuelle Zeit.</small>
        </div>
        <button type="submit">Spiel speichern</button>
        <button type="button" onclick="window.location.href='index.php?action=list'">Abbrechen</button>
    </form>
</body>
</html>