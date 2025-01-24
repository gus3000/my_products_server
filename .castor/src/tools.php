<?php

use Castor\Attribute\AsTask;

use function Castor\io;

#[AsTask]
function csFix(): void
{
    io()->block('CS FIXER');
    \Castor\run(['.castor/vendor/bin/php-cs-fixer', 'fix']);
}

#[AsTask]
function phpstan(): void
{
    \Castor\run(['.castor/vendor/bin/phpstan', 'analyze']);
}
