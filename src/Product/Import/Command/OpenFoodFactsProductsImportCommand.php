<?php

declare(strict_types=1);

namespace App\Product\Import\Command;

use App\Product\Import\GZipExec;
use App\Product\Import\GZipExtract;
use App\Product\Import\ProductImportDTO;
use App\Product\Import\ProductImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(name: 'app:product:import:openfoodfacts', description: 'Hello PhpStorm')]
class OpenFoodFactsProductsImportCommand extends Command
{
    const DOWNLOAD_URL = 'https://static.openfoodfacts.org/data/openfoodfacts-products.jsonl.gz';
//    const IMPORT_FILE_NAME = 'openfoodfacts-products.jsonl.gz';
    const IMPORT_FILE_NAME = 'openfoodfacts_products_1737199719_1737286109.json.gz';
    const EXTRACTED_FILE_NAME = 'openfoodfacts-products.jsonl';

    public function __construct(
        private readonly string              $storageDirectory,
//        private readonly GZipExtract $gZipExtract,
        private readonly GZipExec            $gzipExec,
        private readonly SerializerInterface $serializer,
        private readonly ProductImporter     $productImporter,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$output instanceof ConsoleOutputInterface) {
            throw new \LogicException('This command accepts only an instance of "ConsoleOutputInterface".');
        }

        $io = new SymfonyStyle($input, $output);
//        $section = new ConsoleSectionOutput($output);
        $debugSection = $output->section();
//        $progress =new ProgressBar($section);
        $progress = $io->createProgressBar();
        $progress->setOverwrite(true);

        $io->block("checking directory $this->storageDirectory for imported file...");
//        $extractedFilePath = "$this->storageDirectory/" . self::EXTRACTED_FILE_NAME;
        $compressedFilePath = "$this->storageDirectory/" . self::IMPORT_FILE_NAME;

        $progress->start();
        $successful = $failed = 0;
        $missingFields = [];
        $products = [];
        ($this->gzipExec)($compressedFilePath, function (string $line)
        use ($progress, &$products, &$successful, &$failed, &$missingFields): void {
            $progress->advance();
            try {
                $productDTO = $this->serializer->deserialize($line, ProductImportDTO::class, 'json');
                $progress->setMessage("" . $productDTO->code);
                $products[] = $productDTO;
                $successful++;
//                file_put_contents($this->storageDirectory . "/sample.json", $line);
            } catch (MissingConstructorArgumentsException $e) {
                $failed++;
                foreach ($e->getMissingConstructorArguments() as $missing) {
                    $missingFields[$missing] ??= 0;
                    $missingFields[$missing]++;
                }
                return;
            } catch (\Exception $e) {
                $filesystem = new Filesystem();
                $tmpFile = $filesystem->tempnam(sys_get_temp_dir(), 'import_failed_line', '.json');
                file_put_contents($tmpFile, $line);
                throw new \Exception("Could not import product ({$e->getMessage()}), offending line saved in $tmpFile");
            }
        });


        $progress->finish();

        $io->success("successfully imported $successful products");
        if ($failed > 0) {
            $io->warning("failed to import $failed products");
            $io->warning("fields missing :\n" . join("\n", array_map(fn($key) => $key . " x" . $missingFields[$key], array_keys($missingFields))));
        }

            ($this->productImporter)($products);
//        $filesystem = new Filesystem();
//        if (!$filesystem->exists($extractedFilePath)) {
//            if (!$filesystem->exists($compressedFilePath)) {
//                $io->warning("Download not implemented yet, download it yourself and put it in $this->storageDirectory");
//                return Command::FAILURE;
//            }
//
//            $io->block("Compressed file found, extracting...");
//            ($this->gZipExtract)($compressedFilePath, $extractedFilePath);
//        }

//        $importFile = fopen($extractedFilePath, "r");


        return Command::SUCCESS;
    }
}
