<x-guest-layout>
    <div class="prism-scene" aria-hidden="true">
        <span class="prism-blob blob-1"></span>
        <span class="prism-blob blob-2"></span>
        <span class="prism-blob blob-3"></span>
        <span class="prism-grid"></span>
    </div>

    <div class="login-card">
        <div class="login-heading">
            <div class="heading-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
            </div>
            <p class="eyebrow">WELCOME BACKs</p>
            <h2>Sign in to continue</h2>
            <p class="login-subtitle">Enter your details to access your workspace.</p>
        </div>

        <x-auth-session-status class="form-notice success-notice" :status="session('status')" />
        @if (session('login_error'))
            <div class="form-notice error-notice">{{ session('login_error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="field-group">
                <label for="email">Email address</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@company.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="field-error" />
            </div>

            <div class="field-group">
                <div class="label-row"><label for="password">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                    <button class="password-toggle" type="button" aria-label="Show password" data-password-toggle>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/><circle cx="12" cy="12" r="2.5"/></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="field-error" />
            </div>

            <div class="remember-row">
                <label class="remember-label" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span class="custom-check"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m2 6 2.5 2.5L10 3"/></svg></span>
                    <span>Keep me signed in</span>
                </label>
            </div>

            <button class="sign-in-button" type="submit">
                <span class="btn-label">Sign in</span>
                <span class="btn-shine" aria-hidden="true"></span>
                <span aria-hidden="true" class="btn-arrow">→</span>
            </button>
        </form>
        <p class="secure-note"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3 5 6v5c0 4.3 2.9 8.3 7 10 4.1-1.7 7-5.7 7-10V6l-7-3Z"/><path d="m9 12 2 2 4-4"/></svg>Your connection is secure and encrypted.</p>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap');

        :root {
            --prism-violet: #7C3AED;
            --prism-indigo: #6366F1;
            --prism-pink: #EC4899;
            --prism-cyan: #22D3EE;
            --prism-ink: #1E1B2E;
            --prism-muted: #6B7280;
            --prism-glass-bg: rgba(255, 255, 255, 0.55);
            --prism-glass-border: rgba(255, 255, 255, 0.65);
            --prism-radius: 22px;
        }

        body {
            font-family: 'Inter', sans-serif;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ---------- Animated backdrop ---------- */
        .prism-scene {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            background: linear-gradient(160deg, #F5F3FF 0%, #EEF2FF 45%, #FDF4FF 100%);
        }

        .prism-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.55;
            animation: float 16s ease-in-out infinite;
        }

        .blob-1 {
            width: 480px;
            height: 480px;
            top: -120px;
            left: -100px;
            background: radial-gradient(circle at 30% 30%, var(--prism-violet), transparent 70%);
            animation-duration: 18s;
        }

        .blob-2 {
            width: 420px;
            height: 420px;
            bottom: -140px;
            right: -100px;
            background: radial-gradient(circle at 60% 40%, var(--prism-cyan), transparent 70%);
            animation-duration: 22s;
            animation-delay: -4s;
        }

        .blob-3 {
            width: 360px;
            height: 360px;
            top: 40%;
            left: 55%;
            background: radial-gradient(circle at 50% 50%, var(--prism-pink), transparent 70%);
            animation-duration: 20s;
            animation-delay: -9s;
        }

        .prism-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(124, 58, 237, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(124, 58, 237, 0.05) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: radial-gradient(circle at center, black, transparent 75%);
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.06); }
            66% { transform: translate(-25px, 20px) scale(0.96); }
        }

        /* ---------- Glass prism card ---------- */
        .login-card {
            position: relative;
            width: 100%;
            max-width: 440px;
            margin: 4vh auto;
            padding: 44px 38px 34px;
            border-radius: var(--prism-radius);
            background: var(--prism-glass-bg);
            border: 1px solid var(--prism-glass-border);
            box-shadow:
                0 8px 32px rgba(76, 29, 149, 0.12),
                0 1px 0 rgba(255, 255, 255, 0.8) inset,
                0 0 0 1px rgba(255, 255, 255, 0.2) inset;
            backdrop-filter: blur(22px) saturate(160%);
            -webkit-backdrop-filter: blur(22px) saturate(160%);
            animation: card-in 0.7s cubic-bezier(.16, 1, .3, 1) both;
            overflow: hidden;
        }

        .login-card::before {
            content: "";
            position: absolute;
            inset: 0;
            padding: 1px;
            border-radius: inherit;
            background: linear-gradient(135deg, var(--prism-violet), var(--prism-pink) 45%, var(--prism-cyan));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0.55;
            pointer-events: none;
        }

        .login-card::after {
            content: "";
            position: absolute;
            top: -60%;
            left: -60%;
            width: 220%;
            height: 220%;
            background: linear-gradient(115deg, transparent 40%, rgba(255, 255, 255, 0.35) 50%, transparent 60%);
            transform: rotate(8deg);
            animation: sheen 7s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes sheen {
            0% { transform: translateX(-30%) rotate(8deg); }
            50% { transform: translateX(30%) rotate(8deg); }
            100% { transform: translateX(-30%) rotate(8deg); }
        }

        @keyframes card-in {
            from { opacity: 0; transform: translateY(24px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ---------- Heading ---------- */
        .login-heading { text-align: center; margin-bottom: 28px; }

        .heading-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            color: #fff;
            background: linear-gradient(135deg, var(--prism-violet), var(--prism-indigo));
            box-shadow: 0 10px 24px rgba(99, 102, 241, 0.35);
            animation: icon-pop 0.6s 0.15s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        .heading-icon svg { width: 26px; height: 26px; }

        @keyframes icon-pop {
            from { opacity: 0; transform: scale(0.5) rotate(-8deg); }
            to { opacity: 1; transform: scale(1) rotate(0); }
        }

        .eyebrow {
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.16em;
            color: var(--prism-violet);
            margin: 0 0 6px;
        }

        .login-heading h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--prism-ink);
            margin: 0 0 8px;
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--prism-muted);
            margin: 0;
        }

        /* ---------- Notices ---------- */
        .form-notice {
            font-size: 13.5px;
            padding: 11px 14px;
            border-radius: 12px;
            margin-bottom: 18px;
            animation: card-in 0.4s ease both;
        }

        .success-notice {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #047857;
        }

        .error-notice {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #B91C1C;
        }

        /* ---------- Form ---------- */
        .login-form { display: flex; flex-direction: column; gap: 18px; }

        .field-group { display: flex; flex-direction: column; gap: 7px; }

        .field-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--prism-ink);
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .label-row a {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--prism-violet);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .label-row a:hover { color: var(--prism-pink); }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap svg {
            position: absolute;
            left: 14px;
            width: 18px;
            height: 18px;
            color: var(--prism-muted);
            pointer-events: none;
            transition: color 0.25s ease;
        }

        .input-wrap input {
            width: 100%;
            padding: 12.5px 14px 12.5px 42px;
            font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            color: var(--prism-ink);
            background: rgba(255, 255, 255, 0.75);
            border: 1.5px solid rgba(124, 58, 237, 0.14);
            border-radius: 13px;
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .input-wrap input::placeholder { color: #A5A3B5; }

        .input-wrap input:focus {
            border-color: var(--prism-violet);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.14);
        }

        .input-wrap:focus-within svg { color: var(--prism-violet); }

        .password-toggle {
            position: absolute;
            right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border: none;
            background: transparent;
            color: var(--prism-muted);
            cursor: pointer;
            border-radius: 8px;
            transition: color 0.2s ease, background 0.2s ease;
        }

        .password-toggle svg { width: 18px; height: 18px; }
        .password-toggle:hover { color: var(--prism-violet); background: rgba(124, 58, 237, 0.08); }

        .field-error { font-size: 12.5px; color: #DC2626; margin-top: 2px; }

        /* ---------- Remember me ---------- */
        .remember-row { display: flex; align-items: center; }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13.5px;
            color: var(--prism-ink);
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .custom-check {
            width: 19px;
            height: 19px;
            flex-shrink: 0;
            border-radius: 6px;
            border: 1.5px solid rgba(124, 58, 237, 0.35);
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: background 0.2s ease, border-color 0.2s ease, transform 0.15s ease;
        }

        .custom-check svg {
            width: 11px;
            height: 11px;
            opacity: 0;
            transform: scale(0.6);
            transition: opacity 0.15s ease, transform 0.15s ease;
        }

        .remember-label input:checked + .custom-check {
            background: linear-gradient(135deg, var(--prism-violet), var(--prism-indigo));
            border-color: transparent;
        }

        .remember-label input:checked + .custom-check svg { opacity: 1; transform: scale(1); }
        .remember-label input:focus-visible + .custom-check { outline: 2px solid var(--prism-violet); outline-offset: 2px; }

        /* ---------- Submit button ---------- */
        .sign-in-button {
            position: relative;
            margin-top: 6px;
            padding: 14px 20px;
            border: none;
            border-radius: 13px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, var(--prism-violet), var(--prism-indigo));
            box-shadow: 0 10px 24px rgba(99, 102, 241, 0.35);
            cursor: pointer;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .sign-in-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(99, 102, 241, 0.45);
        }

        .sign-in-button:active { transform: translateY(0); }

        .btn-arrow { transition: transform 0.25s ease; }
        .sign-in-button:hover .btn-arrow { transform: translateX(4px); }

        .btn-shine {
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(115deg, transparent, rgba(255, 255, 255, 0.45), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .sign-in-button:hover .btn-shine { left: 125%; }

        /* ---------- Secure note ---------- */
        .secure-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin: 22px 0 0;
            font-size: 12px;
            color: var(--prism-muted);
        }

        .secure-note svg { width: 14px; height: 14px; color: #10B981; }

        /* ---------- Responsive ---------- */
        @media (max-width: 480px) {
            .login-card {
                margin: 6vh 14px;
                padding: 34px 24px 26px;
                border-radius: 18px;
            }
            .login-heading h2 { font-size: 22px; }
            .prism-blob { filter: blur(50px); }
        }

        @media (prefers-reduced-motion: reduce) {
            .prism-blob, .login-card, .heading-icon, .login-card::after, .btn-shine {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    <script>
        document.querySelector('[data-password-toggle]')?.addEventListener('click', function () {
            const input = document.querySelector('#password');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        });
    </script>
</x-guest-layout>