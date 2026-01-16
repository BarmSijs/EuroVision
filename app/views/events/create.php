<h1><?= htmlspecialchars($title) ?></h1>

<form method="POST" action="/BramS/EuroVision/events/store">
    <div style="margin-bottom: 15px;">
        <label for="year">Jaar:</label>
        <input type="number" id="year" name="year" required style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="name">Event naam:</label>
        <input type="text" id="name" name="name" required style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 300px;">
    </div>

    <div style="margin-bottom: 20px;">
        <label>Landen deelnemers:</label>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 10px;">
            <thead>
                <tr>
                    <th>Land</th>
                    <th>Artiest</th>
                    <th>Lied</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($countries as $country): ?>
                    <tr>
                        <td>
                            <input type="checkbox" id="country_<?= $country['id'] ?>"
                                name="participants[<?= $country['id'] ?>][country_id]"
                                value="<?= $country['id'] ?>"
                                class="country-checkbox"
                                onchange="toggleCountryRow(this)">
                            <label for="country_<?= $country['id'] ?>" style="cursor: pointer;">
                                <?= htmlspecialchars($country['name']) ?>
                            </label>
                        </td>
                        <td>
                            <input type="text"
                                name="participants[<?= $country['id'] ?>][artist]"
                                placeholder="Artiest"
                                class="participant-field"
                                disabled
                                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
                        </td>
                        <td>
                            <input type="text"
                                name="participants[<?= $country['id'] ?>][song]"
                                placeholder="Lied"
                                class="participant-field"
                                disabled
                                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div>
        <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Aanmaken</button>
        <a href="/BramS/EuroVision/events/index" style="margin-left: 10px; padding: 10px 20px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px; display: inline-block;">Annuleren</a>
    </div>
</form>

<script>
    function toggleCountryRow(checkbox) {
        const row = checkbox.closest('tr');
        const fields = row.querySelectorAll('.participant-field');
        fields.forEach(field => {
            field.disabled = !checkbox.checked;
            if (checkbox.checked) {
                field.style.backgroundColor = '#fff';
            } else {
                field.style.backgroundColor = '#f5f5f5';
                field.value = '';
            }
        });
    }

    // Bij page load, alle rijen als disabled
    document.querySelectorAll('.participant-field').forEach(field => {
        field.disabled = true;
        field.style.backgroundColor = '#f5f5f5';
    });
</script>