<?php
 return '
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
		float: left;
		box-sizing: border-box;
	}
	table[class=footer-section] .footer-link {
		width: 23%;
		float: left;
		box-sizing: border-box;
		padding-right: 0 !important;
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
		<!-- START Header -->
		<div class="header" style="clear: both;text-align: center; width: 100%;">
		<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
			<tr style="background: #e20074;">
			<td class="content-block" style="padding: 16px 24px;">
			<img src="'.$this->urlPath.'customapps/nmctheme/img/telekom/tlogocarrier.svg" style="width: 35px;" />
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
			<td class="content-block" style="font-family: sans-serif; vertical-align: top;">
			<img src="'.$this->urlPath.'customapps/nmctheme/img/email/welcome-banner.png" width="100%" style="margin-top: 16px;"/>
			</td>
			</tr>
		</table>
		</div>
	<!-- END Header -->
		<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 600px;">
		<table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;min-height: 450px;">

			<!-- START MAIN CONTENT AREA -->
			<tr>
			<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 32px 0;">
				<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
				<tr>
					<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding:0 24px;">
					<p style="font-family: sans-serif; font-size: 14px; font-weight: bold; margin: 0; Margin-bottom: 16px;">'.$this->l10n->t('Hello').' '.$this->data['displayname'].',</p>
					<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">'.$this->l10n->t("we have activated your MagentaCLOUD, Telekom's online storage. Just click the link, log in and you are ready to go.").'
					</p>
					<a href="https://www.magentacloud.de/" target="_blank" style="display: inline-block; color: #ffffff; background-color: #e20074; border: solid 1px #e20074; border-radius: 8px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: bold; margin: 0; padding: 12px 24px; text-transform: capitalize;">'.$this->l10n->t('Open MagentaCLOUD').'</a>
					<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-top: 32px; Margin-bottom: 24px;">'.$this->l10n->t('With MagentaCLOUD, you can store your photos, videos, documents and much more securely online and access them from anywhere using your personal access data.').'
					</p>
					</td>
				</tr>
				</table>
				<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; ">
				<tr style="background-color: #f1f1f1;">
					<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding-right: 12px;">
					<div style="Width: 100%;padding-top: 32px;padding-bottom: 24px;padding-left: 24px;box-sizing: border-box;">
						<img src="'.$this->urlPath.'customapps/nmctheme/img/email/mobile.svg" style="margin-right: 8px; width: 48px;" />
						<div style="display: inline-block;vertical-align: top;padding-top: 2px;">
						<span style="font-size: 16px;color:#191919">'.$this->l10n->t('Software & Apps').':</span>
						<br/>
						<a style="font-size: 12px;text-decoration: none;color:#e20074" href="https://cloud.telekom-dienste.de/software-apps">magentacloud.de/software-apps</a>
					</div>
					</div>
					</td>
					<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding-right: 12px;">
						<div style="width: 100%;padding-top: 32px;padding-bottom: 24px;padding-right: 24px;box-sizing: border-box;">
						<img src="'.$this->urlPath.'customapps/nmctheme/img/email/computer.svg" style="margin-right: 8px; width: 48px;" />
						<div style="display: inline-block;vertical-align: super;padding-top: 2px;">
							<span style="font-size: 16px;color:#191919">'.$this->l10n->t('Online Information').':</span>
							<br/>
							<a style="font-size: 12px;text-decoration: none;color:#e20074" href="https://telekom.de/magentacloud">telekom.de/magentacloud</a>
						</div>
						</div>
						</td>
					</tr>
				</table>
				<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="padding:0 24px;margin-top:24px;margin-bottom:96px;border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
				<tr>
					<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;padding-right: 12px;">
					<div style="">
						<span style="font-family: sans-serif; font-size: 14px;font-weight: bold;">'.$this->l10n->t('The advantages of the MagentaCLOUD at a glance').':</span>
						<ul style="margin-top: 16px;margin-bottom: 32px;list-style: none;padding: 0;">
						<li style="margin-bottom: 8px;background: url('.$this->urlPath.'customapps/nmctheme/img/email/checkmark.svg); background-repeat: no-repeat;text-indent: 32px;">'.$this->l10n->t('Keep memories safe').'</li>
						<li style="margin-bottom: 8px;background: url('.$this->urlPath.'customapps/nmctheme/img/email/checkmark.svg); background-repeat: no-repeat;text-indent: 32px;">'.$this->l10n->t('Share special moments with family').'</li>
						<li style="margin-bottom: 8px;background: url('.$this->urlPath.'customapps/nmctheme/img/email/checkmark.svg); background-repeat: no-repeat;text-indent: 32px;">'.$this->l10n->t('Keep all files in overview').'</li>
						<li style="margin-bottom: 0px;background: url('.$this->urlPath.'customapps/nmctheme/img/email/checkmark.svg); background-repeat: no-repeat;text-indent: 32px;">'.$this->l10n->t('Expand device memory free of charge').'</li>
						</ul>
						<p style="margin:0"> '.$this->l10n->t('You can find more information as well as frequently asked questions and answers about MagentaCLOUD at').'</p>
						<a href="www.telekom.de/magentacloud" style="text-decoration: none;">www.telekom.de/magentacloud</a>
						<p>'.$this->l10n->t('Your Telekom').'</p>
					</div>
					</td>
					<td style="text-align: center;font-family: sans-serif; font-size: 14px; vertical-align: top;padding-left: 12px;">
						<div style="text-align: center;background: #f1f1f1;padding-top:24px;padding-bottom: 24px;padding-right: 24px;padding-left: 24px;box-sizing: border-box;">

						<div style="font-weight: bolder;"><span style="font-size: 40px;color:#191919;">100 GB</span></div>
						<span style="font-weight: bolder;font-size: 12px;">MagentaCLOUD M</span>
						<p style="font-size: 10px;margin-top: 8px;margin-bottom: 16px;text-align: left;">'.$this->l10n->t('Upgrade now to MagentaCLOUD M <br /> for only 1.95 € per month and immediately have 100 GB of storage <br /> available.').'
							<br /> '.$this->l10n->t('3 months minimum contract term').'</p>
							<span style="display:inline-block; font-size:20px;margin-top: 16px;margin-bottom: 16px;">'.$this->l10n->t('only').' <span style="font-weight: bolder;">1,95 €</span> '.$this->l10n->t('monthly').'</span>
						<a href="https://cloud.telekom-dienste.de/tarife" target="_blank" style="display: inline-block;color: #ffffff;background-color: #e20074;border: solid 1px #e20074;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;text-transform: capitalize;">'.$this->l10n->t('Order now').'</a>
						</div>
						</td>
					</tr>
				</table>

			</td>
			</tr>

		<!-- END MAIN CONTENT AREA -->
		</table>
 ';
?>
