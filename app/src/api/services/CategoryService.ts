import { api } from 'src/boot/axios';

export default class CategoryService {
  static async getCategories(payload: any) {
    return await api.get('/categories', { params: payload });
  }

  static async addCategory(payload: any) {
    return await api.post('/categories', payload);
  }

  static async updateCategory(payload: any, id: string) {
    return await api.put(`/categories/${id}`, payload);
  }

  static async loadCategory(id: string) {
    return await api.get(`/categories/${id}`);
  }

  static async deleteCategory(id: string) {
    return await api.delete(`/categories/${id}`);
  }
}
