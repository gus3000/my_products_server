<?php

namespace App\Product\Import;

class GZipExec
{
    public function __invoke(string $inputFile, callable $callable): void
    {
        $compressedFile = gzopen($inputFile, 'rb');
        if ($compressedFile === false) {
            throw new \Exception('Failed to open input file '.$inputFile);
        }
        while (!gzeof($compressedFile)) {
            $line = gzgets($compressedFile);
            $callable($line);
        }
        gzclose($compressedFile);
    }
}
