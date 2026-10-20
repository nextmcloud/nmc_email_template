<?php

return <<<HTML
<table role="presentation" class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;background:#ffffff;border-radius:3px;min-height:450px;">
	<tr>
		<td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:32px 24px;">
			<table class="quota-details" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;">
				<tr style="background:#f1f1f1;">
					<td class="quota-info" style="font-family:sans-serif;font-size:12px;vertical-align:top;padding-left:32px;padding-right:16px;width:30%;">
						<div style="text-align:center;width:100%;padding-top:48px;box-sizing:border-box;">
							<span style="font-size:32px;color:#e20074;">{$usedValue}</span>
							<span style="font-size:16px;"> {$usedUnit}</span>
							<br>
							<div style="width:110px;display:inline-block;margin-bottom:32px;border-top:1px solid #191919;">
								<span style="font-size:32px;color:#191919;">{$quotaValue}</span>
								<span style="font-size:16px;"> {$quotaUnit}</span>
							</div>
						</div>
					</td>
					<td class="quota-info" style="font-family:sans-serif;font-size:12px;vertical-align:top;width:70%;">
						<div class="warning-info" style="text-align:left;width:100%;padding:24px 0;box-sizing:border-box;">
							<span style="font-weight:bold;">{$quotaWarning}</span>
							<p style="font-size:12px;margin:8px 0 16px;padding:0 16px;">
								<strong>{$percentage}%</strong> {$quotaDescription}
							</p>
							<a href="https://cloud.telekom-dienste.de/tarife" target="_blank" style="display:inline-block;color:#191919;background-color:#f1f1f1;border:1px solid #191919;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;margin-right:8px;">{$orderNow}</a>
							<a href="{$trashUrl}" target="_blank" style="display:inline-block;color:#191919;background-color:#f1f1f1;border:1px solid #191919;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;">{$openTrash}</a>
						</div>
					</td>
				</tr>
			</table>
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top:32px;border-collapse:separate;width:100%;">
				<tr>
					<td style="font-family:sans-serif;font-size:14px;vertical-align:top;">
						<p style="font-size:14px;font-weight:bold;margin:0 0 16px;">{$hello} {$displayName},</p>
						<p style="font-size:14px;font-weight:normal;margin:0 0 16px;">{$statusText}</p>
						<p style="margin:16px 0 32px;">{$yourTelekom}</p>
						<a href="https://www.magentacloud.de/" target="_blank" style="display:inline-block;color:#ffffff;background-color:#e20074;border:1px solid #e20074;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;">{$openMagentaCloud}</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
HTML;
