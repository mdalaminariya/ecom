<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email - Aranoz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0; font-family:Arial, sans-serif; background:#f3f7f4;">

<div style="display:flex; align-items:center; justify-content:center; height:100vh;">

    <div style="
        width:420px;
        background:#ffffff;
        padding:30px;
        border-radius:12px;
        text-align:center;
        box-shadow:0 8px 30px rgba(0,0,0,0.05);
    ">

        <!-- Logo -->
        <img src="https://your-domain.com/logo.png" width="50" alt="Aranoz">

        <!-- Title -->
        <h2 style="color:#2e7d32; margin:10px 0;">Aranoz</h2>

        <h3 style="margin:10px 0; color:#222;">
            Verify Your Email
        </h3>

        <!-- Message -->
        <p style="color:#555; font-size:14px; line-height:1.6;">
            Before getting started, please check your email for a verification link.
            <br><br>
            Didn’t receive the email?
        </p>

        <!-- Success message -->
        @if (session('status') == 'verification-link-sent')
            <p style="color:green; font-size:13px;">
                ✅ A new verification link has been sent!
            </p>
        @endif

        <!-- Resend button -->
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf

            <button type="submit"
                style="
                    margin-top:15px;
                    padding:12px 20px;
                    border:none;
                    border-radius:8px;
                    background:linear-gradient(135deg, #4caf50, #2e7d32);
                    color:white;
                    font-weight:bold;
                    cursor:pointer;
                ">
                Resend Email
            </button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                style="
                    margin-top:10px;
                    background:none;
                    border:none;
                    color:#888;
                    font-size:12px;
                    cursor:pointer;
                ">
                Logout
            </button>
        </form>

    </div>

</div>

</body>
</html>
