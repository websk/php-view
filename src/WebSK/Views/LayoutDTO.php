<?php

namespace WebSK\Views;

/**
 * Class LayoutDTO
 * @package WebSK\Skif
 */
class LayoutDTO
{
    protected string $title = '';

    protected string $site_title = '';

    protected string $short_site_title = '';

    protected ?int $user_id = null;

    protected string $user_name = '';

    protected string $logout_url = '';

    /** @var array<array-key, MenuItemDTO> */
    protected array $menu_item_dto_arr = [];

    protected string $content_html = '';

    protected string $page_url = '';

    /** @var array<array-key, NavTabItemDTO> */
    protected array $nav_tabs_dto_arr = [];

    /** @var array<array-key, BreadcrumbItemDTO> */
    protected array $breadcrumbs_dto_arr = [];

    protected string $description = '';

    protected string $keywords = '';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSiteTitle(): string
    {
        return $this->site_title;
    }

    /**
     * @param string $site_title
     */
    public function setSiteTitle(string $site_title): void
    {
        $this->site_title = $site_title;
    }

    /**
     * @return string
     */
    public function getShortSiteTitle(): string
    {
        return $this->short_site_title;
    }

    /**
     * @param string $short_site_title
     */
    public function setShortSiteTitle(string $short_site_title): void
    {
        $this->short_site_title = $short_site_title;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user_name;
    }

    /**
     * @param string $user_name
     */
    public function setUserName(string $user_name): void
    {
        $this->user_name = $user_name;
    }

    /**
     * @return string
     */
    public function getLogoutUrl(): string
    {
        return $this->logout_url;
    }

    /**
     * @param string $logout_url
     */
    public function setLogoutUrl(string $logout_url): void
    {
        $this->logout_url = $logout_url;
    }

    /**
     * @return array<array-key, MenuItemDTO>
     */
    public function getMenuItemDtoArr(): array
    {
        return $this->menu_item_dto_arr;
    }

    /**
     * @param array<array-key, MenuItemDTO> $menu_item_dto_arr
     */
    public function setMenuItemDtoArr(array $menu_item_dto_arr): void
    {
        $this->menu_item_dto_arr = $menu_item_dto_arr;
    }

    /**
     * @return string
     */
    public function getContentHtml(): string
    {
        return $this->content_html;
    }

    /**
     * @param string $content_html
     */
    public function setContentHtml(string $content_html): void
    {
        $this->content_html = $content_html;
    }

    /**
     * @return string
     */
    public function getPageUrl(): string
    {
        return $this->page_url;
    }

    /**
     * @param string $page_url
     */
    public function setPageUrl(string $page_url): void
    {
        $this->page_url = $page_url;
    }

    /**
     * @return array<array-key, NavTabItemDTO>
     */
    public function getNavTabsDtoArr(): array
    {
        return $this->nav_tabs_dto_arr;
    }

    /**
     * @param array<array-key, NavTabItemDTO> $nav_tabs_dto_arr
     */
    public function setNavTabsDtoArr(array $nav_tabs_dto_arr): void
    {
        $this->nav_tabs_dto_arr = $nav_tabs_dto_arr;
    }

    /**
     * @return array<array-key, BreadcrumbItemDTO>
     */
    public function getBreadcrumbsDtoArr(): array
    {
        return $this->breadcrumbs_dto_arr;
    }

    /**
     * @param array<array-key, BreadcrumbItemDTO> $breadcrumbs_dto_arr
     */
    public function setBreadcrumbsDtoArr(array $breadcrumbs_dto_arr): void
    {
        $this->breadcrumbs_dto_arr = $breadcrumbs_dto_arr;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }
}
