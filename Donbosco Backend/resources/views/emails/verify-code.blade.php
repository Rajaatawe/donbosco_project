<div dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}"
     style="font-family: sans-serif; text-align: {{ $lang == 'ar' ? 'right' : 'left' }}; padding: 20px; background-color: #f4f6f9;">

    <div style="background-color: #ffffff; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto;">
        <h2 style="color: #1f2937;">
            {{ __('emails.greeting', ['name' => $user->first_name], $lang) }}
        </h2>

        <p style="color: #4b5563; line-height: 1.6;">
            {{ __('emails.intro', [], $lang) }}
        </p>

        <div style="font-size: 32px; font-weight: bold; text-align: center; color: #2563eb; letter-spacing: 5px; margin: 30px 0; padding: 15px; border: 2px dashed #2563eb; border-radius: 8px;">
            {{ $code }}
        </div>

        <p style="text-align: center; color: #ef4444; font-size: 14px;">
            ⏳ {{ __('emails.expiry_notice', [], $lang) }}
        </p>

        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 30px 0;">

        <p style="font-size: 12px; color: #9ca3af;">
            {{ __('emails.ignore_msg', [], $lang) }}
        </p>
    </div>
</div>
