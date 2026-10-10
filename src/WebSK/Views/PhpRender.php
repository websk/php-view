<?php

namespace WebSK\Views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Slim\Views\PhpRenderer;
use Throwable;
use UnexpectedValueException;
use WebSK\Config\ConfWrapper;
use WebSK\Slim\Request;

/**
 * Class PhpRender
 * @package WebSK\Views
 */
class PhpRender
{
    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array<string, mixed> $data
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
     * @param array<string, mixed> $data
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
     * @param array<string, mixed> $data
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
     * @param array<string, mixed> $data
     * @return string
     */
    public static function renderTemplate(string $template, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        $buffer_level = ob_get_level();
        ob_start();

        try {
            require $template;

            $contents = ob_get_clean();
            if ($contents === false) {
                throw new RuntimeException('Failed to get the rendered template output');
            }

            return $contents;
        } catch (Throwable $exception) {
            while (ob_get_level() > $buffer_level) {
                ob_end_clean();
            }

            throw $exception;
        }
    }

    /**
     * @param string $module_namespace_dir
     * @param string $template
     * @param array<string, mixed> $data
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
        if ($offset_namespace === false) {
            throw new RuntimeException(
                sprintf('Module namespace directory "%s" is not part of caller directory "%s"', $module_namespace_dir, $caller_dir)
            );
        }

        $full_template_path = substr($caller_dir, 0, $offset_namespace) . $module_namespace_dir . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME . DIRECTORY_SEPARATOR . $template;

        return self::renderTemplate($full_template_path, $data);
    }

    /**
     * @param string $template
     * @param array<string, mixed> $data
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
     * @param array<string, mixed> $data
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
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $backtrace[1] ?? null;
        $caller_path = is_array($caller) ? ($caller['file'] ?? null) : null;
        if (!is_string($caller_path) || $caller_path === '') {
            throw new RuntimeException('Unable to determine the caller file');
        }

        return dirname($caller_path);
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
            $layout_dto->setSiteTitle(self::getStringConfigValue('site_title'));
        }

        if (!$layout_dto->getShortSiteTitle()) {
            $short_site_title = self::getStringConfigValue(
                'short_site_title',
                mb_substr($layout_dto->getSiteTitle(), 0, 3)
            );
            $layout_dto->setShortSiteTitle($short_site_title);
        }

        if (!$layout_dto->getPageUrl()) {
            $request = Request::self();
            if (!$request instanceof ServerRequestInterface) {
                throw new RuntimeException('Slim request is not available');
            }

            $layout_dto->setPageUrl($request->getUri()->getPath());
        }

        $data['layout_dto'] = $layout_dto;

        return self::render($response, $template, $data);
    }

    private static function getStringConfigValue(string $key, string $default = ''): string
    {
        $value = ConfWrapper::value($key, $default);
        if (!is_string($value)) {
            throw new UnexpectedValueException(sprintf('Configuration value "%s" must be a string', $key));
        }

        return $value;
    }
}
