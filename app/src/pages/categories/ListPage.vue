<template>
  <ListComponent />
</template>

<script setup lang="ts">
import { useBreadcrumbStore } from 'src/stores/shared/breadcrumb-store';
import { onBeforeMount } from 'vue';
import ListComponent from 'src/components/categories/ListComponent.vue';

const breadcrumbStore = useBreadcrumbStore();
const { setBreadcrumbs } = breadcrumbStore;

onBeforeMount(() => {
  setBreadcrumbs([
    {
      text: 'Categorias',
      link: '/categorias',
    },
    {
      text: 'Lista',
    },
  ]);
});
</script>
