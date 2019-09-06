<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Infrastructure\Interfaces;

interface Repository
{
    public function save(int $id, string $name, string $description): bool;
    public function findById(int $id): array;
    public function findAll(): array ;
    public function update(int $id, string $name, string $description): bool;
    public function delete(int $id): bool;
}