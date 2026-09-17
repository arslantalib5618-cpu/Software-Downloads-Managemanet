<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>New Post Published</title>
<!--[if mso]>
<noscript>
<xml>
<o:OfficeDocumentSettings>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
</noscript>
<![endif]-->
<style>
  body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
  table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
  img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
  body { margin: 0; padding: 0; width: 100% !important; height: 100% !important; background-color: #f2f4f7; }

  @media only screen and (max-width: 600px) {
    .email-container { width: 100% !important; max-width: 100% !important; }
    .fluid-padding { padding-left: 20px !important; padding-right: 20px !important; }
    .hero-title { font-size: 26px !important; line-height: 34px !important; }
    .post-title { font-size: 22px !important; line-height: 30px !important; }
    .cta-button { width: 100% !important; text-align: center !important; }
    .cta-button a { display: block !important; width: 100% !important; }
  }
</style>
</head>
<body style="margin:0; padding:0; background-color:#f2f4f7;">

<!-- Preheader (hidden preview text) -->
<div style="display:none; font-size:1px; color:#f2f4f7; line-height:1px; max-height:0px; max-width:0px; opacity:0; overflow:hidden;">
    A new post has just been published: {{ $software->title }}
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f2f4f7;">
<tr>
<td align="center" style="padding: 30px 15px;">

    <table role="presentation" class="email-container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 18px rgba(20,20,43,0.08);">

        <!-- HERO BANNER -->
        <tr>
            <td align="center" style="background-color:#4f46e5; background-image:linear-gradient(135deg,#4f46e5 0%, #6366f1 60%, #7c3aed 100%); padding: 60px 30px 55px 30px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:18px;">
                                <tr>
                                    <td style="background-color:rgba(255,255,255,0.15); border-radius:50px; padding:8px 20px;">
                                        <span style="font-family: Arial, Helvetica, sans-serif; font-size:12px; letter-spacing:2px; color:#ffffff; text-transform:uppercase; font-weight:bold;">
                                            &#9733; New Release
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="hero-title" style="font-family: Arial, Helvetica, sans-serif; font-size:34px; line-height:42px; font-weight:800; color:#ffffff; padding-bottom:10px;">
                            New Post Published
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:15px; line-height:22px; color:rgba(255,255,255,0.85); padding: 0 20px;">
                            A fresh update just landed on {{ config('app.name', 'our platform') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- BODY CONTENT -->
        <tr>
            <td class="fluid-padding" style="padding: 45px 45px 10px 45px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="left" class="post-title" style="font-family: Arial, Helvetica, sans-serif; font-size:26px; line-height:34px; font-weight:bold; color:#111827; padding-bottom:16px;">
                            {{ $software->title }}
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-family: Arial, Helvetica, sans-serif; font-size:16px; line-height:26px; color:#4b5563; padding-bottom:34px;">
                            {{ $software->short_description }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- CTA BUTTON -->
        <tr>
            <td class="fluid-padding" align="center" style="padding: 0 45px 45px 45px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td align="center">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" class="cta-button">
                                <tr>
                                    <td align="center" style="border-radius:8px; background-color:#4f46e5; background-image:linear-gradient(135deg,#4f46e5 0%, #7c3aed 100%);">
                                        <!--[if mso]>
                                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ url('/software/'.$software->slug) }}" style="height:52px;v-text-anchor:middle;width:260px;" arcsize="12%" fillcolor="#4f46e5" strokecolor="#4f46e5">
                                        <w:anchorlock/>
                                        <center style="color:#ffffff;font-family:Arial,sans-serif;font-size:16px;font-weight:bold;">Read Full Post</center>
                                        </v:roundrect>
                                        <![endif]-->
                                        <!--[if !mso]><!-->
                                        <a href="{{ url('/software/'.$software->slug) }}"
                                           target="_blank"
                                           style="display:inline-block; padding:16px 42px; font-family: Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:8px; letter-spacing:0.3px;">
                                            Download Now
                                        </a>
                                        <!--<![endif]-->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top:16px; font-family: Arial, Helvetica, sans-serif; font-size:13px; color:#9ca3af;">
                            or <a href="{{ url('/software/'.$software->slug) }}" style="color:#4f46e5; text-decoration:underline;">read the full post</a> on our website
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- DIVIDER -->
        <tr>
            <td style="padding: 0 45px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="border-top:1px solid #e5e7eb; font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td class="fluid-padding" align="center" style="padding: 30px 45px 40px 45px; background-color:#ffffff;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; color:#111827; padding-bottom:6px;">
                            {{ config('app.name', 'Your Website') }}
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#9ca3af;">
                            You are receiving this email because you subscribed to updates from {{ config('app.name', 'our website') }}.
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top:14px; font-family: Arial, Helvetica, sans-serif; font-size:12px; color:#9ca3af;">
                            &copy; {{ date('Y') }} {{ config('app.name', 'Your Website') }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

    <!-- Bottom spacer / unsubscribe area outside card -->
    <table role="presentation" class="email-container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px;">
        <tr>
            <td align="center" style="padding: 22px 15px 0 15px; font-family: Arial, Helvetica, sans-serif; font-size:11px; line-height:16px; color:#b0b4bb;">
                {{ config('app.url') }}
            </td>
        </tr>
    </table>

</td>
</tr>
</table>

</body>
</html>