<?php

declare(strict_types=1);

namespace WebSK\Views\Tests;

use PHPUnit\Framework\TestCase;
use UnexpectedValueException;
use WebSK\Config\ConfWrapper;
use WebSK\Views\Assets;

final class AssetsTest extends TestCase
{
    protected function setUp(): void
    {
        ConfWrapper::setConfig([]);
    }

    public function testWrapAssetsVersionUsesDefaultsAndConfiguredValues(): void
    {
        self::assertSame('/assets/1/css/app.css', Assets::wrapAssetsVersion('css/app.css'));

        ConfWrapper::setConfig([
            'assets_url_path' => '/static',
            'assets_version' => '2026-10-09',
        ]);

        self::assertSame('/static/2026-10-09/js/app.js', Assets::wrapAssetsVersion('/js/app.js'));
    }

    public function testWrapAssetsVersionRejectsInvalidUrlPath(): void
    {
        ConfWrapper::setConfig(['assets_url_path' => []]);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('assets_url_path');

        Assets::wrapAssetsVersion('app.css');
    }

    public function testWrapAssetsVersionRejectsInvalidVersion(): void
    {
        ConfWrapper::setConfig(['assets_version' => []]);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('assets_version');

        Assets::wrapAssetsVersion('app.css');
    }
}
