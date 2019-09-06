<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Infrastructure;
use PDO;
use PDOException;
use Uetiko\Credit\Menu\Domain\Menu;
use Uetiko\Credit\Menu\Infrastructure\Settings;
use Uetiko\Credit\Menu\Infrastructure\Interfaces\Repository;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotSaveException;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotFindException;

class MenuRepository implements Repository
{
    private $connection = Null;
    /** @var $insert \PDOStatement */
    private $insert = null;
    /** @var \PDOStatement */
    private $insertRelationship = null;
    private $update = null;
    private $delete = null;

    public function __construct(Settings $setting)
    {
        $dsn = "mysql:dbname={$setting->getDatabaseName()};host={$setting->getDatabaseHostName()}";

        $this->connection = new PDO(
            $dsn,
            $setting->getDatabaseUserName(),
            $setting->getDatabasePassword()
        );
        $this->insert = $this->connection->prepare(
            "INSERT INTO menu (id, name, description)
                       VALUES (:id, :name, :description)"
        );
        $this->insertRelationship = $this->connection->prepare(
            "INSERT INTO menu_relationship(id, id_parent, id_child)
                       VALUES (:id, :id_parent, :id_child)"
        );
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @return bool
     * @throws MenuNotSaveException
     */
    public function save(int $id, string $name, string $description): bool
    {
        $this->connection->beginTransaction();

        $this->insert->bindParam(':id', $id);
        $this->insert->bindParam(':name', $name);
        $this->insert->bindParam(':description', $description);

        try{

            $result = $this->insert->execute();
        }catch (PDOException $exception){
            $this->connection->rollBack();
            throw new MenuNotSaveException();
        }

        if (false == $result){
            throw new MenuNotSaveException();
        }else{
            return $this->connection->commit();
        }
    }

    /**
     * @param int $id
     * @param Menu $parent
     * @param Menu $child
     * @return bool
     * @throws MenuNotSaveException
     */
    public function saveMenuRelation(string $id, Menu $parent, Menu $child): bool
    {
        $result = false;
        $this->insertRelationship->bindParam(':id', $id);
        $this->insertRelationship->bindParam(':id_parent', $parent->getId());
        $this->insertRelationship->bindParam(':id_child', $child->getId());

        $this->connection->beginTransaction();

        try{
            $result = $this->insertRelationship->execute();
            $this->connection->commit();
        } catch (PDOException $exception) {
            $this->connection->rollBack();
            throw new MenuNotSaveException();
        }

        if (false == $result) {
            throw new MenuNotSaveException();
        } else {
            return $result;
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