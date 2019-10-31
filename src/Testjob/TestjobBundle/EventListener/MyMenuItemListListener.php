<?php

namespace Testjob\TestjobBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MyMenuItemListListener
{
    protected $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request)
    {
        $gallery_page = new \Avanzu\AdminThemeBundle\Model\MenuItemModel('home', 'Галерея', 'testjob_gallery');
        $users_page = new \Avanzu\AdminThemeBundle\Model\MenuItemModel('second', 'Пользователи', 'testjob_users');

        $menuItems = [$gallery_page];

        if ($this->checker->isGranted('ROLE_ADMIN')) {
            $menuItems[] = $users_page;
        }

        return $this->activateByRoute($request->get('_route'), $menuItems);
    }

    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }
}