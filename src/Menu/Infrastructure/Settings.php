<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Infrastructure;

class Settings
{
    private $databaseHostName = '';
    private $databaseName = '';
    private $databaseUserName = '';
    private $databasePassword = '';
    private $databaseSchema = '';

    /**
     * @return string
     */
    public function getDatabaseHostName(): string
    {
        return $this->databaseHostName;
    }

    /**
     * @return string
     */
    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    /**
     * @return string
     */
    public function getDatabaseUserName(): string
    {
        return $this->databaseUserName;
    }

    /**
     * @return string
     */
    public function getDatabasePassword(): string
    {
        return $this->databasePassword;
    }

    /**
     * @return string
     */
    public function getDatabaseSchema(): string
    {
        return $this->databaseSchema;
    }


}