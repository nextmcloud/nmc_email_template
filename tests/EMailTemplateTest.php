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
	protected $l;
	protected $text;
	protected $footer;
	protected $header;

	protected function setUp(): void {
		parent::setUp();

		$this->defaults = $this->createMock(Defaults::class);
		$this->urlGenerator = $this->createMock(IURLGenerator::class);
		$this->l10n = $this->createMock(IL10N::class);
        \OC::$server->getL10NFactory()->get('nmc_email_template');
		$this->l10n->expects($this->any())
			->method('t')
			->willReturnCallback(function ($text, $parameters = []) {
				return vsprintf($text, $parameters);
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

	public function testCustomInternalShareWithNote() {
		$this->data = array("shareWithDisplayName"=>"TEST", "initiator"=>"TEST1", "filename"=>"TEST.file","link"=>"#");
		$this->text = "This is note";

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/file_sharing_notification.html');
		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/files_sharing_notification.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$this->assertSame(trim($expectedHTML), $rendredHTML);
	}

	public function testCustomInternalShareWithoutNote() {
		$this->data = array("shareWithDisplayName"=>"TEST", "initiator"=>"TEST1", "filename"=>"TEST.file","link"=>"#");
		$this->text = "";

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/file_sharing_notification_without_note.html');
		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/files_sharing_notification_without_note.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$this->assertSame(trim($expectedHTML), $rendredHTML);
	}

	public function testCustomExternalShareWithNote() {
		$this->data = array("initiator"=>"TEST1", "filename"=>"TEST.file","link"=>"#");
		$this->text = "This is note";

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/external_share_with_note.html');
		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/external_share_with_note.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$this->assertSame(trim($expectedHTML), $rendredHTML);
	}

	public function testCustomExternalShareWithOutNote() {
		$this->data = array("initiator"=>"TEST1", "filename"=>"TEST.file","link"=>"#");
		$this->text = "";

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/external_share_without_note.html');
		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/external_share_without_note.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$this->assertSame(trim($expectedHTML), $rendredHTML);
	}

	public function testEMailTemplateDefaultFooter() {
		$this->footer = '<div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;border-top:1px solid #191919">
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
		<tr>
			<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; padding-left:24px; font-size: 12px; color: #191919; text-align: left;">
				<span class="apple-link" style="color: #191919; font-size: 12px;font-weight: bold;">© Telekom Deutschland GmbH</span>
			</td>
			<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #191919; text-align: right;">
				<span class="apple-link" style="color: #191919; font-size: 12px; ">
				<a href="'.$this->urlPath.'index.php/settings/user/activity">'.$this->l10n->t('Unsubscribe').'</a></span>
			</td>
			<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #191919; text-align: right;">
				<span class="apple-link" style="color: #191919; font-size: 12px;">
				<a href="http://www.telekom.de/impressum">Impressum</a></span>
			</td>
			<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #191919; text-align: right;">
				<span class="apple-link" style="color: #191919; font-size: 12px; text-align: left;"> <a href="https://static.magentacloud.de/Datenschutz">Data Protection</a></span>
			</td>
			<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; padding-right: 24px; font-size: 12px; color: #191919; text-align: right;">
				<span class="apple-link" style="color: #191919; font-size: 12px;"> <a href="https://cloud.telekom-dienste.de/hilfe">Help & FAQ</a></span>
			</td>
		</tr>
	</table>
</div>';
	  $expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/footer.html');
	  $rendredHTML = $this->footer;
	  $this->assertSame(trim($expectedHTML), $rendredHTML);
	}

	public function testEMailTemplateDefaultHeader() {
		$this->header = '
	<div class="header" style="clear: both;text-align: center; width: 100%;border-bottom:2px solid #e5e5e5;">
		<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
			<tr>
				<td class="content-block" style="background: #e20074;font-family: sans-serif; vertical-align: top; padding-bottom: 16px; padding-top: 16px; padding-left:24px; font-size: 12px; color: #999999; text-align: left;">
					<img src="host_namethemes/nextmagentacloud21/core/img/logo-new.png" width="72px" height="35px"/>
					<span style="color: #fff; font-size: 16px; text-align: left;font-weight:bold;line-height: 40px;padding-left: 24px;vertical-align: top;">Life is for sharing.</span>
				</td>
			</tr>
			<tr>
				<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; padding-left:24px; font-size: 12px; text-align: center;border-top-right-radius:8px;border-top-left-radius:8px">
					<p style="color: #191919; font-size: 25px; text-align: left;font-weight: bold;margin:4px 0">Magenta<span style="font-size: 25px; font-weight: normal;">CLOUD</span></p>
				</td>
			</tr>
		</table>
	</div>
		';
		$sloganTranslated = $this->l10n->t('Life is for sharing');
		$this->header = str_replace('host_name',$this->urlPath, str_replace('Life is for sharing', $sloganTranslated, $this->header));

		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/header.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$expectedHTML = $this->header;
		$this->assertSame(trim($expectedHTML), $rendredHTML);
	}

}
