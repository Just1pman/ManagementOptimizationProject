<?php


namespace App\Service;


use App\Repository\CategoryRepository;
use App\Repository\SkillRepository;

class SkillService
{
    /**
     * @var SkillRepository
     */
    private SkillRepository $skillRepository;

    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * SkillService constructor.
     * @param CategoryRepository $categoryRepository
     * @param SkillRepository $skillRepository
     */
    public function __construct(CategoryRepository $categoryRepository, SkillRepository $skillRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->skillRepository = $skillRepository;
    }

    public function getSkillCategory(): array
    {
        $skills = [];
        foreach ($this->categoryRepository->getAllTitle() as $item) {
            $category = $this->categoryRepository->findOneBy(['title' => $item]);
            $categoryId = $category->getId();
            $skillsCategory = $this->skillRepository->findBy(['category' => $categoryId]);
            $skillsCollection = [];
            foreach ($skillsCategory as $skill) {
                $skillsCollection[$skill->getTitle()] = $skill->getTitle();
            }
            $skills[$item] = $skillsCollection;
        }
        return $skills;
    }



}