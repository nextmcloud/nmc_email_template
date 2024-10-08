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

use OC\Mail\EMailTemplate as ParentTemplate;
use OCP\IConfig;

class EMailTemplate extends ParentTemplate {
	protected string $urlPath = "";
	protected string $bodyText = '%s';
	protected string $heading = <<<EOF
<table align="center" class="container main-heading float-center" style="Margin:0 auto;background:0 0!important;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
	<tbody>
	<tr style="padding:0;text-align:left;vertical-align:top;">
		<td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
			<h1 class="text-center" style="Margin:0;margin-top:20px !important;Margin-bottom:10px;color:inherit;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:center;word-wrap:normal">%s</h1>
		</td>
	</tr>
	</tbody>
</table>
<table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%%">
	<tbody>
	<tr style="padding:0;text-align:left;vertical-align:top">
		<td height="36px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-size:40px;font-weight:400;hyphens:auto;line-height:36px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
	</tr>
	</tbody>
</table>
EOF;
	protected string $head = <<<EOF
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
		table[class=footer-section] .copy-right {
			width: 100%;
			text-align: center !important;
			float: left;
			box-sizing: border-box;
		  }
		  table[class=footer-section] .footer-link {
			width: 100%;
			float: left;
			text-align: center !important;
			box-sizing: border-box;
			padding-right: 0 !important;
		  }

		table[class=monthly-details] .monthly-storage{
			width: 100% !important;
			float: left;
			padding: 0 !important;
			margin-bottom: 16px;
		}
		table[class=quota-details] .quota-info{
			box-sizing: border-box;
			width: 100% !important;
			float: left;
		}
		table[class=quota-details] .warning-info{
			text-align: center !important;
		}
		table[class=quota-details] .warning-info a{
			padding: 12px !important;
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
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #fff;">
		<tr>
		<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
		<td class="container" style="font-family: sans-serif; font-size: 14px; display: block; Margin: 0 auto; max-width: 600px; width: 600px;">
EOF;


	protected string $tail = <<<EOF
</div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
</tr>
</table>
</body>
</html>
EOF;

	protected string $header = <<<EOF
<!-- START Header -->
<div class="header" style="clear: both;text-align: center; width: 100%;border-bottom:2px solid #e5e5e5;">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
  	<tr style="background: #e20074;">
	  <td class="content-block" style="padding: 16px 24px;">
	  <img src="host_namecustomapps/nmctheme/img/telekom/tlogocarrier.svg" style="width: 35px;" />
	  </td>
	  <td style="width: 100%; padding: 16px 0;text-align: left;">
	  <span style="color: #fff;font-size: 16px;font-weight:bold;"></span>
	  </td>
	</tr>
	</tbody>
	</table>
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
	<tbody>
	<tr>
	  <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; padding-left:24px; font-size: 12px; text-align: center;border-top-right-radius:8px;border-top-left-radius:8px">
	  <p style="color: #191919; font-size: 25px; text-align: left;font-weight: bold;margin:4px 0">Magenta<span style="font-size: 25px; font-weight: normal;">CLOUD</span></p>
	  </td>
	</tr>
  </table>
</div>
<!-- END Header -->
EOF;

	protected string $bodyBegin = <<<EOF
<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 600px;">
EOF;


	protected string $bodyEnd = <<<EOF
</div>
EOF;
	protected $l10n = null;

	// protected $button = "";

	// protected $buttonGroup = "";

	// protected $listEnd = "";

	// protected $listItem = "";

	// protected $listBegin = "";

	/**
	 * the following method overwrites the add button group method and
	 * manipulates the result for the welcome email to only include one button
	 */
	public function addBodyButtonGroup(
		string $textLeft,
		string $urlLeft,
		string $textRight,
		string $urlRight,
		string $plainTextLeft = '',
		string $plainTextRight = '',
	): void {

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

	public function addHeader(): void {
		$this->setLanguage();
		if ($this->headerAdded) {
			return;
		}
		$this->urlPath = $this->urlGenerator->getAbsoluteURL('/');
		$sloganTranslated = $this->l10n->t('Life is for sharing');

		$this->header = str_replace('host_name', $this->urlPath, $this->header);

		$this->headerAdded = true;
		$this->htmlBody .= $this->header;
	}


	/**
	 * Adds a heading to the email
	 *
	 * @param string $title
	 * @param string|bool $plainTitle Title that is used in the plain text email
	 *   if empty the $title is used, if false none will be used
	 */
	public function addHeading(string $title, $plainTitle = ''): void {
		if ($plainTitle === '') {
			$plainTitle = $title;
		}

		switch ($this->emailId) {
			case "settings.Welcome":
				$this->button = "";
				$this->buttonGroup = "";
				$this->subject = $this->l10n->t('Welcome to the MagentaCLOUD');
				$this->htmlBody = "";
				$this->heading = "";
				break;
			case "defaultShareProvider.sendNote":
				$this->button = "";
				$this->buttonGroup = "";
				$this->htmlBody .= vsprintf($this->heading, [htmlspecialchars($title)]);
				break;
			case "shareByMail.sendNote":
				$this->button = "";
				$this->buttonGroup = "";
				$this->htmlBody .= vsprintf($this->heading, [htmlspecialchars($title)]);
				break;
			case "sharebymail.RecipientNotification":
				$this->button = "";
				$this->buttonGroup = "";
				$this->subject = $this->data['initiator']." ".$this->l10n->t('shared').' "'.$this->data['filename'].'" '.$this->l10n->t('with you');
				$this->heading = "";
				break;
			case "files_sharing.RecipientNotification":
				$this->button = "";
				$this->buttonGroup = "";
				$this->subject = $this->data['initiator']." ".$this->l10n->t('shared').' "'.$this->data['filename'].'" '.$this->l10n->t('with you');
				$this->heading = "";
				break;
			case "settings.TestEmail":
				$this->htmlBody .= vsprintf($this->heading, [htmlspecialchars($title)]);
				break;
			case "quote.notification":
				$this->button = "";
				$this->buttonGroup = "";
				$this->subject = $this->l10n->t('Your MagentaCLOUD status mail');
				$this->htmlBody .= vsprintf($this->heading, [htmlspecialchars($title)]);
				break;
			case "quota_warning.Notification":
				$this->button = "";
				$this->buttonGroup = "";
				$this->subject = $this->l10n->t('Nearing your storage quota');
				$this->heading = "";
				break;
			case "activity.Notification":
				$this->button = "";
				$this->buttonGroup = "";
				$this->subject = $this->l10n->t('Activity notification for MagentaCLOUD');
				if(isset($this->data['dialyActivity'])) {
					$this->subject = $this->l10n->t('Daily activity summary for MagentaCLOUD');
				}
				$this->heading = '<table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;min-height: 50px;">
				<tr>
				  <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 32px 24px;">
					<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
					  <tr>
						<td style="font-family: sans-serif; vertical-align: top;">
						  <p style="font-family: sans-serif; font-size: 18px; font-weight: bold; margin: 0; Margin-bottom: 16px;">'.$this->l10n->t('Hello').'
						  '.$this->data["displayname"].',</p>
						  <p style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 16px;">'.$this->l10n->t('There were the following activities in your').' <a href="https://www.magentacloud.de/" style="text-decoration:unset;color:#e20074">MagentaCLOUD.</a></p>
						</td>
					  </tr>
					</table>
				  </td>
				</tr>
			   </table>';
				$this->htmlBody .= $this->heading;
				break;
			case "core.EmailVerification":
				$this->button = "";
				$this->buttonGroup = "";
				$this->subject = $this->l10n->t('MagentaCLOUD email verification');
				$this->heading = '';
				break;
			default:
				$this->htmlBody .= vsprintf($this->heading, [htmlspecialchars($title)]);
		}

		if ($plainTitle !== false) {
			$this->plainBody .= $plainTitle . PHP_EOL . PHP_EOL;
		}
	}




	/**
	 * Adds a paragraph to the body of the email
	 *
	 * @param string $text Note: When $plainText falls back to this, HTML is automatically escaped in the HTML email
	 * @param string|bool $plainText Text that is used in the plain text email
	 *   if empty the $text is used, if false none will be used
	 */
	public function addBodyText(string $text, $plainText = ''): void {
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
				$this->bodyText = include_once 'nmc_email_template/template/welcome_mail.php';
				$this->htmlBody .= rtrim($this->bodyText, "1");
				break;
			case "sharebymail.RecipientNotification":
				if($this->data['note'] == null || $this->data['note'] == "") {
					$text = "";
				}
				$this->bodyText = include_once 'nmc_email_template/template/sharebymail_recipientNotification.php';
				$this->htmlBody .= rtrim($this->bodyText, "1");
				break;
			case "files_sharing.RecipientNotification":
				$this->bodyText = include_once 'nmc_email_template/template/files_sharing_recipient_notification.php';
				$this->htmlBody .= rtrim($this->bodyText, "1");
				break;
			case "settings.TestEmail":
				$this->htmlBody .= vsprintf($this->bodyText, [$text]);
				break;
			case "quote.notification":
				$this->htmlBody .= vsprintf($this->bodyText, [$text]);
				break;
			case "quota_warning.Notification":
				$this->bodyText = include_once 'nmc_email_template/template/quota_warning.php';
				$this->htmlBody .= rtrim($this->bodyText, "1");
				break;
			case "activity.Notification":
				$this->bodyText = "";
				$this->htmlBody .= vsprintf($this->bodyText, [$text]);
				break;
			case "core.EmailVerification":
				$this->bodyText = include_once 'nmc_email_template/template/email_verification.php';
				$this->htmlBody .= rtrim($this->bodyText, "1");
				break;
			default:
				$this->htmlBody .= vsprintf($this->bodyText, [$text]);
		}
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

	public function addFooter(string $text = '', ?string $lang = null): void {
		$this->footer = '<div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;border-top:1px solid #191919">
		<table class="footer-section" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
		  <tr>
			<td class="copy-right" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; padding-left:24px; font-size: 12px; color: #191919; text-align: left;">
			  <span class="apple-link" style="color: #191919; font-size: 12px;font-weight: bold;">© Telekom Deutschland GmbH</span>
			</td>
			<td class="footer-link" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #191919; text-align: right;">
			  <span class="apple-link" style="color: #191919; font-size: 12px; ">
				<a>&nbsp;</a></span>
			</td>
			<td class="footer-link" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #191919; text-align: right;">
			  <span class="apple-link" style="color: #191919; font-size: 12px; ">
				<a>&nbsp;</a></span>
			</td>
			<td class="footer-link" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #191919; text-align: right;padding-right: 24px;">
			  <span class="apple-link" style="color: #191919; font-size: 12px; ">
				<a href="'.$this->urlPath.'index.php/settings/user">'.$this->l10n->t('Unsubscribe').'</a></span>
			</td>


			</tr>
<tr>
			<td class="footer-link" style="padding-left:24px;font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 0px; font-size: 12px; color: #191919; text-align: left;">
			  <span class="apple-link" style="color: #191919; font-size: 12px; ">
				<a href="https://static.magentacloud.de/licences/webui.htm">'.$this->l10n->t('Open Source licences').'</a></span>
			</td>
<td class="footer-link" style="padding-right:50px;font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 0px; font-size: 12px; color: #191919; text-align: left;">
			  <span class="apple-link" style="color: #191919; font-size: 12px;">
				<a href="http://www.telekom.de/impressum">'.$this->l10n->t('Impressum').'</a></span>
			</td>

<td class="footer-link" style="padding-right:50px;font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 0px; font-size: 12px; color: #191919; text-align: right;">
			  <span class="apple-link" style="color: #191919; font-size: 12px; text-align: left;"> <a href="https://static.magentacloud.de/Datenschutz">'.$this->l10n->t('Data Protection').'</a></span>
			</td>
<td class="footer-link" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 0px; padding-right: 24px; font-size: 12px; color: #191919; text-align: right;">
			  <span class="apple-link" style="color: #191919; font-size: 12px;"> <a href="https://cloud.telekom-dienste.de/hilfe">'.$this->l10n->t('Help & FAQ').'</a></span>
			</td>
</tr>

		</table>
	  </div>';
		if ($this->footerAdded) {
			return;
		}
		$this->footerAdded = true;
		$this->ensureBodyIsClosed();
		if($this->emailId == "defaultShareProvider.sendNote" || $this->emailId == "shareByMail.sendNote") {
			$this->htmlBody = str_replace('style="Margin:0 auto;background:0 0!important;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"', 'style="font-size:16px;font-family: TeleNeo, sans-serif;color:#191919;float:left !important"', $this->htmlBody);
			$this->htmlBody = str_replace("'Segoe UI'", '', $this->htmlBody);
			$this->htmlBody = str_replace("'Helvetica Neue'", "", $this->htmlBody);
			$this->htmlBody = str_replace('style="Margin:0;margin-top:20px !important;Margin-bottom:10px;color:inherit;font-family:-apple-system,BlinkMacSystemFont,,Roboto,Oxygen-Sans,Ubuntu,Cantarell,,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:center;word-wrap:normal"', 'style="Margin:0;margin-top:20px !important;Margin-bottom:10px;color:inherit;font-family:TeleNeo, sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding: 0 0 0 24px !important;text-align:left;word-wrap:normal;color:#191919"', $this->htmlBody);
			$this->htmlBody = str_replace('style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 600px;"', 'style="font-size:16px;font-family: TeleNeo, sans-serif;color:#191919;padding: 0 0 0 24px !important;margin-bottom:80px"', $this->htmlBody);
			$this->htmlBody = str_replace("</h1>", ":</h1>", $this->htmlBody);
		}
		$this->htmlBody .= $this->footer.$this->tail;
	}

	public function setLanguage() {
		if ($this->l10n) {
			return;
		}
		$userSession = \OC::$server->getUserSession();
		$config = \OC::$server->get(IConfig::class);

		$langCurrent = $config->getSystemValue('default_language', 'en');
		if(isset($this->data['userId'])) {
			$langCurrent = $config->getUserValue($this->data['userId'], 'core', 'lang', null);
		} elseif(isset($this->data['userid'])) { // Welcome email
			$langCurrent = $config->getUserValue($this->data['userid'], 'core', 'lang', null);
		} elseif ($userSession->getUser() !== null) {
			$langCurrent = $config->getUserValue($userSession->getUser()->getUID(), 'core', 'lang', null);
		}
		$this->l10n = $this->l10nFactory->get('nmc_email_template', $langCurrent);
	}
}
