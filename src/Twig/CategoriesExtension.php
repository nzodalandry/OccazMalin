<?php

namespace App\Twig;

use App\Repository\CategoriesRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoriesExtension extends AbstractExtension
{ 
    private $repository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->repository = $categoriesRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('categories', [$this, 'getCategories']),
        ];
    }

    public function getCategories()
    {
        return $this->repository->findAll();
    }
}
