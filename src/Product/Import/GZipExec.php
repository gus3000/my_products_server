<?php

namespace App\Product\Import;

class GZipExec
{
    public function __invoke(string $inputFile, callable $callable, int $stopAfter = -1): void
    {
        $compressedFile = gzopen($inputFile, 'rb');
        if ($compressedFile === false) {
            throw new \Exception('Failed to open input file '.$inputFile);
        }
        $lineIndex = 0;
        while (!gzeof($compressedFile)) {
            $line = gzgets($compressedFile);
            $imported = $callable($line);

            if ($imported && $stopAfter > 0 && ++$lineIndex >= $stopAfter) {
                break;
            }
        }
        gzclose($compressedFile);
    }
}
