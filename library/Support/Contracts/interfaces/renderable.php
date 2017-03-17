<?php
namespace Skinny\support\contracts\interfaces;

interface renderable
{

	/**
	 * Get the evaluated contents of the object.
	 *
	 * @return string
	 */
	public function render();

}

