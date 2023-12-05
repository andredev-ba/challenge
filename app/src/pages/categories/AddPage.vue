<template>
  <FormComponent action="add"/>
</template>

<script setup lang="ts">
import { useBreadcrumbStore } from 'src/stores/shared/breadcrumb-store';
import { onBeforeMount } from 'vue';
import FormComponent from 'src/components/categories/FormComponent.vue';


const breadcrumbStore = useBreadcrumbStore();
const { setBreadcrumbs } = breadcrumbStore;

onBeforeMount(() => {
  setBreadcrumbs([
    {
      text: 'Categorias',
      link: '/categorias',
    },
    {
      text: 'Adicionar',
    },
  ]);
});

</script>
