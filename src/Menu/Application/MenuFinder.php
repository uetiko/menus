<?php
declare(strict_types=1);

namespace Uetiko\Credit\Menu\Application;
use Uetiko\Credit\Menu\Domain\Menu;
use Uetiko\Credit\Menu\Domain\MenuRelationship;
use Uetiko\Credit\Menu\Infrastructure\Interfaces\MenuRepository;

class MenuFinder
{
    private $menuRepository = null;

    public function __construct(MenuRepository $menuRepository)
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

    /**
     * @return array<MenuRelationship>
     * @throws \Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotFindException
     */
    public function findAll(): array {
        $menu = [];
        /** @var Menu $menuParent */
        $menuParent = null;
        $relationships = $this->menuRepository->findAll();
        foreach ($relationships as $relation) {
            if (is_null($menuParent) || $relation['id_parent'] !== $menuParent->getId()){
                $menuParent = $this->findById($relation['id_parent']);
            }
            $menuChild = $this->findById($relation['id_child']);

            $menu[] = new MenuRelationship(
                $relation['id'], $menuParent, $menuChild
            );
        }

        return $menu;
    }

    /**
     * @param string $id
     * @return array<MenuRelationship>
     * @throws \Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotFindException
     */
    public function findAllChildren(string $id): array {
        $menu = [];
        $menuParent = $this->findById($id);
        $children = $this->menuRepository->findMenuRelationshipChildrenByid($id);

        foreach ($children as $child) {
            $menu[] = new MenuRelationship(
                $child['id'], $menuParent, $this->findById($child['id_child'])
            );
        }
    }
}