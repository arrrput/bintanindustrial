<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #295740; margin-bottom: 20px; border-bottom: 2px solid #789d5f; padding-bottom: 10px;">Verification Code</h2>
        
        <p style="font-size: 15px;">Hello,</p>
        <p style="font-size: 15px;">You are attempting to apply for the <strong>{{ $jobTitle }}</strong> position at Bintan Industrial Estate.</p>
        <p style="font-size: 15px;">Please use the following One-Time Password (OTP) to verify your email address and continue with your application:</p>
        
        <div style="background: #fdfdfd; padding: 20px; text-align: center; border-radius: 8px; margin: 30px 0; border: 1px dashed #295740;">
            <h1 style="font-size: 40px; letter-spacing: 5px; color: #295740; margin: 0;">{{ $otp }}</h1>
        </div>
        
        <p style="font-size: 15px; color: #666;">This code is valid for 15 minutes. Please do not share this code with anyone.</p>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; font-size: 11px; color: #999; text-align: center;">
            This is an automated message. Please do not reply to this email.
        </div>
    </div>
</body>
</html>