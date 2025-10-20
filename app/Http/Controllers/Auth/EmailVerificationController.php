<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EmailVerificationController extends Controller
{
    /**
     * Register a new user and send OTP
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'name.required' => 'الاسم مطلوب',
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.email' => 'البريد الإلكتروني غير صحيح',
                'email.unique' => 'البريد الإلكتروني مستخدم من قبل',
                'password.required' => 'كلمة المرور مطلوبة',
                'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
                'password.confirmed' => 'تأكيد كلمة المرور غير مطابق',
            ]);

            // Create user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'is_verified' => false,
            ]);

            // Generate OTP
            $otp = rand(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();

            // Send OTP email
            try {
                Mail::to($user->email)->send(new VerifyEmailOtpMail($otp, $user->name));
                
                Log::info('OTP email sent successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'otp' => $otp
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'تم التسجيل بنجاح! تم إرسال كود التحقق إلى بريدك الإلكتروني.',
                        'email' => $user->email,
                        'user_id' => $user->id
                    ], 201);
                }

                return redirect()->route('verify.otp.form')->with([
                    'success' => 'تم التسجيل بنجاح! تم إرسال كود التحقق إلى بريدك الإلكتروني.',
                    'email' => $user->email
                ]);

            } catch (\Exception $e) {
                Log::error('Failed to send OTP email', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage()
                ]);

                // Delete user if email failed
                $user->delete();

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'فشل في إرسال كود التحقق. يرجى المحاولة مرة أخرى.',
                    ], 500);
                }

                return back()->withErrors(['email' => 'فشل في إرسال كود التحقق. يرجى المحاولة مرة أخرى.']);
            }

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'بيانات غير صحيحة',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'otp'   => 'required|string|size:6',
            ], [
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.email' => 'البريد الإلكتروني غير صحيح',
                'email.exists' => 'البريد الإلكتروني غير موجود',
                'otp.required' => 'كود التحقق مطلوب',
                'otp.size' => 'كود التحقق يجب أن يكون 6 أرقام',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'المستخدم غير موجود'
                    ], 404);
                }
                return back()->withErrors(['email' => 'المستخدم غير موجود']);
            }

            // Check if already verified
            if ($user->is_verified) {
                // If not logged in, log them in automatically
                if (!Auth::check()) {
                    Auth::login($user);
                }
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => '🎉 مرحباً بك مرة أخرى! سيتم توجيهك للموقع الآن.',
                        'redirect_url' => route('home'),
                        'already_verified' => true
                    ]);
                }
                return redirect()->route('home')->with('success', '🎉 مرحباً بك مرة أخرى في ملاك أوت ليت!');
            }

            // Verify OTP
            if ($user->otp_code === $request->otp && now()->lt($user->otp_expires_at)) {
                $user->is_verified = true;
                $user->otp_code = null;
                $user->otp_expires_at = null;
                $user->email_verified_at = now();
                $user->save();

                // Automatically log the user in
                Auth::login($user);

                Log::info('Email verified successfully and user logged in', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => '🎉 مرحباً بك في ملاك أوت ليت! تم التحقق من بريدك الإلكتروني بنجاح وسيتم توجيهك للموقع الآن.',
                        'redirect_url' => route('home'),
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email
                        ]
                    ]);
                }

                return redirect()->route('home')->with('success', '🎉 مرحباً بك في ملاك أوت ليت! تم التحقق من بريدك الإلكتروني بنجاح.');
            }

            // Invalid or expired OTP
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'كود التحقق غير صحيح أو منتهي الصلاحية'
                ], 400);
            }

            return back()->withErrors(['otp' => 'كود التحقق غير صحيح أو منتهي الصلاحية']);

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'بيانات غير صحيحة',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ], [
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.email' => 'البريد الإلكتروني غير صحيح',
                'email.exists' => 'البريد الإلكتروني غير موجود',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'المستخدم غير موجود'
                    ], 404);
                }
                return back()->withErrors(['email' => 'المستخدم غير موجود']);
            }

            if ($user->is_verified) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'البريد الإلكتروني محقق بالفعل'
                    ], 400);
                }
                return back()->withErrors(['email' => 'البريد الإلكتروني محقق بالفعل']);
            }

            // Generate new OTP
            $otp = rand(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();

            // Send OTP email
            try {
                Mail::to($user->email)->send(new VerifyEmailOtpMail($otp, $user->name));

                Log::info('OTP resent successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'تم إرسال كود التحقق مرة أخرى إلى بريدك الإلكتروني'
                    ]);
                }

                return back()->with('success', 'تم إرسال كود التحقق مرة أخرى إلى بريدك الإلكتروني');

            } catch (\Exception $e) {
                Log::error('Failed to resend OTP email', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage()
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'فشل في إرسال كود التحقق. يرجى المحاولة مرة أخرى.'
                    ], 500);
                }

                return back()->withErrors(['email' => 'فشل في إرسال كود التحقق. يرجى المحاولة مرة أخرى.']);
            }

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'بيانات غير صحيحة',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyForm(Request $request)
    {
        $email = $request->get('email') ?? session('email');
        return view('auth.verify-otp', compact('email'));
    }
}
