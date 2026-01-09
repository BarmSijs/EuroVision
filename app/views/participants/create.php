<?php $title = $title ?? 'Nieuwe Participant'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>

    <form method="POST" action="/EuroVision/public/participants/store">
        <div>
            <label for="event_id">Event ID:</label>
            <input type="number" id="event_id" name="event_id" required>
        </div>

        <div>
            <label for="country_id">Country ID:</label>
            <input type="number" id="country_id" name="country_id" required>
        </div>

        <div>
            <label for="artist">Artist:</label>
            <input type="text" id="artist" name="artist" required>
        </div>

        <div>
            <label for="song">Song:</label>
            <input type="text" id="song" name="song" required>
        </div>

        <button type="submit">Opslaan</button>
        <a href="/EuroVision/public/participants/index">Terug</a>
    </form>
</body>

</html>