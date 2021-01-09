<?php


namespace App\Command;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddCategoryCommand extends Command
{
    protected static $defaultName = 'app:add-category';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Adds categories from the CSV to the database')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to add to the database the categories defined in the csv file');
    }

    /**
     * AddCategoryCommand constructor.
     * @param EntityManagerInterface $em
     */

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Attempting import of...');

        $reader = Reader::createFromPath('%kernel.root_dir%/../src/AppBundle/Data/Category.csv');
//        $results = $reader->fetchAssoc();
        $result = $reader->getContent();

        $results = str_getcsv($result);
//        for ($i = 0; $i<count($result) ;$i++) {
//            $category = (new Category())
//                ->setTitle($result[$i]);
//            $this->em->persist($category);
//        }

        foreach ($results as $row) {
                echo "$row";
            $category = (new Category())
                ->setTitle($row);
            $this->em->persist($category);
        }

        $this->em->flush();

        $io->success('Command exited cleanly!');
        return Command::SUCCESS;
    }


}