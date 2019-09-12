<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\PostsImport;

class PostsImportCommand extends Command
{
    protected static $defaultName = 'app:import-posts';
    private $usersManager;

    public function __construct(PostsImport $postsImport)
    {
        $this->postsManager = $postsImport;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Import Posts')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
        }

        $this->postsManager->importNewPosts();
        $io->success('All Posts are imported...');
    }
}
