<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
</head>
<body>
  <h1><?= htmlspecialchars($title) ?></h1>
  <p>Dit is een eenvoudige startpagina.</p>
  <a href="<?= BASE_URL ?>/countries">Bekijk landen</a>
</body>
</html>