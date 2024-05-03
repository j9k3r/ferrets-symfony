<?php
namespace App\Middleware;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;



class EmailLowerCaseMiddleware extends Middleware
{
    public function __construct()
    {
        // Здесь вы можете инициализировать любые зависимости
    }

    public function handle(Request $request, Callback $next)
    {
        // Проверяем, что запрос относится к нужному маршруту
        if ($this->isRouteAllowed($request)) {
            // Получаем тело запроса
            $body = $request->getContent();

            // Проверяем, есть ли в теле поля email
            if (isset($body['email'])) {
                // Приводим email к нижнему регистру
                $body['email'] = strtolower($body['email']);

                // Обновляем тело запроса
                $request->setContent(json_encode($body));
            }
        }

        // Продолжаем обработку запроса
        return $next($request);
    }

    protected function isRouteAllowed(Request $request)
    {
        // Здесь должна быть логика определения, относится ли маршрут к нужному пути
        // Например, можно использовать свойство request.pathInfo
        // В данном примере предполагается, что маршруты проверяются в конфигурации security.yaml
        // и мы знаем, какие маршруты должны быть обработаны нашим middleware
        $allowedRoutes = ['^/api/auth/token/login'];
        return in_array($request->getPathInfo(), $allowedRoutes);
    }
}