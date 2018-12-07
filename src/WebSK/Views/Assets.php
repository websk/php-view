<?php

namespace WebSK\Views;

use WebSK\Config\ConfWrapper;
use WebSK\Utils\Url;

/**
 * Class Assets
 * @package WebSK\Views
 */
class Assets
{
    public const ASSETS_DIR_NAME = 'assets';

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
