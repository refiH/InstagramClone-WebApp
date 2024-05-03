<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/icon-512.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/icon-192.png">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @routes
  @inertiaHead
</head>

<body>
  @inertia
</body>

</html>
