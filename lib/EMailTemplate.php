<?php

declare(strict_types=1);

namespace OCA\NmcEmailTemplate;

use OC\Mail\EMailTemplate as ParentTemplate;
use OCP\IL10N;

class EMailTemplate extends ParentTemplate {
	protected string $urlPath = '';
	protected string $bodyText = '%s';

	protected string $heading = <<<EOF
<table align="center" class="container main-heading float-center" style="margin:0 auto;background:0 0!important;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:580px">
	<tbody>
		<tr style="padding:0;text-align:left;vertical-align:top;">
			<td style="-moz-hyphens:auto;-webkit-hyphens:auto;border-collapse:collapse!important;color:#0a0a0a;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
				<h1 class="text-center" style="margin:20px 0 10px;color:inherit;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;padding:0;text-align:center;word-wrap:normal">%s</h1>
			</td>
		</tr>
	</tbody>
</table>
<table class="spacer float-center" style="margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:100%%">
	<tbody>
		<tr style="padding:0;text-align:left;vertical-align:top">
			<td height="36" style="border-collapse:collapse!important;font-size:40px;line-height:36px;margin:0;padding:0;">&#xA0;</td>
		</tr>
	</tbody>
</table>
EOF;

	protected string $head = <<<EOF
<!doctype html>
<html lang="en" xml:lang="en">
<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>MagentaCLOUD</title>
	<style>
	@media only screen and (max-width:620px) {
		table[class=body] h1 { font-size:28px!important; margin-bottom:10px!important; }
		table[class=body] .content { padding:0!important; }
		table[class=body] .container { padding:0!important; width:100%!important; }
		table[class=body] .main { border-left-width:0!important; border-radius:0!important; border-right-width:0!important; }
		table[class=body] .btn table { width:100%!important; }
		table[class=body] .btn a { width:100%!important; }
		table[class=body] .img-responsive { height:auto!important; max-width:100%!important; width:auto!important; }
		table[class=footer-section] .copy-right,
		table[class=footer-section] .footer-link { width:100%!important; float:left; text-align:center!important; box-sizing:border-box; padding-left:0!important; padding-right:0!important; }
		table[class=monthly-details] .monthly-storage { width:100%!important; float:left; padding:0!important; margin-bottom:16px; }
		table[class=quota-details] .quota-info { box-sizing:border-box; width:100%!important; float:left; }
		table[class=quota-details] .warning-info { text-align:center!important; }
		table[class=quota-details] .warning-info a { padding:12px!important; }
	}
	@media all {
		.ExternalClass { width:100%; }
		.ExternalClass,
		.ExternalClass p,
		.ExternalClass span,
		.ExternalClass font,
		.ExternalClass td,
		.ExternalClass div { line-height:100%; }
		.apple-link a { color:inherit!important; font-family:inherit!important; font-size:inherit!important; font-weight:inherit!important; line-height:inherit!important; text-decoration:none!important; }
		#MessageViewBody a { color:inherit; text-decoration:none; font-size:inherit; font-family:inherit; font-weight:inherit; line-height:inherit; }
		.btn-primary table td:hover { background-color:#e20074!important; }
		.btn-primary a:hover { background-color:#e20074!important; border-color:#e20074!important; }
	}
	</style>
</head>
<body style="background-color:#fff;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;background-color:#fff;">
	<tr>
		<td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
		<td class="container" style="font-family:sans-serif;font-size:14px;display:block;margin:0 auto;max-width:600px;width:600px;">
EOF;

	protected string $tail = <<<EOF
		</td>
		<td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
	</tr>
</table>
</body>
</html>
EOF;

	protected string $header = <<<EOF
<div class="header" style="clear:both;text-align:center;width:100%;border-bottom:2px solid #e5e5e5;">
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
		<tbody>
			<tr style="background:#e20074;">
				<td class="content-block" style="padding:16px 24px;">
					<img src="{{logoUrl}}" style="width:35px;" alt="Telekom">
				</td>
				<td style="width:100%;padding:16px 0;text-align:left;"></td>
			</tr>
		</tbody>
	</table>
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
		<tbody>
			<tr>
				<td class="content-block" style="font-family:sans-serif;vertical-align:top;padding:10px 0 10px 24px;font-size:12px;">
					<p style="color:#191919;font-size:25px;text-align:left;font-weight:bold;margin:4px 0;">Magenta<span style="font-weight:normal;">CLOUD</span></p>
				</td>
			</tr>
		</tbody>
	</table>
</div>
EOF;

	protected string $bodyBegin = <<<EOF
<div class="content" style="box-sizing:border-box;display:block;margin:0 auto;max-width:600px;">
EOF;

	protected string $bodyEnd = <<<EOF
</div>
EOF;

	private string $shareNoteHeading = <<<EOF
<h1 style="margin:20px 0 10px;padding:0 0 0 24px;color:#191919;font-family:TeleNeo,sans-serif;font-size:16px;font-weight:400;line-height:1.3;text-align:left;word-wrap:normal">%s:</h1>
EOF;

	private string $shareNoteBodyBegin = <<<EOF
<div class="content" style="font-size:16px;font-family:TeleNeo,sans-serif;color:#191919;padding:0 0 0 24px;margin-bottom:80px;">
EOF;

	private ?IL10N $nmcL10n = null;
	private array $renderedTemplates = [];

	public function setLanguage(string $language): void {
		parent::setLanguage($language);
		$this->nmcL10n = $this->l10nFactory->get('nmc_email_template', $language !== '' ? $language : null);
	}

	private function getL10n(): IL10N {
		if ($this->nmcL10n === null) {
			$language = $this->language ?? $this->l10nFactory->findLanguage();
			if ($this->language === null && $language !== '') {
				parent::setLanguage($language);
			}
			$this->nmcL10n = $this->l10nFactory->get('nmc_email_template', $language !== '' ? $language : null);
		}
		return $this->nmcL10n;
	}

	private function getUrlPath(): string {
		if ($this->urlPath === '') {
			$this->urlPath = rtrim($this->urlGenerator->getAbsoluteURL('/'), '/') . '/';
		}
		return $this->urlPath;
	}

	private function escape(string $value): string {
		return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	}

	private function renderTemplate(string $templateName, array $variables = []): string {
		$templatePath = __DIR__ . '/../template/' . $templateName;
		if (!is_file($templatePath)) {
			throw new \RuntimeException('Email template not found: ' . $templatePath);
		}
		extract($variables, EXTR_SKIP);
		$template = include $templatePath;
		if (!is_string($template)) {
			throw new \UnexpectedValueException('Email template must return a string: ' . $templatePath);
		}
		return $template;
	}

	private function appendTemplateOnce(string $key, string $templateName, array $variables): void {
		if (isset($this->renderedTemplates[$key])) {
			return;
		}
		$this->ensureBodyListClosed();
		$this->ensureBodyIsOpened();
		$this->htmlBody .= $this->renderTemplate($templateName, $variables);
		$this->renderedTemplates[$key] = true;
	}

	private function isShareNoteMail(): bool {
		return $this->emailId === 'defaultShareProvider.sendNote' || $this->emailId === 'shareByMail.sendNote';
	}

	private function suppressCoreButtons(): bool {
		return in_array($this->emailId, [
			'settings.Welcome',
			'defaultShareProvider.sendNote',
			'shareByMail.sendNote',
			'sharebymail.RecipientNotification',
			'files_sharing.RecipientNotification',
			'quote.notification',
			'quota_warning.Notification',
			'activity.Notification',
			'core.EmailVerification',
		], true);
	}

	public function addHeader(): void {
		if ($this->headerAdded) {
			return;
		}
		$this->headerAdded = true;
		$logoUrl = $this->escape($this->getUrlPath() . 'customapps/nmctheme/img/telekom/tlogocarrier.png');
		$this->htmlBody .= str_replace('{{logoUrl}}', $logoUrl, $this->header);
	}

	public function addHeading(string $title, $plainTitle = ''): void {
		if ($this->footerAdded) {
			return;
		}

		if ($plainTitle === '') {
			$plainTitle = $title;
		}

		$this->ensureBodyIsClosed();
		$l = $this->getL10n();

		switch ($this->emailId) {
			case 'settings.Welcome':
				$this->subject = $l->t('Welcome to the MagentaCLOUD');
				break;

			case 'defaultShareProvider.sendNote':
			case 'shareByMail.sendNote':
				$this->htmlBody .= vsprintf($this->shareNoteHeading, [$this->escape($title)]);
				break;

			case 'sharebymail.RecipientNotification':
			case 'files_sharing.RecipientNotification':
				$initiator = (string)($this->data['initiator'] ?? '');
				$filename = (string)($this->data['filename'] ?? '');
				$this->subject = $initiator . ' ' . $l->t('shared') . ' "' . $filename . '" ' . $l->t('with you');
				break;

			case 'settings.TestEmail':
				$this->htmlBody .= vsprintf($this->heading, [$this->escape($title)]);
				break;

			case 'quote.notification':
				$this->subject = $l->t('Your MagentaCLOUD status mail');
				$this->htmlBody .= vsprintf($this->heading, [$this->escape($title)]);
				break;

			case 'quota_warning.Notification':
				$this->subject = $l->t('Nearing your storage quota');
				break;

			case 'activity.Notification':
				$this->subject = isset($this->data['dailyActivity'])
					? $l->t('Daily activity summary for MagentaCLOUD')
					: $l->t('Activity notification for MagentaCLOUD');

				$this->appendTemplateOnce('activity-intro', 'activity_notification_intro.php', [
					'hello' => $this->escape($l->t('Hello')),
					'displayName' => $this->escape((string)($this->data['displayname'] ?? '')),
					'activityText' => $this->escape($l->t('There were the following activities in your')),
				]);
				break;

			case 'core.EmailVerification':
				$this->subject = $l->t('MagentaCLOUD email verification');
				break;

			default:
				parent::addHeading($title, $plainTitle);
				return;
		}

		if ($plainTitle !== false) {
			$this->plainBody .= $plainTitle . PHP_EOL . PHP_EOL;
		}
	}

	protected function ensureBodyIsOpened(): void {
		if ($this->bodyOpened) {
			return;
		}
		$this->htmlBody .= $this->isShareNoteMail() ? $this->shareNoteBodyBegin : $this->bodyBegin;
		$this->bodyOpened = true;
	}

	public function addBodyText(string $text, $plainText = ''): void {
		if ($this->footerAdded) {
			return;
		}

		$l = $this->getL10n();
		$plain = $plainText === '' ? $text : $plainText;

		switch ($this->emailId) {
			case 'settings.Welcome':
				$baseUrl = $this->getUrlPath();

				$this->appendTemplateOnce('welcome', 'welcome_mail.php', [
					'hello' => $this->escape($l->t('Hello')),
					'displayName' => $this->escape((string)($this->data['displayname'] ?? $this->data['displayName'] ?? '')),
					'introduction' => $this->escape($l->t("we have activated your MagentaCLOUD, Telekom's online storage. Just click the link, log in and you are ready to go.")),
					'description' => $this->escape($l->t('With MagentaCLOUD, you can store your photos, videos, documents and much more securely online and access them from anywhere using your personal access data.')),
					'openMagentaCloud' => $this->escape($l->t('Open MagentaCLOUD')),
					'softwareApps' => $this->escape($l->t('Software & Apps')),
					'onlineInformation' => $this->escape($l->t('Online Information')),
					'advantages' => $this->escape($l->t('The advantages of the MagentaCLOUD at a glance')),
					'keepMemoriesSafe' => $this->escape($l->t('Keep memories safe')),
					'shareMoments' => $this->escape($l->t('Share special moments with family')),
					'keepOverview' => $this->escape($l->t('Keep all files in overview')),
					'expandMemory' => $this->escape($l->t('Expand device memory free of charge')),
					'information' => $this->escape($l->t('You can find more information as well as frequently asked questions and answers about MagentaCLOUD at')),
					'yourTelekom' => $this->escape($l->t('Your Telekom')),
					'upgradeText' => $this->escape($l->t('Upgrade now to MagentaCLOUD M for only 1.95 € per month and immediately have 100 GB of storage available.')),
					'minimumContract' => $this->escape($l->t('3 months minimum contract term')),
					'only' => $this->escape($l->t('only')),
					'monthly' => $this->escape($l->t('monthly')),
					'orderNow' => $this->escape($l->t('Order now')),
					'bannerUrl' => $this->escape($baseUrl . 'customapps/nmc_email_template/img/welcome-banner.png'),
					'mobileImageUrl' => $this->escape($baseUrl . 'customapps/nmctheme/img/email/mobile.png'),
					'computerImageUrl' => $this->escape($baseUrl . 'customapps/nmctheme/img/email/computer.png'),
					'checkmarkUrl' => $this->escape($baseUrl . 'customapps/nmctheme/img/email/checkmark.png'),
				]);
				break;

			case 'sharebymail.RecipientNotification':
			case 'files_sharing.RecipientNotification':
				$this->appendTemplateOnce('share-recipient', 'share_recipient_notification.php', [
					'hello' => $this->escape($l->t('Hello')),
					'displayName' => $this->escape((string)($this->data['shareWithDisplayName'] ?? '')),
					'initiator' => $this->escape((string)($this->data['initiator'] ?? '')),
					'filename' => $this->escape((string)($this->data['filename'] ?? '')),
					'hasShared' => $this->escape($l->t('has shared')),
					'shareDescription' => $this->escape($l->t('With You. Click button below to accept and open it.')),
					'openShare' => $this->escape($l->t('Open share')),
					'messageFrom' => $this->escape($l->t('Message from')),
					'message' => $this->escape(trim(strip_tags($text))),
					'link' => $this->escape((string)($this->data['link'] ?? '')),
				]);
				break;

			case 'quota_warning.Notification':
				$this->appendTemplateOnce('quota-warning', 'quota_warning.php', [
					'usedValue' => $this->escape((string)($this->data['usedSpace'][0] ?? '')),
					'usedUnit' => $this->escape((string)($this->data['usedSpace'][1] ?? '')),
					'quotaValue' => $this->escape((string)($this->data['quota1'][0] ?? '')),
					'quotaUnit' => $this->escape((string)($this->data['quota1'][1] ?? '')),
					'percentage' => $this->escape((string)($this->data['quota'] ?? '')),
					'displayName' => $this->escape((string)($this->data['displayName'] ?? '')),
					'quotaWarning' => $this->escape($l->t('Quota warning')),
					'quotaDescription' => $this->escape($l->t('of your storage is currently occupied. Once your storage is full, you cannot upload any more files. However, you can remove files or empty your recycle bin at any time.')),
					'orderNow' => $this->escape($l->t('Order now')),
					'openTrash' => $this->escape($l->t('Open the trash')),
					'hello' => $this->escape($l->t('Hello')),
					'statusText' => $this->escape($l->t('With the MagentaCLOUD status email, we inform you once a month about the storage space you have used and the shares you have created.')),
					'yourTelekom' => $this->escape($l->t('Your Telekom')),
					'openMagentaCloud' => $this->escape($l->t('Open MagentaCLOUD')),
					'trashUrl' => $this->escape($this->getUrlPath() . 'index.php/apps/files/?dir=/&view=trashbin'),
				]);
				break;

			case 'core.EmailVerification':
				$this->appendTemplateOnce('email-verification', 'email_verification.php', [
					'title' => $this->escape($l->t('Email verification')),
					'description' => $this->escape($l->t('You have entered a new alternative e-mail address. Click the following button to confirm.')),
					'confirmEmail' => $this->escape($l->t('Confirm your email')),
					'link' => $this->escape((string)($this->data['link'] ?? '')),
				]);
				break;

			case 'activity.Notification':
				break;

			case 'defaultShareProvider.sendNote':
			case 'shareByMail.sendNote':
			case 'settings.TestEmail':
			case 'quote.notification':
			default:
				parent::addBodyText($text, $plainText);
				return;
		}

		if ($plain !== false) {
			$this->plainBody .= $plain . PHP_EOL . PHP_EOL;
		}
	}

	public function addBodyButtonGroup(
		string $textLeft,
		string $urlLeft,
		string $textRight,
		string $urlRight,
		string $plainTextLeft = '',
		string $plainTextRight = '',
	): void {
		if (!$this->suppressCoreButtons()) {
			parent::addBodyButtonGroup($textLeft, $urlLeft, $textRight, $urlRight, $plainTextLeft, $plainTextRight);
			return;
		}

		if ($this->footerAdded) {
			return;
		}

		if ($plainTextLeft === '') {
			$plainTextLeft = $textLeft;
		}
		if ($plainTextRight === '') {
			$plainTextRight = $textRight;
		}

		if ($this->emailId === 'settings.Welcome') {
			$this->plainBody .= $plainTextLeft . ': ' . $urlLeft . PHP_EOL;
			return;
		}

		$this->plainBody .= PHP_EOL . $plainTextLeft . ': ' . $urlLeft . PHP_EOL;
		$this->plainBody .= $plainTextRight . ': ' . $urlRight . PHP_EOL . PHP_EOL;
	}

	public function addBodyButton(string $text, string $url, $plainText = ''): void {
		if (!$this->suppressCoreButtons()) {
			parent::addBodyButton($text, $url, $plainText);
			return;
		}

		if ($this->footerAdded) {
			return;
		}

		if ($plainText === '') {
			$plainText = $text;
		}
		if ($plainText !== false) {
			$this->plainBody .= $plainText . ': ';
		}
		$this->plainBody .= $url . PHP_EOL;
	}

	public function addBodyButtons(array $buttons, string $label = ''): void {
		if (!$this->suppressCoreButtons()) {
			parent::addBodyButtons($buttons, $label);
			return;
		}

		if ($this->footerAdded) {
			return;
		}

		if ($label !== '') {
			$this->plainBody .= $label . PHP_EOL;
		}

		foreach ($buttons as $button) {
			$this->plainBody .= $button['text'] . ': ' . $button['url'] . PHP_EOL;
		}

		$this->plainBody .= PHP_EOL;
	}

	public function addFooter(string $text = '', ?string $lang = null): void {
		if ($this->footerAdded) {
			return;
		}

		if ($lang !== null && $lang !== '') {
			$this->setLanguage($lang);
		}

		$l = $this->getL10n();
		$this->footerAdded = true;
		$this->ensureBodyIsClosed();

		$additionalText = '';
		if ($text !== '') {
			$additionalText = '<tr><td colspan="4" style="font-family:sans-serif;padding:16px 24px;font-size:12px;color:#191919;text-align:center;">' . $text . '</td></tr>';
		}

		$openSourceLicences = $this->escape($l->t('Open Source licences'));
		$impressum = $this->escape($l->t('Impressum'));
		$dataProtection = $this->escape($l->t('Data Protection'));
		$help = $this->escape($l->t('Help & FAQ'));

		$this->htmlBody .= <<<EOF
<div class="footer" style="clear:both;margin-top:10px;text-align:center;width:100%;border-top:1px solid #191919;">
	<table class="footer-section" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
		<tbody>
			{$additionalText}
			<tr>
				<td class="copy-right" colspan="4" style="font-family:sans-serif;vertical-align:top;padding:10px 24px;font-size:12px;color:#191919;text-align:left;">
					<span class="apple-link" style="color:#191919;font-size:12px;font-weight:bold;">© Telekom Deutschland GmbH</span>
				</td>
			</tr>
			<tr>
				<td class="footer-link" style="padding:0 12px 10px 24px;font-family:sans-serif;font-size:12px;text-align:left;">
					<a href="https://static.magentacloud.de/licences/webui.htm" style="color:#191919;text-decoration:none;">{$openSourceLicences}</a>
				</td>
				<td class="footer-link" style="padding:0 12px 10px;font-family:sans-serif;font-size:12px;text-align:left;">
					<a href="https://www.telekom.de/impressum" style="color:#191919;text-decoration:none;">{$impressum}</a>
				</td>
				<td class="footer-link" style="padding:0 12px 10px;font-family:sans-serif;font-size:12px;text-align:left;">
					<a href="https://static.magentacloud.de/privacy/datenschutzhinweise_web.htm" style="color:#191919;text-decoration:none;">{$dataProtection}</a>
				</td>
				<td class="footer-link" style="padding:0 24px 10px 12px;font-family:sans-serif;font-size:12px;text-align:right;">
					<a href="https://cloud.telekom-dienste.de/hilfe" style="color:#191919;text-decoration:none;">{$help}</a>
				</td>
			</tr>
		</tbody>
	</table>
</div>
EOF;

		$this->htmlBody .= $this->tail;
		$this->plainBody .= PHP_EOL . '-- ' . PHP_EOL;

		if ($text !== '') {
			$this->plainBody .= trim(html_entity_decode(
				strip_tags(str_ireplace(['<br>', '<br/>', '<br />'], PHP_EOL, $text)),
				ENT_QUOTES | ENT_HTML5,
				'UTF-8'
			)) . PHP_EOL;
		}

		$this->plainBody .= '© Telekom Deutschland GmbH' . PHP_EOL;
		$this->plainBody .= $l->t('Open Source licences') . ': https://static.magentacloud.de/licences/webui.htm' . PHP_EOL;
		$this->plainBody .= $l->t('Impressum') . ': https://www.telekom.de/impressum' . PHP_EOL;
		$this->plainBody .= $l->t('Data Protection') . ': https://static.magentacloud.de/privacy/datenschutzhinweise_web.htm' . PHP_EOL;
		$this->plainBody .= $l->t('Help & FAQ') . ': https://cloud.telekom-dienste.de/hilfe';
	}

	public function renderHtml(): string {
		if (!$this->footerAdded) {
			$this->addFooter();
		}
		return parent::renderHtml();
	}

	public function renderText(): string {
		if (!$this->footerAdded) {
			$this->addFooter();
		}
		return parent::renderText();
	}
}
