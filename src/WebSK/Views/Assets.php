<?php

namespace WebSK\Views;

use UnexpectedValueException;
use WebSK\Config\ConfWrapper;
use WebSK\Utils\Url;

/**
 * Class Assets
 * @package WebSK\Views
 */
class Assets
{
    const string ASSETS_DIR_NAME = 'assets';

    /**
     * @param string $resource
     * @return string
     */
    public static function wrapAssetsVersion(string $resource): string
    {
        $assetsVersion = ConfWrapper::value('assets_version', 1);
        $assetsUrlPath = ConfWrapper::value('assets_url_path', self::ASSETS_DIR_NAME);
        if (!is_int($assetsVersion) && !is_string($assetsVersion)) {
            throw new UnexpectedValueException('Configuration value "assets_version" must be an integer or string');
        }

        if (!is_string($assetsUrlPath)) {
            throw new UnexpectedValueException('Configuration value "assets_url_path" must be a string');
        }

        return Url::appendLeadingSlash($assetsUrlPath . '/' . $assetsVersion . Url::appendLeadingSlash($resource));
    }
}
