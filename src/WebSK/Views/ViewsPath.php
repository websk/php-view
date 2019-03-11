<?php

namespace WebSK\Views;

use WebSK\Config\ConfWrapper;

/**
 * Class ViewsPath
 * @package WebSK\Views
 */
class ViewsPath
{
    const VIEWS_DIR_NAME = 'views';
    const VIEWS_MODULES_DIR = 'modules';
    const SRC_DIR_NAME = 'src';

    public static function getSiteSrcPath()
    {
        return ConfWrapper::value('site_full_path') . DIRECTORY_SEPARATOR . self::SRC_DIR_NAME;
    }

    /**
     * @return string
     */
    public static function getSiteViewsPath()
    {
        return ConfWrapper::value('site_full_path') . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME;
    }

    /**
     * @param string $template
     * @return string
     */
    public static function getFullTemplatePath(string $template)
    {
        return ConfWrapper::value('site_full_path') . DIRECTORY_SEPARATOR . $template;
    }

    /**
     * @param string $module
     * @param string $template
     * @return bool
     */
    public static function existsTemplateByModuleRelativeToRootSitePath(string $module, string $template)
    {
        $site_modules_file_path = ViewsPath::VIEWS_DIR_NAME .  DIRECTORY_SEPARATOR . ViewsPath::VIEWS_MODULES_DIR . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $template;

        if (file_exists(self::getFullTemplatePath($site_modules_file_path))) {
            return true;
        }

        return false;
    }
}
