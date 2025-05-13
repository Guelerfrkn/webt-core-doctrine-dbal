<?php
// src/View/game_form.php
/**
 * @var array|null $errors Array mit Fehlermeldungen
 * @var array|null $old_values Array mit vorherigen Eingaben bei Fehler
 */
$errors = $errors ?? []; // Sicherstellen, dass $errors existiert
$old_values = $old_values ?? []; // Sicherstellen, dass $old_values existiert
?>
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
        .error-message { color: red; font-size: 0.9em; margin-top: -5px; margin-bottom: 10px;}
        .db-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center;}
    </style>
</head>
<body>
    <h1>Neues Spiel hinzufügen</h1>

    <?php if (isset($errors['db_error'])): ?>
        <div class="db-error"><?php echo htmlspecialchars($errors['db_error']); ?></div>
    <?php endif; ?>
    <?php if (isset($errors['player_names'])): ?>
        <div class="error-message" style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 10px; border-radius: 5px; text-align:center;">
            <?php echo htmlspecialchars($errors['player_names']); ?>
        </div>
    <?php endif; ?>


    <form action="index.php?action=add" method="post">
        <div class="player-section">
            <h3>Spieler 1</h3>
            <div class="form-group">
                <label for="player1">Name Spieler 1:</label>
                <input type="text" id="player1" name="player1" value="<?php echo htmlspecialchars($old_values['player1'] ?? ''); ?>" required>
                <?php if (isset($errors['player1'])): ?><div class="error-message"><?php echo htmlspecialchars($errors['player1']); ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label for="symbol_player1">Symbol Spieler 1:</label>
                <select id="symbol_player1" name="symbol_player1" required>
                    <option value="">Bitte wählen</option>
                    <option value="rock" <?php echo (($old_values['symbol_player1'] ?? '') === 'rock' ? 'selected' : ''); ?>>Stein (Rock)</option>
                    <option value="paper" <?php echo (($old_values['symbol_player1'] ?? '') === 'paper' ? 'selected' : ''); ?>>Papier (Paper)</option>
                    <option value="scissors" <?php echo (($old_values['symbol_player1'] ?? '') === 'scissors' ? 'selected' : ''); ?>>Schere (Scissors)</option>
                </select>
                <?php if (isset($errors['symbol_player1'])): ?><div class="error-message"><?php echo htmlspecialchars($errors['symbol_player1']); ?></div><?php endif; ?>
            </div>
        </div>

        <div class="player-section">
            <h3>Spieler 2</h3>
            <div class="form-group">
                <label for="player2">Name Spieler 2:</label>
                <input type="text" id="player2" name="player2" value="<?php echo htmlspecialchars($old_values['player2'] ?? ''); ?>" required>
                 <?php if (isset($errors['player2'])): ?><div class="error-message"><?php echo htmlspecialchars($errors['player2']); ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label for="symbol_player2">Symbol Spieler 2:</label>
                <select id="symbol_player2" name="symbol_player2" required>
                    <option value="">Bitte wählen</option>
                    <option value="rock" <?php echo (($old_values['symbol_player2'] ?? '') === 'rock' ? 'selected' : ''); ?>>Stein (Rock)</option>
                    <option value="paper" <?php echo (($old_values['symbol_player2'] ?? '') === 'paper' ? 'selected' : ''); ?>>Papier (Paper)</option>
                    <option value="scissors" <?php echo (($old_values['symbol_player2'] ?? '') === 'scissors' ? 'selected' : ''); ?>>Schere (Scissors)</option>
                </select>
                <?php if (isset($errors['symbol_player2'])): ?><div class="error-message"><?php echo htmlspecialchars($errors['symbol_player2']); ?></div><?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="game_date">Datum & Zeit (optional):</label>
            <input type="datetime-local" id="game_date" name="game_date" value="<?php echo htmlspecialchars($old_values['game_date'] ?? ''); ?>">
            <small>Leer lassen für aktuelle Zeit.</small>
        </div>
        <button type="submit">Spiel speichern</button>
        <button type="button" onclick="window.location.href='index.php?action=list'">Abbrechen</button>
    </form>
</body>
</html>