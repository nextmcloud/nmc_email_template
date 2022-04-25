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
use OCP\L10N\IFactory as L10NFactory;
use OCP\IURLGenerator;
use OCP\IUser;
use OCP\Share\IShare;
use OCP\Share\IManager;
use OCP\Mail\IEMailTemplate;
use OCA\MonthlyStatusEmail\Service\ClientDetector;
use OCA\MonthlyStatusEmail\Service\StorageInfoProvider;


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

	/**
	 * @var IL10N
	 */
	private $l;

	/** @var L10NFactory */
	private $l10nFactory;

	/** @var IUser */
	private $user;

	/**
	 * @var ClientDetector
	 */
	private $clientDetector;

	/**
	 * @var StorageInfoProvider
	 */
	private $storageInfoProvider;

	 /**
	 * @var IManager
	 */
	private $shareManager;


	public function __construct(IConfig $config, IURLGenerator $generator,IL10N $l,L10NFactory $l10nFactory,
	ClientDetector $clientDetector,StorageInfoProvider $storageInfoProvider,IManager $shareManager) {
		$this->productName = $config->getAppValue('theming', 'productName', 'Nextcloud');
		$this->entity = $config->getAppValue('theming', 'name', 'Nextcloud');
		$this->generator = $generator;
		$this->config = $config;
		$this->l = $l;
		$this->shareManager = $shareManager;
		$this->l10nFactory = $l10nFactory;
		$this->clientDetector = $clientDetector;
		$this->storageInfoProvider = $storageInfoProvider;
		
		
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
		$quota = $this->humanFileSize((int) $storageInfo['quota']);
		$usedSpace = $this->humanFileSize((int) $storageInfo['used']);
		$percentage = $this->humanFileSize((int) $storageInfo['relative']);
		$requestMoreStorageLink = $this->getRequestMoreStorageLink();
		if ($requestMoreStorageLink !== '') {
			$requestMoreStorageLink = '<p>' . $requestMoreStorageLink . '</p>';
		}
		$userLang = $this->config->getUserValue($this->user->getUID(), 'core', 'lang', null);
		$this->l = $this->l10nFactory->get('nmc_email_template', $userLang);
		$content = $this->l->t("of your memory is currently occupied. You can expand your storage space at any time for
		a fee.");
		$expendStorage = $this->l->t('Expand storage');
		$storage =$this->l->t("Storage");
		// Warning no storage left
		$emailTemplate->addBodyText(
			<<<EOF
			<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 600px;">
            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;min-height: 450px;">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 32px 24px;">
                  
			<table class="monthly-details" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td class="monthly-storage" style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding-right: 12px;width: 50%;">
                        <div style="text-align: center;background: #f1f1f1;width: 100%;padding-top: 48px;padding-bottom: 24px;padding-right: 24px;padding-left: 24px;box-sizing: border-box;">
                          <span style="font-size: 32px;color:#e20074">$usedSpace[0]</span><span style="font-size: 16px;"> $usedSpace[1]</span>    
                          <br />                    
                          <div style="width:110px;display: inline-block;padding-bottom: 32px;border-top: 1px solid #191919;"><span style="font-size: 32px;color:#191919;">$quota[0]</span><span style="font-size: 16px;"> $quota[1]</span></div>
                          <br />        
                          <span style="font-weight: bold;">$storage</span>
                          <p style="font-size: 12px;margin-top: 8px;margin-bottom: 16px;"><span style="font-size: 12px;font-weight: bold;">$percentage[0]%</span> $content</p>
                          <a href="https://cloud.telekom-dienste.de/tarife" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;text-transform: capitalize;">$expendStorage</a>
                        </div>

EOF,
			"Speicherplatz\n\nSie nutzen im Moment $usedSpace[0] $usedSpace[1] von insgesammt $quota[0] $quota[1]."
		);
		$emailTemplate->addHeading('Hallo,');
		$emailTemplate->addBodyText('Ihr Speicherplatz in der ' . $this->entity . ' ist vollständing belegt. Sie können Ihren Speicherplatz jederzeit kostenpflichtig erweitern und dabei zwischen verschiedenen Speichergrößen wählen.');
		$this->writeClosing($emailTemplate);
		//$emailTemplate->addBodyButton('Jetzt Speicher erweitern', 'TODO');
	}

	public function writeStorageWarning(IEMailTemplate $emailTemplate, array $storageInfo): void {
		$quota = $this->humanFileSize((int) $storageInfo['quota']);
		$usedSpace = $this->humanFileSize((int) $storageInfo['used']);
		$percentage = $this->humanFileSize((int) $storageInfo['relative']);

		$requestMoreStorageLink = $this->getRequestMoreStorageLink();
		if ($requestMoreStorageLink !== '') {
			$requestMoreStorageLink = '<p>' . $requestMoreStorageLink . '</p>';
		}
		$userLang = $this->config->getUserValue($this->user->getUID(), 'core', 'lang', null);
		$this->l = $this->l10nFactory->get('nmc_email_template', $userLang);
		$content = $this->l->t("of your memory is currently occupied. You can expand your storage space at any time for
		a fee.");
		$expendStorage = $this->l->t('Expand storage');
		$storage =$this->l->t("Storage");
		// Warning almost no storage left
		$emailTemplate->addBodyText(
			<<<EOF
			<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 600px;">
            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;min-height: 450px;">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 32px 24px;">
                  
			<table class="monthly-details" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
			<tr>
			  <td class="monthly-storage" style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding-right: 12px;width: 50%;">
				<div style="text-align: center;background: #f1f1f1;width: 100%;padding-top: 48px;padding-bottom: 24px;padding-right: 24px;padding-left: 24px;box-sizing: border-box;">
				  <span style="font-size: 32px;color:#e20074">$usedSpace[0]</span><span style="font-size: 16px;"> $usedSpace[1]</span>    
				  <br />                    
				  <div style="width:110px;display: inline-block;padding-bottom: 32px;border-top: 1px solid #191919;"><span style="font-size: 32px;color:#191919;">$quota[0]</span><span style="font-size: 16px;"> $quota[1]</span></div>
				  <br />        
				  <span style="font-weight: bold;">$storage</span>
				  <p style="font-size: 12px;margin-top: 8px;margin-bottom: 16px;"><span style="font-size: 12px;font-weight: bold;">$percentage[0]%</span> $content</p>
				  <a href="https://cloud.telekom-dienste.de/tarife" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;text-transform: capitalize;">$expendStorage</a>
				</div>
EOF,
			"Speicherplatz\n\nSie nutzen im Moment $usedSpace[0] $usedSpace[1] von insgesammt $quota[0] $quota[1]."
		);
		$emailTemplate->addHeading('Hallo,');
		$emailTemplate->addBodyText('Ihr Speicherplatz in der ' . $this->entity . ' ist fast vollständing belegt. Sie können Ihren Speicherplatz jederzeit kostenpflichtig erweitern und dabei zwischen verschiedenen Speichergrößen wählen.');
		$this->writeClosing($emailTemplate);
		//$emailTemplate->addBodyButton('Jetzt Speicher erweitern', 'TODO');
	}

	public function writeStorageNoQuota(IEMailTemplate $emailTemplate, array $storageInfo): void {

		$quota = $this->humanFileSize((int)$storageInfo['quota']);
		$usedSpace = $this->humanFileSize( (int) $storageInfo['used']);
		$percentage = $this->humanFileSize( (int) $storageInfo['relative']);
		if($quota[0]=="?"){
			$quota[0]="Unlimited";
		}
		$userLang = $this->config->getUserValue($this->user->getUID(), 'core', 'lang', null);
		$this->l = $this->l10nFactory->get('nmc_email_template', $userLang);
		$content = $this->l->t("of your memory is currently occupied. You can expand your storage space at any time for
		a fee.");
		$storage =$this->l->t("Storage");
		$expendStorage = $this->l->t('Expand storage');
		// Message no quota
		$emailTemplate->addBodyText(
			<<<EOF
			<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 600px;">
            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;min-height: 450px;">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 32px 24px;">
                  
			<table class="monthly-details" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
			<tr>
			  <td class="monthly-storage" style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding-right: 12px;width: 50%;">
				<div style="text-align: center;background: #f1f1f1;width: 100%;padding-top: 48px;padding-bottom: 24px;padding-right: 24px;padding-left: 24px;box-sizing: border-box;">
				  <span style="font-size: 32px;color:#e20074">$usedSpace[0]</span><span style="font-size: 16px;"> $usedSpace[1]</span>    
				  <br />                    
				  <div style="width:110px;display: inline-block;padding-bottom: 32px;border-top: 1px solid #191919;"><span style="font-size: 32px;color:#191919;">$quota[0]</span><span style="font-size: 16px;"> $quota[1]</span></div>
				  <br />        
				  <span style="font-weight: bold;">$storage</span>
				  <p style="font-size: 12px;margin-top: 8px;margin-bottom: 16px;"><span style="font-size: 12px;font-weight: bold;">$percentage[0]%</span> $content</p>
				  <a href="https://cloud.telekom-dienste.de/tarife" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;text-transform: capitalize;">$expendStorage</a>
				</div>
EOF,
			"Speicherplatz\n\nSie nutzen im Moment $usedSpace[0] $usedSpace[1]"
		);
	}

	public function writeStorageSpaceLeft(IEMailTemplate $emailTemplate, array $storageInfo): void {
		$quota = $this->humanFileSize((int) $storageInfo['quota']);
		$usedSpace = $this->humanFileSize((int) $storageInfo['used']);
		$percentage = $this->humanFileSize((int) $storageInfo['relative']);
		$userLang = $this->config->getUserValue($this->user->getUID(), 'core', 'lang', null);
		$this->l = $this->l10nFactory->get('nmc_email_template', $userLang);
		$requestMoreStorageLink = $this->getRequestMoreStorageLink();
		if ($requestMoreStorageLink !== '') {
			$requestMoreStorageLink = '<p>' . $requestMoreStorageLink . '</p>';
		}
		$content = $this->l->t("of your memory is currently occupied. You can expand your storage space at any time for a fee.");
		$expendStorage = $this->l->t('Expand storage');
		$storage =$this->l->t("Storage");
		$emailTemplate->addBodyText(
			<<<EOF
			<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 600px;">
            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;min-height: 450px;">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 32px 24px;">
                  
			<table class="monthly-details" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
			<tr>
			  <td class="monthly-storage" style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding-right: 12px;width: 50%;">
				<div style="text-align: center;background: #f1f1f1;width: 100%;padding-top: 48px;padding-bottom: 24px;padding-right: 24px;padding-left: 24px;box-sizing: border-box;">
				  <span style="font-size: 32px;color:#e20074">$usedSpace[0]</span><span style="font-size: 16px;"> $usedSpace[1]</span>    
				  <br />                    
				  <div style="width:110px;display: inline-block;padding-bottom: 32px;border-top: 1px solid #191919;"><span style="font-size: 32px;color:#191919;">$quota[0]</span><span style="font-size: 16px;"> $quota[1]</span></div>
				  <br />        
				  <span style="font-weight: bold;">$storage</span>
				  <p style="font-size: 12px;margin-top: 8px;margin-bottom: 16px;"><span style="font-size: 12px;font-weight: bold;">$percentage[0]%</span> $content</p>
				  <a href="https://cloud.telekom-dienste.de/tarife" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;text-transform: capitalize;">$expendStorage</a>
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
			$home = $this->generator->getAbsoluteURL('/');
			$userLang = $this->config->getUserValue($this->user->getUID(), 'core', 'lang', null);
			 $this->l = $this->l10nFactory->get('nmc_email_template', $userLang);
			$share = $this->l->t('Shares');
			$content1 = $this->l->t('You have shared');
			$content2=$this->l->t('items of content you can manage your shares with once click.');
			$myShare = $this->l->t('My share');
			$emailTemplate->addBodyText(
				<<<EOF
				</td>
                        <td class="monthly-storage" style="text-align: center;font-family: sans-serif; font-size: 14px; vertical-align: top;padding-left: 12px;width: 50%;">
                          <div style="background: #f1f1f1;width: 100%;padding-top: 42px;padding-bottom: 24px;padding-right: 24px;padding-left: 24px;box-sizing: border-box;">
                            <img src="$home/themes/nextmagentacloud21/core/img/email/user-share.png" height="48px" width="48px">
							<div style="padding-top: 8px;"><span style="font-size: 25px;"><span style="color: #e20074;">$shareCount</span>  $share</span></div>
                            <div style="padding-top: 32px;"><span style="font-weight: bold;">$share</span></div>
                            <p style="margin-top: 8px;font-size: 12px;margin-bottom: 16px;">$content1 $shareCount $content2</p>
                            <a href="$home/apps/files/?dir=/&view=sharingout" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;text-transform: capitalize;">$myShare</a>
                          </div>
                          </td>
                      </tr>
                   </table>
EOF,
				"."
			);
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
		$username = $user->getDisplayNameOtherUser();
		$clientConditions = [];
		$clientConditions = $this->ClientCondition($user);
		$storageInfo = $this->storageInfoProvider->getStorageInfo($user);
		$quota = $this->humanFileSize((int) $storageInfo['quota']);
		$usedSpace = $this->humanFileSize((int) $storageInfo['used']);
		$percentage = $this->humanFileSize((int) $storageInfo['relative']);
		$shareCount = $this->handleShare($user);
		/* if doesn't have upload anything */
		if($usedSpace[0] <1 && $usedSpace[1]=="MB"){
			array_push($clientConditions,5);
		}
		/* if doesn't share anything */
		if($shareCount<1){
			array_push($clientConditions,4);
		}
		if(count($clientConditions) ==0 || count($clientConditions)<2 ){
			$clientConditions[]=0;
		}
		$statement = array_rand($clientConditions,1);
		switch($clientConditions[$statement]){
			case 1:
				$randomNumber = rand(2,3);
				switch($randomNumber){
					case 2:
						$content1 = $this->l->t('Do you already know the free MagentaCLOUD app?');
						$content2 = $this->l->t('Take a look at your most beautiful moments wherever you are - for example, on the bus on your mobile device or at a friend\'s house on your tablet. Thanks to your MagentaCLOUD, your pictures are always where you are.');
						$content3 = $this->l->t('Practical- With the app, you can automatically synchronize up your photos and videos to your MagentaCLOUD if you wish.');
					break;
					case 3:
						$content1 = $this->l->t('do you already know the free MagentaCLOUD synchronization software?');
						$content2 = $this->l->t('After downloading the free software, your MagentaCLOUD is created as a folder on your Windows PC or Mac. All files that you move to this folder are automatically synchronized with your cloud - so everything stays up to date. Open the files from your MagentaCLOUD with your usual applications (e.g. Office) and make quickly changes available on all devices.');
						$content4Link ="https://cloud.telekom-dienste.de/software-apps";
						$content4 =$this->l->t('Here you can find our software for download.');
					break;
				}
				break;
			case 2:
			$content1 = $this->l->t('Do you already know the free MagentaCLOUD app?');
			$content2 = $this->l->t('Take a look at your most beautiful moments wherever you are - for example, on the bus on your mobile device or at a friend\'s house on your tablet. Thanks to your MagentaCLOUD, your pictures are always where you are.');
			$content3 = $this->l->t('Practical- With the app, you can automatically synchronize up your photos and videos to your MagentaCLOUD if you wish.');
			break;
			case 3:
				$content1 = $this->l->t('do you already know the free MagentaCLOUD synchronization software?');
				$content2 = $this->l->t('After downloading the free software, your MagentaCLOUD is created as a folder on your Windows PC or Mac. All files that you move to this folder are automatically synchronized with your cloud - so everything stays up to date. Open the files from your MagentaCLOUD with your usual applications (e.g. Office) and make quickly changes available on all devices.');
				$content4Link ="https://cloud.telekom-dienste.de/software-apps";
				$content4 =$this->l->t('Here you can find our software for download.');
				break;
			case 4:				
				$content1 = $this->l->t('you have not shared any files or folders yet.');
				$content2 = $this->l->t('Weddings, family celebrations, vacations spent together - easily share your most beautiful moments with your loved ones. This works without the hassle of sharing media. Even files that are too large for an e-mail attachment can be conveniently made available to others via a link with your MagentaCLOUD.');
				$content3 = $this->l->t('');
				$content4Link ="";
				$content4 =$this->l->t('');
				break;

			case 5:
				$content1 = $this->l->t('This is how easy it is to upload files to MagentaCLOUD: Log in, click on \'Upload\' and select a file (e.g. your best vacation photo). As soon as the file is uploaded, you can access it anywhere - for example, comfortably at home on your PC, on the road in the bus, or at a friend\'s house on your tablet.');
				break;

			default:
				$content1 = $this->l->t('with the MagentaCLOUD status email,we inform you once a month about the storage space you have used and the shares you have created.');
				$content2 = $this->l->t('We also give you tips and tricks for the daily use of you');
				$content3 = $this->l->t('You can find out how to upload,move,share etc.files');				
				break;

		}
		$userLang = $this->config->getUserValue($this->user->getUID(), 'core', 'lang', null);
		$l = $this->l10nFactory->get('nmc_email_template', $userLang);

		$this->l = $l;
		$home = $this->generator->getAbsoluteURL('/');
		$emailTemplate->setSubject($this->l->t("Your MagentaCLOUD status mail"));
		$hello = $l->t('Hello');
		$yourTelekom= $this->l->t('Your Telekom');
		$OpenMagentaCLOUD = $this->l->t('Open MagentaCLOUD');
		if($clientConditions[$statement]==5){
			$emailTemplate->addBodyText(
				<<<EOF
				<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
				<tr>
					<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
						<p style="font-family: sans-serif; font-size: 14px; font-weight: bold; margin: 0; Margin-bottom: 16px;margin-top:32px;">$hello '$username',</p>
						<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">$content1</p>
						<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">$content2</p><p>$content3 </p>
						 <p><a style="color:#e20074;text-decoration: none;" href="$content4Link">$content4</a></p>
						<p style="margin-top:16px;margin-bottom:32px">$yourTelekom</p>


						<table role="presentation" border="0" 
						cellpadding="0" cellspacing="0" class="btn btn-primary" 
						style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
							<tbody>
								<tr>
									<td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 32px;">
										<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
											<tbody>
												<tr>
													<td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #e20074; border-radius: 8px; text-align: center;"> <a href="$home" target="_blank" style="display: inline-block; color: #ffffff; background-color: #e20074; border: solid 1px #e20074; border-radius: 8px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: bold; margin: 0; padding: 12px 24px; text-transform: capitalize;">$OpenMagentaCLOUD</a> </td>
												</tr>
											</tbody>
										</table>
										</td>
										</tr>
									  </tbody>
									</table>
								  </td>
							  </tr>
							</table>
						  </td>
						</tr>
		  
					  <!-- END MAIN CONTENT AREA -->
					  </table>
		
	EOF,
				"."
			);
		}
		else{
			$emailTemplate->addBodyText(
			<<<EOF
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
					<tr>
						<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
							<p style="font-family: sans-serif; font-size: 14px; font-weight: bold; margin: 0; Margin-bottom: 16px;margin-top:32px;">$hello '$username',</p>
							<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">$content1</p>
							<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">$content2</p><p>$content3 </p>
							 <p><a style="color:#e20074;text-decoration: none;" href="$content4Link">$content4</a></p>
							<p style="margin-top:16px;margin-bottom:32px">$yourTelekom</p>


							<table role="presentation" border="0" 
							cellpadding="0" cellspacing="0" class="btn btn-primary" 
							style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
								<tbody>
									<tr>
										<td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 32px;">
											<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
												<tbody>
													<tr>
														<td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #e20074; border-radius: 8px; text-align: center;"> <a href="$home" target="_blank" style="display: inline-block; color: #ffffff; background-color: #e20074; border: solid 1px #e20074; border-radius: 8px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: bold; margin: 0; padding: 12px 24px; text-transform: capitalize;">$OpenMagentaCLOUD</a> </td>
													</tr>
												</tbody>
											</table>
											</td>
											</tr>
										  </tbody>
										</table>
									  </td>
								  </tr>
								</table>
							  </td>
							</tr>
			  
						  <!-- END MAIN CONTENT AREA -->
						  </table>
	
EOF,
			"."
		);
	}
	//$emailTemplate->addBodyButton($this->productName . ' öffnen', $home, strip_tags($this->productName) . ' öffnen');
	}

	public function setUser(IUser $user) {
		$this->user = $user;
		$this->l10n = $this->l10nFactory->get('monthly_status_email',
			$this->config->getUserValue($user->getUID(), 'lang', null)
		);
	}

	private function ClientCondition(IUser $user): array {
		try {
			$hasDesktopClient = $this->clientDetector->hasDesktopConnection($user);
			$hasMobileClient = $this->clientDetector->hasMobileConnection($user);
		} catch (Exception $e) {
			$this->logger->error('There was an error when trying to detect mobile/desktop connection' . $e->getMessage(), [
				'exception' => $e
			]);
			return -1;
		}
		$availableGenericMessages = [];
		
		if (!$hasDesktopClient && !$hasMobileClient) {
			$availableGenericMessages[] = self::NO_CLIENT_CONNECTION;
		} elseif (!$hasMobileClient) {
			$availableGenericMessages[] = self::NO_MOBILE_CLIENT_CONNECTION;
		} elseif (!$hasDesktopClient) {
			$availableGenericMessages[] = self::NO_DESKTOP_CLIENT_CONNECTION;
		}
		return $availableGenericMessages;
	}

	private function handleShare(IUser $user): int {
		$requestedShareTypes = [
			IShare::TYPE_USER,
			IShare::TYPE_GROUP,
			IShare::TYPE_LINK,
			IShare::TYPE_REMOTE,
			IShare::TYPE_EMAIL,
			IShare::TYPE_ROOM,
			IShare::TYPE_CIRCLE,
			IShare::TYPE_DECK,
		];
		$shareCount = 0;
		foreach ($requestedShareTypes as $requestedShareType) {
			$shares = $this->shareManager->getSharesBy(
				$user->getUID(),
				$requestedShareType,
				null,
				false,
				100
			);
			$shareCount += count($shares);
			if ($shareCount > 100) {
				break; // don't
			}
		}
		return $shareCount;
	}
}
