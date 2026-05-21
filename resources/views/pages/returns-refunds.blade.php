@extends('layouts.app')

@section('title', 'Returns & Refunds - Lilly\'s Nook')

@push('styles')
    <style>
        .policy-hero {
            position: relative;
            padding: 5rem 0 3rem;
            background: linear-gradient(135deg, #fffaf7 0%, #fff1f4 100%);
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
            top: -120px;
            right: -80px;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(244, 143, 177, 0.16) 0%, transparent 70%);
        }

        .policy-hero::after {
            bottom: -140px;
            left: -100px;
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, rgba(85, 107, 47, 0.08) 0%, transparent 70%);
        }

        .policy-card {
            position: relative;
            z-index: 1;
            max-width: 920px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.84);
            border: 1px solid rgba(244, 143, 177, 0.14);
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
            background: rgba(244, 143, 177, 0.12);
            color: #b04c6e;
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
            max-width: 760px;
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
            background: linear-gradient(135deg, #111827, #374151);
            color: #fff;
            border-radius: 22px;
            padding: 2rem;
            box-shadow: 0 18px 36px rgba(17, 24, 39, 0.18);
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
                <span class="policy-eyebrow">Returns & Refunds</span>
                <h1 class="policy-title">Clear, final-sale terms with one exception for genuine issues.</h1>
                <p class="policy-lead mb-0">
                    Our products are prepared with care, which is why we do not accept returns or refunds for change of
                    mind, sizing preference, or order cancellation after processing.
                </p>
            </div>
        </div>
    </section>

    <section class="policy-content">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-7">
                    <div class="policy-section mb-4">
                        <h2 class="h3 mb-3">Final sale policy</h2>
                        <p>
                            Every order placed on Lily's Nook is treated as a final sale once confirmed and processed.
                            We do not provide returns, refunds, or exchanges for items that have been shipped or delivered.
                        </p>
                        <p class="mb-0">
                            This helps us keep pricing fair, quality control consistent, and operations efficient for all
                            customers.
                        </p>
                    </div>

                    <div class="policy-section mb-4">
                        <h3 class="h4 mb-3">Not eligible for return or refund</h3>
                        <ul class="policy-bullet-list mb-0">
                            <li>Change of mind after purchase</li>
                            <li>Incorrect size selection</li>
                            <li>Preference changes in color, fit, or style</li>
                            <li>Order cancellation after processing or dispatch</li>
                            <li>Used, washed, altered, or customer-damaged items</li>
                        </ul>
                    </div>

                    <div class="policy-section">
                        <h3 class="h4 mb-3">Damaged, defective, or incorrect items</h3>
                        <p>
                            If your parcel arrives damaged, defective, or incorrect, contact us within 24 hours of delivery
                            at <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a> with your order number and clear
                            photos of the issue.
                        </p>
                        <p class="mb-0">
                            We will review the request and, if approved, arrange a suitable resolution at our discretion.
                            Requests submitted after the reporting window may not be accepted.
                        </p>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="policy-highlight">
                        <h3 class="h4 mb-3">Quick summary</h3>
                        <ul class="policy-bullet-list mb-4">
                            <li>No refunds for change of mind</li>
                            <li>No returns or exchanges after dispatch</li>
                            <li>Report delivery issues within 24 hours</li>
                            <li>Keep the original packaging until inspection is complete</li>
                        </ul>
                        <div class="policy-note mb-3">
                            Please inspect your parcel as soon as it arrives so any genuine issue can be reviewed quickly.
                        </div>
                        <p class="mb-0">
                            For any order concern, email <a class="text-white"
                                href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
