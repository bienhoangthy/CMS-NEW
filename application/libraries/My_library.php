<?php
class my_library
{
    public static function base_url()
    {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/';
        return $url;
    }
    public static function cdn_url()
    {
        $url = 'http://cdn.' . $_SERVER['SERVER_NAME'] . '/';
        return $url;
    }
    public static function admin_site()
    {
        $url = self::base_url() . 'admin/';
        return $url;
    }
    
    public static function lang()
    {
        $lang = 'vn';
        return $lang;
    }
    public static function base_file()
    {
        $url = self::base_url() . 'media/';
        return $url;
    }
    public static function base_public()
    {
        $url = self::base_url() . 'public/';
        return $url;
    }

    //Admin
    public static function admin_css()
    {
        $url = self::base_url() . 'public/admin/css/';
        return $url;
    }
    public static function admin_js()
    {
        $url = self::base_url() . 'public/admin/js/';
        return $url;
    }
    public static function admin_images()
    {
        $url = self::base_url() . 'public/admin/images/';
        return $url;
    }
}
