<?php

declare(strict_types=1);

namespace WebSK\Views\Tests;

use PHPUnit\Framework\TestCase;
use WebSK\Views\BreadcrumbItemDTO;
use WebSK\Views\LayoutDTO;
use WebSK\Views\MenuItemDTO;
use WebSK\Views\NavTabItemDTO;

final class DtoTest extends TestCase
{
    public function testLayoutDtoStoresScalarValuesAndCollections(): void
    {
        $menuItem = new MenuItemDTO('Home', '/');
        $navTab = new NavTabItemDTO('Overview', '/overview', '_blank');
        $breadcrumb = new BreadcrumbItemDTO('Home', '/');
        $layout = new LayoutDTO();

        $layout->setTitle('Page');
        $layout->setSiteTitle('Site');
        $layout->setShortSiteTitle('ST');
        $layout->setUserId(42);
        $layout->setUserName('Ada');
        $layout->setLogoutUrl('/logout');
        $layout->setMenuItemDtoArr(['main' => $menuItem]);
        $layout->setContentHtml('<main>Content</main>');
        $layout->setPageUrl('/page');
        $layout->setNavTabsDtoArr([$navTab]);
        $layout->setBreadcrumbsDtoArr([$breadcrumb]);
        $layout->setDescription('Description');
        $layout->setKeywords('php,view');

        self::assertSame('Page', $layout->getTitle());
        self::assertSame('Site', $layout->getSiteTitle());
        self::assertSame('ST', $layout->getShortSiteTitle());
        self::assertSame(42, $layout->getUserId());
        self::assertSame('Ada', $layout->getUserName());
        self::assertSame('/logout', $layout->getLogoutUrl());
        self::assertSame(['main' => $menuItem], $layout->getMenuItemDtoArr());
        self::assertSame('<main>Content</main>', $layout->getContentHtml());
        self::assertSame('/page', $layout->getPageUrl());
        self::assertSame([$navTab], $layout->getNavTabsDtoArr());
        self::assertSame([$breadcrumb], $layout->getBreadcrumbsDtoArr());
        self::assertSame('Description', $layout->getDescription());
        self::assertSame('php,view', $layout->getKeywords());
    }

    public function testMenuItemStoresChildrenAndPermissions(): void
    {
        $child = new MenuItemDTO('Child', '/child');
        $item = new MenuItemDTO('Parent', '/parent', ['child' => $child], 'icon-home', ['admin']);

        self::assertSame('Parent', $item->getText());
        self::assertSame('/parent', $item->getUrl());
        self::assertSame(['child' => $child], $item->getChildrenArr());
        self::assertSame('icon-home', $item->getIconClassesStr());
        self::assertSame(['admin'], $item->getPermissionsArr());

        $item->setText('Updated');
        $item->setUrl('/updated');
        $item->setChildrenArr([]);
        $item->setIconClassesStr('icon-updated');
        $item->setPermissionsArr(['editor']);

        self::assertSame('Updated', $item->getText());
        self::assertSame('/updated', $item->getUrl());
        self::assertSame([], $item->getChildrenArr());
        self::assertSame('icon-updated', $item->getIconClassesStr());
        self::assertSame(['editor'], $item->getPermissionsArr());
    }

    public function testNavigationAndBreadcrumbDtosAreMutable(): void
    {
        $navTab = new NavTabItemDTO('Initial', '/initial');
        $navTab->setName('Updated');
        $navTab->setUrl('/updated');
        $navTab->setTarget('_blank');

        self::assertSame('Updated', $navTab->getName());
        self::assertSame('/updated', $navTab->getUrl());
        self::assertSame('_blank', $navTab->getTarget());

        $breadcrumb = new BreadcrumbItemDTO('Initial');
        $breadcrumb->setName('Updated');
        $breadcrumb->setUrl('/updated');

        self::assertSame('Updated', $breadcrumb->getName());
        self::assertSame('/updated', $breadcrumb->getUrl());
    }
}
