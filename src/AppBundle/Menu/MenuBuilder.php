<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder {

    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory) {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack) {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', array('route' => 'homepage'));
        $route = $requestStack->getCurrentRequest()->get('_route');
        dump($route);
        switch ($route) {
            case 'products':
                $menu
                        ->addChild('Productos')
                        ->setCurrent(true)
                ;
                break;
            case 'products_filtered':
                $menu
                        ->addChild('Productos')
                        ->setCurrent(true)
                ;
                break;
             case 'product':
                $menu
                        ->addChild('Productos')
                        ->setCurrent(true)
                ;
                break;
            case 'gallery':
                $menu
                        ->addChild('Galería')
                        ->setCurrent(true)
                ;
                break;
            case 'contact':
                $menu
                        ->addChild('Contacto')
                        ->setCurrent(true)
                ;
                break;
        }

        return $menu;
    }

}
