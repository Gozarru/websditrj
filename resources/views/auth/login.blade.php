<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Masuk admin — {{ site('school_name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="login">
    <div class="login-brand"><span class="sb-logo">RJ</span><div><h1>Masuk admin</h1><span class="muted">{{ site('school_name') }}</span></div></div>
    <form class="card" method="POST" action="{{ route('login') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email')<div class="errs">{{ $message }}</div>@enderror
        <label for="password">Kata sandi</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">
        @error('password')<div class="errs">{{ $message }}</div>@enderror
        <label class="chk"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
        <p><button class="btn" type="submit">Masuk</button></p>
    </form>
    <p><a href="{{ route('home') }}">Kembali ke website</a></p>
</div>
</body>
</html>
