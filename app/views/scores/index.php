<?php $title = $title ?? 'Scores'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>
    <a href="/EuroVision/public/scores/create">Nieuwe Score</a>

    <?php if (!empty($scores)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Participant ID</th>
                    <th>Song Score</th>
                    <th>Outfit Score</th>
                    <th>Act Score</th>
                    <th>Total Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $score): ?>
                    <tr>
                        <td><?= htmlspecialchars($score['id']) ?></td>
                        <td><?= htmlspecialchars($score['user_id']) ?></td>
                        <td><?= htmlspecialchars($score['participant_id']) ?></td>
                        <td><?= htmlspecialchars($score['song_score']) ?></td>
                        <td><?= htmlspecialchars($score['outfit_score']) ?></td>
                        <td><?= htmlspecialchars($score['act_score']) ?></td>
                        <td><?= htmlspecialchars($score['total_score']) ?></td>
                        <td>
                            <a href="/EuroVision/public/scores/edit/<?= $score['id'] ?>">Bewerk</a>
                            <a href="/EuroVision/public/scores/delete/<?= $score['id'] ?>" onclick="return confirm('Weet je het zeker?');">Verwijder</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen scores gevonden.</p>
    <?php endif; ?>
</body>

</html>