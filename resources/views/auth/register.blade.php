<!doctype html>
<html lang="ru">
<head>
    @include('parts.head', ['title' => 'Регистрация'])
</head>
<body>
    <div class="content">
        <form method="POST" action="{{ asset('register') }}" class="login-form">
            @csrf
            <div class="mb-3 input-block">
                <label for="name" class="form-label">ФИО</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
                <div class="invalid-feedback">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3 input-block">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control @error('login') is-invalid @enderror" name="login" id="login" value="{{ old('login') }}">
                <div class="invalid-feedback">
                    @error('login')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3 input-block">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                <div class="invalid-feedback">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3 input-block">
                <label for="password_confirmation" class="form-label">Повторите пароль</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn submit-btn">Зарегистрировать</button>
        </form>
    </div>
</body>
</html>
