<h1><?= htmlspecialchars($title) ?></h1>

<p>Event: <strong><?= htmlspecialchars($event['name']) ?></strong> (<?= $event['year'] ?>)
    <a href="/BramS/EuroVision/events/edit/<?= $event['id'] ?>" style="margin-left: 10px; font-size: 14px;">✏️ Bewerk event</a>
</p>

<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
    <thead>
        <tr>
            <th>Land</th>
            <th>Artiest</th>
            <th>Lied</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($participants as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['country_name']) ?></td>
                <td><?= htmlspecialchars($p['artist'] ?? '-') ?></td>
                <td><?= htmlspecialchars($p['song'] ?? '-') ?></td>
                <td>
                    <a href="/BramS/EuroVision/participants/edit/<?= $p['id'] ?>">Bewerk</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div style="margin-top: 20px; margin-bottom: 20px;">
    <button onclick="document.getElementById('addParticipantForm').style.display='block'"
        style="background-color: #2196F3; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
        ➕ Nieuwe deelnemer toevoegen
    </button>
</div>

<!-- Form voor nieuwe deelnemer -->
<div id="addParticipantForm" style="display:none; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 4px; background-color: #f9f9f9;">
    <h3>Nieuwe deelnemer toevoegen</h3>
    <form method="POST" action="/BramS/EuroVision/events/addParticipant/<?= $event['id'] ?>">
        <div style="margin-bottom: 15px;">
            <label for="country_id">Land:</label>
            <select id="country_id" name="country_id" required style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
                <option value="">-- Selecteer land --</option>
                <?php
                // Haal alle landen op die nog niet in dit event zitten
                $existingCountries = array_map(fn($p) => $p['country_id'], $participants);
                foreach ($this->countrieModel->all() as $country):
                    if (!in_array($country['id'], $existingCountries)):
                ?>
                        <option value="<?= $country['id'] ?>"><?= htmlspecialchars($country['name']) ?></option>
                <?php
                    endif;
                endforeach;
                ?>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="artist">Artiest:</label>
            <input type="text" id="artist" name="artist" placeholder="Artiest" required
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="song">Lied:</label>
            <input type="text" id="song" name="song" placeholder="Lied" required
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
        </div>

        <div>
            <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                Toevoegen
            </button>
            <button type="button" onclick="document.getElementById('addParticipantForm').style.display='none'"
                style="margin-left: 10px; padding: 10px 20px; border: 1px solid #ccc; border-radius: 4px; background: white; cursor: pointer;">
                Annuleren
            </button>
        </div>
    </form>
</div>

<div style="margin-top: 20px;">
    <a href="/BramS/EuroVision/events/selectWinner/<?= $event['id'] ?>"
        style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
        Alle deelnemers klaar → Winnaar selecteren
    </a>
    <a href="/BramS/EuroVision/events/index"
        style="margin-left: 10px; padding: 10px 20px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;">
        Terug naar events
    </a>
</div>