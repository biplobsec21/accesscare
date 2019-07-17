<?php

namespace App\Traits;

/**
 * Trait GeneratesModals
 */
trait GeneratesModals
{

	/**
	 * Generate a random string based on the characters and length provided; also ensure the generated value is not in a database
	 *
	 * @param string $id Id of the new modal
	 * @param string $title Text appearing in the modal-header
	 * @param string $body Text appearing in modal-body
	 * @return string The generated string
	 */
	protected function generateModal($id, $title, $body, $foot = null)
	{
		return '<div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header p-2">
				<h5 class="m-0">' . $title . '</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i class="fal fa-times"></i>
				</button>
				</div>
				<div class="modal-body">' . $body . '</div>
				<div class="modal-footer p-2 d-flex justify-content-between">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>' .
				$foot
				. '</div>
				</div>
				</div>
				</div>';
	}
}
