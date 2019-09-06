<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Domain;

use Uetiko\Credit\Menu\Domain\Menu;

class MenuRelationship
{
    /** @var \Uetiko\Credit\Menu\Domain\Menu */
    private $parent = Null;
    /** @var \Uetiko\Credit\Menu\Domain\Menu */
    private $child = Null;

    public function __construct(Menu $parent, Menu $child)
    {
        $this->parent = $parent;
        $this->child = $child;
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