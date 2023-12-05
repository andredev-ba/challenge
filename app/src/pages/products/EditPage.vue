<template>
  <FormComponent action="edit"/>
</template>

<script setup lang="ts">
import { useBreadcrumbStore } from 'src/stores/shared/breadcrumb-store';
import { onBeforeMount } from 'vue';
import FormComponent from 'src/components/products/FormComponent.vue';


const breadcrumbStore = useBreadcrumbStore();
const { setBreadcrumbs } = breadcrumbStore;

onBeforeMount(() => {
  setBreadcrumbs([
    {
      text: 'Produtos',
      link: '/produtos',
    },
    {
      text: 'Editar',
    },
  ]);
});

</script>
