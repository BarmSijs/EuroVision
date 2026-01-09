<?php $title = $title ?? 'Landen'; ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>
</head>

<body>
  <h1>views/countries/index</h1>
  <pre>
  <?php
  print_r(get_defined_vars());
  ?>
  </pre>
</body>

</html>