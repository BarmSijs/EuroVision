<div style="display: flex;; align-items: center;">
    <h1>Events</h1>
    <a href="/BramS/EuroVision/events/create" style="font-size: 30px; text-decoration: none;">➕</a>
</div>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Jaar</th>
            <th>Event</th>
            <th>Winnaar</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['year']) ?></td>
                <td><?= htmlspecialchars($event['name']) ?></td>
                <td>
                    <?php if (!empty($event['winner']) && !empty($event['winner']['artist'])): ?>
                        <strong><?= htmlspecialchars($event['winner']['artist']) ?></strong><br>
                        <?= htmlspecialchars($event['winner']['song'] ?? '') ?>
                    <?php else: ?>
                        Geen winnaar
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/BramS/EuroVision/events/participants/<?= $event['id'] ?>">Bewerk</a>
                    <a href="/BramS/EuroVision/scores/scoreEvent/<?= $event['id'] ?>">Scores</a>
                    <a href="/BramS/EuroVision/events/delete/<?= $event['id'] ?>">Verwijder</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>