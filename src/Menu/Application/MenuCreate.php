<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Application;

use Ramsey\Uuid\UuidInterface;
use Uetiko\Credit\Menu\Domain\Menu;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotSaveException;
use Uetiko\Credit\Menu\Infrastructure\Interfaces\MenuRepository;
use Ramsey\Uuid\Uuid;

class MenuCreate
{
    /** @var $idRelation UuidInterface */
    private $idRelation = null;
    /** @var $menuParent Menu */
    private $menuParent = null;
    /** @var $menu Menu */
    private $menu = null;
    /** @var $menuRepository Repository */
    private $menuRepository = null;

    public function __construct(
        string $id, string $name, string $description, MenuRepository $menuRepository
    )
    {
        $this->menu = new Menu($id, $name, $description);
        $this->menuRepository = $menuRepository;
    }

    public function create(){
        $this->menuRepository->save(
            $this->menu->getId(), $this->menu->getName(),
            $this->menu->getDescription()
        );
    }

    /**
     * @param Menu $relationship
     * @return bool
     * @throws \Exception
     * @throws MenuNotSaveException
     */
    public function createRelation(Menu $relationship): bool {
        $this->menuParent = $relationship;
        $this->idRelation = Uuid::uuid4();
        return $this->menuRepository->saveMenuRelation(
            $this->idRelation->toString(), $this->$relationship, $this->menu
        );
    }

    /**
     * @return UuidInterface
     */
    public function getIdRelation(): UuidInterface
    {
        return $this->idRelation;
    }

    /**
     * @return Menu
     */
    public function getMenuParent(): Menu
    {
        return $this->menuParent;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }


}