<?php
namespace Mouf\Utils\I18n\Fine\Common;

use Mouf\Utils\I18n\Fine\TranslatorInterface;
use Mouf\Utils\Value\ValueUtils;
use Mouf\Utils\Value\ValueInterface;

/**
 * An object that represents a translated key.
 */
class TranslatedValue implements ValueInterface
{
    /**
     * The service that will perform the translation
     *
     * @var TranslatorInterface
     */
	private $translator;

	/**
     * Key to search translation
     * @var string|ValueInterface
     */
	private $key;

    /**
     * Parameters to customize the translation
     * @var array<string,string>|ValueInterface
     */
    private $parameters;

    /**
     *
     * @param TranslatorInterface $translator
     * @param string $key
     * @param array<string,string> $parameters
     * @Important
     */
	public function __construct(TranslatorInterface $translator, $key, array $parameters = []) {
        $this->translator = $translator;
        $this->key = $key;
        $this->parameters = $parameters;
    }

	/**
     * Returns the value represented by this object.
     *
     * @return string
     */
	public function val() {
        $translation = $this->translator->getTranslation(ValueUtils::val($this->key), ValueUtils::val($this->parameters));
        if ($translation === null) {
            $translation = '???'.ValueUtils::val($this->key).'???';
        }
        return $translation;
    }
}