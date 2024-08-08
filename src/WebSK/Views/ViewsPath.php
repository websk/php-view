<?php

namespace WebSK\Views;

use WebSK\Config\ConfWrapper;

/**
 * Class ViewsPath
 * @package WebSK\Views
 */
class ViewsPath
{
    const string VIEWS_DIR_NAME = 'views';
    const string VIEWS_MODULES_DIR = 'modules';
    const string SRC_DIR_NAME = 'src';
    const string SITE_FULL_PATH_CONFIG_KEY = 'site_full_path';

    public static function getSiteSrcPath(): string
    {
        return ConfWrapper::value(self::SITE_FULL_PATH_CONFIG_KEY) . DIRECTORY_SEPARATOR . self::SRC_DIR_NAME;
    }

    /**
     * @return string
     */
    public static function getSiteViewsPath(): string
    {
        return ConfWrapper::value(self::SITE_FULL_PATH_CONFIG_KEY) . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME;
    }

    /**
     * @param string $template
     * @return string
     */
    public static function getFullTemplatePath(string $template): string
    {
        return ConfWrapper::value(self::SITE_FULL_PATH_CONFIG_KEY) . DIRECTORY_SEPARATOR . $template;
    }

    /**
     * @param string $module
     * @param string $template
     * @return bool
     */
    public static function existsTemplateByModuleRelativeToRootSitePath(string $module, string $template): bool
    {
        $template_path = ViewsPath::VIEWS_DIR_NAME .  DIRECTORY_SEPARATOR . ViewsPath::VIEWS_MODULES_DIR . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $template;

        if (file_exists(self::getFullTemplatePath($template_path))) {
            return true;
        }

        return false;
    }
}
