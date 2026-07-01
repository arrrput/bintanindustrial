<!DOCTYPE html>
<html>
<head>
    <title>Application Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f9f9f9;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9f9f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.04);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 35px 35px 20px;">
                            <h2 style="color: #295740; margin: 0; font-size: 24px;">BIIE Recruitment</h2>
                            <p style="color: #888; font-size: 14px; margin-top: 5px;">Position: <strong>{{ $applicant->career->title }}</strong></p>
                        </td>
                    </tr>

                    <!-- Message Body -->
                    <tr>
                        <td style="padding: 0 35px;">
                            <div style="background-color: #fdfdfd; padding: 25px; border-radius: 12px; border: 1px solid #f5f5f5;">
                                <p style="font-size: 16px; margin-top: 0;">Dear <strong>{{ $applicant->first_name }}</strong>,</p>

                                @php $status = $applicant->status; @endphp

                                @if($status == 'pending')
                                    <p>Thank you for applying to Bintan Industrial Estate! Your application for the <strong>{{ $applicant->career->title }}</strong> position has been successfully submitted.</p>
                                    <p>Our recruitment team will review your application shortly. We appreciate the time and effort you've put into your application.</p>
                                @elseif($status == 'screening')
                                    <p>Your application for the <strong>{{ $applicant->career->title }}</strong> position is currently being <strong>processed</strong> by our recruitment team.</p>
                                    <p>We are reviewing your qualifications and will notify you of the next steps soon.</p>
                                @elseif($status == 'interview')
                                    <p style="color: #295740; font-weight: bold; font-size: 17px;">Great news! You have been selected for the next stage.</p>
                                    <p>We would like to invite you for an interview session for the <strong>{{ $applicant->career->title }}</strong> position. An invitation message with details will be sent to you shortly.</p>
                                @elseif($status == 'hired')
                                    <p style="color: #198754; font-weight: bold; font-size: 18px;">Congratulations! You're Hired! 🎉</p>
                                    <p>We are excited to inform you that you have been <strong>Accepted</strong> for the position of {{ $applicant->career->title }}. Welcome to the team!</p>
                                    <p>Our HR department will contact you soon regarding the onboarding process.</p>
                                @elseif($status == 'rejected')
                                     @if(str_contains($applicant->status_reason, 'closing date') || str_contains($applicant->status_reason, 'closed'))
                                         <p>Thank you for your interest in joining us. We would like to inform you that the job vacancy for <strong>{{ $applicant->career->title }}</strong> has reached its closing date and is now closed. Unfortunately, we cannot move your application to the next step at this time.</p>
                                     @else
                                         <p>Thank you for your interest in joining us. After a careful review of all applications for the <strong>{{ $applicant->career->title }}</strong> position, we regret to inform you that we will not be moving forward with your candidacy at this time.</p>
                                     @endif
                                     <p>We wish you the very best in your job search and future career.</p>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Progress Bar Section -->
                    <tr>
                        <td style="padding: 40px 35px 35px;">
                            <div style="border-top: 1px solid #eee; padding-top: 30px;">
                                @php
                                    $currentStep = match($status) {
                                        'pending' => 1,
                                        'screening', 'interview' => 2,
                                        'hired', 'rejected' => 3,
                                        default => 1
                                    };
                                    
                                    $colorActive = '#295740';
                                    $colorCompleted = '#789d5f';
                                    $colorRejected = '#dc3545';
                                    $colorInactive = '#eeeeee';
                                    $textColor = '#999999';
                                @endphp

                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <!-- Step 1: Applied -->
                                        <td align="center" width="33%">
                                            <div style="width: 30px; height: 30px; line-height: 30px; border-radius: 50%; background-color: {{ $currentStep > 1 ? $colorCompleted : $colorActive }}; color: #ffffff; font-weight: bold; font-size: 12px; margin-bottom: 8px;">1</div>
                                            <div style="font-size: 10px; font-weight: bold; color: {{ $currentStep > 1 ? $colorCompleted : $colorActive }}; text-transform: uppercase;">Applied</div>
                                        </td>
                                        <!-- Step 2: Process -->
                                        <td align="center" width="33%">
                                            <div style="width: 30px; height: 30px; line-height: 30px; border-radius: 50%; background-color: {{ $currentStep == 2 ? $colorActive : ($currentStep > 2 ? $colorCompleted : $colorInactive) }}; color: {{ $currentStep >= 2 ? '#ffffff' : '#999999' }}; font-weight: bold; font-size: 12px; margin-bottom: 8px;">2</div>
                                            <div style="font-size: 10px; font-weight: bold; color: {{ $currentStep == 2 ? $colorActive : ($currentStep > 2 ? $colorCompleted : $textColor) }}; text-transform: uppercase;">Process</div>
                                        </td>
                                        <!-- Step 3: Decision -->
                                        <td align="center" width="33%">
                                            <div style="width: 30px; height: 30px; line-height: 30px; border-radius: 50%; background-color: {{ $currentStep == 3 ? ($status == 'rejected' ? $colorRejected : $colorActive) : $colorInactive }}; color: {{ $currentStep == 3 ? '#ffffff' : '#999999' }}; font-weight: bold; font-size: 12px; margin-bottom: 8px;">3</div>
                                            <div style="font-size: 10px; font-weight: bold; color: {{ $currentStep == 3 ? ($status == 'rejected' ? $colorRejected : $colorActive) : $textColor }}; text-transform: uppercase;">Decision</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 20px 35px 35px; border-top: 1px solid #eee;">
                            <p style="font-size: 11px; color: #aaa; margin: 0;">This is an automated notification from the <strong>Bintan Industrial Estate Recruitment System</strong>.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>