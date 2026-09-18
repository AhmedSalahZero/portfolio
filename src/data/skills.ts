import type { Skill } from '@/types';

const labels: Record<string, string> = {
    backend: 'Backend',
    frontend: 'Frontend',
    database: 'Databases',
    devops: 'DevOps & Cloud',
    tools: 'Tools & Practices',
};

function skill(
    id: number,
    name: string,
    category: string,
    level: number,
    is_featured: boolean,
    sort_order: number,
): Skill {
    return {
        id,
        name,
        category,
        category_label: labels[category] ?? category,
        level,
        icon: null,
        is_featured,
        sort_order,
    };
}

export const skills: Skill[] = [
    skill(1, 'PHP', 'backend', 95, true, 0),
    skill(2, 'Laravel', 'backend', 95, true, 1),
    skill(3, 'REST API Design', 'backend', 92, true, 2),
    skill(4, 'Authentication & Sanctum', 'backend', 88, false, 3),
    skill(5, 'Queues & Background Jobs', 'backend', 85, false, 4),
    skill(6, 'Real-time / WebSockets', 'backend', 82, false, 5),
    skill(7, 'Node.js (basic)', 'backend', 45, false, 6),
    skill(8, 'Python (basic)', 'backend', 45, false, 7),
    skill(9, 'Vue 3', 'frontend', 90, true, 8),
    skill(10, 'TypeScript', 'frontend', 85, true, 9),
    skill(11, 'JavaScript (ES6+)', 'frontend', 88, false, 10),
    skill(12, 'Tailwind CSS', 'frontend', 90, true, 11),
    skill(13, 'Inertia.js', 'frontend', 84, false, 12),
    skill(14, 'Pinia', 'frontend', 80, false, 13),
    skill(15, 'HTML5 & CSS3', 'frontend', 90, false, 14),
    skill(16, 'MySQL', 'database', 92, true, 15),
    skill(17, 'Eloquent ORM', 'database', 92, false, 16),
    skill(18, 'Query Optimization', 'database', 85, false, 17),
    skill(19, 'Redis', 'database', 78, false, 18),
    skill(20, 'Docker', 'devops', 80, true, 19),
    skill(21, 'CI/CD Pipelines', 'devops', 78, false, 20),
    skill(22, 'AWS', 'devops', 68, false, 21),
    skill(23, 'Vagrant', 'devops', 65, false, 22),
    skill(24, 'Nginx', 'devops', 76, false, 23),
    skill(25, 'Linux', 'devops', 82, false, 24),
    skill(26, 'Git', 'devops', 90, false, 25),
    skill(27, 'PHPUnit / Pest', 'tools', 82, true, 26),
    skill(28, 'Firebase', 'tools', 80, false, 27),
    skill(29, 'Twilio', 'tools', 78, false, 28),
    skill(30, 'Payment Gateways', 'tools', 80, false, 29),
    skill(31, 'Google Maps API', 'tools', 78, false, 30),
    skill(32, 'WhatsApp Cloud API', 'tools', 85, true, 31),
    skill(33, 'OpenAI API', 'tools', 80, false, 32),
    skill(34, 'Odoo ERP', 'tools', 78, false, 33),
    skill(35, 'PHPStan / Larastan', 'tools', 85, false, 34),
];

export function skillsByName(names: string[]): Skill[] {
    return names.map((name) => {
        const found = skills.find((item) => item.name === name);
        if (!found) {
            throw new Error(`Unknown skill: ${name}`);
        }
        return found;
    });
}
