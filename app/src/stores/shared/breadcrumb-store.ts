import { defineStore } from 'pinia';
import { BreadcrumbItem } from 'src/shared/types';

export const useBreadcrumbStore = defineStore('breadcrumb-store', {
  state: () => ({
    breadcrumbs: [{}] as BreadcrumbItem[],
  }),
  getters: {},
  actions: {
    setBreadcrumbs(breadcrumbs: object[]): void {
      Object.assign(this.breadcrumbs, breadcrumbs);
    },
  },
});
