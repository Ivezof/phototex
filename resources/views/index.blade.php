<!doctype html>
<html lang="ru">
<head>
    @include('parts.head', ['title' => 'Главная'])
</head>
<body>
    @guest
        <div class="content">
            <div class="info">
                <div class="text">БРАК ФОТОТЕХ</div>
                <a href="{{ route('getLogin') }}" class="login-btn">ВОЙТИ</a>
            </div>
        </div>
    @endguest
</body>
</html>
