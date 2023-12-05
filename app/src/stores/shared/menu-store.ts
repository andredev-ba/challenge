import { defineStore } from 'pinia';

export const useMenuStore = defineStore('menu-store', {
  state: () => ({
    link: 'dashboard',
  }),

  actions: {
    openPage(page: string): void {
      this.link = page;
      this.router.push(`/${page}`);
    }
  },
});
