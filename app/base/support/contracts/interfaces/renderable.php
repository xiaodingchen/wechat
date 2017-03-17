<?php
namespace App\base\support\contracts\interfaces;

interface renderable
{

	/**
	 * Get the evaluated contents of the object.
	 *
	 * @return string
	 */
	public function render();

}

