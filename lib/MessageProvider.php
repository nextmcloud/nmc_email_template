<?php

/**
 * @copyright Copyright (c) 2021 Carl Schwan <carl@carlschwan.eu>
 *
 * @author Carl Schwan <carl@carlschwan.eu>
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

declare(strict_types=1);

namespace OCA\EmailTemplateExample;;

use OCA\MonthlyStatusEmail\Db\NotificationTracker;
use OCA\MonthlyStatusEmail\Jobs\SendNotificationsJob;
use OCP\Files\FileInfo;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\IUser;
use OCP\Mail\IEMailTemplate;

class MessageProvider {
	public const NO_SHARE_AVAILABLE = 0;
	public const NO_CLIENT_CONNECTION = 1;
	public const NO_MOBILE_CLIENT_CONNECTION = 2;
	public const NO_DESKTOP_CLIENT_CONNECTION = 3;
	public const RECOMMEND_NEXTCLOUD = 4;
	public const TIP_FILE_RECOVERY = 5;
	public const TIP_EMAIL_CENTER = 6;
	public const TIP_MORE_STORAGE = 7;
	public const TIP_DISCOVER_PARTNER = 8;
	public const NO_FILE_UPLOAD = 9;
	public const NO_EMAIL_UPLOAD = 10;

	/**
	 * @var string
	 */
	private $productName;
	/**
	 * @var IURLGenerator
	 */
	private $generator;
	/**
	 * @var IConfig
	 */
	private $config;
	/**
	 * @var string
	 */
	private $entity;

	public function __construct(IConfig $config, IURLGenerator $generator) {
		$this->productName = $config->getAppValue('theming', 'productName', 'Nextcloud');
		$this->entity = $config->getAppValue('theming', 'name', 'Nextcloud');
		$this->generator = $generator;
		$this->config = $config;
	}

	/**
	 * Similar to OC_Utils::humanFileSize but extract the units and number
	 * separately.
	 *
	 * @param int $bytes
	 * @return array|string[]
	 */
	protected function humanFileSize(int $bytes): array {
		if ($bytes < 0) {
			return ['?', ''];
		}
		if ($bytes < 1024) {
			return [$bytes, 'B'];
		}
		$bytes = round($bytes / 1024, 0);
		if ($bytes < 1024) {
			return [$bytes, 'KB'];
		}
		$bytes = round($bytes / 1024, 1);
		if ($bytes < 1024) {
			return [$bytes, 'MB'];
		}
		$bytes = round($bytes / 1024, 1);
		if ($bytes < 1024) {
			return [$bytes, 'GB'];
		}
		$bytes = round($bytes / 1024, 1);
		if ($bytes < 1024) {
			return [$bytes, 'TB'];
		}

		$bytes = round($bytes / 1024, 1);
		return [$bytes, 'PB'];
	}

	/**
	 * Link to get more storage or an empty string if not such
	 * functionality exists.
	 *
	 * @return string
	 */
	protected function getRequestMoreStorageLink(): string {
		return '';
	}

	/**
	 * Write generic end of mail. (e.g Thanks, Service name, ...)
	 */
	public function writeClosing(IEMailTemplate $emailTemplate): void {
		//$emailTemplate->addBodyText('Your Nextcloud');
	}

	/**
	 * Storage used at more than 99%.
	 *
	 * @param IEMailTemplate $emailTemplate
	 * @param array $storageInfo
	 */
	public function writeStorageFull(IEMailTemplate $emailTemplate, array $storageInfo): void {
		$quota = $this->humanFileSize($storageInfo['quota']);
		$usedSpace = $this->humanFileSize($storageInfo['used']);

		$requestMoreStorageLink = $this->getRequestMoreStorageLink();
		if ($requestMoreStorageLink !== '') {
			$requestMoreStorageLink = '<p>' . $requestMoreStorageLink . '</p>';
		}

		// Warning no storage left
		$emailTemplate->addBodyText(
			<<<EOF
<table style="background-color: #f8f8f8; padding: 20px; width: 100%">
	<tr>
		<td style="padding-right: 20px; text-align: center">
			<span style="font-size: 35px; color: red">$usedSpace[0]</span>&nbsp;<span style="font-size: larger">$usedSpace[1]</span>
			<hr />
			<span style="font-size: 35px">$quota[0]</span>&nbsp;<span style="font-size: larger">$quota[1]</span>
		</td>
		<td>
			<h3 style="font-weight: bold">Speicherplatz</h3>
			<p>Sie nutzen im Moment $usedSpace[0] $usedSpace[1] von insgesammt $quota[0] $quota[1].</p>
			$requestMoreStorageLink
		</td>a
	</tr>
</table>
EOF,
			"Speicherplatz\n\nSie nutzen im Moment $usedSpace[0] $usedSpace[1] von insgesammt $quota[0] $quota[1]."
		);
		$emailTemplate->addHeading('Hallo,');
		$emailTemplate->addBodyText('Ihr Speicherplatz in der ' . $this->entity . ' ist vollständing belegt. Sie können Ihren Speicherplatz jederzeit kostenpflichtig erweitern und dabei zwischen verschiedenen Speichergrößen wählen.');
		$this->writeClosing($emailTemplate);
		$emailTemplate->addBodyButton('Jetzt Speicher erweitern', 'TODO');
	}

	public function writeStorageWarning(IEMailTemplate $emailTemplate, array $storageInfo): void {
		$quota = $this->humanFileSize($storageInfo['quota']);
		$usedSpace = $this->humanFileSize($storageInfo['used']);

		$requestMoreStorageLink = $this->getRequestMoreStorageLink();
		if ($requestMoreStorageLink !== '') {
			$requestMoreStorageLink = '<p>' . $requestMoreStorageLink . '</p>';
		}
		// Warning almost no storage left
		$emailTemplate->addBodyText(
			<<<EOF
<table style="background-color: #f8f8f8; padding: 20px; width: 100%">
	<tr>
		<td style="padding-right: 20px; text-align: center">
			<span style="font-size: 35px; color: orange">$usedSpace[0]</span>&nbsp;<span style="font-size: larger">$usedSpace[1]</span>
			<hr />
			<span style="font-size: 35px">$quota[0]</span>&nbsp;<span style="font-size: larger">$quota[1]</span>
		</td>
		<td>
			<h3 style="font-weight: bold">Speicherplatz</h3>
			<p>Sie nutzen im Moment $usedSpace[0] $usedSpace[1] von insgesammt $quota[0] $quota[1].</p>
			$requestMoreStorageLink
		</td>
	</tr>
</table>
EOF,
			"Speicherplatz\n\nSie nutzen im Moment $usedSpace[0] $usedSpace[1] von insgesammt $quota[0] $quota[1]."
		);
		$emailTemplate->addHeading('Hallo,');
		$emailTemplate->addBodyText('Ihr Speicherplatz in der ' . $this->entity . ' ist fast vollständing belegt. Sie können Ihren Speicherplatz jederzeit kostenpflichtig erweitern und dabei zwischen verschiedenen Speichergrößen wählen.');
		$this->writeClosing($emailTemplate);
		$emailTemplate->addBodyButton('Jetzt Speicher erweitern', 'TODO');
	}

	public function writeStorageNoQuota(IEMailTemplate $emailTemplate, array $storageInfo): void {
		$usedSpace = $this->humanFileSize($storageInfo['used']);
		// Message no quota
		$emailTemplate->addBodyText(
			<<<EOF

<table style="background-color: #f8f8f8; padding: 20px; width: 100%">
	<tr>
		<td style="padding-right: 20px; text-align: center">
			<span style="font-size: 35px">$usedSpace[0]</span>&nbsp;<span style="font-size: larger">$usedSpace[1]</span>
		</td>
		<td>
			<h3 style="font-weight: bold">Speicherplatz</h3>
			<p>Sie nutzen im Moment $usedSpace[0] $usedSpace[1].</p>
		</td>
	</tr>
</table>
EOF,
			"Speicherplatz\n\nSie nutzen im Moment $usedSpace[0] $usedSpace[1]"
		);
	}

	public function writeStorageSpaceLeft(IEMailTemplate $emailTemplate, array $storageInfo): void {
		$quota = $this->humanFileSize($storageInfo['quota']);
		$usedSpace = $this->humanFileSize($storageInfo['used']);

		$requestMoreStorageLink = $this->getRequestMoreStorageLink();
		if ($requestMoreStorageLink !== '') {
			$requestMoreStorageLink = '<p>' . $requestMoreStorageLink . '</p>';
		}

		$emailTemplate->addBodyText(
			<<<EOF
			<div style="text-align: center;background: #f1f1f1;width: 266px;padding-top: 48px;padding-bottom: 24px;padding-right: 24px;padding-left: 24px;box-sizing: border-box;">
			<table id="part1"><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding-right: 12px;">

			<span style="font-size: 32px;color:#e20074">$usedSpace[0]</span><span style="font-size: 16px;"> $usedSpace[1]</span>
			  <br>
			  <div style="width:110px;display: inline-block;margin-bottom: 32px;border-top: 1px solid #191919;"><span style="font-size: 32px;color:#191919;">$quota[0]</span><span style="font-size: 16px;"> $quota[1]</span></div>
			  <br>
			  <span style="font-weight: bold;">Storage</span>
			  <p style="font-size: 12px;margin-top: 8px;margin-bottom: 16px;"><span style="font-size: 12px;font-weight: bold;">$percentage[0]</span>% of your memory is currently occupied. You can expand your storage space at any time for
				a fee.</p>
				$requestMoreStorageLink
			  <a href="#" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1 !important;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;text-transform: capitalize;">Expand Storage</a>
			  </td></table>
			  </div>

EOF,
			"."
		);
	}

	public function writeWelcomeMail(IEMailTemplate $emailTemplate, string $name): void {
		$emailTemplate->addHeading("Welcome $name !");

		$emailTemplate->addBodyText(
			'mit der Status-Mail zur ' . $this->entity . ' informieren wir Sie einmail montatlich über Ihren belegten Speicherplatz und über Ihre erteilten Freigaben.',
			'mit der Status-Mail zur ' . strip_tags($this->entity) . ' informieren wir Sie einmail montatlich über Ihren belegten Speicherplatz und über Ihre erteilten Freigaben.'
		);

		$emailTemplate->addBodyText(
			'Außerdem geben wir Ihnen Tipps und Tricks zum täaglichen Umgang mit Ihrer ' . $this->entity . '. Wie Sie Dateien hochlanden, verschieben, freigeben, etc., erfagren Sie hier: <a href="TODO">Erste Hilfe</a>',
			'Außerdem geben wir Ihnen Tipps und Tricks zum täaglichen Umgang mit Ihrer ' . strip_tags($this->entity) . '. Wie Sie Dateien hochlanden, verschieben, freigeben, etc., erfagren Sie hier: [Erste Hilfe](TODO)',
		);
	}

	public function writeShareMessage(IEMailTemplate $emailTemplate, int $shareCount) {
		if ($shareCount > 100) {
			$emailTemplate->addBodyText(
				<<<EOF
<div style="background-color: #f8f8f8; padding: 20px; float: right; margin-top: 50px">
	<h3 style="font-weight: bold">Freigaben</h3>
	<p>Sie haben mehr als $shareCount Dateien freigegeben.</p>
</div>
EOF,
				"Freigabeben\n\nSie haben mehr als $shareCount Dateien freigegeben."
			);
		} elseif ($shareCount === 0) {
			$emailTemplate->addBodyText(
				<<<EOF
<div style="background-color: #f8f8f8; padding: 20px; float: right; margin-top: 50px">
	<h3 style="font-weight: bold">Freigaben</h3>
	<p>Sie haben keine Dateien freigegeben.</p>
</div>
EOF,
				"Freigabeben\n\nSie haben kein Dateien freigegeben."
			);
		} elseif ($shareCount === 1) {
			$emailTemplate->addBodyText(
				<<<EOF
<div style="background-color: #f8f8f8; padding: 20px; float: right; margin-top: 50px">
	<h3 style="font-weight: bold">Freigaben</h3>
	<p>Sie haben eine Datei freigegeben.</p>
</div>
EOF,
				"Freigabeben\n\nSie haben eine Datei freigegeben."
			);
		} else {
			$host = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'];
			// $host = 'https://dev1.next.magentacloud.de'; // for test only

			$emailTemplate->addBodyText(
				<<<EOF
				<div style="background: #f1f1f1;width: 266px;padding-top: 42px;padding-bottom: 24px;padding-right: 24px;padding-left: 24px;box-sizing: border-box;">
				<table id="part2">
				<td style="text-align: center;font-family: sans-serif; font-size: 14px; vertical-align: top;padding-left: 12px;">
				<img src="$host/themes/nextmagentacloud21/core/img/icons/add.svg" height="48px" width="48px">
				  <div style="margin-top: 8px;"><span style="font-size: 25px;"><span style="color: #e20074;">$shareCount</span>  Shares</span></div>
				  <div style="margin-top: 32px;"><span style="font-weight: bold;">Shares</span></div>
				  <p style="margin-top: 8px;font-size: 12px;margin-bottom: 32px;">You have shared $shareCount items of content you can manage your shares with once click.</p>
				  <a href="#" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1 !important;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;text-transform: capitalize;">My Share</a>
				  </td>
				  <table>
				  </div>

EOF,
				"."
			);
		}
	}

	public function writeOptOutMessage(IEMailTemplate $emailTemplate, NotificationTracker $trackedNotification) {
		$emailTemplate->addFooter(sprintf(
			'Sie können die Status-Email <a href="%s">hier</a> abstellen',
			$this->generator->getAbsoluteURL($this->generator->linkToRoute('monthly_status_email.optout.displayOptingOutPage', [
				'token' => $trackedNotification->getSecretToken()
			]))
		));
	}

	public function getFromAddress(): string {
		$sendFromDomain = $this->config->getSystemValue('mail_domain', 'domain.org');
		$sendFromAddress = $this->config->getSystemValue('mail_from_address', 'nextcloud');

		return implode('@', [
			$sendFromAddress,
			$sendFromDomain
		]);
	}

	public function writeGenericMessage(IEMailTemplate $emailTemplate, IUser $user, int $messageId): void {
	   //$emailTemplate->addHeading('Hello ' . $user->getDisplayNameOtherUser() . ',');
		$displayName = $user->getDisplayNameOtherUser();
		$home = $this->generator->getAbsoluteURL('/');

		$emailTemplate->addBodyText(
			<<<EOF
			<table><tr>
		<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
		  <p style="font-family: sans-serif; font-size: 14px; font-weight: bold; margin: 0; Margin-bottom: 16px;">Hello $displayName,</p>
		  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">with the MagentaCLOUD status email,we inform you once a month about the storage space you have used and the shares you have created.</p>
		  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">We also give you tips and tricks for the daily use of you <br>MagentaCLOUD.You can find out how to upload,move,share etc.files<br>
		  here <a style="color:#e20074;text-decoration: none;" href="https://cloud.telekom-dienste.de/hilfe/erste-schritte/erste-schritte">First Steps</a></p>
		  <p style="margin-top:16px;margin-bottom:32px">Your Telekom</p>
		  <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
			  <tbody>
				<tr>
				  <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 32px;">
					<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
					  <tbody>
						<tr>
						  <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #e20074 !important; border-radius: 8px; text-align: center;"> <a href="#" target="_blank" style="display: inline-block; color: #ffffff; background-color: #e20074 !important; border: solid 1px #e20074; border-radius: 8px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: bold; margin: 0; padding: 12px 24px; text-transform: capitalize;">Open MagentaCLOUD</a> </td>
						</tr>
					  </tbody>
					</table>
				  </td>
				</tr>
			  </tbody>
			</table>
		  </td>
	  </tr></table>
EOF,
			"."
		);
	$emailTemplate->addBodyButton($this->productName . ' öffnen', $home, strip_tags($this->productName) . ' öffnen');
	}
}
