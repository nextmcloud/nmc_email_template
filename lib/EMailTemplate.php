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
	protected $displayname;

	protected $head = <<<EOF
<!doctype html>
<html>
	<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Magenta Cloud</title>
	<style>
	@media only screen and (max-width: 620px) {
		table[class=body] h1 {
		font-size: 28px !important;
		margin-bottom: 10px !important;
		}
		table[class=body] p,
			table[class=body] ul,
			table[class=body] ol,
			table[class=body] td,
			table[class=body] span,
			table[class=body] a {
		font-size: 16px !important;
		}
		table[class=body] .wrapper,
			table[class=body] .article {
		padding: 10px !important;
		}
		table[class=body] .content {
		padding: 0 !important;
		}
		table[class=body] .container {
		padding: 0 !important;
		width: 100% !important;
		}
		table[class=body] .main {
		border-left-width: 0 !important;
		border-radius: 0 !important;
		border-right-width: 0 !important;
		}
		table[class=body] .btn table {
		width: 100% !important;
		}
		table[class=body] .btn a {
		width: 100% !important;
		}
		table[class=body] .img-responsive {
		height: auto !important;
		max-width: 100% !important;
		width: auto !important;
		}
	}
	@media all {
		.ExternalClass {
		width: 100%;
		}
		.ExternalClass,
			.ExternalClass p,
			.ExternalClass span,
			.ExternalClass font,
			.ExternalClass td,
			.ExternalClass div {
		line-height: 100%;
		}
		.apple-link a {
		color: inherit !important;
		font-family: inherit !important;
		font-size: inherit !important;
		font-weight: inherit !important;
		line-height: inherit !important;
		text-decoration: none !important;
		}
		#MessageViewBody a {
		color: inherit;
		text-decoration: none;
		font-size: inherit;
		font-family: inherit;
		font-weight: inherit;
		line-height: inherit;
		}
		.btn-primary table td:hover {
		background-color: #e20074 !important;
		}
		.btn-primary a:hover {
		background-color: #e20074 !important;
		border-color: #e20074 !important;
		}
	}
	</style>
	</head>
	<body style="background-color: #fff; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
	<span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #fff;">
		<tr>
		<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
		<td class="container" style="font-family: sans-serif; font-size: 14px; display: block; Margin: 0 auto; max-width: 600px; width: 600px;">
EOF;


protected $tail = <<<EOF
</div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
</tr>
</table>
</body>
</html>
EOF;

protected $header = <<<EOF
<!-- START Header -->
<div class="header" style="clear: both;text-align: center; width: 100%;border-bottom:2px solid #e5e5e5;">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
	<tr>
	  <td class="content-block" style="background: #e20074;font-family: sans-serif; vertical-align: top; padding-bottom: 16px; padding-top: 16px; padding-left:24px; font-size: 12px; color: #999999; text-align: left;">
	  <img src="https://dev1.next.magentacloud.de/themes/nextmagentacloud21/core/img/logo.svg" width="72px" height="35px"/>
	<span style="color: #fff; font-size: 16px; text-align: left;font-weight:bold;line-height: 40px;padding-left: 24px;vertical-align: top;"> Life is for sharing.</span>
	  </td>
	</tr>
	<tr>
	  <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; padding-left:24px; font-size: 12px; text-align: center;border-top-right-radius:8px;border-top-left-radius:8px">
	  <p style="color: #191919; font-size: 25px; text-align: left;font-weight: bold;margin:4px 0">Magenta<span style="font-size: 25px; font-weight: normal;">CLOUD</span></p>
	  </td>
	</tr>

  </table>
</div>
<!-- END Header -->
EOF;

protected $bodyBegin = <<<EOF
<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 600px;">
EOF;


protected $bodyEnd = <<<EOF
</div>
EOF;

protected $button = "";

protected $buttonGroup = "";

protected $listEnd = "";

protected $listItem = "";

protected $listBegin = "";

protected $footer = <<<EOF
<!-- START FOOTER -->
<div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;border-top:2px solid #e5e5e5">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
	<tr>
	  <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; padding-left:24px; font-size: 12px; color: #999999; text-align: left;">
		<span class="apple-link" style="color: #191919; font-size: 16px; text-align: left;">© Telekom Deutschland GmbH</span>
	  </td>
<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
		<span class="apple-link" style="color: #191919; font-size: 16px; text-align: left;">
Impressum</span>
	  </td>
<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
		<span class="apple-link" style="color: #191919; font-size: 16px; text-align: left;">Datenschutz</span>
	  </td>
<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; padding-right: 24px; font-size: 12px; color: #999999; text-align: right;">
		<span class="apple-link" style="color: #191919; font-size: 16px; text-align: left;">Hilfe & FAQ</span>
	  </td>
	</tr>

  </table>
</div>
<!-- END FOOTER -->
EOF;

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
		$this->htmlBody .= $this->header;
	}


	/**
	 * Adds a paragraph to the body of the email
	 *
	 * @param string $text Note: When $plainText falls back to this, HTML is automatically escaped in the HTML email
	 * @param string|bool $plainText Text that is used in the plain text email
	 *   if empty the $text is used, if false none will be used
	 */
	public function addBodyText(string $text, $plainText = '') {
		// $uid = \OC_User::getUser();
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

		switch ($this->emailId) {
		  case "settings.Welcome":
			$this->bodyText = include 'nmc_email_template/template/body.php';
			break;
		  case "files_sharing.RecipientNotification":
			$this->bodyText = include 'nmc_email_template/template/files_sharing_recipient_notification.php';
			break;
		  case "defaultShareProvider.sendNote":
			$this->bodyText = include 'nmc_email_template/template/default_shareprovider_sendnote.php';
			break;
		  case "settings.TestEmail":
			$this->bodyText = include 'nmc_email_template/template/test_email.php';
			break;
		  case "quote.notification":
			$this->bodyText = include 'nmc_email_template/template/body.php';
			break;
		  case "quota warning.notifiaiont":
			$this->bodyText = include 'nmc_email_template/template/body.php';
			break;
		  default:
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
		// $this->footer = "Details ".json_encode($this->data).include 'nmc_email_template/template/footer.php';
		// $this->htmlBody .= str_replace('<str_repalce>',$text, $this->emailId."**************".$this->footer);
		$this->htmlBody .= $this->footer;
	}
}
