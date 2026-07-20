<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Xác thực yêu cầu đặt lại mật khẩu</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style type="text/css">
        body, table, td, p, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        @media only screen and (max-width: 600px) {
            .email-container { width: 100% !important; }
            .content-padding { padding-left: 24px !important; padding-right: 24px !important; }
            .otp-code { font-size: 36px !important; letter-spacing: 6px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <div style="display: none; font-size: 1px; color: #f4f4f5; line-height: 1px; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all;">
        Mã OTP của bạn có hiệu lực trong 5 phút. Không chia sẻ mã này với bất kỳ ai.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f5;">
        <tr>
            <td align="center" style="padding: 40px 16px;">

                <table role="presentation" class="email-container" width="560" cellpadding="0" cellspacing="0" border="0" style="max-width: 560px; width: 100%; background-color: #ffffff; border-radius: 12px; border: 1px solid #e4e4e7;">

                    <tr>
                        <td align="center" class="content-padding" style="padding: 40px 40px 24px 40px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 12px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" width="44" height="44" style="width: 44px; height: 44px; background-color: #18181b; border-radius: 10px; font-size: 20px; font-weight: 900; color: #ffffff; line-height: 44px; text-align: center;" aria-label="{{ $appName }} logo">
                                                    {{ $logoText }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-size: 18px; font-weight: 800; color: #18181b; letter-spacing: 0.5px; text-transform: uppercase;">
                                        {{ $appName }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 40px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="border-top: 1px solid #f4f4f5; font-size: 0; line-height: 0;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="content-padding" style="padding: 32px 40px 40px 40px;">

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="font-size: 22px; font-weight: 700; color: #18181b; line-height: 1.3; padding-bottom: 20px;">
                                        Xác thực yêu cầu đặt lại mật khẩu
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="font-size: 16px; line-height: 1.6; color: #374151; padding-bottom: 8px;">
                                        @if($userName)
                                            Xin chào {{ $userName }},
                                        @else
                                            Xin chào,
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; line-height: 1.6; color: #374151; padding-bottom: 28px;">
                                        Chúng tôi vừa nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại <strong style="color: #18181b;">{{ $appName }}</strong>. Vui lòng sử dụng mã xác thực bên dưới để tiếp tục.
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 24px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f5; border-radius: 10px; border: 1px solid #e4e4e7;">
                                            <tr>
                                                <td align="center" style="padding: 28px 24px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td align="center" style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; padding-bottom: 12px;">
                                                                Mã xác thực của bạn
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="otp-code" style="font-size: 42px; font-weight: 700; color: #18181b; letter-spacing: 8px; line-height: 1.2; font-family: 'Courier New', Courier, monospace;">
                                                                {{ $otp }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="font-size: 16px; font-weight: 600; color: #18181b; padding-bottom: 24px;">
                                        Mã OTP có hiệu lực trong 5 phút.
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="background-color: #fef2f2; border-radius: 8px; border-left: 4px solid #dc2626; padding: 16px 20px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="font-size: 13px; font-weight: 700; color: #991b1b; text-transform: uppercase; letter-spacing: 0.5px; padding-bottom: 6px;">
                                                    Bảo mật
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 15px; line-height: 1.5; color: #991b1b;">
                                                    Không chia sẻ mã OTP này với bất kỳ ai, kể cả nhân viên của hệ thống.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="font-size: 15px; line-height: 1.6; color: #6b7280; padding-top: 24px;">
                                        Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua Email. Tài khoản của bạn vẫn an toàn.
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td style="background-color: #fafafa; border-top: 1px solid #f4f4f5; border-radius: 0 0 12px 12px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" class="content-padding" style="padding: 24px 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="font-size: 13px; line-height: 1.6; color: #9ca3af; padding-bottom: 8px;">
                                                    &copy; {{ date('Y') }} {{ $appName }}. Mọi quyền được bảo lưu.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="font-size: 13px; line-height: 1.6; color: #9ca3af;">
                                                    <a href="{{ $appUrl }}" style="color: #6b7280; text-decoration: underline;">{{ $appUrl }}</a>
                                                    &nbsp;&middot;&nbsp;
                                                    <a href="mailto:{{ $supportEmail }}" style="color: #6b7280; text-decoration: underline;">{{ $supportEmail }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
