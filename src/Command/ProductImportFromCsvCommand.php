<?php

namespace App\Command;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\ProductCsvImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

#[AsCommand(
    name: 'app:product:import-from-csv',
    description: 'Add a short description for your command',
)]
class ProductImportFromCsvCommand extends Command
{
    public function __construct(
        private readonly ProductCsvImporter $productCsvImporter,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('csvFile', InputArgument::REQUIRED, 'A csv containing the products to import')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $csvFile = $input->getArgument('csvFile');

        if(!file_exists($csvFile)) {
            throw new \InvalidArgumentException("File not found : $csvFile");
        }

        ($this->productCsvImporter)($csvFile);

//        $this->csvEncoder->decode();

        return Command::SUCCESS;
    }
}
