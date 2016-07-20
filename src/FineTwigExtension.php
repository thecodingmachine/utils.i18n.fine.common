<?php
namespace Mouf\Utils\I18n\Fine\Common;

use Interop\Container\ContainerInterface;
use Mouf\Utils\I18n\Fine\TranslatorInterface;
use Twig_Extension;
use Mouf\Html\HtmlElement\HtmlElementInterface;
use Mouf\Utils\Value\ValueInterface;
use Mouf\MoufException;

/**
 * The Fine Twig extension provides a "t" filter that you can use to translate strings in Twig templates.
 *
 * @author David Negrier <david@mouf-php.com>
 *
 */
class FineTwigExtension extends Twig_Extension
{

    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'fine';
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('t', [$this, 'translate']),
        );
    }

    public function translate($message, array $parameters = array(), LanguageDetectionInterface $languageDetection = null)
    {
        $text = $this->translator->getTranslation($message, $parameters, $languageDetection);
        return ($text !== null) ? $text : "???".$message."???";
    }
}
