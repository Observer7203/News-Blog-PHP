<?php

namespace App\Core;

use Smarty;

class View
{
    private static ?Smarty $smarty = null;

    public static function getSmarty(): Smarty
    {
        if (self::$smarty === null) {
            self::$smarty = new Smarty();
            self::$smarty->setTemplateDir(__DIR__ . '/../../templates');
            self::$smarty->setCompileDir(__DIR__ . '/../../templates/compile');
            self::$smarty->setCacheDir(__DIR__ . '/../../templates/cache');

            $appConfig = require __DIR__ . '/../../config/app.php';
            self::$smarty->assign('app_name', $appConfig['name']);
            self::$smarty->assign('app_url', $appConfig['url']);
        }

        return self::$smarty;
    }

    public static function render(string $template, array $data = []): void
    {
        $smarty = self::getSmarty();

        foreach ($data as $key => $value) {
            $smarty->assign($key, $value);
        }

        $smarty->display($template);
    }
}
