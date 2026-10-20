<?php

$messageHtml = '';

if ($message !== '') {
	$messageHtml = <<<HTML
<p style="font-family:sans-serif;font-size:14px;font-weight:bold;margin:0;">{$messageFrom} {$initiator}:</p>
<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0 0 15px;">{$message}</p>
HTML;
}

return <<<HTML
<table role="presentation" class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;background:#ffffff;border-radius:3px;min-height:450px;">
	<tr>
		<td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:32px 24px;">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;">
				<tr>
					<td style="font-family:sans-serif;font-size:14px;vertical-align:top;">
						<p style="font-size:14px;font-weight:bold;margin:0 0 16px;">{$hello} {$displayName},</p>
						<p style="font-size:14px;font-weight:normal;margin:0 0 16px;">{$initiator} {$hasShared} <strong>{$filename}</strong> {$shareDescription}</p>
						<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
							<tr>
								<td align="left" style="padding-bottom:32px;">
									<a href="{$link}" target="_blank" style="display:inline-block;color:#ffffff;background-color:#e20074;border:1px solid #e20074;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;">{$openShare}</a>
								</td>
							</tr>
						</table>
						{$messageHtml}
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
HTML;
