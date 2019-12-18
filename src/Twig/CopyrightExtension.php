<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CopyrightExtension extends AbstractExtension
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('copyright', [$this, 'copyright']),
        ];
    }

    public function copyright(?string $since=null)
    {
        $copyright = "&copy; ";

        if (null == $since) {
            $since = date('Y');
        }

        $copyright.= $since;

        if ($since < date('Y')) {
            $copyright.= "-".date('Y');
        }

        $copyright.= " ".$this->params->get('appTitle');

        return html_entity_decode($copyright);
    }
}
