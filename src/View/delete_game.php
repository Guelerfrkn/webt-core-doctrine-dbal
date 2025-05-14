<?php
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spiel löschen bestätigen</title>
     <style>
        body { font-family: sans-serif; max-width: 600px; margin: 20px auto; padding: 15px; border: 1px solid #ccc; }
        .confirmation-box { border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;}
        .confirmation-box p { margin-top: 0; }
        .confirmation-box ul { list-style-type: none; padding-left: 0; margin-bottom: 0;}
        .confirmation-box ul li strong { display: inline-block; width: 90px;}
        button { padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        button[type="submit"] { background-color: #dc3545; color: white; }
        button[type="button"] { background-color: #6c757d; color: white; margin-left: 10px;}
    </style>
</head>
<body>
    <h1>Spiel löschen bestätigen</h1>
    <div class="confirmation-box">
        <p>Bist du sicher, dass du das folgende Spiel unwiderruflich löschen möchtest?</p>
        <ul>
            <li><strong>Spieler 1:</strong> <?php echo htmlspecialchars($game['player1']); ?> (<?php echo htmlspecialchars(ucfirst($game['symbol_player1'])); ?>)</li>
            <li><strong>Spieler 2:</strong> <?php echo htmlspecialchars($game['player2']); ?> (<?php echo htmlspecialchars(ucfirst($game['symbol_player2'])); ?>)</li>
            <li><strong>Datum:</strong> <?php echo htmlspecialchars(date('d.m.Y H:i:s', strtotime($game['game_date']))); ?></li>
        </ul>
    </div>
    <form action="index.php?action=delete" method="post">
        <input type="hidden" name="id" value="<?php echo $game['id']; ?>">
        <button type="submit">Ja, endgültig löschen</button>
        <button type="button" onclick="window.location.href='index.php?action=list'">Nein, abbrechen</button>
    </form>
</body>
</html>