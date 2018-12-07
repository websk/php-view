<?php

namespace WebSK\Views;

use WebSK\Config\ConfWrapper;

/**
 * Class ViewsPath
 * @package WebSK\Views
 */
class ViewsPath
{
    public const VIEWS_DIR_NAME = 'views';
    public const VIEWS_MODULES_DIR = 'modules';
    public const SRC_DIR_NAME = 'src';

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
        return ViewsPath::getSiteViewsPath() . DIRECTORY_SEPARATOR . $template;
    }
}
