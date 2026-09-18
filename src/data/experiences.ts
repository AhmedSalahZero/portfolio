import type { Experience } from '@/types';

export const experiences: Experience[] = [
    {
        id: 1,
        company: 'Matrix Clouds',
        role: 'Full-Stack Developer',
        location: 'Maadi, Cairo',
        employment_type: 'Full-time',
        start_date: '2020-09-01',
        end_date: null,
        is_current: true,
        description:
            'Architect and deliver production SaaS platforms, enterprise finance suites, and mobile APIs with Laravel and Vue 3.',
        achievements: [
            'Architected Mnjz — a multi-tenant WhatsApp Business SaaS serving 200+ organizations, with team inbox, bulk campaigns, Flow Builder automation, AI replies, and subscription billing.',
            'Optimized Mnjz chat loading time by 92% (10s to under 0.8s) for clients with 13,000+ contacts via query optimization, MySQL indexing, and Redis caching.',
            'Built CashVero and Vero Analysis enterprise treasury/CFO platforms with Odoo ERP integration (XML/JSON-RPC) and bilingual dashboards.',
            'Performed a full Laravel 9→12 / PHP 8.0→8.4 migration, resolving 1000+ PHPStan/Larastan errors and enforcing PHPUnit coverage.',
        ],
        sort_order: 0,
    },
    {
        id: 2,
        company: 'The Tailors Dev',
        role: 'Backend & API Engineer',
        location: '6th of October City, Giza',
        employment_type: 'Full-time',
        start_date: '2020-09-01',
        end_date: null,
        is_current: true,
        description:
            'Built backends, mobile APIs, and integrations for ride-hailing, marketplace, and fintech products.',
        achievements: [
            'Developed Ladyes (Nawaem) back-end — a women-focused ride-hailing platform with geospatial driver matching, digital wallet, Firebase tracking, and PayFort payments.',
            'Built a multi-vendor e-commerce marketplace with JWT/Sanctum mobile API, vendor wallet system, Saudi ZATCA e-invoicing, and Aramex shipping integration.',
            'Integrated MyFatoorah, PayMob, and Stripe payment gateways; implemented Pusher broadcasting, Firebase FCM/Firestore, and an Arabic OCR pipeline (Tesseract + Google Vision API).',
        ],
        sort_order: 1,
    },
];
