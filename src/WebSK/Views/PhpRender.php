<?php

namespace WebSK\Views;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;
use Websk\Utils\Assert;

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
    ) {
        $data['response'] = $response;

        $view_path = ViewsPath::getSiteViewsPath();

        $php_renderer = new PhpRenderer($view_path);

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
    ) {
        $cb_arr = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        $caller_obj = array_shift($cb_arr);
        Assert::assert($caller_obj);

        $caller_path = $caller_obj['file'];
        $caller_path_arr = pathinfo($caller_path);

        $caller_dir = $caller_path_arr['dirname'];

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
    public static function renderTemplate(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);
        ob_start();

        require ViewsPath::getFullTemplatePath($template);

        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    /**
     * @param string $module
     * @param string $template
     * @param array $data
     * @return false|string
     */
    public static function renderTemplateByModule(string $module, string $template, array $data = [])
    {
        $site_modules_file_path = ViewsPath::VIEWS_MODULES_DIR . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $template;

        if (!file_exists(ViewsPath::getFullTemplatePath($site_modules_file_path))) {
            return self::renderTemplate(
                $site_modules_file_path,
                $data
            );
        }

        extract($data, EXTR_SKIP);
        ob_start();

        require ViewsPath::getSiteSrcPath() . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME . DIRECTORY_SEPARATOR . $template;

        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }

    /**
     * @param string $template
     * @param array $data
     * @return false|string
     * @throws \Exception
     */
    public static function renderLocalTemplate(string $template, array $data = []) {
        $cb_arr = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        $caller_obj = array_shift($cb_arr);
        Assert::assert($caller_obj);

        $caller_path = $caller_obj['file'];
        $caller_path_arr = pathinfo($caller_path);

        $caller_dir = $caller_path_arr['dirname'];

        $full_template_path = $caller_dir . DIRECTORY_SEPARATOR . ViewsPath::VIEWS_DIR_NAME . DIRECTORY_SEPARATOR . $template;

        extract($data, EXTR_SKIP);
        ob_start();

        require $full_template_path;

        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }
}
