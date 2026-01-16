<h1><?= htmlspecialchars($title) ?></h1>

<p>Event: <strong><?= htmlspecialchars($event['name']) ?></strong> (<?= $event['year'] ?>)</p>

<div style="margin-bottom: 20px;">
    <label for="user_id">Beoordelaar:</label>
    <select id="user_id" onchange="window.location.href='/BramS/EuroVision/scores/resultsEvent/<?= $event['id'] ?>/' + this.value" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        <option value="">-- Selecteer beoordelaar --</option>
        <?php foreach ($users as $user): ?>
            <?php if (in_array($user['id'], $usersWithScores)): ?>
                <option value="<?= $user['id'] ?>" <?= $user['id'] == $selectedUserId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)
                </option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>

<?php if (!empty($participantScores)): ?>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="width: 50px;">Plaats</th>
                <th>Land</th>
                <th>Artiest</th>
                <th>Lied</th>
                <th style="width: 100px;">Lied</th>
                <th style="width: 100px;">Outfit</th>
                <th style="width: 100px;">Act</th>
                <th style="width: 100px;">Totaal</th>
            </tr>
        </thead>
        <tbody>
            <?php $place = 1; ?>
            <?php foreach ($participantScores as $ps): ?>
                <tr style="background-color: <?= $place === 1 ? '#FFD700' : ($place === 2 ? '#C0C0C0' : ($place === 3 ? '#CD7F32' : 'white')) ?>;">
                    <td style="text-align: center; font-weight: bold;">
                        <?php if ($place === 1): ?>🥇<?php elseif ($place === 2): ?>🥈<?php elseif ($place === 3): ?>🥉<?php else: ?><?= $place ?><?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($ps['participant']['country_name']) ?></td>
                    <td><?= htmlspecialchars($ps['participant']['artist'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($ps['participant']['song'] ?? '-') ?></td>
                    <td style="text-align: center;"><?= $ps['song_score'] ?></td>
                    <td style="text-align: center;"><?= $ps['outfit_score'] ?></td>
                    <td style="text-align: center;"><?= $ps['act_score'] ?></td>
                    <td style="text-align: center; font-weight: bold; font-size: 16px;">
                        <?= $ps['total_score'] ?>
                    </td>
                </tr>
                <?php $place++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="color: #666; padding: 20px; background-color: #f5f5f5; border-radius: 4px;">
        Geen scores beschikbaar voor deze beoordelaar.
    </p>
<?php endif; ?>

<div style="margin-top: 20px;">
    <a href="/BramS/EuroVision/scores/scoreEvent/<?= $event['id'] ?>"
        style="background-color: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
        ← Terug naar scoring
    </a>
    <a href="/BramS/EuroVision/events/index"
        style="margin-left: 10px; padding: 10px 20px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;">
        Terug naar events
    </a>
</div>


<style>
    table td {
        vertical-align: top;
    }
</style>