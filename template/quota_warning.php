<?php
 return '
 <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;min-height: 450px;">

 <!-- START MAIN CONTENT AREA -->
 <tr>
   <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 32px 24px;">

	 <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
	   <tr style="background: #f1f1f1;">
		 <td style="font-family: sans-serif; font-size: 12px; vertical-align: top;padding-left: 32px;padding-right: 16px">
		   <div style="text-align: center;width: 100% ;padding-top: 48px;box-sizing: border-box;">
			 <span style="font-size: 32px;color:#e20074">'.$this->data['usedSpace'][0].'</span><span style="font-size: 16px;"> '.$this->data['usedSpace'][1].'</span>
			 <br />
			 <div style="width:110px;display: inline-block;margin-bottom: 32px;border-top: 1px solid #191919;"><span style="font-size: 32px;color:#191919;">'.$this->data['quota1'][0].'</span><span style="font-size: 16px;"> '.$this->data['quota1'][1].'</span></div>
		   </div>
		   </td>
		   <td style="font-family: sans-serif; font-size: 12px; vertical-align: top;padding-right: 24px;padding-left: 16px">
			 <div style="text-align: left;width: 100% ;padding-top: 24px;padding-bottom: 24px;box-sizing: border-box;">
			 <span style="font-weight: bold;">'.$this->l10n->t('Quota warning').'</span>
			   <p style="font-size: 12px;margin-top: 8px;margin-bottom: 16px;"><span style="font-size: 12px;font-weight: bold;">'.$this->data['quota'].' %</span> '.$this->l10n->t('of your storage is currently occupied.Once your memory is used up,you cannot upload any more files.However,you can remove files or empty you recycle bin at any time').' </p>
			   <a href="https://cloud.telekom-dienste.de/tarife" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1 !important;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;;margin-right: 8px;">'.$this->l10n->t('Expand storage').'</a>
			   <a href="/apps/files/?dir=/&view=trashbin" target="_blank" style="display: inline-block;color: #191919;background-color: #f1f1f1 !important;border: 1px solid #191919;border-radius: 8px;box-sizing: border-box;cursor: pointer;text-decoration: none;font-size: 12px;font-weight: bold;margin: 0;padding: 12px 24px;">'.$this->l10n->t('Open the trash').'</a>
			 </div>
			 </td>
		 </tr>
	  </table>

	 <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top:32px;border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
	   <tr>
		 <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
		   <p style="font-family: sans-serif; font-size: 14px; font-weight: bold; margin: 0; Margin-bottom: 16px;">'.$this->l10n->t('Hello').' '.$this->data['displayName'].',</p>
		   <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 16px;">'.$this->l10n->t('with the MagentaCLOUD status email,we inform you once a month about the storage space you have used and the shares you have created.').'</p>
		   <p style="margin-top:16px;margin-bottom:32px">'.$this->l10n->t('Your Telekom').'</p>
		   <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
			   <tbody>
				 <tr>
				   <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 32px;">
					 <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
					   <tbody>
						 <tr>
						   <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #e20074 !important; border-radius: 8px; text-align: center;"> <a href="https://www.magentacloud.de/" target="_blank" style="display: inline-block; color: #ffffff; background-color: #e20074 !important; border: solid 1px #e20074; border-radius: 8px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: bold; margin: 0; padding: 12px 24px; text-transform: capitalize;">'.$this->l10n->t('Open MagentaCLOUD').'</a> </td>
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
?>
