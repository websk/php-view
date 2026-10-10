<?php

declare(strict_types=1);

namespace WebSK\Views\Tests;

use PHPUnit\Framework\TestCase;
use UnexpectedValueException;
use WebSK\Config\ConfWrapper;
use WebSK\Views\ViewsPath;

final class ViewsPathTest extends TestCase
{
    protected function setUp(): void
    {
        ConfWrapper::setConfig(['site_full_path' => __DIR__ . '/fixtures/site']);
    }

    public function testBuildsSitePathsAndFindsModuleTemplate(): void
    {
        $sitePath = __DIR__ . '/fixtures/site';

        self::assertSame($sitePath . '/src', ViewsPath::getSiteSrcPath());
        self::assertSame($sitePath . '/views', ViewsPath::getSiteViewsPath());
        self::assertSame($sitePath . '/views/layout.php', ViewsPath::getFullTemplatePath('views/layout.php'));
        self::assertTrue(ViewsPath::existsTemplateByModuleRelativeToRootSitePath('Example', 'override.php'));
        self::assertFalse(ViewsPath::existsTemplateByModuleRelativeToRootSitePath('Example', 'missing.php'));
    }

    public function testRejectsInvalidSiteFullPath(): void
    {
        ConfWrapper::setConfig(['site_full_path' => []]);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('site_full_path');

        ViewsPath::getSiteViewsPath();
    }
}
