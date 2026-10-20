<?php

return <<<HTML
<table role="presentation" class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;background:#ffffff;border-radius:3px;min-height:330px;">
	<tr>
		<td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:32px 24px;">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;">
				<tr>
					<td style="font-family:sans-serif;font-size:14px;vertical-align:top;">
						<p style="font-size:24px;font-weight:400;margin:0 0 30px;">{$title}</p>
						<p style="font-size:14px;font-weight:normal;margin:0 0 16px;">{$description}</p>
						<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
							<tr>
								<td align="left" style="padding-bottom:32px;">
									<a href="{$link}" target="_blank" style="display:inline-block;color:#ffffff;background-color:#e20074;border:1px solid #e20074;border-radius:8px;text-decoration:none;font-size:12px;font-weight:bold;padding:12px 24px;">{$confirmEmail}</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
HTML;
