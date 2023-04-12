<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password Page ASABRI</title>
</head>
<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
        <tbody>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" style="margin:auto; max-width:650px; width:100%">
                        <tbody>
                            <tr>
                                <td colspan="2" style="background-color:rgba(51, 51, 51, 1)">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h1 style="margin-left:0; margin-right:0; text-align:left">Password Reset</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; vertical-align:top">
                                    <p style="margin-left:0; margin-right:0; text-align:left">Hi
                                        {{ $mailData['name'] }},</p>

                                    <p style="margin-left:0; margin-right:0; text-align:left">We received a request to
                                        reset the password for the <strong>{{ $mailData['name'] }}</strong> account that
                                        is associated with this email address.<br />
                                        If you made this request, please click the button below to securely reset your
                                        password.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left">
                                    <table align="left" border="0" cellpadding="0" cellspacing="0"
                                        style="background-color:rgba(255, 80, 0, 1); border-radius:4px">
                                        <tbody>
                                            <tr>
                                                <td class="p-2" style="border-radius:6px;"><a
                                                        href="{{ $mailData['url'] }}NewPasswordPage?confirmation={{ $mailData['code'] }}&amp;userstoredomain=PRIMARY&amp;username={{ $mailData['name'] }}&amp;tenantdomain=carbon.super&amp;callback={{ $mailData['url'] }}Loginaccount"
                                                        style="width: 230px; border-radius:10px; font-family: &quot;Nunito Sans&quot;, Arial, Verdana, Helvetica, sans-serif; font-size: 18px; line-height: 21px; font-weight: 600; color: rgba(255, 255, 255, 1); text-decoration: none; background-color: rgba(255, 80, 0, 1); text-align: center; display: inline-block; cursor: pointer">Reset
                                                        Password</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; vertical-align:top">
                                    <p style="margin-left:0; margin-right:0; text-align:left">If clicking the button
                                        doesn&#39;t seem to work, you can copy and paste the following link into your
                                        browser.<br />
                                        <a href="{{ $mailData['url'] }}NewPasswordPage?confirmation={{ $mailData['code'] }}&amp;userstoredomain=PRIMARY&amp;username={{ $mailData['name'] }}&amp;tenantdomain=carbon.super&amp;callback={{ $mailData['url'] }}Loginaccount"
                                            style="word-break: break-all; color: rgba(255, 80, 0, 1); font-size: 14px">{{ $mailData['url'] }}NewPasswordPage?confirmation={{ $mailData['code'] }}&amp;userstoredomain=PRIMARY&amp;username={{ $mailData['name'] }}&amp;tenantdomain=carbon.super&amp;callback={{ $mailData['url'] }}Loginaccount</a>
                                    </p>
                                    &nbsp;

                                    <p style="margin-left:0; margin-right:0; text-align:left">If you did not request to
                                        have your {{ $mailData['name'] }} password reset, disregard this email and no
                                        changes to your account will be made.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; vertical-align:top">
                                    <p style="margin-left:0; margin-right:0; text-align:left">Thanks,<br />
                                        WSO2 API Manager Team</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p style="margin-left:0; margin-right:0">&copy; 2023 PT.&nbsp;<a
                                            href="http://wso2.com/"
                                            style="color: rgba(119, 119, 119, 1); text-decoration: none">S</a>WAMEDIA
                                        INFORMATIKA<br />
                                        Jl. Sido Mulyo No.29, 40123, Sadang Serang, Jawa Barat</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
