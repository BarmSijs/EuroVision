<h1><?= htmlspecialchars($title) ?></h1>

<form method="POST" action="/EuroVision/public/events/store">
    <div>
        <label for="year">Jaar:</label>
        <input type="number" id="year" name="year" required>
    </div>

    <div>
        <label for="name">Event naam:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div>
        <label>Landen deelnemers:</label>
        <div style="border: 1px solid #ccc; padding: 10px; max-height: 300px; overflow-y: auto;">
            <?php foreach ($countries as $country): ?>
                <div>
                    <input type="checkbox" id="country_<?= $country['id'] ?>"
                        name="countries[]" value="<?= $country['id'] ?>">
                    <label for="country_<?= $country['id'] ?>">
                        <?= htmlspecialchars($country['name']) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div>
        <button type="submit">Aanmaken</button>
        <a href="/EuroVision/public/events/index">Annuleren</a>
    </div>
</form>