<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Infrastructure\Interfaces;
use Uetiko\Credit\Menu\Domain\Menu;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotFindException;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotSaveException;

interface Repository
{
    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @return bool
     * @throws MenuNotSaveException
     */
    public function save(string $id, string $name, string $description): bool;

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
    public function findById(string $id): array;

    /**
     * @return array
     * @throws MenuNotFindException
     */
    public function findAll(): array ;
    public function update(string $id, string $name, string $description): bool;
    public function delete(string $id): bool;
}