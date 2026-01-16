<h1><?= htmlspecialchars($title) ?></h1>

<form method="POST" action="/BramS/EuroVision/events/update/<?= $event['id'] ?>" style="max-width: 500px;">
    <div style="margin-bottom: 15px;">
        <label for="year">Jaar:</label>
        <input type="number" id="year" name="year" value="<?= htmlspecialchars($event['year']) ?>" required
            style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="name">Event naam:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($event['name']) ?>" required
            style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Opslaan
        </button>
        <a href="/BramS/EuroVision/events/participants/<?= $event['id'] ?>"
            style="margin-left: 10px; padding: 10px 20px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px; display: inline-block;">
            Terug naar deelnemers
        </a>
    </div>
</form>