<h1><?= htmlspecialchars($title) ?></h1>

<form method="POST" action="/BramS/EuroVision/participants/update/<?= $participant['id'] ?>" style="max-width: 500px;">
    <div style="margin-bottom: 15px;">
        <label for="country_id">Land:</label>
        <input type="text" id="country_id" value="Land ID: <?= $participant['country_id'] ?>" disabled
            style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%; background-color: #f5f5f5;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="artist">Artiest:</label>
        <input type="text" id="artist" name="artist" value="<?= htmlspecialchars($participant['artist'] ?? '') ?>" required
            placeholder="Voer de artiestennaam in"
            style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="song">Lied:</label>
        <input type="text" id="song" name="song" value="<?= htmlspecialchars($participant['song'] ?? '') ?>" required
            placeholder="Voer de liefdnaam in"
            style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
    </div>

    <input type="hidden" name="event_id" value="<?= $participant['event_id'] ?>">

    <div style="margin-top: 20px;">
        <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Opslaan
        </button>
        <a href="/BramS/EuroVision/events/participants/<?= $participant['event_id'] ?>"
            style="margin-left: 10px; padding: 10px 20px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px; display: inline-block;">
            Annuleren
        </a>
    </div>
</form>