<?php

declare(strict_types=1);

namespace OCA\NmcEmailTemplate;

use OCA\MonthlyStatusEmail\Db\NotificationTracker;
use OCA\MonthlyStatusEmail\Service\ClientDetector;
use OCA\MonthlyStatusEmail\Service\MessageProvider as BaseMessageProvider;
use OCA\MonthlyStatusEmail\Service\StorageInfoProvider;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\IUser;
use OCP\L10N\IFactory as L10NFactory;
use OCP\Mail\IEMailTemplate;
use OCP\Share\IManager;
use OCP\Share\IShare;
use Psr\Log\LoggerInterface;

class MessageProvider extends BaseMessageProvider {
	public const NO_SHARE_AVAILABLE = 0;
	public const NO_CLIENT_CONNECTION = 1;
	public const NO_MOBILE_CLIENT_CONNECTION = 2;
	public const NO_DESKTOP_CLIENT_CONNECTION = 3;
	public const TIP_FILE_RECOVERY = 5;
	public const NO_FILE_UPLOAD = 9;
	public const DEFAULT_MESSAGE = -1;

	private const STORAGE_FULL = 'full';
	private const STORAGE_WARNING = 'warning';
	private const STORAGE_NO_QUOTA = 'no_quota';
	private const STORAGE_SPACE_LEFT = 'space_left';

	private IConfig $config;
	private IURLGenerator $generator;
	private IL10N $l;
	private L10NFactory $l10nFactory;
	private ClientDetector $clientDetector;
	private StorageInfoProvider $storageInfoProvider;
	private IManager $shareManager;
	private LoggerInterface $logger;
	private string $entity;

	public function __construct(
		IConfig $config,
		IURLGenerator $generator,
		IL10N $l,
		L10NFactory $l10nFactory,
		ClientDetector $clientDetector,
		StorageInfoProvider $storageInfoProvider,
		IManager $shareManager,
		LoggerInterface $logger
	) {
		$this->config = $config;
		$this->generator = $generator;
		$this->l = $l;
		$this->l10nFactory = $l10nFactory;
		$this->clientDetector = $clientDetector;
		$this->storageInfoProvider = $storageInfoProvider;
		$this->shareManager = $shareManager;
		$this->logger = $logger;
		$this->entity = $config->getAppValue('theming', 'name', 'MagentaCLOUD');
	}

	/**
	 * Set the current user and use the user's configured language.
	 *
	 * This method is called by monthly_status_email before rendering
	 * the contents of a status email.
	 */
	public function setUser(IUser $user): void {
		$this->setLanguageForUser($user);
	}

	/**
	 * @return array{0:int|float|string,1:string}
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

	public function writeClosing(IEMailTemplate $emailTemplate): void {
		// intentionally empty
	}

	private function getClientConditions(IUser $user): array {
		try {
			$hasDesktopClient = $this->clientDetector->hasDesktopConnection($user);
			$hasMobileClient = $this->clientDetector->hasMobileConnection($user);
		} catch (\Exception $e) {
			$this->logger->error(
				'There was an error when trying to detect mobile/desktop connection: ' . $e->getMessage(),
				[
					'exception' => $e,
				]
			);

			return [];
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

			if ($shareCount >= 100) {
				break;
			}
		}

		return $shareCount;
	}

	public function getFromAddress(): string {
		$sendFromDomain = $this->config->getSystemValue('mail_domain', 'domain.org');
		$sendFromAddress = $this->config->getSystemValue('mail_from_address', 'nextcloud');

		return implode('@', [
			$sendFromAddress,
			$sendFromDomain,
		]);
	}

	public function writeOptOutMessage(
		IEMailTemplate $emailTemplate,
		NotificationTracker $trackedNotification
	): void {
		$emailTemplate->addFooter(sprintf(
			'Sie können die Status-Email <a href="%s">hier</a> abstellen',
			$this->generator->getAbsoluteURL(
				$this->generator->linkToRoute(
					'monthly_status_email.optout.displayOptingOutPage',
					[
						'token' => $trackedNotification->getSecretToken(),
					]
				)
			)
		));
	}

	private function renderStorageSection(
		IEMailTemplate $emailTemplate,
		array $storageInfo,
		string $type
	): void {
		$quota = $this->humanFileSize((int)$storageInfo['quota']);
		$usedSpace = $this->humanFileSize((int)$storageInfo['used']);
		$percentage = round((float)$storageInfo['relative']);

		$storage = $this->l->t('Storage');
		$expandStorage = $this->l->t('Expand storage');

		$expandable = '';
		$content = '';

		switch ($type) {
			case self::STORAGE_FULL:
				$content = $this->l->t(
					'Your storage is almost full.'
				);
				break;

			case self::STORAGE_WARNING:
				$content = $this->l->t(
					'Your storage usage is high.'
				);
				break;

			case self::STORAGE_NO_QUOTA:
				$quota[0] = 'Unlimited';

				$content = $this->l->t(
					'Your storage has no quota limit.'
				);
				break;

			case self::STORAGE_SPACE_LEFT:
				$content = $this->l->t(
					'You still have available storage space.'
				);
				break;
		}

		$quotaBytes = (int)$storageInfo['quota'];

		if ($quotaBytes !== 5 * 1024 ** 4 && $type !== self::STORAGE_NO_QUOTA) {
			$expandable = sprintf(
				'<a href="%s" target="_blank" style="%s">%s</a>',
				'https://cloud.telekom-dienste.de/tarife',
				'display:inline-block;color:#191919;background-color:#f1f1f1;border:1px solid #191919;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;',
				$expandStorage
			);
		}

		$emailTemplate->addBodyText(
			$this->buildStorageHtml(
				$storage,
				$usedSpace,
				$quota,
				$percentage,
				$content,
				$expandable
			),
			$this->l->t(
				'Storage space: %s %s used.',
				[
					$usedSpace[0],
					$usedSpace[1],
				]
			)
		);
	}

	private function buildStorageHtml(
		string $storage,
		array $usedSpace,
		array $quota,
		float $percentage,
		string $content,
		string $expandable
	): string {
		return <<<EOF
		<div class="content" style="max-width:600px;margin:0 auto;">
			<table role="presentation" style="width:100%;">
				<tr>
					<td style="padding:32px 24px;">
						<div style="text-align:center;background:#f1f1f1;padding:48px 24px 24px;">
							<span style="font-size:32px;color:#e20074">
								{$usedSpace[0]}
							</span>
							<span style="font-size:16px;">
								{$usedSpace[1]}
							</span>
							<br>
							<div style="margin:16px 0;border-top:1px solid #191919;">
								<span style="font-size:32px;">
									{$quota[0]}
								</span>

								<span style="font-size:16px;">
									{$quota[1]}
								</span>
							</div>
							<span style="font-weight:bold;">
								{$storage}
							</span>
							<p style="font-size:12px;margin:8px 0 16px;">
								<strong>{$percentage}%</strong>
								{$content}
							</p>
							{$expandable}
						</div>
		EOF;
	}

	public function writeStorageFull(
		IEMailTemplate $emailTemplate,
		array $storageInfo
	): void {
		$this->renderStorageSection(
			$emailTemplate,
			$storageInfo,
			self::STORAGE_FULL
		);
	}

	public function writeStorageWarning(
		IEMailTemplate $emailTemplate,
		array $storageInfo
	): void {
		$this->renderStorageSection(
			$emailTemplate,
			$storageInfo,
			self::STORAGE_WARNING
		);
	}

	public function writeStorageNoQuota(
		IEMailTemplate $emailTemplate,
		array $storageInfo
	): void {
		$this->renderStorageSection(
			$emailTemplate,
			$storageInfo,
			self::STORAGE_NO_QUOTA
		);
	}

	public function writeStorageSpaceLeft(
		IEMailTemplate $emailTemplate,
		array $storageInfo
	): void {
		$this->renderStorageSection(
			$emailTemplate,
			$storageInfo,
			self::STORAGE_SPACE_LEFT
		);
	}

	public function writeWelcomeMail(
		IEMailTemplate $emailTemplate,
		string $name
	): void {
		$emailTemplate->addHeading(
			$this->l->t('Welcome %s!', [$name])
		);

		$emailTemplate->addBodyText(
			$this->l->t(
				'With the status mail for %s, we inform you once a month about your used storage space and your granted shares.',
				[$this->entity]
			),
			$this->l->t(
				'With the status mail for %s, we inform you once a month about your used storage space and your granted shares.',
				[strip_tags($this->entity)]
			)
		);

		$emailTemplate->addBodyText(
			$this->l->t(
				'We also give you tips and tricks for using your %s every day. You can find out how to upload, move, share files and more here: <a href="%s">Help</a>',
				[
					$this->entity,
					'https://cloud.telekom-dienste.de/hilfe',
				]
			),
			$this->l->t(
				'We also give you tips and tricks for using your %s every day. You can find out how to upload, move, share files and more here: Help',
				[strip_tags($this->entity)]
			)
		);
	}

	public function writeShareMessage(
		IEMailTemplate $emailTemplate,
		int $shareCount
	): void {
		$home = $this->generator->getAbsoluteURL('/');
		$share = $this->l->t('Shares');
		$content1 = $this->l->t('You have shared');
		$content2 = $this->l->t('items. You can manage your shares with one click.');
		$myShare = $this->l->t('My share');

		$emailTemplate->addBodyText(
			<<<EOF
					</td>
					<td class="monthly-storage" style="text-align: center; font-family: sans-serif; font-size: 14px; vertical-align: top; padding-left: 12px; width: 50%;">
						<div style="background: #f1f1f1; border-top: 48px solid #f1f1f1; border-right: 24px solid #f1f1f1; border-left: 24px solid #f1f1f1; border-bottom: 24px solid #f1f1f1;">
							<img src="$home/customapps/nmctheme/img/email/user-share.svg" style="width: 48px;">
							<div style="border-top: 8px solid #f1f1f1; border-bottom: 8px solid #f1f1f1;">
								<span style="font-size: 24px;">
									<span style="color: #e20074;">$shareCount</span>
								</span>
							</div>
							<br>
							<span style="font-weight: bold;">$share</span>
							<p style="font-size: 12px; margin-top: 8px; margin-bottom: 16px;">$content1 $shareCount $content2</p>
							<a href="$home/apps/files/?dir=/&view=sharingout" target="_blank" style="display: inline-block; color: #191919; background-color: #f1f1f1; border: 1px solid #191919; border-radius: 8px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: bold; margin: 0; padding: 12px 24px;">$myShare</a>
						</div>
					</td>
				</tr>
			</table>
			EOF,
			'.'
		);
	}

	private function resolveMessageType(
		array $clientConditions,
		int $shareCount,
		array $storageInfo
	): int {
		if ($storageInfo['used'] < 1048576) {
			return self::NO_FILE_UPLOAD;
		}

		if ($shareCount < 1) {
			return self::NO_SHARE_AVAILABLE;
		}

		if (empty($clientConditions)) {
			return self::DEFAULT_MESSAGE;
		}

		return $clientConditions[array_rand($clientConditions)];
	}

	/*
	 * In this section we put switch statement to differentiate the body
	 * content from different scenarios:
	 *
	 * 1. if user has no data uploaded
	 * 2. if user has no shares
	 * 3. if user hasn't installed the desktop app
	 * 4. if user hasn't installed the mobile app
	 * 5. if user fulfils all conditions
	 */
	private function getContent(int $type): array {
		return match ($type) {
			self::NO_FILE_UPLOAD => [
				'paragraph1' => $this->l->t('This is how easy it is to upload files to MagentaCLOUD: Log in, click on \'Upload\' and select a file (e.g. your best vacation photo). As soon as the file is uploaded, you can access it anywhere - for example, comfortably at home on your PC, on the road in the bus, or at a friend\'s house on your tablet.'),
				'paragraph2' => '',
				'paragraph3' => '',
				'link' => '',
				'linkText' => '',
			],

			self::TIP_FILE_RECOVERY => [
				'paragraph1' => $this->l->t('This is how easy it is to upload files to MagentaCLOUD: Log in, click on \'Upload\' and select a file (e.g. your best vacation photo). As soon as the file is uploaded, you can access it anywhere - for example, comfortably at home on your PC, on the road in the bus, or at a friend\'s house on your tablet.'),
				'paragraph2' => '',
				'paragraph3' => '',
				'link' => '',
				'linkText' => '',
			],

			self::NO_SHARE_AVAILABLE => [
				'paragraph1' => $this->l->t('You have not shared any files or folders yet.'),
				'paragraph2' => $this->l->t('Weddings, family celebrations, vacations spent together - easily share your most beautiful moments with your loved ones. This works without the hassle of sharing media. Even files that are too large for an e-mail attachment can be conveniently made available to others via a link with your MagentaCLOUD.'),
				'paragraph3' => '',
				'link' => '',
				'linkText' => '',
			],

			self::NO_CLIENT_CONNECTION => [
				'paragraph1' => $this->l->t('Do you already know the free MagentaCLOUD app?'),
				'paragraph2' => $this->l->t('Take a look at your most beautiful moments wherever you are - for example, on the bus on your mobile device or at a friend\'s house on your tablet. Thanks to your MagentaCLOUD, your pictures are always where you are.'),
				'paragraph3' => $this->l->t('Practical: With the app, you can automatically synchronize up your photos and videos to your MagentaCLOUD if you wish.'),
				'link' => '',
				'linkText' => '',
			],

			self::NO_MOBILE_CLIENT_CONNECTION => [
				'paragraph1' => $this->l->t('Do you already know the free MagentaCLOUD app?'),
				'paragraph2' => $this->l->t('Take a look at your most beautiful moments wherever you are - for example, on the bus on your mobile device or at a friend\'s house on your tablet. Thanks to your MagentaCLOUD, your pictures are always where you are.'),
				'paragraph3' => $this->l->t('Practical: With the app, you can automatically synchronize up your photos and videos to your MagentaCLOUD if you wish.'),
				'link' => '',
				'linkText' => '',
			],

			self::NO_DESKTOP_CLIENT_CONNECTION => [
				'paragraph1' => $this->l->t('Do you already know the free MagentaCLOUD synchronization software?'),
				'paragraph2' => $this->l->t('After downloading the free software, your MagentaCLOUD is created as a folder on your Windows PC or Mac. All files that you move to this folder are automatically synchronized with your cloud - so everything stays up to date. Open the files from your MagentaCLOUD with your usual applications (e.g. Office) and make quickly changes available on all devices.'),
				'paragraph3' => '',
				'link' => 'https://cloud.telekom-dienste.de/software-apps',
				'linkText' => $this->l->t('Here you can find our software for download.'),
			],

			self::DEFAULT_MESSAGE => [
				'paragraph1' => $this->l->t('With the MagentaCLOUD status e-mail, we will inform you once a month about the storage space you have used and the permissions you have been granted.'),
				'paragraph2' => $this->l->t('We also give you tips and tricks on how to use your MagentaCLOUD on a daily basis.'),
				'paragraph3' => $this->l->t('You can find out how to upload, move, share, etc. files here:'),
				'link' => 'https://cloud.telekom-dienste.de/hilfe',
				'linkText' => $this->l->t('First steps'),
			],

			default => [
				'paragraph1' => $this->l->t('With the MagentaCLOUD status e-mail, we will inform you once a month about the storage space you have used and the permissions you have been granted.'),
				'paragraph2' => $this->l->t('We also give you tips and tricks on how to use your MagentaCLOUD on a daily basis.'),
				'paragraph3' => $this->l->t('You can find out how to upload, move, share, etc. files here:'),
				'link' => 'https://cloud.telekom-dienste.de/hilfe',
				'linkText' => $this->l->t('First steps'),
			],
		};
	}

	private function setLanguageForUser(IUser $user): void {
		$lang = $this->config->getUserValue(
			$user->getUID(),
			'core',
			'lang',
			''
		);

		$this->l = $this->l10nFactory->get(
			'nmc_email_template',
			$lang !== '' ? $lang : null
		);
	}

	public function writeGenericMessage(
		IEMailTemplate $emailTemplate,
		IUser $user,
		int $messageId
	): void {
		$this->setLanguageForUser($user);

		$clientConditions = $this->getClientConditions($user);
		$storageInfo = $this->storageInfoProvider->getStorageInfo($user);
		$shareCount = $this->handleShare($user);

		$messageType = $messageId !== self::DEFAULT_MESSAGE
			? $messageId
			: $this->resolveMessageType(
				$clientConditions,
				$shareCount,
				$storageInfo
			);

		$content = $this->getContent($messageType);

		$emailTemplate->setSubject(
			$this->l->t('Your MagentaCLOUD status mail')
		);

		$username = htmlspecialchars(
			$user->getDisplayName(),
			ENT_QUOTES,
			'UTF-8'
		);

		$home = $this->generator->getAbsoluteURL('/');
		$hello = $this->l->t('Hello');
		$yourTelekom = $this->l->t('Your Telekom');
		$openMagentaCLOUD = $this->l->t('Open MagentaCLOUD');

		$linkHtml = $content['link'] !== '' && $content['linkText'] !== ''
			? sprintf(
				'<p style="margin:0 0 16px 0;"><a href="%s" style="color:#e20074;text-decoration:none;">%s</a></p>',
				htmlspecialchars(
					$content['link'],
					ENT_QUOTES,
					'UTF-8'
				),
				htmlspecialchars(
					$content['linkText'],
					ENT_QUOTES,
					'UTF-8'
				)
			)
			: '';

		$emailTemplate->addBodyText(
			<<<EOF
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;">
				<tr>
					<td style="font-family:sans-serif;font-size:14px;vertical-align:top;">

						<p style="font-weight:bold;margin:32px 0 16px 0;">
							$hello $username,
						</p>

						<p style="margin:0 0 16px 0;">{$content['paragraph1']}</p>
						<p style="margin:0 0 16px 0;">{$content['paragraph2']}</p>
						<p style="margin:0 0 16px 0;">{$content['paragraph3']}</p>

						$linkHtml

						<p style="margin:16px 0 32px 0;">$yourTelekom</p>

						<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width:100%;">
							<tr>
								<td align="left" style="padding-bottom:32px;">
									<a href="$home"
										target="_blank"
										style="display:inline-block;background:#e20074;color:#ffffff;
											text-decoration:none;border-radius:8px;
											padding:12px 24px;font-size:12px;font-weight:bold;">
										$openMagentaCLOUD
									</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			EOF,
			'.'
		);
	}
}
