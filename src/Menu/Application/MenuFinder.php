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

    /**
     * @param string $id
     * @return Menu
     * @throws \Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotFindException
     */
    public function findById(string $id): Menu
    {
        $result = [];
        $result = $this->menuRepository->findById($id);
        return new Menu($result['id'], $result['name'], $result['description']);
    }

    public function findAll(): array{}
}