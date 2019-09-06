<?php
declare(strict_types=1);
namespace Uetiko\Credit\Menu\Application;

use Uetiko\Credit\Menu\Infrastructure\Interfaces\Repository;

class MenuDelete
{
    protected $menuRepisitory = null;
    protected $menuToErase = [];

    public function __construct(Repository $menuRepository)
    {
        $this->menuRepisitory = $menuRepository;
    }
}