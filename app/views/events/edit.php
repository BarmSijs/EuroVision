<?php $title = $title ?? 'Bewerk Event'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>

    <form method="POST" action="/EuroVision/public/events/update/<?= $event['id'] ?>">
        <div>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" value="<?= htmlspecialchars($event['year']) ?>" required>
        </div>

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>
        </div>

        <div>
            <label for="winner_participant_id">Winner Participant ID:</label>
            <input type="number" id="winner_participant_id" name="winner_participant_id" value="<?= htmlspecialchars($event['winner_participant_id'] ?? '') ?>">
        </div>

        <button type="submit">Bijwerken</button>
        <a href="/EuroVision/public/events/index">Terug</a>
    </form>
</body>

</html>