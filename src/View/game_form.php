<?php // src/View/game_form.php ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neues Spiel hinzufügen</title>
     <style>
        body { font-family: sans-serif; max-width: 600px; margin: 20px auto; padding: 15px; border: 1px solid #ccc; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="datetime-local"], select { width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button[type="button"] { background-color: #6c757d; margin-left: 10px;}
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Neues Spiel hinzufügen</h1>
    <form action="index.php?action=add" method="post">
        <div class="form-group">
            <label for="player">Spieler:</label>
            <input type="text" id="player" name="player" required>
        </div>
        <div class="form-group">
            <label for="symbol">Symbol:</label>
            <select id="symbol" name="symbol" required>
                <option value="">Bitte wählen</option>
                <option value="rock">Rock (Stein)</option>
                <option value="paper">Paper (Papier)</option>
                <option value="scissors">Scissors (Schere)</option>
            </select>
        </div>
         <div class="form-group">
            <label for="game_date">Datum & Zeit (optional):</label>
            <input type="datetime-local" id="game_date" name="game_date">
             <small>Leer lassen für aktuelle Zeit.</small>
        </div>
        <button type="submit">Spiel speichern</button>
        <button type="button" onclick="window.location.href='index.php?action=list'">Abbrechen</button>
    </form>
</body>
</html>