<?php
/**
 * @copyright 2018, Marius Blüm <marius@nextcloud.com>
 *
 * @author Marius Blüm <marius@nextcloud.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\EmailTemplateExample;

use Exception;
use OC\Mail\EMailTemplate as ParentTemplate;

class EMailTemplate extends ParentTemplate {

	protected $heading = "";

	/**
	 * the following method overwrites the add button group method and
	 * manipulates the result for the welcome email to only include one button
	 */
	public function addBodyButtonGroup(
		string $textLeft, string $urlLeft,
		string $textRight, string $urlRight,
		string $plainTextLeft = '',
		string $plainTextRight = '') {

		// for the welcome email we omit the left button ("Install client") and only show the button that links to the instance
		if ($this->emailId === 'settings.Welcome') {
			parent::addBodyButton($textLeft, $urlLeft, $plainTextLeft);
			return;
		}
		parent::addBodyButtonGroup($textLeft, $urlLeft, $textRight, $urlRight, $plainTextLeft, $plainTextRight);
	}

	/**
	 * Adds a header to the email
	 */
	public function addHeader() {
		if ($this->headerAdded) {
			return;
		}
		$this->headerAdded = true;
		$this->header = include 'nmc_email_template/template/header.php';
		$this->htmlBody .= str_replace('<str_repalce>',$text, $this->header);
	}


	/**
	 * Adds a paragraph to the body of the email
	 *
	 * @param string $text Note: When $plainText falls back to this, HTML is automatically escaped in the HTML email
	 * @param string|bool $plainText Text that is used in the plain text email
	 *   if empty the $text is used, if false none will be used
	 */
	public function addBodyText(string $text, $plainText = '') {
		if ($this->footerAdded) {
			return;
		}
		if ($plainText === '') {
			$plainText = $text;
			$text = htmlspecialchars($text);
		}
		$this->ensureBodyListClosed();
		$this->ensureBodyIsOpened();
		// To DO:- Add condtions based on email event later this is test only
		if ($this->emailId === 'settings.Welcome') {
			$this->bodyText = include 'nmc_email_template/template/body.php';
		}else{
			$this->bodyText = include 'nmc_email_template/template/body.php';
		}
		$this->htmlBody .= str_replace('<str_repalce>',$text, $this->bodyText);
		// $this->htmlBody .= vsprintf($this->bodyText, [$text]);
		if ($plainText !== false) {
			$this->plainBody .= $plainText . PHP_EOL . PHP_EOL;
		}
	}

	/**
	 * Adds a logo and a text to the footer. <br> in the text will be replaced by new lines in the plain text email
	 *
	 * This method completely overwrites the default behaviour.
	 */

	public function addFooter(string $text = '', ?string $lang = null) {
		if ($this->footerAdded) {
			return;
		}
		$this->footerAdded = true;
		$this->ensureBodyIsClosed();
		$this->header = include 'nmc_email_template/template/footer.php';
		$this->htmlBody .= str_replace('<str_repalce>',$text, $this->header);
	}
}
