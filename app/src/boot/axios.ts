import { boot } from 'quasar/wrappers';
import axios, { AxiosInstance } from 'axios';
import { Loading, Dialog } from 'quasar';
import { keycloak } from 'boot/keycloak'
declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $axios: AxiosInstance;
  }
}

const api = axios.create({
  baseURL: process.env.API_URL,
  timeout: 30000,
  headers: {
    'Content-Type': 'application/json',
  }
});

let numeroDeRequisicoes = 0;

api.interceptors.request.use(async config => {
    numeroDeRequisicoes++;
    if (numeroDeRequisicoes === 1) {
      Loading.show();
    }
    config.headers = Object.assign({
      'Authorization': `Bearer ${keycloak.token}`,
      'Content-Type': config.headers['Content-Type']
    })
    return config;
  },
  error => {
    Dialog.create({
      title: 'Erro na Solicitação',
      message: `Ocorreu um erro ao processar a solicitação: ${error.message}`,
      color: 'negative',
      persistent: true,
    });
    Promise.reject(error)
  });

api.interceptors.response.use(async response => {
    numeroDeRequisicoes--;
    if (numeroDeRequisicoes === 0) {
      Loading.hide();
    }
    return response;
  },
  async error => {
    numeroDeRequisicoes--;
    if (numeroDeRequisicoes === 0) {
      Loading.hide();
    }

    const originalRequest = error.config;

    if (error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;
      const token = await keycloak.updateToken(5);
      if (token) {
        originalRequest.headers.Authorization = `Bearer ${token}`;
        return axios(originalRequest);
      }
    } else {
      Dialog.create({
        title: 'Erro na Solicitação',
        message: `Ocorreu um erro ao processar a solicitação: ${error.response.data.message}`,
        color: 'negative',
        persistent: true,
      });
    }
    Promise.reject(error)
  });

export default boot(({ app }) => {
  app.config.globalProperties.$axios = axios;
  app.config.globalProperties.$api = api;
});

export { api };
