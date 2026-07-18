import api from '@/services/api';
import type {
  AdminUser,
  ApiEnvelope,
  ContactMessage,
  Experience,
  Profile,
  Project,
  Skill,
} from '@/types';

interface DashboardStats {
  projects: number;
  published_projects: number;
  skills: number;
  experiences: number;
  testimonials: number;
  unread_messages: number;
}

export const adminApi = {
  async login(email: string, password: string): Promise<{ token: string; user: AdminUser }> {
    const { data } = await api.post<ApiEnvelope<{ token: string; user: AdminUser }>>('/admin/login', {
      email,
      password,
    });
    return data.data;
  },

  async me(): Promise<AdminUser> {
    const { data } = await api.get<ApiEnvelope<AdminUser>>('/admin/me');
    return data.data;
  },

  async logout(): Promise<void> {
    await api.post('/admin/logout');
  },

  async dashboard(): Promise<DashboardStats> {
    const { data } = await api.get<ApiEnvelope<DashboardStats>>('/admin/dashboard');
    return data.data;
  },

  // Projects
  async projects(): Promise<Project[]> {
    const { data } = await api.get<{ data: Project[] }>('/admin/projects');
    return data.data;
  },
  async createProject(payload: Partial<Project> & { skill_ids?: number[] }): Promise<Project> {
    const { data } = await api.post<ApiEnvelope<Project>>('/admin/projects', payload);
    return data.data;
  },
  async updateProject(slug: string, payload: Partial<Project> & { skill_ids?: number[] }): Promise<Project> {
    const { data } = await api.put<ApiEnvelope<Project>>(`/admin/projects/${slug}`, payload);
    return data.data;
  },
  async deleteProject(slug: string): Promise<void> {
    await api.delete(`/admin/projects/${slug}`);
  },

  // Skills
  async skills(): Promise<Skill[]> {
    const { data } = await api.get<{ data: Skill[] }>('/admin/skills');
    return data.data;
  },
  async createSkill(payload: Partial<Skill>): Promise<Skill> {
    const { data } = await api.post<ApiEnvelope<Skill>>('/admin/skills', payload);
    return data.data;
  },
  async updateSkill(id: number, payload: Partial<Skill>): Promise<Skill> {
    const { data } = await api.put<ApiEnvelope<Skill>>(`/admin/skills/${id}`, payload);
    return data.data;
  },
  async deleteSkill(id: number): Promise<void> {
    await api.delete(`/admin/skills/${id}`);
  },

  // Experiences
  async experiences(): Promise<Experience[]> {
    const { data } = await api.get<{ data: Experience[] }>('/admin/experiences');
    return data.data;
  },
  async createExperience(payload: Partial<Experience>): Promise<Experience> {
    const { data } = await api.post<ApiEnvelope<Experience>>('/admin/experiences', payload);
    return data.data;
  },
  async updateExperience(id: number, payload: Partial<Experience>): Promise<Experience> {
    const { data } = await api.put<ApiEnvelope<Experience>>(`/admin/experiences/${id}`, payload);
    return data.data;
  },
  async deleteExperience(id: number): Promise<void> {
    await api.delete(`/admin/experiences/${id}`);
  },

  // Profile
  async profile(): Promise<Profile> {
    const { data } = await api.get<ApiEnvelope<Profile>>('/admin/profile');
    return data.data;
  },

  // Messages
  async messages(): Promise<ContactMessage[]> {
    const { data } = await api.get<{ data: ContactMessage[] }>('/admin/messages');
    return data.data;
  },
  async message(id: number): Promise<ContactMessage> {
    const { data } = await api.get<ApiEnvelope<ContactMessage>>(`/admin/messages/${id}`);
    return data.data;
  },
  async deleteMessage(id: number): Promise<void> {
    await api.delete(`/admin/messages/${id}`);
  },
};
