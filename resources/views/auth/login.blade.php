<!doctype html>
<html lang="ru">
<head>
    @include('parts.head', ['title' => 'Авторизация'])
</head>
<body>
    <div class="content">
        <div class="auth-form">
            <form method="POST" action="{{ asset('login') }}" class="login-form">
                @csrf
                @error('data_invalid')
                    <div class="alert alert-dark" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mb-3 input-block">
                    <label for="code" class="form-label">Код сотрудника склада</label>
                    <input type="number" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code') }}">
                    <div class="invalid-feedback">
                        @error('code')
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
                <button type="submit" class="btn submit-btn">Вход</button>
            </form>
        </div>
    </div>
</body>
</html>
