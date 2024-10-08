<?php

namespace WebSK\Views;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;
use WebSK\Config\ConfWrapper;
use WebSK\Slim\Request;
use WebSK\Utils\Assert;

/**
 * Class PhpRender
 * @package WebSK\Views
 */
class PhpRender
{
    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    public static function render(
        ResponseInterface $response,
        string $template,
        array $data = []
    ): ResponseInterface {
        $data['response'] = $response;

        $php_renderer = new PhpRenderer();

        return $php_renderer->render($response, $template, $data);
    }

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    public static function renderLocal(
        ResponseInterface $response,
        string $template,
        array $data = []
    ): ResponseInterface {
        $caller_dir = self::getCallerDir();

        $data['response'] = $response;

        $php_renderer = new PhpRenderer($caller_dir);

        return $php_renderer->render($response, $template, $data);
    }

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    public static function renderInViewsDir(
        ResponseInterface $response,
        string $template,
        array $data = []
    ): ResponseInterface {
        $caller_dir = self::getCallerDir();

        $full_template_path = $caller_dir . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME;

        $data['response'] = $response;

        $php_renderer = new PhpRenderer($full_template_path);

        return $php_renderer->render($response, $template, $data);
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     */
    public static function renderTemplate(string $template, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        ob_start();

        require $template;

        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    /**
     * @param string $module_namespace_dir
     * @param string $template
     * @param array $data
     * @return string
     */
    public static function renderTemplateForModuleNamespace(string $module_namespace_dir, string $template, array $data = []): string
    {
        if (ViewsPath::existsTemplateByModuleRelativeToRootSitePath($module_namespace_dir, $template)) {
            $template_path = ViewsPath::VIEWS_DIR_NAME .  DIRECTORY_SEPARATOR . ViewsPath::VIEWS_MODULES_DIR . DIRECTORY_SEPARATOR . $module_namespace_dir . DIRECTORY_SEPARATOR . $template;

            $full_template_path = ViewsPath::getFullTemplatePath($template_path);

            return self::renderTemplate($full_template_path, $data);
        }

        $caller_dir = self::getCallerDir();
        $offset_namespace = strpos($caller_dir, $module_namespace_dir);

        $full_template_path = substr($caller_dir, 0, $offset_namespace) . $module_namespace_dir . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME . DIRECTORY_SEPARATOR . $template;

        return self::renderTemplate($full_template_path, $data);
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public static function renderLocalTemplate(string $template, array $data = []): string
    {
        $caller_dir = self::getCallerDir();
        $full_template_path = $caller_dir . DIRECTORY_SEPARATOR . $template;

        return self::renderTemplate($full_template_path, $data);
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public static function renderTemplateInViewsDir(string $template, array $data = []): string
    {
        $caller_dir = self::getCallerDir();
        $full_template_path = $caller_dir . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME . DIRECTORY_SEPARATOR . $template;

        return self::renderTemplate($full_template_path, $data);
    }

    /**
     * @return string
     */
    private static function getCallerDir(): string
    {
        $cb_arr = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        $caller_obj = $cb_arr[1] ?? null;
        Assert::assert($caller_obj);

        $caller_path = $caller_obj['file'];
        $caller_path_arr = pathinfo($caller_path);

        $caller_dir = $caller_path_arr['dirname'] ?? '';

        return $caller_dir;
    }

    /**
     * @param ResponseInterface $response
     * @param string $template ,
     * @param LayoutDTO $layout_dto
     * @return ResponseInterface
     */
    public static function renderLayout(ResponseInterface $response, string $template, LayoutDTO $layout_dto): ResponseInterface
    {
        if (!$layout_dto->getSiteTitle()) {
            $layout_dto->setSiteTitle(ConfWrapper::value('site_title', ''));
        }

        if (!$layout_dto->getShortSiteTitle()) {
            $short_site_title = ConfWrapper::value('short_site_title', mb_substr($layout_dto->getSiteTitle(), 0, 3));
            $layout_dto->setShortSiteTitle($short_site_title);
        }

        if (!$layout_dto->getPageUrl()) {
            $layout_dto->setPageUrl(Request::self()->getUri()->getPath());
        }

        $data['layout_dto'] = $layout_dto;

        return self::render($response, $template, $data);
    }
}
