import api from '@/services/api';
import type { ApiEnvelope, Project, ProjectSummary, SiteData } from '@/types';

export interface ContactPayload {
  name: string;
  email: string;
  subject?: string;
  message: string;
  website?: string; // honeypot
}

export const publicApi = {
  async site(): Promise<SiteData> {
    const { data } = await api.get<ApiEnvelope<SiteData>>('/site');
    return data.data;
  },

  async projects(params?: { skill?: string; category?: string }): Promise<ProjectSummary[]> {
    const { data } = await api.get<{ data: ProjectSummary[] }>('/projects', { params });
    return data.data;
  },

  async project(slug: string): Promise<Project> {
    const { data } = await api.get<ApiEnvelope<Project>>(`/projects/${slug}`);
    return data.data;
  },

  async sendContact(payload: ContactPayload): Promise<string> {
    const { data } = await api.post<ApiEnvelope<null>>('/contact', payload);
    return data.message;
  },
};
