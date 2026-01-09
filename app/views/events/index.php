<?php $title = $title ?? 'Events'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>
    <a href="/EuroVision/public/events/create">Nieuw Event</a>

    <?php if (!empty($events)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Year</th>
                    <th>Name</th>
                    <th>Winner Participant ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['id']) ?></td>
                        <td><?= htmlspecialchars($event['year']) ?></td>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['winner_participant_id'] ?? 'N/A') ?></td>
                        <td>
                            <a href="/EuroVision/public/events/edit/<?= $event['id'] ?>">Bewerk</a>
                            <a href="/EuroVision/public/events/delete/<?= $event['id'] ?>" onclick="return confirm('Weet je het zeker?');">Verwijder</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen events gevonden.</p>
    <?php endif; ?>
</body>

</html>