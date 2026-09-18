export interface KeyValue {
    label: string;
    value: string;
}

export interface Skill {
    id: number;
    name: string;
    category: string;
    category_label: string;
    level: number;
    icon: string | null;
    is_featured: boolean;
    sort_order: number;
}

export interface ProjectImage {
    id: number;
    url: string;
    caption: string | null;
    sort_order: number;
}

export interface ProjectSummary {
    id: number;
    title: string;
    slug: string;
    tagline: string;
    summary: string;
    category: string | null;
    role: string | null;
    year: number | null;
    cover_image: string | null;
    live_url: string | null;
    repo_url: string | null;
    is_featured: boolean;
    metrics: KeyValue[];
    skills: Skill[];
}

export interface Project extends ProjectSummary {
    client: string | null;
    problem: string | null;
    solution: string | null;
    outcome: string | null;
    highlights: string[];
    is_published: boolean;
    sort_order: number;
    skill_ids?: number[];
    images: ProjectImage[];
}

export interface Profile {
    name: string;
    title: string;
    headline: string;
    bio: string;
    location: string | null;
    email: string | null;
    phone: string | null;
    years_experience: number;
    availability: string | null;
    avatar_url: string | null;
    cv_url: string | null;
    social: {
        github: string | null;
        linkedin: string | null;
        twitter: string | null;
        website: string | null;
    };
    stats: KeyValue[];
}

export interface Experience {
    id: number;
    company: string;
    role: string;
    location: string | null;
    employment_type: string | null;
    start_date: string | null;
    end_date: string | null;
    is_current: boolean;
    description: string | null;
    achievements: string[];
    sort_order: number;
}

export interface Testimonial {
    id: number;
    author: string;
    position: string | null;
    company: string | null;
    quote: string;
    avatar_url: string | null;
    sort_order: number;
}

export interface SiteData {
    profile: Profile;
    skills: Skill[];
    projects: Project[];
    experiences: Experience[];
    testimonials: Testimonial[];
}
