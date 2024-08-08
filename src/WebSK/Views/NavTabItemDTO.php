<?php

namespace WebSK\Views;

/**
 * Class NavTabItemDTO
 * @package WebSK\Views
 */
class NavTabItemDTO
{
    protected string $name = '';

    protected string $url = '';

    protected string $target = '';

    /**
     * NavTabItemDTO constructor.
     * @param string $name
     * @param string $url
     * @param string $target
     */
    public function __construct(string $name, string $url, string $target = '')
    {
        $this->name = $name;
        $this->url = $url;
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }
}
