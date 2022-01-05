<?php
/**
 * @copyright 2017, Morris Jobke <hey@morrisjobke.de>
 *
 * @author Morris Jobke <hey@morrisjobke.de>
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

namespace Test\Mail;

use OC\Mail\EMailTemplate;
use OCP\Defaults;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\L10N\IFactory;
use Test\TestCase;
use OCA\EmailTemplateExample;

class EMailTemplateTest extends TestCase {
	/** @var Defaults|\PHPUnit\Framework\MockObject\MockObject */
	private $defaults;
	/** @var IURLGenerator|\PHPUnit\Framework\MockObject\MockObject */
	private $urlGenerator;
	/** @var IFactory|\PHPUnit\Framework\MockObject\MockObject */
	private $l10n;
	/** @var EMailTemplate */
	private $emailTemplate;

	protected $urlPath = "";
	protected $data;

	protected function setUp(): void {
		parent::setUp();

		$this->defaults = $this->createMock(Defaults::class);
		$this->urlGenerator = $this->createMock(IURLGenerator::class);
		$this->l10n = $this->createMock(IL10N::class);

		$this->l10n->expects($this->any())
			->method('t')
			->willReturnCallback(function ($string, $args) {
				if (!is_array($args)) {
					$args = [$args];
				}
				return vsprintf($string, $args);
			});

		$this->urlPath = $this->urlGenerator->getAbsoluteURL('/');
	}


	public function testCustomWelcomeEmail() {
		$this->data = array("displayname"=>"TEST");
		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/welcome_mail.html');
		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/welcome_mail.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$this->assertSame($expectedHTML, $rendredHTML);
	}

	/*

	public function testEMailTemplateCustomFooter() {
		$this->defaults
			->expects($this->any())
			->method('getColorPrimary')
			->willReturn('#0082c9');
		$this->defaults
			->expects($this->any())
			->method('getLogo')
			->willReturn('/img/logo-mail-header.png');
		$this->defaults
			->expects($this->any())
			->method('getName')
			->willReturn('TestCloud');
		$this->defaults
			->expects($this->any())
			->method('getTextColorPrimary')
			->willReturn('#ffffff');
		$this->urlGenerator
			->expects($this->once())
			->method('getAbsoluteURL')
			->with('/img/logo-mail-header.png')
			->willReturn('https://example.org/img/logo-mail-header.png');


		$this->emailTemplate->addHeader();
		$this->emailTemplate->addHeading('Welcome aboard');
		$this->emailTemplate->addBodyText('Welcome to your Nextcloud account, you can add, protect, and share your data.');
		$this->emailTemplate->addBodyText('Your username is: abc');
		$this->emailTemplate->addBodyButtonGroup(
			'Set your password', 'https://example.org/resetPassword/123',
			'Install Client', 'https://nextcloud.com/install/#install-clients'
		);
		$this->emailTemplate->addFooter(
			'TestCloud - A safe home for your data<br>This is an automatically sent email, please do not reply.'
		);

		 $expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/new-account-email.html');
		 $this->assertSame($expectedHTML, $this->emailTemplate->renderHtml());
		$expectedTXT = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/new-account-email.txt');
		$expectedTXT = trim($expectedTXT);
		$renderText = trim($this->emailTemplate->renderText());
		$this->assertSame($expectedTXT, $renderText);
	}


	public function testEMailTemplateDefaultFooter() {
		$this->defaults
			->expects($this->any())
			->method('getColorPrimary')
			->willReturn('#0082c9');
		$this->defaults
			->expects($this->any())
			->method('getName')
			->willReturn('TestCloud');
		$this->defaults
			->expects($this->any())
			->method('getSlogan')
			->willReturn('A safe home for your data');
		$this->defaults
			->expects($this->any())
			->method('getLogo')
			->willReturn('/img/logo-mail-header.png');
		$this->defaults
			->expects($this->any())
			->method('getTextColorPrimary')
			->willReturn('#ffffff');
		$this->urlGenerator
			->expects($this->once())
			->method('getAbsoluteURL')
			->with('/img/logo-mail-header.png')
			->willReturn('https://example.org/img/logo-mail-header.png');

		$this->emailTemplate->addHeader();
		$this->emailTemplate->addHeading('Welcome aboard');
		$this->emailTemplate->addBodyText('Welcome to your Nextcloud account, you can add, protect, and share your data.');
		$this->emailTemplate->addBodyText('Your username is: abc');
		$this->emailTemplate->addBodyButtonGroup(
			'Set your password', 'https://example.org/resetPassword/123',
			'Install Client', 'https://nextcloud.com/install/#install-clients'
		);
		$this->emailTemplate->addFooter();

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/new-account-email-custom.html');
		$this->assertSame($expectedHTML, $this->emailTemplate->renderHtml());
		$expectedTXT = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/new-account-email-custom.txt');
		$this->assertSame($expectedTXT, $this->emailTemplate->renderText());
	}

	public function testEMailTemplateSingleButton() {
		$this->defaults
			->expects($this->any())
			->method('getColorPrimary')
			->willReturn('#0082c9');
		$this->defaults
			->expects($this->any())
			->method('getName')
			->willReturn('TestCloud');
		$this->defaults
			->expects($this->any())
			->method('getSlogan')
			->willReturn('A safe home for your data');
		$this->defaults
			->expects($this->any())
			->method('getLogo')
			->willReturn('/img/logo-mail-header.png');
		$this->defaults
			->expects($this->any())
			->method('getTextColorPrimary')
			->willReturn('#ffffff');
		$this->urlGenerator
			->expects($this->once())
			->method('getAbsoluteURL')
			->with('/img/logo-mail-header.png')
			->willReturn('https://example.org/img/logo-mail-header.png');

		$this->emailTemplate->addHeader();
		$this->emailTemplate->addHeading('Welcome aboard');
		$this->emailTemplate->addBodyText('Welcome to your Nextcloud account, you can add, protect, and share your data.');
		$this->emailTemplate->addBodyText('Your username is: abc');
		$this->emailTemplate->addBodyButton(
			'Set your password', 'https://example.org/resetPassword/123',
			false
		);
		$this->emailTemplate->addFooter();

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/new-account-email-single-button.html');
		$this->assertSame($expectedHTML, $this->emailTemplate->renderHtml());
		$expectedTXT = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/new-account-email-single-button.txt');
		$this->assertSame($expectedTXT, $this->emailTemplate->renderText());
	}



	public function testEMailTemplateAlternativePlainTexts() {
		$this->defaults
			->expects($this->any())
			->method('getColorPrimary')
			->willReturn('#0082c9');
		$this->defaults
			->expects($this->any())
			->method('getName')
			->willReturn('TestCloud');
		$this->defaults
			->expects($this->any())
			->method('getSlogan')
			->willReturn('A safe home for your data');
		$this->defaults
			->expects($this->any())
			->method('getLogo')
			->willReturn('/img/logo-mail-header.png');
		$this->defaults
			->expects($this->any())
			->method('getTextColorPrimary')
			->willReturn('#ffffff');
		$this->urlGenerator
			->expects($this->once())
			->method('getAbsoluteURL')
			->with('/img/logo-mail-header.png')
			->willReturn('https://example.org/img/logo-mail-header.png');

		$this->emailTemplate->addHeader();
		$this->emailTemplate->addHeading('Welcome aboard', 'Welcome aboard - text');
		$this->emailTemplate->addBodyText('Welcome to your Nextcloud account, you can add, protect, and share your data.', 'Welcome to your Nextcloud account, you can add, protect, and share your data. - text');
		$this->emailTemplate->addBodyText('Your username is: abc');
		$this->emailTemplate->addBodyButtonGroup(
			'Set your password', 'https://example.org/resetPassword/123',
			'Install Client', 'https://nextcloud.com/install/#install-clients',
			'Set your password - text', 'Install Client - text'
		);
		$this->emailTemplate->addFooter();

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/new-account-email-custom.html');
		$this->assertSame($expectedHTML, $this->emailTemplate->renderHtml());
		$expectedTXT = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/new-account-email-custom-text-alternative.txt');
		$this->assertSame($expectedTXT, $this->emailTemplate->renderText());
	}

*/
}
