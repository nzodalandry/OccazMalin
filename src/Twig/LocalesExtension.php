<?php
namespace App\Twig;
 
use Symfony\Component\Intl\Intl;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

 
class LocalesExtension extends AbstractExtension
{
    private $locales;
    private $params;
    private $localeCodes;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->localeCodes = explode('|', $this->params->get('locales'));
    }
 
    // /**
    //  * {@inheritdoc}
    //  */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }
 
    // /**
    //  * Takes the list of codes of the locales (languages) enabled in the
    //  * application and returns an array with the name of each locale written
    //  * in its own language (e.g. English, Français, Español, etc.).
    //  */
    public function getLocales()
    {
        if (null !== $this->locales) {
            return $this->locales;
        }
 
        $this->locales = [];
        foreach ($this->localeCodes as $localeCode) {
            $this->locales[] = [
                'code' => $localeCode, 
                'name' => ucfirst(Intl::getLocaleBundle()->getLocaleName($localeCode, $localeCode))
            ];
        }
 
        return $this->locales;
    }
}