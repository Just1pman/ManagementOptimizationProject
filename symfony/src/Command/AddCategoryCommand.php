<?php

namespace App\Command;

use App\Service\SkillCategoryService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddCategoryCommand extends Command
{
    protected static $defaultName = 'app:import-category';

    /**
     * @var SkillCategoryService
     */
    private $categoryService;
    /**
     * @var String
     */
    private $uploads_folder;

    /**
     * ImportSkillCategoryCommand constructor.
     * @param SkillCategoryService $categoryService
     * @param string $uploads_folder
     */

    public function __construct(
        string $uploads_folder,
        SkillCategoryService $categoryService
    )
    {
        parent::__construct();

        $this->categoryService = $categoryService;
        $this->uploads_folder = $uploads_folder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addOption('file', null, InputOption::VALUE_OPTIONAL, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('file')) {
            $filePath = $this->uploads_folder .  $input->getOption('file');
            $io->note(sprintf('You passed option: %s', $input->getOption('file')));
        }
        try {
            $this->categoryService->execute($filePath, $io);
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}