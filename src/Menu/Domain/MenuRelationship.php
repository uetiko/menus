<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Domain;

use Uetiko\Credit\Menu\Domain\Menu;

class MenuRelationship
{
    /** @var $id string */
    private $id = null;
    /** @var \Uetiko\Credit\Menu\Domain\Menu */
    private $parent = Null;
    /** @var \Uetiko\Credit\Menu\Domain\Menu */
    private $child = Null;

    public function __construct(string $id, Menu $parent, Menu $child)
    {
        $this->id = $id;
        $this->parent = $parent;
        $this->child = $child;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \Uetiko\Credit\Menu\Domain\Menu
     */
    public function getParent(): \Uetiko\Credit\Menu\Domain\Menu
    {
        return $this->parent;
    }

    /**
     * @return \Uetiko\Credit\Menu\Domain\Menu
     */
    public function getChild(): \Uetiko\Credit\Menu\Domain\Menu
    {
        return $this->child;
    }
}