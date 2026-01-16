<h1><?= htmlspecialchars($title) ?></h1>

<p>Selecteer de winnaar voor <strong><?= htmlspecialchars($event['name']) ?> (<?= $event['year'] ?>)</strong></p>

<div style="border: 1px solid #ccc; padding: 10px; margin: 20px 0;">
    <?php foreach ($participants as $participant): ?>
        <div style="padding: 10px; border-bottom: 1px solid #eee;">
            <strong><?= htmlspecialchars($participant['country_name']) ?></strong>
            <?php if (!empty($participant['artist'])): ?>
                <br><small><?= htmlspecialchars($participant['artist']) ?> - <?= htmlspecialchars($participant['song']) ?></small>
            <?php endif; ?>
            <br>
            <a href="/BramS/EuroVision/events/setWinner/<?= $event['id'] ?>/<?= $participant['id'] ?>"
                style="color: green; text-decoration: none; font-weight: bold;">✓ Selecteer als winnaar</a>
        </div>
    <?php endforeach; ?>
</div>

<a href="/BramS/EuroVision/events/index">Terug naar events</a>