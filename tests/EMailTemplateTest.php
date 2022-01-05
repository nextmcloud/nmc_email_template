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


	protected function setUp(): void {
		parent::setUp();

		$this->defaults = $this->createMock(Defaults::class);
		$this->urlGenerator = $this->createMock(IURLGenerator::class);
		$this->l10n = $this->createMock(IL10N::class);

		$this->l10n->expects($this->any())
			->method('t')
			->willReturnCallback(function ($text, $parameters = []) {
				return vsprintf($text, $parameters);
			});


/*		$lang = 'de_DE';
		$l = $this->createMock(IL10N::class);

		$this->l10n->expects($this->once())
			->method('get')
			->with('nmc_email_template', $lang)
			->willReturn($l);
*/

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
/*
	public function testCustomInternalShareWithOutNote() {
		$this->data = array("shareWithDisplayName"=>"TEST", "initiator"=>"TEST1", "filename"=>"TEST.file","link"=>"#");
		$this->text = "";

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/file_sharing_notification.html');
		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/files_sharing_notification.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$this->assertSame($expectedHTML, $rendredHTML);
	}

	public function testCustomExternalShareWithNote() {
		$this->data = array("shareWithDisplayName"=>"TEST", "initiator"=>"TEST1", "filename"=>"TEST.file","link"=>"#");
		$this->text = "This is note";

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/file_sharing_notification.html');
		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/files_sharing_notification.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$this->assertSame($expectedHTML, $rendredHTML);
	}

	public function testCustomExternalShareWithOutNote() {
		$this->data = array("shareWithDisplayName"=>"TEST", "initiator"=>"TEST1", "filename"=>"TEST.file","link"=>"#");
		$this->text = "";

		$expectedHTML = file_get_contents(\OC::$SERVERROOT . '/apps/nmc_email_template/tests/data/emails/file_sharing_notification.html');
		$rendredHTML = include_once 'nmc_email_template/tests/data/emails/files_sharing_notification.php';
		$rendredHTML = rtrim($rendredHTML,"1");
		$this->assertSame($expectedHTML, $rendredHTML);
	}
*/
}
