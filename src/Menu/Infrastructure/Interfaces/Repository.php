<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Infrastructure\Interfaces;
use Uetiko\Credit\Menu\Domain\Menu;

interface Repository
{
    public function save(string $id, string $name, string $description): bool;
    public function saveMenuRelation(string $id, Menu $parent, Menu $child): bool;
    public function findById(string $id): array;
    public function findAll(): array ;
    public function update(string $id, string $name, string $description): bool;
    public function delete(string $id): bool;
}