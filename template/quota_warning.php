<?php

return <<<HTML
<table role="presentation" class="main" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;background:#fff;">
	<tr>
		<td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:32px 24px;">
			<table class="quota-details" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;">
				<tr style="background:#f1f1f1;">
					<td class="quota-info" style="font-family:sans-serif;font-size:12px;vertical-align:top;padding:32px 16px 32px 32px;width:30%;">
						<div style="text-align:center;width:100%;box-sizing:border-box;">
							<span style="white-space:nowrap;">
								<span style="font-size:30px;color:#e20074;">{$usedValue}</span>
								<span style="font-size:16px;">&nbsp;{$usedUnit}</span>
							</span>
							<div style="width:110px;display:inline-block;margin-top:16px;padding-top:6px;border-top:1px solid #191919;">
								<span style="white-space:nowrap;">
									<span style="font-size:30px;color:#191919;">{$quotaValue}</span>
									<span style="font-size:16px;">&nbsp;{$quotaUnit}</span>
								</span>
							</div>
						</div>
					</td>
					<td class="quota-info" style="font-family:sans-serif;font-size:12px;vertical-align:middle;padding:32px 32px 32px 16px;width:70%;">
						<div class="warning-info" style="text-align:left;width:100%;box-sizing:border-box;">
							<div style="font-size:14px;font-weight:bold;margin-bottom:8px;">{$quotaWarning}</div>
							<p style="font-size:12px;line-height:1.5;margin:0 0 20px;">
								<strong>{$percentage}%</strong> {$quotaDescription}
							</p>
							<a href="{$orderUrl}" target="_blank" style="display:inline-block;color:#191919;background:#f1f1f1;border:1px solid #191919;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;margin-right:8px;">{$orderNow}</a>
							<a href="{$trashUrl}" target="_blank" style="display:inline-block;color:#191919;background:#f1f1f1;border:1px solid #191919;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;">{$openTrash}</a>
						</div>
					</td>
				</tr>
			</table>
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top:32px;border-collapse:separate;width:100%;">
				<tr>
					<td style="font-family:sans-serif;font-size:14px;vertical-align:top;">
						<p style="font-weight:bold;margin:0 0 16px;">{$hello} {$displayName},</p>
						<p style="margin:0 0 16px;">{$statusText}</p>
						<p style="margin:16px 0 32px;">{$yourTelekom}</p>
						<a href="{$homeUrl}" target="_blank" style="display:inline-block;color:#fff;background:#e20074;border:1px solid #e20074;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;">{$openMagentaCloud}</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
HTML;
