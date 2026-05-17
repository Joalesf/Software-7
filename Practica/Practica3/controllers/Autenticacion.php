<?php

class Autenticacion
{
    public static function verificarSesion(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function iniciarSesion(array $usuario): void
    {
        session_regenerate_id(true);

        $_SESSION['user_id'] = (int) $usuario['id'];
        $_SESSION['username'] = $usuario['usuario'];
        $_SESSION['full_name'] = $usuario['nombre_completo'];
        $_SESSION['email'] = $usuario['correo'];
    }

    public static function crearTokenRecuerdame(int $usuarioId): void
    {
        TokenRecuerdame::eliminarExpirados();

        $plainToken = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $plainToken);
        $expiresAt = time() + ((int) app_config('remember_days') * 86400);

        TokenRecuerdame::crear($usuarioId, $tokenHash, date('Y-m-d H:i:s', $expiresAt));
        self::setCookie(app_config('remember_cookie'), $plainToken, $expiresAt, true);
    }

    public static function eliminarTokenRecuerdame(): void
    {
        $cookieName = app_config('remember_cookie');
        $plainToken = $_COOKIE[$cookieName] ?? '';

        if ($plainToken !== '') {
            try {
                TokenRecuerdame::eliminarPorTokenPlano($plainToken);
            } catch (PDOException $exception) {
                error_log($exception->getMessage());
            }
        }

        self::clearCookie($cookieName);
    }

    public static function intentarSesionConCookie(): bool
    {
        if (self::verificarSesion()) {
            return true;
        }

        $cookieName = app_config('remember_cookie');
        $plainToken = $_COOKIE[$cookieName] ?? '';

        if ($plainToken === '') {
            return false;
        }

        $token = TokenRecuerdame::buscarValidoPorTokenPlano($plainToken);

        if (!$token) {
            self::clearCookie($cookieName);
            return false;
        }

        $usuario = Usuario::buscarPorId((int) $token['usuario_id']);

        if (!$usuario) {
            TokenRecuerdame::eliminarPorTokenPlano($plainToken);
            self::clearCookie($cookieName);
            return false;
        }

        TokenRecuerdame::eliminarPorId((int) $token['id']);
        self::iniciarSesion($usuario);
        self::crearTokenRecuerdame((int) $usuario['id']);

        return true;
    }

    public static function cerrarSesion(): void
    {
        self::eliminarTokenRecuerdame();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 3600,
                'path' => $params['path'],
                'domain' => $params['domain'],
                'secure' => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }

        session_destroy();
    }

    public static function temaActual(): string
    {
        $theme = $_COOKIE[app_config('theme_cookie')] ?? 'default';
        return in_array($theme, app_config('themes'), true) ? $theme : 'default';
    }

    public static function guardarTema(string $theme): void
    {
        if (!in_array($theme, app_config('themes'), true)) {
            $theme = 'default';
        }

        $expiresAt = time() + ((int) app_config('theme_days') * 86400);
        self::setCookie(app_config('theme_cookie'), $theme, $expiresAt, false);
    }

    private static function setCookie(string $name, string $value, int $expiresAt, bool $httpOnly): void
    {
        $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

        setcookie($name, $value, [
            'expires' => $expiresAt,
            'path' => '/',
            'secure' => $isHttps,
            'httponly' => $httpOnly,
            'samesite' => 'Lax',
        ]);

        $_COOKIE[$name] = $value;
    }

    private static function clearCookie(string $name): void
    {
        $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

        setcookie($name, '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        unset($_COOKIE[$name]);
    }
}
