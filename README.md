# EuroVision — Minimal PHP MVC Starter

Korte uitleg en instructies:

- Webroot: zet je server (XAMPP) naar de `public/` map.
- Routes: `/` → `HomeController::index()`, `/foo/bar` → `FooController::bar()`.
- Views: `app/views/` — gebruik `Controller::render('viewname', ['key'=> 'value'])`.
- Models: `app/models/Model.php` toont hoe je `app/db.php` gebruikt (PDO).
- DB: pas `app/db.php` aan met je MySQL-instellingen.

Voorbeeld: bezoek `http://localhost/EuroVision/public/` om de startpagina te zien.



git remote add origin https://github.com/BarmSijs/EuroVision.git
git branch -M main
git push -u origin main