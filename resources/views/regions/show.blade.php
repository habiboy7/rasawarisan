<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Provinsi di {{ $pulau->name }}</title>
</head>
<body>
  <h1>🗺️ Provinsi di {{ $pulau->name }}</h1>

  <ul>
    @forelse ($provinsi as $p)
      <li>{{ $p->name }}</li>
    @empty
      <li>Tidak ada provinsi ditemukan di pulau ini.</li>
    @endforelse
  </ul>

  <a href="{{ route('destinasi.index') }}">← Kembali ke daftar pulau</a>
</body>
</html>
