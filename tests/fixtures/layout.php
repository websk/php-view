<?php

use WebSK\Views\LayoutDTO;

/** @var LayoutDTO $layout_dto */
echo $layout_dto->getSiteTitle() . '|' . $layout_dto->getShortSiteTitle() . '|' . $layout_dto->getPageUrl();
