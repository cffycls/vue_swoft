<?php declare(strict_types=1);


namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Context\Context;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Throwable;

/**
 * Class ControllerMiddleware - The middleware of httpDispatcher
 *
 * @Bean()
 */
class ControllerMiddleware implements MiddlewareInterface
{
    /**
     * Process an incoming server request.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @inheritdoc
     * @throws Throwable
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Response $response */
        $status = 0;
        $date = date("Y-m-d H:i:s ");
        $method = $request->getMethod();

        $router    = \Swoft\Bean\BeanFactory::getSingleton('httpRouter');
        $uriPath   = $request->getUriPath();
        $routeData = $router->match($uriPath, $method);
        if( $routeData[0] == \Swoft\Http\Server\Router\Router::NOT_FOUND ){
            $response = Context::mustGet()->getResponse();
            var_dump(1111111);
            return $response->withData([$method .": 拒绝访问"]);
        }

        if ( $status == 0 ) {
            //直接处理之后的 响应
            $response = $handler->handle($request);
            var_dump("直接响应");
            return $response->withData($date); //已完成、处理无效
            return $response;
        } elseif ( $status == 1) {
            //验证失败的 响应
            $json = ['code'=>0,'msg'=>'授权失败','time'=>$date];
            $response = Context::mustGet()->getResponse();
            return $response->withData($json);

        } elseif ( $status == 2 ) {
            $response = Context::mustGet()->getResponse();
            return $response->withData("ok")->withStatus(404);
        } else {
            $response = Context::mustGet()->getResponse();
            return $response->withData($method);
        }
    }
}