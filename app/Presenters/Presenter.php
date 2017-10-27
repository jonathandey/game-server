<?php

namespace App\Presenters;

abstract class Presenter
{
	public function htmlErrorMessage($errorMessage)
	{
		return "<div class='alert alert-danger text-center'>{$errorMessage}</div>";
	}

	public function htmlSuccessMessage($successMessage)
	{
		return "<div class='alert alert-success text-center'>{$successMessage}</div>";
	}

	public function htmlInfoMessage($successMessage)
	{
		return "<div class='alert alert-info text-center'>{$successMessage}</div>";
	}
}