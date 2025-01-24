<?php

namespace App\Product\Import;

class GZipExtract
{
    public function __construct(
        private readonly int $bufferSize = 4096,
    ) {
    }

    public function __invoke(string $inputFile, string $outputFile): void
    {
        $compressedFile = gzopen($inputFile, 'rb');
        if ($compressedFile === false) {
            throw new \Exception('Failed to open input file '.$inputFile);
        }
        $extractedFile = fopen($outputFile, 'w');
        if ($extractedFile === false) {
            throw new \Exception('Failed to open output file '.$outputFile);
        }
        while (!gzeof($compressedFile)) {
            $dataRead = gzread($compressedFile, $this->bufferSize);
            if ($dataRead === false) {
                break;
            }
            fwrite($extractedFile, $dataRead);
        }

        gzclose($compressedFile);
        fclose($extractedFile);
    }
}
