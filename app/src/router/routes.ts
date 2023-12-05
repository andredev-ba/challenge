import { RouteRecordRaw } from 'vue-router';

function createCategoryRoutes(): RouteRecordRaw[] {
  return [
    {
      name: 'Categorias',
      path: 'categorias',
      meta: {
        icon: 'fa-solid fa-layer-group',
        requiresAuth: true,
        requiredRoles: ['admin'],
      },

      component: () => import('src/pages/categories/ListPage.vue'),
    },
    {
      name: 'Adicionar categoria',
      path: 'categorias/adicionar',
      meta: {
        icon: 'fa-solid fa-layer-group',
        requiresAuth: true,
        requiredRoles: ['admin']
      },

      component: () => import('src/pages/categories/AddPage.vue'),
    },
    {
      name: 'Editar categoria',
      path: 'categorias/editar/:uuid',
      meta: {
        icon: 'fa-solid fa-layer-group',
        requiresAuth: true,
        requiredRoles: ['admin'],
      },

      component: () => import('src/pages/categories/EditPage.vue'),
    },
  ];
}

function createProductRoutes(): RouteRecordRaw[] {
  return [
    {
      name: 'Produtos',
      path: 'produtos',
      meta: {
        icon: 'fa-solid fa-cube',
        requiresAuth: true,
        requiredRoles: ['user'],
      },

      component: () => import('src/pages/products/ListPage.vue'),
    },
    {
      name: 'Adicionar produto',
      path: 'produtos/adicionar',
      meta: {
        icon: 'fa-solid fa-cube',
        requiresAuth: true,
        requiredRoles: ['user']
      },

      component: () => import('src/pages/products/AddPage.vue'),
    },
    {
      name: 'Editar produto',
      path: 'produtos/editar/:uuid',
      meta: {
        icon: 'fa-solid fa-cube',
        requiresAuth: true,
        requiredRoles: ['user'],
      },

      component: () => import('src/pages/products/EditPage.vue'),
    },
  ];
}

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        name: 'Início',
        path: '',
        alias: 'dashboard',
        meta: {
          icon: 'fa-solid fa-dashboard'
        },
        component: () => import('pages/IndexPage.vue'),
      },
      ...createCategoryRoutes(),
      ...createProductRoutes(),
    ],
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
