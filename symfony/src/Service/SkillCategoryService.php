<?php


namespace App\Service;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class SkillCategoryService
{
    /**
     * @var CategoryRepository
     */
    private $CategoryRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(CategoryRepository $CategoryRepository, EntityManagerInterface $em)
    {
        $this->CategoryRepository = $CategoryRepository;
        $this->em = $em;
    }

    public function execute(String $filePath, SymfonyStyle $io):void {
        $filesystem = new Filesystem();

        //check that file exists
        if (!$filesystem->exists($filePath)) {
            throw new \Exception(sprintf('Cant open file[%s]', $filePath));
        } else {
            $io->info('File Exists start process');
            $this->processFile($filePath, $io);
        }
    }

    private function processFile(string $filePath, SymfonyStyle $io):void
    {
        if (($fp = fopen($filePath, "r")) !== FALSE) {
            while (($row = fgetcsv($fp, 1000, ",")) !== FALSE) {
//                var_dump($row);
                $title = $row[0];
                $io->info(sprintf(' process[%s]', $title));
                $this->checkAndSave($title, $io);
            }
            fclose($fp);
            $io->info('Save data to database ');
            $this->em->flush();
        }
    }

    private function checkAndSave($title, SymfonyStyle $io)
    {
        // read from file
//        $csvData = [];
//        foreach ($csvData as $title) {
        //check if exists
        if ($skillCategory = $this->CategoryRepository->findOneBy(['title'=>$title]) instanceof Category) {
            $io->warning(sprintf(' > skill category [%] exists', $title));
        } else {
            //create new Category
            $category = new Category();
            $category->setTitle($title);

            $this->em->persist($category);
            $io->success(sprintf(' > skill category[%s] created', $title));
        }
    }
}