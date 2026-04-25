@extends('layouts.app')

@section('title', 'FAQs')

@push('styles')
    <style>
        .faq-hero {
            position: relative;
            overflow: hidden;
            padding: clamp(2rem, 4vw, 3.75rem) 0;
            background: linear-gradient(135deg, #fff7fb, #fdfdff 55%, #fffdf6);
        }

        .faq-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 88% 18%, rgba(240, 154, 182, 0.22), transparent 30%),
                radial-gradient(circle at 12% 86%, rgba(155, 184, 245, 0.2), transparent 30%);
            pointer-events: none;
        }

        .faq-hero::after {
            content: '';
            position: absolute;
            width: 340px;
            height: 340px;
            right: -120px;
            bottom: -160px;
            border-radius: 999px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.35), rgba(240, 154, 182, 0.08));
            border: 1px solid rgba(255, 255, 255, 0.35);
            filter: blur(0.3px);
            pointer-events: none;
        }

        .faq-hero-card,
        .faq-support-card {
            position: relative;
            z-index: 1;
            background: #fff;
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 24px;
            box-shadow: 0 22px 48px rgba(15, 23, 42, 0.08);
        }

        .faq-hero-card {
            padding: clamp(1.5rem, 3vw, 2.5rem);
        }

        .faq-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.85rem;
            color: #d36b8f;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .faq-intro {
            max-width: 56rem;
            color: #5f6b7a;
            line-height: 1.7;
        }

        .faq-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
            margin-top: 1rem;
        }

        .faq-meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
            color: #4b5563;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .faq-meta-chip strong {
            color: #111827;
            font-weight: 800;
        }

        .faq-jump-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin: 1.25rem 0 0;
            padding: 0;
            list-style: none;
        }

        .faq-jump-list a {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.55rem 0.9rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #374151;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .faq-jump-list a:hover {
            transform: translateY(-1px);
            background: #ffffff;
            border-color: #cfd8e3;
            box-shadow: 0 8px 14px rgba(15, 23, 42, 0.06);
        }

        .faq-section {
            padding: 0 0 1.75rem;
        }

        .faq-category {
            margin-bottom: 1.4rem;
        }

        .faq-category-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.9rem;
            color: #1f2937;
            font-size: 1.15rem;
            font-weight: 700;
        }

        .faq-category-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 1.75rem;
            height: 1.75rem;
            padding: 0 0.5rem;
            border-radius: 999px;
            background: linear-gradient(90deg, #f7d9e4, #e4eefc);
            color: #374151;
            font-size: 0.8rem;
            font-weight: 800;
        }

        .faq-item {
            background: #fff;
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            overflow: hidden;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .faq-item+.faq-item {
            margin-top: 0.85rem;
        }

        .faq-item summary {
            list-style: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.1rem;
            color: #111827;
            font-weight: 700;
            transition: background 0.2s ease;
        }

        .faq-item summary::-webkit-details-marker {
            display: none;
        }

        .faq-item summary::after {
            content: '+';
            width: 1.8rem;
            height: 1.8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #f3f4f6;
            color: #374151;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .faq-item[open] summary::after {
            content: '–';
            background: #111827;
            color: #fff;
        }

        .faq-item[open] {
            border-color: #d7e0eb;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        }

        .faq-item[open] summary {
            background: linear-gradient(180deg, #f9fbff, #ffffff);
        }

        .faq-answer {
            padding: 0 1.1rem 1.05rem;
            color: #4b5563;
            line-height: 1.75;
        }

        .faq-answer p:last-child {
            margin-bottom: 0;
        }

        .faq-answer strong {
            color: #1f2937;
        }

        .faq-support-card {
            padding: 1.4rem;
            background:
                radial-gradient(circle at top right, rgba(240, 154, 182, 0.09), transparent 32%),
                linear-gradient(145deg, #ffffff, #f9fbff);
        }

        .faq-support-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .faq-support-item {
            padding: 1rem;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .faq-support-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.06);
        }

        .faq-support-item span {
            display: block;
            color: #6b7280;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 0.35rem;
        }

        @media (max-width: 767.98px) {
            .faq-support-grid {
                grid-template-columns: 1fr;
            }

            .faq-item summary {
                align-items: flex-start;
            }

            .faq-category-title {
                font-size: 1.06rem;
            }

            .faq-hero-card,
            .faq-support-card {
                border-radius: 20px;
            }
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
                            'Every piece is hand-checked with care before it leaves our Nook. Metro cities usually take 8–12 days and the rest of India takes 10–14 days from the day of dispatch. You’ll get live tracking on WhatsApp and email. During monsoon or festive peaks, allow 1–2 extra days — we’ll keep you posted.',
                    ],
                    [
                        'question' => 'Do you ship internationally?',
                        'answer' =>
                            'We’re India-only for now, but going global is on our vision board. If you’d like us in your country, email mousmi@rivierakouture.com and you’ll be first to know when we launch worldwide.',
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
                        'question' => 'What if the size doesn’t fit or I change my mind?',
                        'answer' =>
                            'We offer a 5-day size exchange window from delivery. Conditions: unworn, unwashed, with tags intact, and free of perfume or makeup marks. We’ll arrange a doorstep pickup. Please note: we currently offer exchanges only, not refunds.',
                    ],
                    [
                        'question' => 'What if I receive a damaged or defective item?',
                        'answer' =>
                            'Rare, but we’ve got you. Share photos on WhatsApp within 24 hours of delivery and we’ll arrange a free replacement plus pickup of the original piece.',
                    ],
                    [
                        'question' => 'Can I cancel my order?',
                        'answer' =>
                            'Yes, within 2 hours of placing it. After that, your piece moves into stitching or quality check and we’re unable to cancel. Message us on WhatsApp immediately if you need to.',
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
                            'Completely. We use Razorpay and CC Avenue with bank-grade encryption. We never store your card details. UPI, Netbanking, and wallets are also accepted.',
                    ],
                    [
                        'question' => 'I didn’t receive an order confirmation email — what should I do?',
                        'answer' =>
                            'Please check your spam or promotions folder first. If it’s not there, WhatsApp us your name and order number at +91-9811164835. We’ll confirm your order within 10 minutes.',
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
                            'We practice slow fashion: small batches, handloom whenever possible, plastic-free packaging, and a tree planted for every prepaid order. We’re not perfect yet, but we’re committed and transparent. Read more on our Sustainability page.',
                    ],
                    [
                        'question' => 'How can I speak to a real person?',
                        'answer' =>
                            'We’re here 10am–6pm, Monday to Saturday. WhatsApp: +91-9811164835. Email: mousmi@rivierakouture.com — replies within 4 hours. Instagram DM: @lilysnook.',
                    ],
                ],
            ],
        ];

        $faqItemCount = collect($faqSections)->sum(fn($section) => count($section['items']));
    @endphp

    <section class="faq-hero">
        <div class="container">
            <div class="faq-hero-card">
                <div class="faq-kicker">Frequently Asked Questions</div>
                <h1 class="page-title mb-3">Lily’s Nook FAQ</h1>
                <p class="faq-intro mb-0">Your nook, your rules. A little clarity goes a long way. Find quick answers about
                    shipping, fit, exchanges, care, payments, and how to reach us.</p>

                <div class="faq-meta">
                    <span class="faq-meta-chip"><strong>{{ count($faqSections) }}</strong> Categories</span>
                    <span class="faq-meta-chip"><strong>{{ $faqItemCount }}</strong> Questions</span>
                    <span class="faq-meta-chip">Support: 10am–6pm, Mon–Sat</span>
                </div>

                <ul class="faq-jump-list">
                    @foreach ($faqSections as $section)
                        <li><a href="#{{ $section['id'] }}">{{ $section['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="faq-section padding-large">
        <div class="container">
            @foreach ($faqSections as $section)
                <div class="faq-category" id="{{ $section['id'] }}">
                    <h2 class="faq-category-title">
                        <span>{{ $section['title'] }}</span>
                        <span class="faq-category-count">{{ count($section['items']) }}</span>
                    </h2>

                    @foreach ($section['items'] as $item)
                        <details class="faq-item" {{ $loop->first && $loop->parent->first ? 'open' : '' }}>
                            <summary>{{ $item['question'] }}</summary>
                            <div class="faq-answer">
                                <p>{{ $item['answer'] }}</p>
                            </div>
                        </details>
                    @endforeach
                </div>
            @endforeach

            <div class="faq-support-card mt-4">
                <h2 class="faq-category-title mb-3">Need to speak to someone?</h2>
                <div class="faq-support-grid">
                    <div class="faq-support-item">
                        <span>WhatsApp</span>
                        <a href="https://wa.me/919811164835" target="_blank" rel="noopener">+91-9811164835</a>
                    </div>
                    <div class="faq-support-item">
                        <span>Email</span>
                        <a href="mailto:mousmi@rivierakouture.com">mousmi@rivierakouture.com</a>
                    </div>
                    <div class="faq-support-item">
                        <span>Support Hours</span>
                        <p class="mb-0">10am–6pm, Monday to Saturday</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
