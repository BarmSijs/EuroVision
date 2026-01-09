<?php $title = $title ?? 'Nieuwe Score'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>

    <form method="POST" action="/EuroVision/public/scores/store">
        <div>
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" required>
        </div>

        <div>
            <label for="participant_id">Participant ID:</label>
            <input type="number" id="participant_id" name="participant_id" required>
        </div>

        <div>
            <label for="song_score">Song Score:</label>
            <input type="number" id="song_score" name="song_score" value="0" required>
        </div>

        <div>
            <label for="outfit_score">Outfit Score:</label>
            <input type="number" id="outfit_score" name="outfit_score" value="0" required>
        </div>

        <div>
            <label for="act_score">Act Score:</label>
            <input type="number" id="act_score" name="act_score" value="0" required>
        </div>

        <div>
            <label for="total_score">Total Score:</label>
            <input type="number" id="total_score" name="total_score" value="0" required>
        </div>

        <button type="submit">Opslaan</button>
        <a href="/EuroVision/public/scores/index">Terug</a>
    </form>
</body>

</html>