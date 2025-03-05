<?php

declare(strict_types=1);

namespace App\Product\Import\Command;

use App\Product\BarCode\BarCode;
use App\Product\Import\GZipExec;
use App\Product\Import\GZipExtract;
use App\Product\Import\ProductImportDTO;
use App\Product\Import\ProductImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\SerializerInterface;
use Webmozart\Assert\Assert;

#[AsCommand(name: 'app:product:import:openfoodfacts', description: 'Hello PhpStorm')]
class OpenFoodFactsProductsImportCommand extends Command
{
    public const DOWNLOAD_URL = 'https://static.openfoodfacts.org/data/openfoodfacts-products.jsonl.gz';
    public const IMPORT_FILE_NAME = 'openfoodfacts-products.jsonl.gz';
    //    public const IMPORT_FILE_NAME = 'openfoodfacts_products_1737199719_1737286109.json.gz';
    public const EXTRACTED_FILE_NAME = 'openfoodfacts-products.jsonl';

    public function __construct(
        private readonly string $storageDirectory,
        //        private readonly GZipExtract $gZipExtract,
        private readonly GZipExec $gzipExec,
        private readonly SerializerInterface $serializer,
        private readonly ProductImporter $productImporter,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('stopAfter', null, InputOption::VALUE_REQUIRED, 'stop the import after X entries', '-1');
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$output instanceof ConsoleOutputInterface) {
            throw new \LogicException('This command accepts only an instance of "ConsoleOutputInterface".');
        }

        $stopAfter = $input->getOption('stopAfter');
        Assert::string($stopAfter);
        $stopAfter = (int) $stopAfter;

        $io = new SymfonyStyle($input, $output);
        //        $section = new ConsoleSectionOutput($output);
        $debugSection = $output->section();
        //        $progress =new ProgressBar($section);
        $progress = $io->createProgressBar();
        $progress->setOverwrite(true);

        $io->block("checking directory $this->storageDirectory for imported file...");
        //        $extractedFilePath = "$this->storageDirectory/" . self::EXTRACTED_FILE_NAME;
        $compressedFilePath = "$this->storageDirectory/".self::IMPORT_FILE_NAME;

        $progress->start();
        $successful = $failed = 0;
        $missingFields = [];
        $products = [];
        ($this->gzipExec)($compressedFilePath, function (string $line) use ($progress, &$products, &$successful, &$failed, &$missingFields): bool {
            try {
                $productDTO = $this->serializer->deserialize($line, ProductImportDTO::class, 'json');
                if ($productDTO->lang !== 'fr') {
                    return false;
                }

                $code = new BarCode($productDTO->code);
                if (!$code->isControlKeyValid()) {
                    ++$failed;

                    return false;
                }

                $progress->advance();
                $progress->setMessage(''.$productDTO->code);
                $products[] = $productDTO;
                ++$successful;

                return true;

                //                if ($productDTO->code === '3596710536047') {
                //                    file_put_contents($this->storageDirectory.'/sample.json', $line);
                //                }
            } catch (MissingConstructorArgumentsException $e) {
                ++$failed;
                foreach ($e->getMissingConstructorArguments() as $missing) {
                    $missingFields[$missing] ??= 0;
                    ++$missingFields[$missing];
                }

                return false;
            } catch (\Exception $e) {
                $filesystem = new Filesystem();
                $tmpFile = $filesystem->tempnam(sys_get_temp_dir(), 'web/import_failed_line', '.json');
                file_put_contents($tmpFile, $line);

                throw new \Exception("Could not import product ({$e->getMessage()}), offending line saved in $tmpFile", previous: $e);
            }
        }, $stopAfter);

        $progress->finish();

        $io->success("successfully imported $successful products");
        if ($failed > 0) {
            $io->warning("failed to import $failed products");
            $io->warning("fields missing :\n".join("\n", array_map(fn ($key) => $key.' x'.$missingFields[$key], array_keys($missingFields))));
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
