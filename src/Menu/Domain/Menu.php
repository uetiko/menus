<?php
declare(strict_types=1);

namespace Uetiko\Credit\Menu\Domain;


class Menu
{
    /** @var $id int */
    private $id = null;
    /** @var $name string */
    private $name = null;
    /** @var $description string */
    private $description = null;

    public function __construct(int $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}