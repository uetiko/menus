<?php


namespace Uetiko\Credit\Menu\Infrastructure\Interfaces;


use Uetiko\Credit\Menu\Domain\Menu;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotFindException;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotSaveException;
use Uetiko\Credit\Menu\Infrastructure\Interfaces\Repository;

interface MenuRepository extends Repository
{
    /**
     * @param string $id
     * @param Menu $parent
     * @param Menu $child
     * @return bool
     * @throws MenuNotSaveException
     */
    public function saveMenuRelation(string $id, Menu $parent, Menu $child): bool;

    /**
     * @param string $id
     * @return array
     * @throws MenuNotFindException
     */
    public function findMenuRelationshipChildrenByid(string $id): array ;
}