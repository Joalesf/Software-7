<?php
// modelos/Cookie.php - Modelo para gestionar cookies

class Cookie {
    const COOKIE_NAME = 'nombre_usuario';
    const COOKIE_TIME = 300; // 5 minutos
    
    public static function crear($nombre) {
        setcookie(self::COOKIE_NAME, $nombre, time() + self::COOKIE_TIME, "/");
        return true;
    }
    
    public static function obtener() {
        return isset($_COOKIE[self::COOKIE_NAME]) ? $_COOKIE[self::COOKIE_NAME] : null;
    }
    
    public static function existe() {
        return isset($_COOKIE[self::COOKIE_NAME]);
    }
    
    public static function eliminar() {
        setcookie(self::COOKIE_NAME, '', time() - 3600, "/");
        return true;
    }
}
?>
