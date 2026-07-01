<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\AdminContactNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // 1. Validasi data dari form
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required'
        ]);

        // 2. Verifikasi reCAPTCHA ke Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('NOCAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('reCAPTCHA verification failed. Please try again.', 422);
            }
            return redirect()->back()->withErrors(['captcha' => 'reCAPTCHA verification failed.'])->withInput();
        }

        // 3. Simpan pesan ke database
        $contact = Contact::create($request->except('g-recaptcha-response'));

        // 3. Kirim Email Notifikasi
        // Mengambil email admin dari config (lebih aman daripada env() langsung di controller)
        $adminEmail = config('mail.from.address'); 

        try {
            Mail::to($adminEmail)->send(new AdminContactNotification($contact));
        } catch (\Exception $e) {
            // Jika email gagal terkirim (misal karena jaringan), pesan tetap tersimpan di database
            Log::error('Email Kontak Gagal Dikirim: ' . $e->getMessage() . ' | Data: ' . json_encode($request->all()));
        }

        // 4. Kembalikan respons sesuai dengan cara form dikirim
        if ($request->ajax() || $request->wantsJson()) {
            return response('OK');
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully. Thank you for contacting us!');
    }
}