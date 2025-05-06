<?php

use Castor\Attribute\AsContext;
use Castor\Attribute\AsTask;
use Castor\Context;

use function Castor\io;

#[AsContext()]
function csFixerContext(): Context
{
    return new Context(environment: [
        'PHP_CS_FIXER_IGNORE_ENV' => 1,
    ]);
}

#[AsTask]
function csFix(): void
{
    io()->block('CS FIXER');
    \Castor\run(['.castor/vendor/bin/php-cs-fixer', 'fix']);
}

#[AsTask]
function phpstan(): void
{
    \Castor\run(['.castor/vendor/bin/phpstan', 'analyze', '--memory-limit=512M']);
}

#[AsTask]
function phpstanBaseline(): void
{
    \Castor\run(['.castor/vendor/bin/phpstan', '-b']);
}
