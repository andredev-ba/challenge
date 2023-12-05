<template>
  <div class="row justify-between bg-white shadow-1 q-pa-md text-grey-10">
    <div class="text-h6 row items-center">
      <q-icon :name="$route.meta.icon" />
      <div class="q-ml-sm">{{ $route.name }}</div>
    </div>
    <BreadcrumbsComponent />
  </div>
</template>

<script setup lang="ts">
import BreadcrumbsComponent from './BreadcrumbsComponent.vue';
</script>
