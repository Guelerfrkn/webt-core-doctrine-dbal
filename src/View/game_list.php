<?php
// src/View/game_list.php
/**
 * @var array $games Die Liste der Spiele
 * @var string $tournamentName Der Name des Turniers
 * @var string $currentDate Das aktuelle Datum
 */
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tournamentName); ?> - Spielrunden</title>
    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 20px auto; padding: 15px; border: 1px solid #ccc; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .actions a { margin-right: 5px; text-decoration: none; }
        .add-button { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        /* Responsive Anpassungen */
        @media (max-width: 600px) {
            body { margin: 10px; padding: 10px; }
            table, thead, tbody, th, td, tr { display: block; }
            thead tr { position: absolute; top: -9999px; left: -9999px; }
            tr { border: 1px solid #ccc; margin-bottom: 5px; }
            td { border: none; border-bottom: 1px solid #eee; position: relative; padding-left: 50%; white-space: normal; text-align:right; }
            td:before { position: absolute; top: 6px; left: 6px; width: 45%; padding-right: 10px; white-space: nowrap; text-align:left; font-weight: bold; }
            td:nth-of-type(1):before { content: "Spieler"; }
            td:nth-of-type(2):before { content: "Symbol"; }
            td:nth-of-type(3):before { content: "Datum/Zeit"; }
            td:nth-of-type(4):before { content: "Aktionen"; }
            .actions { text-align: right; }
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($tournamentName); ?></h1>
    <p style="text-align: center;">Datum: <?php echo htmlspecialchars($currentDate); ?></p>

    <a href="index.php?action=showAddForm" class="add-button">Neues Spiel hinzufügen</a>

    <h2>Spielrunden</h2>
    <table>
        <thead>
            <tr>
                <th>Spieler</th>
                <th>Symbol</th>
                <th>Datum & Zeit</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($games)): ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Noch keine Spiele erfasst.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($games as $game): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($game['player']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($game['symbol'])); // Großschreibung ?></td>
                        <td><?php echo htmlspecialchars(date('d.m.Y H:i:s', strtotime($game['game_date']))); ?></td>
                        <td class="actions">
                            <a href="index.php?action=showDeleteForm&id=<?php echo $game['id']; ?>" style="color: red;" onclick="return confirm('Sicher, dass du dieses Spiel löschen willst?');">Löschen</a>
                            </td>
                    </tr>
                <?php endforeach; ?>
                <?php // Füge hier ggf. manuell weitere Dummy-Zeilen hinzu, um immer mind. 5 zu haben, falls DB leer ist ?>
                <?php if (count($games) < 5): ?>
                    <?php for($i = count($games); $i < 5; $i++): ?>
                    <?php endfor; ?>
                <?php endif; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>