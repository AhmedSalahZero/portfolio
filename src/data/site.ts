import type { SiteData } from '@/types';
import { experiences } from './experiences';
import { profile } from './profile';
import { projects } from './projects';
import { skills } from './skills';

export const siteData: SiteData = {
    profile,
    skills,
    projects,
    experiences,
    testimonials: [],
};
