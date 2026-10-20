<?php

return <<<HTML
<table role="presentation" style="border-collapse:separate;width:100%;">
	<tr>
		<td>
			<img src="{$bannerUrl}" width="100%" style="display:block;margin-top:16px;" alt="">
		</td>
	</tr>
</table>
<table role="presentation" class="main" style="border-collapse:separate;width:100%;background:#ffffff;border-radius:3px;min-height:450px;">
	<tr>
		<td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;padding:32px 0;">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width:100%;">
				<tr>
					<td style="padding:0 24px;">
						<p style="font-weight:bold;margin:0 0 16px;">{$hello} {$displayName},</p>
						<p style="margin:0 0 16px;">{$introduction}</p>
						<a href="https://www.magentacloud.de/" target="_blank" style="display:inline-block;color:#ffffff;background-color:#e20074;border:1px solid #e20074;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;">{$openMagentaCloud}</a>
						<p style="margin:32px 0 24px;">{$description}</p>
					</td>
				</tr>
			</table>
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width:100%;">
				<tr style="background-color:#f1f1f1;">
					<td style="padding:32px 12px 24px 24px;width:50%;">
						<img src="{$mobileImageUrl}" style="margin-right:8px;width:48px;" alt="">
						<div style="display:inline-block;vertical-align:top;padding-top:2px;">
							<span style="font-size:16px;">{$softwareApps}:</span><br>
							<a style="font-size:12px;text-decoration:none;color:#e20074;" href="https://cloud.telekom-dienste.de/software-apps">magentacloud.de/software-apps</a>
						</div>
					</td>
					<td style="padding:32px 24px 24px 12px;width:50%;">
						<img src="{$computerImageUrl}" style="margin-right:8px;width:48px;" alt="">
						<div style="display:inline-block;vertical-align:top;padding-top:2px;">
							<span style="font-size:16px;">{$onlineInformation}:</span><br>
							<a style="font-size:12px;text-decoration:none;color:#e20074;" href="https://www.telekom.de/magentacloud">telekom.de/magentacloud</a>
						</div>
					</td>
				</tr>
			</table>
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="padding:0 24px;margin-top:24px;margin-bottom:96px;width:100%;">
				<tr>
					<td style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-right:12px;width:55%;">
						<strong>{$advantages}:</strong>
						<ul style="margin:16px 0 32px;list-style:none;padding:0;">
							<li style="margin-bottom:8px;background:url({$checkmarkUrl}) no-repeat;text-indent:32px;">{$keepMemoriesSafe}</li>
							<li style="margin-bottom:8px;background:url({$checkmarkUrl}) no-repeat;text-indent:32px;">{$shareMoments}</li>
							<li style="margin-bottom:8px;background:url({$checkmarkUrl}) no-repeat;text-indent:32px;">{$keepOverview}</li>
							<li style="background:url({$checkmarkUrl}) no-repeat;text-indent:32px;">{$expandMemory}</li>
						</ul>
						<p style="margin:0;">{$information}</p>
						<a href="https://www.telekom.de/magentacloud" style="text-decoration:none;color:#e20074;">www.telekom.de/magentacloud</a>
						<p>{$yourTelekom}</p>
					</td>
					<td style="text-align:center;vertical-align:top;padding-left:12px;width:45%;">
						<div style="text-align:center;background:#f1f1f1;padding:24px;">
							<div style="font-weight:bold;"><span style="font-size:40px;">100 GB</span></div>
							<span style="font-weight:bold;font-size:12px;">MagentaCLOUD M</span>
							<p style="font-size:10px;margin:8px 0 16px;text-align:left;">{$upgradeText}<br>{$minimumContract}</p>
							<span style="display:inline-block;font-size:20px;margin:16px 0;">{$only} <strong>1,95 €</strong> {$monthly}</span><br>
							<a href="https://cloud.telekom-dienste.de/tarife" target="_blank" style="display:inline-block;color:#ffffff;background-color:#e20074;border:1px solid #e20074;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;">{$orderNow}</a>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
HTML;
