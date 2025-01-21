<?php

namespace App\Product\Import;

class GZipExtract
{
    public function __construct(
        private readonly int $bufferSize = 4096,
    )
    {
    }

    public function __invoke(string $inputFile, string $outputFile): void
    {
        $compressedFile = gzopen($inputFile, 'rb');
        $extractedFile = fopen($outputFile, 'w');
        while (!gzeof($compressedFile)) {
            $dataRead = gzread($compressedFile, $this->bufferSize);
            fwrite($extractedFile, $dataRead);
        }

        gzclose($compressedFile);
        fclose($extractedFile);
    }
}