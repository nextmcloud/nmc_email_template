<?php

return '
 <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;min-height: 330px;">
 <!-- START MAIN CONTENT AREA -->
 <tr>
   <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 32px 24px;">
	 <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
	   <tr>
		 <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
		   <p style="font-family: sans-serif; font-size: 24px; font-weight: bold; margin: 0; Margin-bottom: 30px;font-weight: 400;">'.$this->l10n->t('Email verification').'</p>
		   <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">'.$this->l10n->t('You have entered a new alternative e-mail address. Click the following button to confirm.').'</p>
		   <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
			 <tbody>
			   <tr>
				 <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 32px;">
				   <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
					 <tbody>
					   <tr>
						 <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #e20074; border-radius: 8px; text-align: center;"> <a href="'.$this->data['link'].'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #e20074; border: solid 1px #e20074; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: bold; margin: 0; padding: 12px 24px; text-transform: capitalize; border-color: #e20074;">'.$this->l10n->t('Confirm your email').'</a> </td>
					   </tr>
					 </tbody>
				   </table>
				 </td>
			   </tr>
			 </tbody>
		   </table>
		 </td>
	   </tr>
	 </table>
   </td>
 </tr>
<!-- END MAIN CONTENT AREA -->
</table>
 ';
