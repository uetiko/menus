<?php
declare(strict_types=1);

namespace Uetiko\Credit\Menu\Domain;


class Menu
{
    /** @var $id string */
    private $id = null;
    /** @var $name string */
    private $name = null;
    /** @var $description string */
    private $description = null;

    public function __construct(string $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}