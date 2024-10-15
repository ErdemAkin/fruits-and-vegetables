<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    $dotEnv = new Dotenv();
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env.test');
}

passthru(
    sprintf(
        'APP_ENV=%s php "%s/../bin/console" doctrine:database:drop --force',
        'test',
        __DIR__,
    )
);
passthru(
    sprintf(
        'APP_ENV=%s php "%s/../bin/console" doctrine:database:create',
        'test',
        __DIR__,
    )
);
passthru(
    sprintf(
        'APP_ENV=%s php "%s/../bin/console" doctrine:migrations:migrate --no-interaction',
        'test',
        __DIR__,
    )
);