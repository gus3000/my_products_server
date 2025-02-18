<?php

namespace qrcode;

use Castor\Attribute\AsTask;

use function Castor\context;
use function Castor\run;

#[AsTask]
function generate(string $username)
{
    // TODO
    run(['qrencode', '-t', 'ansiutf8', $username], context: context());
}
