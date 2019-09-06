<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Infrastructure;
use PDO;
use PDOException;
use Uetiko\Credit\Menu\Domain\Menu;
use Uetiko\Credit\Menu\Infrastructure\Settings;
use Uetiko\Credit\Menu\Infrastructure\Interfaces\MenuRepository as Repository;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotSaveException;
use Uetiko\Credit\Menu\Infrastructure\Exceptions\MenuNotFindException;

class MenuRepository implements Repository
{
    private $connection = Null;
    /** @var $insert \PDOStatement */
    private $insert = null;
    /** @var \PDOStatement */
    private $insertRelationship = null;
    /** @var $update \PDOStatement */
    private $update = null;
    /** @var $delete \PDOStatement */
    private $delete = null;
    /** @var $find \PDOStatement */
    private $find = null;
    /** @var $findRelation \PDOStatement */
    private $findRelation = null;
    /** @var $findAll \PDOStatement */
    private $findAll = null;

    public function __construct(Settings $setting)
    {
        $dsn = "mysql:dbname={$setting->getDatabaseName()};host={$setting->getDatabaseHostName()}";

        $this->connection = new PDO(
            $dsn,
            $setting->getDatabaseUserName(),
            $setting->getDatabasePassword()
        );

        $this->initStatements();
    }

    private function initStatements():void {
        $this->insert = $this->connection->prepare(
            "INSERT INTO menu (id, name, description)
                       VALUES (:id, :name, :description)"
        );
        $this->insertRelationship = $this->connection->prepare(
            "INSERT INTO menu_relationship(id, id_parent, id_child)
                       VALUES (:id, :id_parent, :id_child)"
        );

        $this->find = $this->connection->prepare(
            "SELECT id, name, description
                       FROM menu
                       WHERE id = :id"
        );

        $this->findAll = $this->connection->prepare(
            "SELECT r.id_parent, r.id_child, r.id
                       FROM menu_relationship r
                       order by r.id_parent asc;
            "
        );

        $this->findRelation = $this->connection->prepare(
            "SELECT id, id_parent, id_child
                       FROM menu_relationship
                       WHERE id_parent = :id
                       order by id asc "
        );
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @return bool
     * @throws MenuNotSaveException
     */
    public function save(string $id, string $name, string $description): bool
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
     * @param string $id
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

    /**
     * @param string $id
     * @return array
     * @throws MenuNotFindException
     */
    public function findById(string $id): array
    {
        $find = [];
        $this->find->bindParam(':id', $id);
        $this->find->execute();
        $find = $this->find->fetch(PDO::FETCH_ASSOC);

        if(true == empty($find)) {
            throw new MenuNotFindException();
        } else {
            return $find;
        }
    }

    public function findAll(): array
    {
        $result = [];
        $this->findAll->execute();
        $result = $this->findAll->fetchAll(PDO::FETCH_ASSOC);

        if(true == empty($result)){
            throw new MenuNotFindException();
        } else {
            return $result;
        }
    }

    public function update(string $id, string $name, string $description): bool
    {
        $rows = 0;
        $rows = $this->connection->exec();

        if(0 == $rows){
            throw new MenuNotSaveException();
        }

        return true;
    }

    public function delete(string $id): bool
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

    /**
     * @param string $id
     * @return array
     * @throws MenuNotFindException
     */
    public function findMenuRelationshipChildrenByid(string $id): array
    {
        $find = [];
        $this->findRelation->bindParam(':id', $id);
        $this->findRelation->execute();
        $find = $this->findRelation->fetchAll(PDO::FETCH_ASSOC);

        if(true == empty($find)) {
            throw new MenuNotFindException();
        } else {
            return $find;
        }
    }
}