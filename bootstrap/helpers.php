<?php

use App\Console\Kernel;
use Laravel\Lumen\Routing\Router;

if (!function_exists('console')) {
    /**
     * @param string $command
     * @param array $parameters
     * @return array
     */
    function console(string $command, array $parameters = []): array
    {
        /** @var Kernel $kernel */
        $kernel = app(Kernel::class);
        $code = $kernel->call($command, $parameters);
        $output = explode(PHP_EOL, $kernel->output());
        return compact('code', 'output');
    }
}

if (!function_exists('router')) {
    /**
     * @return Router
     */
    function router(): Router
    {
        return app()->router;
    }
}
