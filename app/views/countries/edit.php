<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
</head>
<body>
  <h1><?= htmlspecialchars($title) ?></h1>
  <form method="post" action="<?= BASE_URL ?>/drinks/update/<?= $drink['id'] ?>">
    <p>
      <label>Naam<br>
      <input name="name" required value="<?= htmlspecialchars($drink['name']) ?>"></label>
    </p>
    <p>
      <label>Prijs<br>
      <input name="price" type="number" step="0.01" value="<?= htmlspecialchars($drink['price']) ?>"></label>
    </p>
    <p>
      <label>Beschrijving<br>
      <textarea name="description"><?= htmlspecialchars($drink['description']) ?></textarea></label>
    </p>
    <p><button type="submit">Bijwerken</button></p>
  </form>
  <p><a href="<?= BASE_URL ?>/drinks/index">Terug</a></p>
</body>
</html>
