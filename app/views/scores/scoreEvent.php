<h1><?= htmlspecialchars($title) ?></h1>

<p>Event: <strong><?= htmlspecialchars($event['name']) ?></strong> (<?= $event['year'] ?>)</p>

<form method="POST" action="/BramS/EuroVision/scores/saveScores/<?= $event['id'] ?>">
    <div style="margin-bottom: 20px;">
        <label for="user_id">Beoordelaar:</label>
        <select id="user_id" name="user_id" required onchange="loadUserScores(this.value)" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="">-- Selecteer beoordelaar --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Land</th>
                <th>Artiest</th>
                <th>Lied</th>
                <th>Lied Score (0-10)</th>
                <th>Outfit Score (0-10)</th>
                <th>Act Score (0-10)</th>
                <th>Totaal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $p): ?>
                <tr data-participant-id="<?= $p['id'] ?>">
                    <td><?= htmlspecialchars($p['country_name']) ?></td>
                    <td><?= htmlspecialchars($p['artist'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($p['song'] ?? '-') ?></td>
                    <td>
                        <input type="number" name="scores[<?= $p['id'] ?>][song]" min="0" max="10" value="0"
                            onchange="calculateTotal(this)" class="score-input"
                            style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 80px; text-align: center;">
                    </td>
                    <td>
                        <input type="number" name="scores[<?= $p['id'] ?>][outfit]" min="0" max="10" value="0"
                            onchange="calculateTotal(this)" class="score-input"
                            style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 80px; text-align: center;">
                    </td>
                    <td>
                        <input type="number" name="scores[<?= $p['id'] ?>][act]" min="0" max="10" value="0"
                            onchange="calculateTotal(this)" class="score-input"
                            style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 80px; text-align: center;">
                    </td>
                    <td>
                        <span class="total" data-participant-id="<?= $p['id'] ?>">0</span>/30
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Scores opslaan
        </button>
        <a href="/BramS/EuroVision/scores/resultsEvent/<?= $event['id'] ?>"
            style="margin-left: 10px; background-color: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
            Bekijk resultaten →
        </a>
        <a href="/BramS/EuroVision/events/index"
            style="margin-left: 10px; padding: 10px 20px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;">
            Terug naar events
        </a>
    </div>
</form>

<script>
    const scoresData = <?= json_encode($scoresMap) ?>;

    function loadUserScores(userId) {
        if (!userId || !scoresData[userId]) {
            document.querySelectorAll('.score-input').forEach(input => {
                input.value = '0';
                calculateTotal(input);
            });
            return;
        }

        const userScores = scoresData[userId];
        document.querySelectorAll('tr[data-participant-id]').forEach(row => {
            const participantId = row.dataset.participantId;
            if (userScores[participantId]) {
                const score = userScores[participantId];
                row.querySelector('input[name*="[song]"]').value = score.song_score || 0;
                row.querySelector('input[name*="[outfit]"]').value = score.outfit_score || 0;
                row.querySelector('input[name*="[act]"]').value = score.act_score || 0;
                calculateTotal(row.querySelector('.score-input'));
            } else {
                row.querySelector('input[name*="[song]"]').value = 0;
                row.querySelector('input[name*="[outfit]"]').value = 0;
                row.querySelector('input[name*="[act]"]').value = 0;
                calculateTotal(row.querySelector('.score-input'));
            }
        });
    }

    function calculateTotal(input) {
        const row = input.closest('tr');
        const song = parseInt(row.querySelector('input[name*="[song]"]').value) || 0;
        const outfit = parseInt(row.querySelector('input[name*="[outfit]"]').value) || 0;
        const act = parseInt(row.querySelector('input[name*="[act]"]').value) || 0;
        const total = song + outfit + act;
        row.querySelector('.total').textContent = total;
    }
</script>