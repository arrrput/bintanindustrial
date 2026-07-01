<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru dari Website</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #295740; margin-bottom: 20px; border-bottom: 2px solid #789d5f; padding-bottom: 10px;">New Message from Website</h2>
        <p style="font-size: 15px;">You have received a new inquiry via the Bintan Industrial Estate contact form.</p>
        
        <div style="background: #fdfdfd; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #f0f0f0;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; width: 120px; color: #666;"><strong>Sender Name</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #333;">: {{ $contactData['name'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #666;"><strong>Email Address</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #333;">: <a href="mailto:{{ $contactData['email'] }}" style="color: #295740; text-decoration: none;">{{ $contactData['email'] }}</a></td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #666;"><strong>Subject</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #333; font-weight: bold;">: {{ $contactData['subject'] }}</td>
                </tr>
            </table>
        </div>
        
        <h4 style="margin-top: 25px; margin-bottom: 10px; color: #295740;">Message Content:</h4>
        <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; border-left: 5px solid #789d5f; color: #444; font-style: italic;">
            "{{ $contactData['message'] }}"
        </div>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; font-size: 11px; color: #999; text-align: center;">
            This is an automated message sent from the <strong>Bintan Industrial Estate</strong> website. Please reply directly to the sender's email provided above.
        </div>
    </div>
</body>
</html>