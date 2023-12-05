import { api } from 'src/boot/axios';

export default class ProductService {
  static async getProducts(payload: any) {
    return await api.get('/products', { params: payload });
  }

  static async addProduct(payload: any) {
    const formData = new FormData();
    Object.keys(payload).forEach((key) => {
      formData.append(key, payload[key]);
    });
    return await api.post('/products', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
  }

  static async createProduct() {
    return await api.get(`/products/create`);
  }

  static async updateProduct(payload: any, id: string) {
    const formData = new FormData();
    Object.keys(payload).forEach((key) => {
      formData.append(key, payload[key]);
    });
    return await api.post(`/products/${id}`, payload, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
  }

  static async editProduct(id: string) {
    return await api.get(`/products/${id}`);
  }

  static async deleteProduct(id: string) {
    return await api.delete(`/products/${id}`);
  }
}
