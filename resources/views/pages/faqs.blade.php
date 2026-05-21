@extends('layouts.app')

@section('title', 'FAQs')

@push('styles')
    <style>
        .faq-hero {
            position: relative;
            padding: 5rem 0;
            background: linear-gradient(135deg, #fff7fb, #fef4f8);
            border-bottom: 1px solid rgba(240, 154, 182, 0.2);
            overflow: hidden;
        }

        .faq-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(244, 143, 177, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .faq-hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(155, 184, 245, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .faq-header-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }

        .faq-header-content h1 {
            font-size: 3rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 1.5rem;
        }

        .faq-header-content p {
            font-size: 1.1rem;
            color: #718096;
            line-height: 1.6;
        }

        .faq-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 2rem;
            position: relative;
            z-index: 2;
        }

        .faq-nav a {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: white;
            color: #4a5568;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #edf2f7;
            transition: all 0.3s ease;
        }

        .faq-nav a:hover {
            transform: translateY(-2px);
            background: var(--primary-color);
            color: white;
            box-shadow: 0 6px 12px rgba(244, 143, 177, 0.3);
            border-color: var(--primary-color);
        }

        .faq-container {
            padding: 4rem 0;
            background: #ffffff;
        }

        .faq-section {
            margin-bottom: 3.5rem;
        }

        .faq-section-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 1.5rem;
            color: #2d3748;
        }

        .faq-section-title .badge {
            font-size: 0.9rem;
            padding: 0.4em 0.8em;
            background: var(--primary-color);
        }

        .accordion-item {
            border: none;
            background: transparent;
            margin-bottom: 1rem;
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .accordion-item:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        .accordion-button {
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: #2d3748;
            background: #ffffff;
            border-radius: 12px !important;
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) {
            color: var(--primary-color);
            background: #fffcfdfa;
            border-bottom: 1px solid #f7fafc;
        }

        .accordion-button::after {
            background-size: 1.25rem;
            transition: transform 0.3s ease;
        }

        .accordion-body {
            padding: 1.25rem 1.5rem;
            color: #4a5568;
            line-height: 1.7;
            background: #ffffff;
        }

        .support-box {
            background: linear-gradient(145deg, #ffffff, #f7fafc);
            border: 1px solid #edf2f7;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02);
            margin-top: 3rem;
        }

        .support-box h3 {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1.5rem;
        }

        .support-box .contact-method {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .support-box .contact-method:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .contact-method svg {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .contact-method strong {
            display: block;
            margin-bottom: 0.2rem;
            color: #2d3748;
        }

        .contact-method span {
            color: #718096;
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    @php
        $faqSections = [
            [
                'id' => 'orders-shipping',
                'title' => 'Orders & Shipping',
                'items' => [
                    [
                        'question' => 'How long will my order take to arrive?',
                        'answer' =>
                            'Every piece is hand-checked with care before it leaves our Nook. Metro cities usually take 8–12 days and the rest of India takes 10–14 days from the day of dispatch. You’ll get live tracking via email. During monsoon or festive peaks, allow 1–2 extra days — we’ll keep you posted.',
                    ],
                    [
                        'question' => 'Do you ship internationally?',
                        'answer' =>
                            'We’re India-only for now, but going global is on our vision board. If you’d like us in your country, send an email to our support team and you’ll be first to know when we launch worldwide.',
                    ],
                    [
                        'question' => 'Is Cash on Delivery available?',
                        'answer' =>
                            'We’re prepaid-only right now. It helps us ship faster, avoid returns, and plant a tree with every order.',
                    ],
                    [
                        'question' => 'What are the shipping charges?',
                        'answer' =>
                            'Shipping is calculated at checkout based on your location and order value. All shipments are sent via trusted courier partners with end-to-end tracking.',
                    ],
                ],
            ],
            [
                'id' => 'sizing-fit',
                'title' => 'Sizing & Fit',
                'items' => [
                    [
                        'question' => 'What if I’m between two sizes?',
                        'answer' =>
                            'Choose comfort and size up. Lily’s Nook silhouettes are designed to feel easy and breathable, and most customers find the relaxed fit beautifully comfortable. Need help? Our Size Guide has detailed measurements for every style.',
                    ],
                    [
                        'question' => 'Will my garment shrink after washing?',
                        'answer' =>
                            'All our handloom cotton, mulmul, and linen fabrics are pre-washed and pre-shrunk. Expect less than 3% shrinkage, already accounted for in sizing. For longevity: cold wash, gentle cycle, dry in shade.',
                    ],
                    [
                        'question' => 'What about lengths for petite or tall frames?',
                        'answer' =>
                            'Exact garment lengths are listed on each product page. Most dresses include a 2-inch in-seam allowance for easy alterations. Tall? Browse styles marked “Tall-Friendly” for extra length.',
                    ],
                ],
            ],
            [
                'id' => 'exchanges-cancellations',
                'title' => 'Exchanges & Cancellations',
                'items' => [
                    [
                        'question' => 'What if I receive a damaged or defective item?',
                        'answer' =>
                            'Rare, but we’ve got you. Share photos via email within 24 hours of delivery and we’ll arrange a free replacement plus pickup of the original piece.',
                    ],
                    [
                        'question' => 'Can I cancel my order?',
                        'answer' =>
                            'Yes, within 2 hours of placing it. After that, your piece moves into stitching or quality check and we’re unable to cancel. Email us immediately if you need to.',
                    ],
                ],
            ],
            [
                'id' => 'fabric-care',
                'title' => 'Fabric, Care & Features',
                'items' => [
                    [
                        'question' => 'What fabrics does Lily’s Nook use?',
                        'answer' =>
                            'Only what feels good on skin and soul. Each product page lists the exact fabric — Handloom Cotton, Mulmul, Linen, Rayon Slub, Silk, Brocade, and select imported textiles. If it’s blended or special, we’ll tell you upfront.',
                    ],
                    [
                        'question' => 'Will the colors bleed or fade?',
                        'answer' =>
                            'We use azo-free, skin-safe dyes on all handloom fabrics. For the first two washes: hand-wash separately in cold water with mild detergent. A 15-minute salt soak helps set the color. Thereafter, machine wash gentle and dry inside-out in shade.',
                    ],
                    [
                        'question' => 'Do your outfits have pockets?',
                        'answer' =>
                            'When design allows, absolutely. We believe pockets are a love language. Check the “Features” section on each product page for “Functional pockets”.',
                    ],
                    [
                        'question' => 'Are any fabrics sheer?',
                        'answer' =>
                            'Light mulmul and white cottons can be delicately sheer. We mention this in the description and recommend a slip or camisole. Many styles come with a matching inner attached — details are on the product page.',
                    ],
                ],
            ],
            [
                'id' => 'payments-security',
                'title' => 'Payments & Security',
                'items' => [
                    [
                        'question' => 'Is my payment information safe?',
                        'answer' =>
                            'Completely. We use highly secure payment gateways with bank-grade encryption. We never store your card details. UPI, Netbanking, and wallets are also accepted.',
                    ],
                    [
                        'question' => 'I didn’t receive an order confirmation email — what should I do?',
                        'answer' =>
                            'Please check your spam or promotions folder first. If it’s not there, email us your name and order details. We’ll confirm your order promptly.',
                    ],
                ],
            ],
            [
                'id' => 'about-lilys-nook',
                'title' => 'About Lily’s Nook',
                'items' => [
                    [
                        'question' => 'Why the name “Lily’s Nook”?',
                        'answer' =>
                            'Because every woman and child deserves a nook — a corner of comfort that belongs to her. Lily stands for softness and quiet strength. Our clothing is meant to feel like that: easy, honest, and entirely yours.',
                    ],
                    [
                        'question' => 'Do you offer custom sizing or alterations?',
                        'answer' =>
                            'Not for standard orders, to ensure quick dispatch. However, select styles offer “Custom Length Available” for minor sleeve or hem adjustments. Have a special request? Email us — we’ll do our best.',
                    ],
                    [
                        'question' => 'How sustainable is Lily’s Nook?',
                        'answer' =>
                            'We practice slow fashion: small batches, handloom whenever possible, plastic-free packaging, and a tree planted for every prepaid order. We’re not perfect yet, but we’re committed and transparent.',
                    ],
                    [
                        'question' => 'How can I speak to a real person?',
                        'answer' =>
                            'We’re here 10am–6pm, Monday to Saturday. Email us at ' .
                            ($contactEmail ?? config('mail.from.address', 'lilysnook05@gmail.com')) .
                            ' — replies usually within 4 hours. Or drop us a direct message on Instagram @lilysnook.',
                    ],
                ],
            ],
        ];
    @endphp

    <section class="faq-hero">
        <div class="container">
            <div class="faq-header-content">
                <h1 class="font-playfair">How can we help you?</h1>
                <p>Your nook, your rules. A little clarity goes a long way. Find quick answers about shipping, fit,
                    exchanges, care, and how to reach us.</p>
                <div class="faq-nav">
                    @foreach ($faqSections as $section)
                        <a href="#{{ $section['id'] }}">{{ $section['title'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="faq-container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @foreach ($faqSections as $index => $section)
                        <div class="faq-section" id="{{ $section['id'] }}">
                            <h2 class="faq-section-title font-playfair">
                                {{ $section['title'] }}
                                <span class="badge rounded-pill">{{ count($section['items']) }}</span>
                            </h2>

                            <div class="accordion" id="accordion-{{ $section['id'] }}">
                                @foreach ($section['items'] as $itemIndex => $item)
                                    @php
                                        $itemId = 'collapse-' . $index . '-' . $itemIndex;
                                    @endphp
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button {{ $index == 0 && $itemIndex == 0 ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#{{ $itemId }}"
                                                aria-expanded="{{ $index == 0 && $itemIndex == 0 ? 'true' : 'false' }}">
                                                {{ $item['question'] }}
                                            </button>
                                        </h2>
                                        <div id="{{ $itemId }}"
                                            class="accordion-collapse collapse {{ $index == 0 && $itemIndex == 0 ? 'show' : '' }}"
                                            data-bs-parent="#accordion-{{ $section['id'] }}">
                                            <div class="accordion-body">
                                                {{ $item['answer'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- Support Box -->
                    <div class="support-box">
                        <h3 class="font-playfair">Still have questions?</h3>
                        <p class="text-muted mb-4">Can't find the answer you're looking for? Please reach out to us.</p>
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <a href="mailto:{{ $contactEmail ?? config('mail.from.address', 'lilysnook05@gmail.com') }}"
                                class="contact-method">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <strong>Email Support</strong>
                                <span>{{ $contactEmail ?? config('mail.from.address', 'lilysnook05@gmail.com') }}</span>
                            </a>
                            <div class="contact-method" style="cursor: default; pointer-events: none;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <strong>Support Hours</strong>
                                <span>10am–6pm, Mon-Sat</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
