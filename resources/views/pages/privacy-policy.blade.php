@extends('layouts.app')

@section('title', 'Privacy Policy - Lilly\'s Nook')

@push('styles')
    <style>
        .policy-hero {
            position: relative;
            padding: 5rem 0 3rem;
            background: linear-gradient(135deg, #f9fbff 0%, #fef3f7 100%);
            overflow: hidden;
        }

        .policy-hero::before,
        .policy-hero::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .policy-hero::before {
            top: -100px;
            left: -80px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(85, 107, 47, 0.08) 0%, transparent 70%);
        }

        .policy-hero::after {
            bottom: -120px;
            right: -90px;
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, rgba(244, 143, 177, 0.18) 0%, transparent 70%);
        }

        .policy-card {
            position: relative;
            z-index: 1;
            max-width: 940px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.86);
            border: 1px solid rgba(17, 24, 39, 0.06);
            border-radius: 28px;
            padding: 2.5rem;
            box-shadow: 0 20px 45px rgba(17, 24, 39, 0.06);
            backdrop-filter: blur(8px);
        }

        .policy-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.9rem;
            border-radius: 999px;
            background: rgba(85, 107, 47, 0.12);
            color: #556b2f;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .policy-title {
            font-size: clamp(2.2rem, 4vw, 3.6rem);
            line-height: 1.08;
            color: #1f2937;
            margin: 1rem 0 1rem;
        }

        .policy-lead {
            font-size: 1.05rem;
            color: #5b6472;
            line-height: 1.75;
            max-width: 780px;
        }

        .policy-content {
            padding: 0 0 5rem;
            margin-top: -0.5rem;
        }

        .policy-section {
            background: #ffffff;
            border: 1px solid #eef1f5;
            border-radius: 22px;
            padding: 2rem;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.03);
            height: 100%;
        }

        .policy-section h2,
        .policy-section h3 {
            color: #1f2937;
        }

        .policy-section p,
        .policy-section li {
            color: #5b6472;
            line-height: 1.8;
        }

        .policy-bullet-list {
            padding-left: 1.1rem;
            margin-bottom: 0;
        }

        .policy-highlight {
            background: linear-gradient(135deg, #556b2f, #3f4f24);
            color: #fff;
            border-radius: 22px;
            padding: 2rem;
            box-shadow: 0 18px 36px rgba(85, 107, 47, 0.2);
        }

        .policy-highlight p,
        .policy-highlight li {
            color: rgba(255, 255, 255, 0.92);
        }

        .policy-note {
            border-left: 4px solid var(--primary-color);
            background: #fff7fa;
            border-radius: 16px;
            padding: 1rem 1.2rem;
            color: #6b7280;
        }
    </style>
@endpush

@section('content')
    @php
        $supportEmail = config('mail.from.address', 'lilysnook05@gmail.com');
    @endphp

    <section class="policy-hero">
        <div class="container">
            <div class="policy-card">
                <span class="policy-eyebrow">Privacy Policy</span>
                <h1 class="policy-title">Your privacy matters to us.</h1>
                <p class="policy-lead mb-0">
                    This policy explains how Lily's Nook collects, uses, stores, and protects your personal information.
                    We keep data handling transparent, secure, and limited to what is necessary to serve your order and
                    support experience.
                </p>
            </div>
        </div>
    </section>

    <section class="policy-content">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-8">
                    <div class="policy-section mb-4">
                        <h2 class="h3 mb-3">Information we collect</h2>
                        <p>We may collect the following information when you interact with our website or place an order:
                        </p>
                        <ul class="policy-bullet-list">
                            <li>Name, email address, phone number, and shipping address</li>
                            <li>Order details, payment status, and delivery information</li>
                            <li>Messages sent through contact forms, newsletters, or customer support</li>
                            <li>Technical data such as browser type, device information, and usage analytics</li>
                        </ul>
                    </div>

                    <div class="policy-section mb-4">
                        <h3 class="h4 mb-3">How we use your information</h3>
                        <ul class="policy-bullet-list mb-0">
                            <li>To process and fulfill your orders</li>
                            <li>To send order confirmations, shipping updates, and support replies</li>
                            <li>To improve our website, products, and customer experience</li>
                            <li>To send marketing emails only when you have opted in</li>
                            <li>To comply with legal, tax, and security obligations</li>
                        </ul>
                    </div>

                    <div class="policy-section mb-4">
                        <h3 class="h4 mb-3">How we protect your data</h3>
                        <p>
                            We use reasonable administrative, technical, and organizational safeguards to protect your data
                            from unauthorized access, loss, misuse, or disclosure. Access to customer information is limited
                            to team members and service providers who need it to perform their duties.
                        </p>
                        <p class="mb-0">
                            Payment information is handled by trusted third-party payment processors. We do not
                            intentionally
                            store full card details on our servers.
                        </p>
                    </div>

                    <div class="policy-section">
                        <h3 class="h4 mb-3">Your choices and rights</h3>
                        <ul class="policy-bullet-list mb-0">
                            <li>You may request access to the personal information we hold about you</li>
                            <li>You may ask us to correct inaccurate details</li>
                            <li>You may unsubscribe from promotional emails at any time</li>
                            <li>You may contact us to request deletion where permitted by law</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="policy-highlight">
                        <h3 class="h4 mb-3">What we do not do</h3>
                        <ul class="policy-bullet-list mb-4">
                            <li>We do not sell your personal information</li>
                            <li>We do not share data with unrelated advertisers</li>
                            <li>We do not store full card details on our servers</li>
                        </ul>
                        <div class="policy-note mb-3">
                            Cookies may be used for login sessions, cart persistence, analytics, and basic site
                            functionality.
                        </div>
                        <p class="mb-0">
                            If you have questions about this policy, email us at <a class="text-white"
                                href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
