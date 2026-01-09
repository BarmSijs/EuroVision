<?php $title = $title ?? 'Participants'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>
    <a href="/EuroVision/public/participants/create">Nieuwe Participant</a>

    <?php if (!empty($participants)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event ID</th>
                    <th>Country ID</th>
                    <th>Artist</th>
                    <th>Song</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($participants as $participant): ?>
                    <tr>
                        <td><?= htmlspecialchars($participant['id']) ?></td>
                        <td><?= htmlspecialchars($participant['event_id']) ?></td>
                        <td><?= htmlspecialchars($participant['country_id']) ?></td>
                        <td><?= htmlspecialchars($participant['artist']) ?></td>
                        <td><?= htmlspecialchars($participant['song']) ?></td>
                        <td>
                            <a href="/EuroVision/public/participants/edit/<?= $participant['id'] ?>">Bewerk</a>
                            <a href="/EuroVision/public/participants/delete/<?= $participant['id'] ?>" onclick="return confirm('Weet je het zeker?');">Verwijder</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen participants gevonden.</p>
    <?php endif; ?>
</body>

</html>