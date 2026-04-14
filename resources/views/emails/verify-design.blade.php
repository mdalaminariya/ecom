<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
</head>
<body style="margin:0; padding:0; background:#f3f7f4; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
<tr>
<td align="center">

    <!-- Card -->
    <table width="420" cellpadding="0" cellspacing="0"
        style="background:#ffffff; border-radius:12px; padding:30px; text-align:center; box-shadow:0 6px 25px rgba(0,0,0,0.05);">

        <!-- Logo -->
        <tr>
            <td style="padding-bottom:15px;">
                <!-- Replace with your real hosted logo -->
                <img src={{ asset('frontend/assets/img/fevicon.png') }} width="50" alt="Aranoz">
            </td>
        </tr>

        <!-- App Name -->
        <tr>
            <td>
                <h2 style="margin:0; color:#2e7d32;">Aranoz</h2>
            </td>
        </tr>

        <!-- Title -->
        <tr>
            <td style="padding-top:10px;">
                <h1 style="margin:0; font-size:22px; color:#222;">
                    Verify your email
                </h1>
            </td>
        </tr>

        <!-- Message -->
        <tr>
            <td style="padding:15px 0; color:#555; font-size:14px; line-height:1.6;">
                Hi {{ $user->name ?? 'there' }},<br><br>
                Welcome to <strong>Aranoz</strong> 🌿<br>
                Please confirm your email address to get started.
            </td>
        </tr>

        <!-- Button -->
        <tr>
            <td style="padding:20px 0;">
                <a href="{{ $url }}"
                   style="
                       display:inline-block;
                       padding:14px 28px;
                       font-size:14px;
                       color:#ffffff;
                       text-decoration:none;
                       border-radius:8px;
                       background:linear-gradient(135deg, #4caf50, #2e7d32);
                       font-weight:bold;
                   ">
                    Verify Email
                </a>
            </td>
        </tr>

        <!-- Fallback link -->
        <tr>
            <td style="font-size:12px; color:#888;">
                If the button doesn’t work, use this link:<br>
                <a href="{{ $url }}" style="color:#2e7d32; word-break:break-all;">
                    {{ $url }}
                </a>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding-top:25px; font-size:12px; color:#aaa;">
                If you didn’t create an account, you can safely ignore this email.
            </td>
        </tr>

    </table>

    <!-- Bottom footer -->
    <div style="margin-top:15px; font-size:12px; color:#bbb;">
        © {{ date('Y') }} Aranoz. All rights reserved.
    </div>

</td>
</tr>
</table>

</body>
</html>
