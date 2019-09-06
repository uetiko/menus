<?php
declare(strict_types=1);

namespace Uetiko\Credit\Menu\Application;
use Uetiko\Credit\Menu\Domain\Menu;
use Uetiko\Credit\Menu\Infrastructure\Interfaces\Repository;

class MenuFinder
{
    private $menuRepository = null;

    public function __construct(Repository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function findById(int $id): Menu
    {}

    public function findAll(): array{}
}