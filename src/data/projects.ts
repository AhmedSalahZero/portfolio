import type { Project } from '@/types';
import { skillsByName } from './skills';

function project(
    id: number,
    data: Omit<Project, 'id' | 'skills' | 'images' | 'cover_image' | 'repo_url'> & {
        skillNames: string[];
        cover_image?: string | null;
        repo_url?: string | null;
    },
): Project {
    const { skillNames, ...rest } = data;
    const skills = skillsByName(skillNames);

    return {
        ...rest,
        id,
        cover_image: data.cover_image ?? null,
        repo_url: data.repo_url ?? null,
        images: [],
        skills,
        skill_ids: skills.map((item) => item.id),
    };
}

export const projects: Project[] = [
    project(1, {
        title: 'Mnjz',
        slug: 'mnjz',
        tagline: 'Multi-tenant WhatsApp Business SaaS serving 200+ organizations.',
        category: 'SaaS & Automation',
        role: 'Full-Stack Developer',
        client: 'Matrix Clouds',
        year: 2025,
        is_featured: true,
        is_published: true,
        sort_order: 0,
        live_url: 'https://app.mnjz.net',
        summary:
            'A multi-tenant WhatsApp Business SaaS platform for customer engagement at scale — real-time team inbox, bulk campaign engine, visual Flow Builder automation, AI-assisted replies, subscription billing, and REST APIs for mobile integrations.',
        problem:
            'Businesses needed a single platform to manage WhatsApp customer conversations across large teams, run bulk marketing campaigns, and automate replies — all while isolating data for hundreds of separate organizations on shared infrastructure.',
        solution:
            'I architected a multi-tenant Laravel + Vue 3 (Inertia.js/TypeScript) platform on top of the WhatsApp Cloud API, with a real-time team inbox, a bulk campaign engine, a visual Flow Builder for no-code automation, AI-assisted replies via OpenAI, subscription billing, and versioned REST APIs for mobile clients. I heavily optimized read paths for large accounts.',
        outcome:
            'A production SaaS serving 200+ organizations. I optimized chat loading time by 92% (from ~10s to under 0.8s) for clients with 13,000+ contacts through query optimization, unused-column removal, MySQL indexing, and Redis caching.',
        highlights: [
            'Multi-tenant architecture isolating data for 200+ organizations on shared infrastructure.',
            'Real-time team inbox with Pusher broadcasting and Firebase FCM push notifications.',
            'Bulk campaign engine and visual Flow Builder for no-code conversation automation.',
            'AI-assisted replies powered by OpenAI, plus subscription billing and mobile REST APIs.',
            'Chat load time cut by 92% (10s → <0.8s) for accounts with 13,000+ contacts.',
        ],
        metrics: [
            { label: 'Organizations', value: '200+' },
            { label: 'Chat Speed-up', value: '92%' },
            { label: 'Max Contacts', value: '13,000+' },
            { label: 'Real-time', value: 'Yes' },
        ],
        skillNames: [
            'Laravel',
            'PHP',
            'Vue 3',
            'Inertia.js',
            'TypeScript',
            'MySQL',
            'Redis',
            'Real-time / WebSockets',
            'WhatsApp Cloud API',
            'OpenAI API',
            'Firebase',
            'REST API Design',
        ],
    }),
    project(2, {
        title: 'CashVero',
        slug: 'cashvero',
        tagline: 'Enterprise treasury and cash-flow management system with Odoo ERP integration.',
        category: 'Enterprise Finance',
        role: 'Full-Stack Developer',
        client: 'Evoqas',
        year: 2025,
        is_featured: true,
        is_published: true,
        sort_order: 1,
        live_url: 'https://cashvero.evoqas.com',
        summary:
            'An enterprise-grade treasury platform managing loans, letters of credit/guarantee, deposits, and cash-flow operations, with bidirectional Odoo ERP sync and bilingual (EN/AR) dashboards.',
        problem:
            'A dedicated enterprise client needed to consolidate complex treasury operations — loans, LC/LG, deposits, and cash positions — into one system that stayed in sync with their Odoo ERP and served both Arabic and English users.',
        solution:
            'I built a Laravel + Vue treasury platform covering 10+ financial modules, integrated with Odoo ERP over XML/JSON-RPC for bidirectional data sync, with role-based access control and bilingual dashboards. Quality was enforced with PHPStan/Larastan static analysis and a GitHub Actions CI/CD pipeline.',
        outcome:
            'Deployed for a dedicated enterprise client with full ongoing maintenance, replacing fragmented spreadsheets with a single, auditable source of truth for treasury operations.',
        highlights: [
            '10+ financial modules: loans, LC/LG, deposits, and cash-flow management.',
            'Bidirectional Odoo ERP integration over XML/JSON-RPC.',
            'Bilingual (EN/AR) dashboards with role-based access control.',
            'Static analysis (PHPStan/Larastan) and GitHub Actions CI/CD.',
        ],
        metrics: [
            { label: 'Finance Modules', value: '10+' },
            { label: 'ERP Sync', value: 'Odoo' },
            { label: 'Languages', value: 'EN / AR' },
        ],
        skillNames: [
            'Laravel',
            'PHP',
            'Vue 3',
            'MySQL',
            'Odoo ERP',
            'PHPStan / Larastan',
            'CI/CD Pipelines',
            'Query Optimization',
        ],
    }),
    project(3, {
        title: 'Vero Analysis',
        slug: 'vero-analysis',
        tagline: 'Multi-client financial analysis platform serving 20+ clients with Odoo ERP sync.',
        category: 'Enterprise Finance',
        role: 'Full-Stack Developer',
        client: 'Evoqas',
        year: 2025,
        is_featured: true,
        is_published: true,
        sort_order: 2,
        live_url: null,
        summary:
            'A multi-client financial analysis platform serving 20+ clients, providing cash-flow, aging, and forecasting dashboards backed by bidirectional Odoo ERP synchronization, with role-based access and a bilingual (EN/AR) interface.',
        problem:
            'Unlike CashVero (a single-tenant treasury system for one dedicated enterprise), the business needed a platform that could onboard many clients at once and give each of them financial analysis dashboards kept in sync with their Odoo ERP data.',
        solution:
            'I built a Laravel + Vue platform that serves 20+ clients from a shared codebase, with bidirectional Odoo ERP sync (XML/JSON-RPC), cash-flow/aging/forecasting dashboards, RBAC, and a bilingual (EN/AR) UI. It shares foundations with CashVero but is designed for multi-client scale rather than a single dedicated deployment.',
        outcome:
            'A scalable analysis product adopted by 20+ clients, turning raw ERP data into actionable cash-flow, aging, and forecasting insights.',
        highlights: [
            "Multi-client platform serving 20+ clients (vs. CashVero's single dedicated deployment).",
            'Bidirectional Odoo ERP synchronization over XML/JSON-RPC.',
            'Cash-flow, aging, and forecasting dashboards.',
            'Role-based access control and bilingual (EN/AR) interface.',
        ],
        metrics: [
            { label: 'Clients Served', value: '20+' },
            { label: 'ERP Sync', value: 'Odoo' },
            { label: 'Languages', value: 'EN / AR' },
        ],
        skillNames: [
            'Laravel',
            'PHP',
            'Vue 3',
            'MySQL',
            'Odoo ERP',
            'PHPStan / Larastan',
            'CI/CD Pipelines',
            'Query Optimization',
        ],
    }),
    project(4, {
        title: 'CFO Tools',
        slug: 'cfo-tools',
        tagline: 'Financial feasibility SaaS: IRR/NPV modeling, S-curve planning, and investor-ready reports.',
        category: 'Enterprise Finance',
        role: 'Full-Stack Developer',
        client: 'Evoqas',
        year: 2025,
        is_featured: true,
        is_published: true,
        sort_order: 3,
        live_url: 'https://cfostools.evoqas.com',
        summary:
            'A financial feasibility and CFO tooling SaaS for the hospitality and entertainment sector — IRR/NPV/payback engines, S-curve construction planning, revenue forecasting, loan structuring, and investor-ready reports with Excel/PDF export.',
        problem:
            'Hospitality and entertainment operators needed to model project feasibility — forecasting revenue across rooms, F&B, and gaming, structuring loans, and producing investor-ready financial reports — without stitching together fragile spreadsheets.',
        solution:
            'Part of the Vero Analysis suite serving 20+ clients, I built feasibility engines for IRR, NPV, and payback, S-curve construction planning, and multi-stream revenue forecasting (rooms, F&B, gaming), plus loan structuring and Excel/PDF export for investor-ready reports.',
        outcome:
            'A reusable feasibility SaaS that turns complex financial modeling into repeatable, exportable analyses, serving 20+ clients across the Vero Analysis platform.',
        highlights: [
            'IRR / NPV / payback feasibility engines.',
            'S-curve construction planning and multi-stream revenue forecasting (rooms, F&B, gaming).',
            'Loan structuring and investor-ready financial reports.',
            'Excel and PDF export of full financial models.',
        ],
        metrics: [
            { label: 'Clients Served', value: '20+' },
            { label: 'Modeling', value: 'IRR / NPV' },
            { label: 'Export', value: 'Excel / PDF' },
        ],
        skillNames: ['Laravel', 'PHP', 'Vue 3', 'MySQL', 'Odoo ERP', 'Query Optimization', 'CI/CD Pipelines'],
    }),
    project(5, {
        title: 'Ladyes',
        slug: 'ladyes',
        tagline: 'A women-only ride-hailing platform with real-time trip tracking and in-app payments.',
        category: 'Mobility & Marketplace',
        role: 'Backend & API Engineer',
        client: 'Ladyes',
        year: 2024,
        is_featured: true,
        is_published: true,
        sort_order: 4,
        live_url: null,
        summary:
            'End-to-end backend and REST API powering client and driver mobile apps for a women-focused ride-hailing service, with live geolocation, secure payments, and a full operations dashboard.',
        problem:
            'The business needed a safety-first ride-hailing system serving female passengers and drivers, supporting the complete trip lifecycle, real-time driver matching, in-trip safety features, and a commission/payout model — all across two mobile clients and an admin panel.',
        solution:
            'I designed a modular Laravel backend exposing versioned REST APIs consumed by the client and driver apps. Driver matching uses MySQL spatial queries; trip state is streamed in real time via WebSockets and Firebase, and payments run through a card gateway with wallet, cash, refunds, and driver payouts. Safety features include emergency SOS contacts and WhatsApp/SMS alerts.',
        outcome:
            'A maintainable platform handling the full booking-to-payout flow, with clear domain boundaries (actions, services, and traits) that made new business rules straightforward to add.',
        highlights: [
            'Full trip lifecycle: booking, geospatial driver matching, live tracking, cancellations with penalty rules, and completion.',
            'Real-time updates over WebSockets (Pusher) and Firebase Firestore/FCM push notifications.',
            'Payments: card gateway integration, in-app wallet, cash capture, refunds, and driver commission/payouts.',
            'Safety: emergency SOS, saved emergency contacts, and WhatsApp/SMS notifications via Twilio.',
            'Multi-country/city support, coupons, ratings, and driver gamification (medals, rush-hour incentives).',
        ],
        metrics: [
            { label: 'Eloquent Models', value: '52' },
            { label: 'Migrations', value: '80+' },
            { label: 'Mobile Apps', value: '2' },
            { label: 'Real-time', value: 'Yes' },
        ],
        skillNames: [
            'Laravel',
            'PHP',
            'MySQL',
            'REST API Design',
            'Real-time / WebSockets',
            'Firebase',
            'Twilio',
            'Google Maps API',
            'Authentication & Sanctum',
            'Redis',
        ],
    }),
    project(6, {
        title: 'STC-EG',
        slug: 'stc-eg',
        tagline: 'Corporate platform for an oil & gas training, inspection, and supply-chain company.',
        category: 'Corporate & Enterprise',
        role: 'Full-Stack Developer',
        client: 'STC-EG',
        year: 2024,
        is_featured: true,
        is_published: true,
        sort_order: 5,
        live_url: 'https://www.stc-eg.com/en',
        summary:
            'A multi-division corporate platform presenting a large catalog of accredited training courses, inspection services, and a supply-chain product catalog, with bilingual content and lead capture.',
        problem:
            'A specialized oil & gas services company needed a professional web presence unifying three business lines — training, inspection, and supply chain — each with deep, structured catalogs (dozens of course families, certification bodies, and product categories) that non-technical staff could keep up to date.',
        solution:
            'I built a content-managed platform organizing 100+ courses under certification bodies (PECB, IADC, IOSH, NASP, OSHAcademy, and more), inspection service listings, and a hierarchical product catalog for mud-pump parts, valves, and safety equipment. The information architecture is data-driven, so new courses and products are added through the admin without code changes.',
        outcome:
            "A scalable corporate site that consolidated the company's offering into a single, searchable, maintainable catalog and supported client acquisition across all three divisions.",
        highlights: [
            'Structured catalog of 100+ accredited training courses across multiple international certification bodies.',
            'Three unified business divisions: Training, Inspection, and Supply Chain.',
            'Hierarchical product catalog (mud-pump parts, valves, PPE, and more) with categories and specifications.',
            'Bilingual (English/Arabic) content and lead-capture flows.',
        ],
        metrics: [
            { label: 'Training Courses', value: '100+' },
            { label: 'Business Divisions', value: '3' },
            { label: 'Certification Bodies', value: '9+' },
        ],
        skillNames: ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'Eloquent ORM'],
    }),
    project(7, {
        title: 'InPractice',
        slug: 'inpractice',
        tagline: 'Learn. Connect. Earn. — a mentorship and learning marketplace.',
        category: 'EdTech & Marketplace',
        role: 'Full-Stack Developer',
        client: null,
        year: 2024,
        is_featured: true,
        is_published: true,
        sort_order: 6,
        live_url: null,
        summary:
            'A learning platform that connects learners with practitioners, enabling structured courses, mentorship connections, and monetization for content creators.',
        problem:
            'Learners needed a way to connect with real practitioners and pay for guidance, while experts needed tools to package their knowledge and earn from it.',
        solution:
            'Built with Laravel and an Inertia.js + Vue single-page frontend, the platform models learners, mentors, content, and transactions, with a clean server-driven SPA experience and role-based access.',
        outcome:
            'A cohesive product where the "learn, connect, earn" loop is a first-class flow, backed by a well-normalized schema.',
        highlights: [
            'Server-driven SPA using Inertia.js + Vue for a fast, app-like experience.',
            'Mentorship connections and monetization flows for creators.',
            'Role-based access separating learners, mentors, and administrators.',
        ],
        metrics: [
            { label: 'Eloquent Models', value: '30' },
            { label: 'Stack', value: 'Laravel + Vue' },
        ],
        skillNames: ['Laravel', 'PHP', 'MySQL', 'Inertia.js', 'Vue 3', 'Tailwind CSS'],
    }),
    project(8, {
        title: 'SAA',
        slug: 'saa',
        tagline: 'Multi-vendor marketplace with dedicated customer and vendor mobile apps.',
        category: 'Marketplace & E-commerce',
        role: 'Backend & API Engineer',
        client: null,
        year: 2023,
        is_featured: true,
        is_published: true,
        sort_order: 7,
        live_url: null,
        summary:
            'A marketplace backend serving separate customer and vendor mobile applications, with a custom operations panel, real-time updates, and document generation.',
        problem:
            'The product required two distinct mobile experiences — one for customers and one for vendors — sharing a single backend with orders, catalogs, notifications, and back-office administration.',
        solution:
            'I implemented REST APIs for both apps, a custom admin panel for operations, real-time messaging/notifications over WebSockets, SMS via Twilio, and PDF/Excel exports for invoices and reports.',
        outcome:
            'A dual-app marketplace with a productive admin experience and reliable, documented APIs (shipped with Postman collections for both apps).',
        highlights: [
            'Two API surfaces powering separate customer and vendor apps from one codebase.',
            'Custom admin panel for catalog, orders, and operations.',
            'Real-time notifications (WebSockets) and SMS via Twilio.',
            'Invoice/report generation with PDF (Snappy) and Excel exports.',
        ],
        metrics: [
            { label: 'Eloquent Models', value: '40' },
            { label: 'Mobile Apps', value: '2' },
            { label: 'Admin', value: 'Custom' },
        ],
        skillNames: ['Laravel', 'PHP', 'MySQL', 'REST API Design', 'Real-time / WebSockets', 'Twilio'],
    }),
    project(9, {
        title: 'Proctor',
        slug: 'proctor',
        tagline: 'Online examination and proctoring system with automated reporting.',
        category: 'EdTech',
        role: 'Backend Developer',
        client: null,
        year: 2023,
        is_featured: false,
        is_published: true,
        sort_order: 8,
        live_url: null,
        summary:
            'A platform for creating, delivering, and monitoring online exams, with structured results and PDF report generation.',
        problem:
            'Institutions needed to run online assessments with integrity controls and produce shareable, printable reports of results.',
        solution:
            'I modeled exams, questions, attempts, and results, and implemented PDF report generation for candidates and administrators, with a clean separation between assessment logic and reporting.',
        outcome: 'A dependable assessment engine that turns raw attempt data into professional, exportable reports.',
        highlights: [
            'Exam authoring, delivery, and attempt tracking.',
            'Automated PDF reporting for results.',
            'Clean domain separation between assessment and reporting.',
        ],
        metrics: [
            { label: 'Eloquent Models', value: '27' },
            { label: 'Reporting', value: 'PDF' },
        ],
        skillNames: ['Laravel', 'PHP', 'MySQL', 'Eloquent ORM'],
    }),
    project(10, {
        title: 'Manufacturing ERP',
        slug: 'manufacturing-erp',
        tagline: 'Enterprise resource planning for manufacturing operations.',
        category: 'ERP & Enterprise',
        role: 'Backend Developer',
        client: null,
        year: 2023,
        is_featured: false,
        is_published: true,
        sort_order: 9,
        live_url: null,
        summary:
            'A manufacturing-focused ERP managing production, inventory, and operations across a large, richly-related domain, with multilingual UI and role-based permissions.',
        problem:
            'A manufacturer needed to digitize complex operations spanning production, inventory, and resource management, with fine-grained access control and multi-language support.',
        solution:
            'I built a broad domain model (75+ entities) on Laravel with role/permission-based authorization and a translation-managed interface, emphasizing data integrity across highly interrelated records.',
        outcome:
            'A centralized system that replaced fragmented processes with a single source of truth for manufacturing operations.',
        highlights: [
            '75+ interrelated domain models covering production and inventory.',
            'Role- and permission-based authorization (Spatie).',
            'Multilingual UI via managed translations and media handling.',
        ],
        metrics: [
            { label: 'Eloquent Models', value: '75+' },
            { label: 'Access Control', value: 'RBAC' },
            { label: 'I18n', value: 'Yes' },
        ],
        skillNames: ['Laravel', 'PHP', 'MySQL', 'Eloquent ORM', 'Query Optimization'],
    }),
    project(11, {
        title: 'Vero',
        slug: 'vero',
        tagline: 'Large-scale entertainment and CRM platform with campaign automation.',
        category: 'CRM & Automation',
        role: 'Backend Developer',
        client: null,
        year: 2023,
        is_featured: false,
        is_published: true,
        sort_order: 10,
        live_url: null,
        summary:
            'A high-complexity platform combining entertainment content management with CRM and marketing-campaign automation over a very large domain model.',
        problem:
            'The product needed to manage extensive content and customer data while running automated marketing campaigns and tracking their delivery at scale.',
        solution:
            'I worked across a 180+ model domain, implementing campaign logging/automation, bulk data exports, and media management, with attention to query performance on large tables.',
        outcome:
            'A platform capable of orchestrating campaigns over large datasets while remaining maintainable through clear module boundaries.',
        highlights: [
            '180+ domain models spanning content, customers, and campaigns.',
            'Marketing-campaign automation with delivery logging.',
            'Bulk Excel exports and media library management.',
            'Query-performance focus on large datasets.',
        ],
        metrics: [
            { label: 'Eloquent Models', value: '180+' },
            { label: 'Domain', value: 'CRM + Content' },
        ],
        skillNames: ['Laravel', 'PHP', 'MySQL', 'Query Optimization', 'Redis'],
    }),
    project(12, {
        title: 'Property-MG',
        slug: 'property-mg',
        tagline: 'Property management system for units, tenants, and operations.',
        category: 'PropTech',
        role: 'Full-Stack Developer',
        client: null,
        year: 2023,
        is_featured: false,
        is_published: true,
        sort_order: 11,
        live_url: null,
        summary:
            'A property-management application handling properties, units, tenants, and related operational workflows with an Inertia + Vue interface.',
        problem:
            'Property operators needed a single system to manage portfolios, tenants, and day-to-day operational records.',
        solution:
            'I built a normalized schema (31 models, 50+ migrations) with a server-driven Vue SPA via Inertia, plus Excel exports and role-based access.',
        outcome: 'A streamlined operational tool that centralizes property and tenant data.',
        highlights: [
            'Portfolio, unit, and tenant management.',
            'Inertia.js + Vue SPA frontend.',
            'Excel exports and permission-based access.',
        ],
        metrics: [
            { label: 'Eloquent Models', value: '31' },
            { label: 'Migrations', value: '50+' },
        ],
        skillNames: ['Laravel', 'PHP', 'MySQL', 'Inertia.js', 'Vue 3'],
    }),
    project(13, {
        title: 'Service-Pro',
        slug: 'service-pro',
        tagline: 'On-demand services marketplace connecting customers and providers.',
        category: 'Marketplace',
        role: 'Full-Stack Developer',
        client: null,
        year: 2024,
        is_featured: false,
        is_published: true,
        sort_order: 12,
        live_url: null,
        summary:
            'A services marketplace with a rich domain (63 models, 90+ migrations) linking customers to service providers, bookings, and back-office administration.',
        problem:
            'The business needed a marketplace to manage service catalogs, provider onboarding, bookings, and operations at scale.',
        solution:
            'I implemented a broad, well-migrated schema with an Inertia + Vue frontend, role-based access, and Excel reporting, structured for future growth.',
        outcome: 'A marketplace foundation with clear data boundaries that supports steady feature expansion.',
        highlights: [
            'Service catalog, provider onboarding, and bookings.',
            '90+ migrations reflecting a carefully evolved schema.',
            'Inertia.js + Vue frontend with role-based access.',
        ],
        metrics: [
            { label: 'Eloquent Models', value: '63' },
            { label: 'Migrations', value: '90+' },
        ],
        skillNames: ['Laravel', 'PHP', 'MySQL', 'Inertia.js', 'Vue 3'],
    }),
];
