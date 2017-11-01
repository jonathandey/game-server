<?php

namespace App\Http\Response;

class Response
{
	protected $includedAttributes = [];

	public function includeAttributes(array $attributes = [])
	{
		$this->includedAttributes = array_merge_recursive($this->includedAttributes, $attributes);

		return $this;
	}

	public function view($file, array $attributes = [])
	{
		$attributes = array_merge_recursive($this->includedAttributes, $attributes);

		return view($file, $attributes);
	}

	public function redirectBackWithMessage($message = null)
	{
		return redirect()->back()->with(compact('message'));
	}
}