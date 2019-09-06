<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Infrastructure;
use PDO;
use PDOException;
use Uetiko\Credit\Menu\Infrastructure\Settings;
use Uetiko\Credit\Menu\Infrastructure\Interfaces\Repository;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotSaveException;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotFindException;

class MenuRepository implements Repository
{
    private $connection = Null;

    public function __construct(Settins $setting)
    {
        $this->connection = new PDO();
    }

    public function save(int $id, string $name, string $description): bool
    {
        $this->connection->beginTransaction();

        try{
            $this->connection->exec();
            return $this->connection->commit();
        }catch (PDOException $exception){
            $this->connection->rollBack();
            throw new MenuNotSaveException();
        }
    }

    public function findById(int $id): array
    {
        $statement = $this->connection->query();
        return  $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll(): array
    {
        $statement = $this->connection->query();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $name, string $description): bool
    {
        $rows = 0;
        $rows = $this->connection->exec();

        if(0 == $rows){
            throw new MenuNotSaveException();
        }

        return true;
    }

    public function delete(int $id): bool
    {
        $rows = 0;

        try{
            $rows = $this->connection->exec();
        } catch (PDOException $exception){
            throw new MenuNotSaveException();
        }

        if (0 == $rows){
            throw  new MenuNotFindException();
        }else{
            return true;
        }
    }

    public function __destruct()
    {
        $this->connection = null;
    }
}