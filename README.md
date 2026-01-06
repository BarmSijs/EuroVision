# EuroVision — Minimal PHP MVC Starter

Korte uitleg en instructies:

- Webroot: zet je server (XAMPP) naar de `public/` map.
- Front controller: `public/front.php` behandelt inkomende requests via `app/router.php`.
- Routes: `/` → `HomeController::index()`, `/foo/bar` → `FooController::bar()`.
- Views: `app/views/` — gebruik `Controller::render('viewname', ['key'=> 'value'])`.
- Models: `app/models/Model.php` toont hoe je `app/db.php` gebruikt (PDO).
- DB: pas `app/db.php` aan met je MySQL-instellingen.

Voorbeeld: bezoek `http://localhost/EuroVision/public/` om de startpagina te zien.
