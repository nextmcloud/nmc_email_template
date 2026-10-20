<?php

return <<<HTML
<table role="presentation" class="main" style="border-collapse:separate;width:100%;background:#ffffff;border-radius:3px;">
	<tr>
		<td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;padding:32px 24px;">
			<p style="font-size:18px;font-weight:bold;margin:0 0 16px;">{$hello} {$displayName},</p>
			<p style="font-size:16px;font-weight:normal;margin:0 0 16px;">{$activityText} <a href="https://www.magentacloud.de/" style="text-decoration:none;color:#e20074;">MagentaCLOUD.</a></p>
		</td>
	</tr>
</table>
HTML;
