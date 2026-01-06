<?php $title = $title ?? 'Landen'; ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
</head>
<body>
  <h1><?= htmlspecialchars($title) ?></h1>
  <p><a href="<?= BASE_URL ?>/countries/create">Nieuw land toevoegen</a></p>
  <table border="1" cellpadding="6" cellspacing="0">
    <thead>
      <tr><th>ID</th><th>Naam</th><th>Acties</th></tr>
    </thead>
    <tbody>
    <?php if (!empty($countries) && is_array($countries)): ?>
      <?php foreach ($countries as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td>
          <a href="<?= BASE_URL ?>/countries/edit/<?= $c['id'] ?>">Bewerk</a>
          |
          <a href="<?= BASE_URL ?>/countries/delete/<?= $c['id'] ?>" onclick="return confirm('Verwijderen?')">Verwijder</a>
        </td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="3">Geen landen gevonden.</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
