<?php
$status = $_GET['status'] ?? '';
$successMessage = '';
if ($status === 'added') {
    $successMessage = "Spiel erfolgreich hinzugefügt!";
} elseif ($status === 'deleted') {
    $successMessage = "Spiel erfolgreich gelöscht!";
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tournamentName); ?> - Spielrunden</title>
    <style>
        body { font-family: sans-serif; max-width: 1100px; margin: 20px auto; padding: 15px; border: 1px solid #ccc; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: auto;}
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; word-wrap: break-word; }
        th { background-color: #f2f2f2; white-space: nowrap; }
        .actions a { margin-right: 5px; text-decoration: none; }
        .add-button { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        .success-message { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center;}
        @media (max-width: 800px) {
            table, thead, tbody, th, td, tr { display: block; }
            thead tr { position: absolute; top: -9999px; left: -9999px; }
            tr { border: 1px solid #ccc; margin-bottom: 10px; }
            td { border: none; border-bottom: 1px solid #eee; position: relative; padding-left: 45%; white-space: normal; text-align:right; min-height: 24px; }
            td:before { position: absolute; top: 6px; left: 6px; width: 40%; padding-right: 10px; white-space: nowrap; text-align:left; font-weight: bold; }
            td:nth-of-type(1):before { content: "Spieler 1:"; }
            td:nth-of-type(2):before { content: "Symbol P1:"; }
            td:nth-of-type(3):before { content: "Spieler 2:"; }
            td:nth-of-type(4):before { content: "Symbol P2:"; }
            td:nth-of-type(5):before { content: "Datum/Zeit:"; }
            td:nth-of-type(6):before { content: "Aktionen:"; }
            .actions { text-align: right; }
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($tournamentName); ?></h1>
    <p style="text-align: center;">Datum: <?php echo htmlspecialchars($currentDate); ?></p>

    <?php if ($successMessage): ?>
        <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
    <?php endif; ?>

    <a href="index.php?action=showAddForm" class="add-button">Neues Spiel hinzufügen</a>

    <h2>Spielrunden</h2>
    <table>
        <thead>
            <tr>
                <th>Spieler 1</th>
                <th>Symbol P1</th>
                <th>Spieler 2</th>
                <th>Symbol P2</th>
                <th>Datum & Zeit</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($games)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Noch keine Spiele erfasst.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($games as $game): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($game['player1']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($game['symbol_player1'])); ?></td>
                        <td><?php echo htmlspecialchars($game['player2']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($game['symbol_player2'])); ?></td>
                        <td><?php echo htmlspecialchars(date('d.m.Y H:i:s', strtotime($game['game_date']))); ?></td>
                        <td class="actions">
                            <a href="index.php?action=showDeleteForm&id=<?php echo $game['id']; ?>" style="color: red;" onclick="return confirm('Sicher, dass du dieses Spiel löschen willst? Das kann nicht rückgängig gemacht werden.');">Löschen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>