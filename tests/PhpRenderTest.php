<?php

declare(strict_types=1);

namespace WebSK\Views\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;
use UnexpectedValueException;
use WebSK\Config\ConfWrapper;
use WebSK\Slim\Facade;
use WebSK\Views\LayoutDTO;
use WebSK\Views\PhpRender;
use WebSK\Views\Tests\Support\ArrayContainer;

final class PhpRenderTest extends TestCase
{
    protected function setUp(): void
    {
        ConfWrapper::setConfig(['site_full_path' => __DIR__ . '/fixtures/site']);
    }

    public function testRendersTemplateDataAndPsr7Responses(): void
    {
        $template = __DIR__ . '/fixtures/template.php';

        self::assertSame('Hello, Codex!', PhpRender::renderTemplate($template, ['name' => 'Codex']));

        $response = PhpRender::render(new Response(), $template, ['name' => 'Response']);
        self::assertSame('Hello, Response!', (string) $response->getBody());

        $localResponse = PhpRender::renderLocal(new Response(), 'fixtures/template.php', ['name' => 'Local']);
        self::assertSame('Hello, Local!', (string) $localResponse->getBody());

        $viewsResponse = PhpRender::renderInViewsDir(new Response(), 'template.php', ['name' => 'Views']);
        self::assertSame('Hello, Views!', (string) $viewsResponse->getBody());

        self::assertSame('Hello, Local template!', PhpRender::renderLocalTemplate('fixtures/template.php', ['name' => 'Local template']));
        self::assertSame('Hello, Views template!', PhpRender::renderTemplateInViewsDir('template.php', ['name' => 'Views template']));
    }

    public function testCleansOutputBufferWhenTemplateThrows(): void
    {
        $bufferLevel = ob_get_level();

        try {
            PhpRender::renderTemplate(__DIR__ . '/fixtures/throwing.php');
            self::fail('The throwing template must propagate its exception');
        } catch (RuntimeException $exception) {
            self::assertSame('Template failure', $exception->getMessage());
            self::assertSame($bufferLevel, ob_get_level());
        }
    }

    public function testRendersModuleOverrideAndCallerFallback(): void
    {
        self::assertSame(
            'Override: configured',
            PhpRender::renderTemplateForModuleNamespace('Example', 'override.php', ['name' => 'configured'])
        );
        self::assertSame(
            'Hello, fallback!',
            PhpRender::renderTemplateForModuleNamespace('tests', 'template.php', ['name' => 'fallback'])
        );
    }

    public function testRejectsModuleOutsideCallerDirectory(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('is not part of caller directory');

        PhpRender::renderTemplateForModuleNamespace('missing-module', 'template.php');
    }

    public function testRenderLayoutUsesConfiguredTitlesAndCurrentRequestPath(): void
    {
        ConfWrapper::setConfig([
            'site_full_path' => __DIR__ . '/fixtures/site',
            'site_title' => 'Example site',
        ]);
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/current-page');
        $container = new ArrayContainer([ServerRequestInterface::class => $request]);
        Facade::setFacadeApplication(AppFactory::create(new ResponseFactory(), $container));
        $layout = new LayoutDTO();

        $response = PhpRender::renderLayout(
            new Response(),
            __DIR__ . '/fixtures/layout.php',
            $layout
        );

        self::assertSame('Example site', $layout->getSiteTitle());
        self::assertSame('Exa', $layout->getShortSiteTitle());
        self::assertSame('/current-page', $layout->getPageUrl());
        self::assertSame('Example site|Exa|/current-page', (string) $response->getBody());
    }

    public function testRenderLayoutRejectsInvalidConfiguredTitle(): void
    {
        ConfWrapper::setConfig(['site_title' => []]);
        $layout = new LayoutDTO();
        $layout->setPageUrl('/');

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('site_title');

        PhpRender::renderLayout(new Response(), __DIR__ . '/fixtures/layout.php', $layout);
    }

    public function testRenderLayoutRejectsInvalidRequestService(): void
    {
        ConfWrapper::setConfig([
            'site_title' => 'Example site',
            'short_site_title' => 'Exa',
        ]);
        $container = new ArrayContainer([ServerRequestInterface::class => new \stdClass()]);
        Facade::setFacadeApplication(AppFactory::create(new ResponseFactory(), $container));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Slim request is not available');

        PhpRender::renderLayout(new Response(), __DIR__ . '/fixtures/layout.php', new LayoutDTO());
    }
}
