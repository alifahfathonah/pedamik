<?php

namespace App;

use DI\Container;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension implements ExtensionInterface, GlobalsInterface
{
    protected $container;

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    public function getGlobals(): array
    {
        return [
            'flash_message' => $this->getFlashMessage(),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('dd', [$this, 'dieDump']),
            new TwigFunction('alertType', [$this, 'alertType']),
            new TwigFunction('old', [$this, 'old']),
        ];
    }

    public function dieDump($thing)
    {
        dd($thing);
    }

    public function alertType($type)
    {
        switch ($type) {
            case 'warning':
                return 'orange';
                break;

            case 'danger':
                return 'red';
                break;

            case 'primary':
                return 'blue';
                break;

            case 'success':
                return 'green';
                break;

            default:
                return 'gray';
                break;
        }
    }

    public function getFlashMessage()
    {
        if (!$this->container->get('flash')->hasMessage('flash_message')) return null;

        return $this->container->get('flash')->getMessage('flash_message')[0];
    }

    public function old($name)
    {
        if (!$this->container->get('flash')->hasMessage('input')) return '';

        $input = $this->container->get('flash')->getMessage('input')[0];

        if (array_key_exists($name, $input)) return $input[$name];

        return null;
    }
}
