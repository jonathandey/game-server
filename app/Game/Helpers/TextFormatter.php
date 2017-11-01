<?php

namespace App\Game\Helpers;

use Golonka\BBCode\BBCodeParser;

class TextFormatter
{
	protected $text = '';

	private $bbCodeParser = null;

	public function __construct($text)
	{
		$this->text = $text;

		$this->setBBCodeParsers();
	}

	public function asBBCode()
	{
		return $this->bbCodeParser()->only(
				'image', 
				'bold', 
				'italic',
				'center',
				'quote',
				'sub',
				'underline',
				'youtube'
			)
			->parse($this->text)
		;
	}

	protected function setBBCodeParsers()
	{
		$this->bbCodeParser()->setParser(
			'youtube', 
			"/\[youtube\](?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)\[\/youtube\]/s",
			'<iframe width="560" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
			'$1'
		);
	}

	private function bbCodeParser()
	{
		if (! is_null($this->bbCodeParser)) {
			return $this->bbCodeParser;
		}

		$this->bbCodeParser = new BBCodeParser;

		return $this->bbCodeParser;
	}

}