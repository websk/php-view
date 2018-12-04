<?php

namespace WebSK\Views;

use WebSK\Slim\ConfWrapper;
use WebSK\Utils\Url;

/**
 * Class ViewsPath
 * @package WebSK\Views
 */
class ViewsPath
{
    public const VIEWS_DIR_NAME = 'views';
    public const VIEWS_MODULES_DIR = 'modules';
    public const SRC_DIR_NAME = 'src';
    public const ASSETS_DIR_NAME = 'assets';

    public static function getSiteSrcPath()
    {
        return ConfWrapper::value('site_path') . DIRECTORY_SEPARATOR . self::SRC_DIR_NAME;
    }

    /**
     * @return string
     */
    public static function getSiteViewsPath()
    {
        return ConfWrapper::value('site_path') . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME;
    }

    /**
     * @param string $template
     * @return string
     */
    public static function getFullTemplatePath(string $template)
    {
        return ViewsPath::getSiteViewsPath() . DIRECTORY_SEPARATOR . $template;
    }

    /**
     * @param $resource
     * @return string
     */
    public static function wrapAssetsVersion($resource)
    {
        $assetsVersion = ConfWrapper::value('assets_version', 1);
        $assetsUrlPath = ConfWrapper::value('assets_url_path', self::ASSETS_DIR_NAME);

        return Url::appendLeadingSlash($assetsUrlPath . '/' . $assetsVersion . Url::appendLeadingSlash($resource));
    }
}
