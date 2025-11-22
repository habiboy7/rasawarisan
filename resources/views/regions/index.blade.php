<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Pulau</title>
</head>
<body>
  <h1>🌏 Daftar Pulau di Indonesia</h1>

  <ul>
    @foreach ($pulau as $p)
      <li>
        <a href="{{ route('destinasi.show', $p->slug) }}">{{ $p->name }}</a>
      </li>
    @endforeach
  </ul>

</body>
</html>
