<?php

declare(strict_types=1);

namespace App\Fixture\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Zenstruck\Foundry\Story;

#[AsCommand(name: 'app:fixtures:story:import:all', description: 'Import stories from database')]
class ImportStoryCommand extends Command
{
    public function __construct(
        /** @var array<Story> */
        #[AutowireIterator('foundry.story')]
        private readonly iterable $stories,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        foreach ($this->stories as $story) {
            $io->text('loading story '.$story::class);
            $story->load();
        }

        return Command::SUCCESS;
    }
}
