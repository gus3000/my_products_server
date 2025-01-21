<?php

namespace App\Product\Import;

class GZipExec
{
    public function __invoke(string $inputFile, callable $callable): void
    {
        $compressedFile = gzopen($inputFile, 'rb');
        while (!gzeof($compressedFile)) {
            $line = gzgets($compressedFile);
            $callable($line);
        }
        gzclose($compressedFile);
    }
}