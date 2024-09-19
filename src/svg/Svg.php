<?php

namespace bsqr\svg;

use Imagick;
use ImagickPixel;


/**
 * Svg image.
 */
class Svg {


	/** @var string ~ Content between <svg> and </svg> tags.*/
	protected $content;
	/** @var string[] ~ Attributes of svg root element */
	protected $attributes;


	/**
	 * @param string $content ~ Content between <svg> and </svg> tags.
	 * @param string[] $attributes ~ Attributes of svg root element.
	 */
	public function __construct($content, $attributes = []) {
		$this->content = $content;
		$this->attributes = $attributes;
	}


	/**
	 * Return an instance with current and specified attributes merged.
	 *
	 * @param string[] $attributes
	 * @return Svg
	 */
	public function withAttrs(array $attributes) {
		return new Svg($this->content, array_merge($this->attributes, $attributes));
	}


	/**
	 * Return an instance with specified size.
	 *
	 * @param string|int|float $width
	 * @param string|int|float $height
	 * @return Svg
	 */
	public function withSize($width, $height) {
		return $this->withAttrs(["width" => $width, "height" => $height]);
	}


	/** @return string */
	public function __toString() {
		$result = "<svg xmlns=\"http://www.w3.org/2000/svg\"";
		foreach ($this->attributes as $arg => $value) {
			if (NULL !== $value) {
				$result .= " " . $arg . "=\"" . htmlspecialchars($value, ENT_QUOTES) . "\"";
			}
		}
		$result .= ">" . $this->content . "</svg>";
		return $result;
	}


    /**
     *
     *
     * @param int $width ~ Width.
     * @param int $height ~ Height.
     *
     * @return Imagick
     * @throws \ImagickException
     */
	public function toImagick($width, $height): Imagick
    {
		$svgData = (string) $this->withSize($width, $height);

		$img = new Imagick();
		$img->setBackgroundColor(new ImagickPixel("transparent"));
		$img->readImageBlob($svgData);
		return $img;
	}

}
