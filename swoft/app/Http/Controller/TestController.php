<?php  declare(strict_types=1);

namespace App\Http\Controller;

use Swoft\Context\Context;
use Swoft\Http\Message\ContentType;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Throwable;

/**
 * 测试类
 *
 * @Controller("/test")
 */
class TestController
{
    /**
     * @RequestMapping("/test/a")
     * @throws Throwable
     *
     * 方法注释
     */
    public function index(): Response
    {
        return Context::mustGet()->getResponse()->withContentType(ContentType::HTML)->withContent("12345");

    }
    /**
     * @RequestMapping(route="/test/rs", method={RequestMethod::POST, RequestMethod::PUT})
     * @throws Throwable
     *
     * 方法注释
     */
    public function restful(): Response
    {
        //SwoftTest\Http\Server\Testing\Controller\RouteController
        //* @RequestMapping("method", method={RequestMethod::POST, RequestMethod::PUT})
        //Swoft\Devtool\Http\Controller\GenController
        //* @RequestMapping(route="preview", method=RequestMethod::POST)
        return Context::mustGet()->getResponse()->withContentType(ContentType::HTML)->withContent("hiaa");
    }
}


