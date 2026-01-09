<?php $title = $title ?? 'Bewerk Score'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>

    <form method="POST" action="/EuroVision/public/scores/update/<?= $score['id'] ?>">
        <div>
            <label for="song_score">Song Score:</label>
            <input type="number" id="song_score" name="song_score" value="<?= htmlspecialchars($score['song_score']) ?>" required>
        </div>

        <div>
            <label for="outfit_score">Outfit Score:</label>
            <input type="number" id="outfit_score" name="outfit_score" value="<?= htmlspecialchars($score['outfit_score']) ?>" required>
        </div>

        <div>
            <label for="act_score">Act Score:</label>
            <input type="number" id="act_score" name="act_score" value="<?= htmlspecialchars($score['act_score']) ?>" required>
        </div>

        <div>
            <label for="total_score">Total Score:</label>
            <input type="number" id="total_score" name="total_score" value="<?= htmlspecialchars($score['total_score']) ?>" required>
        </div>

        <button type="submit">Bijwerken</button>
        <a href="/EuroVision/public/scores/index">Terug</a>
    </form>
</body>

</html>