<template>
  <q-breadcrumbs separator=">" class="row" style="font-size: 14px">
    <q-breadcrumbs-el
      icon="home"
      @click="$router.push('/')"
      style="cursor: pointer"
      label="Início"
    />
    <template v-for="(item, index) in breadcrumbs" :key="index">
      <q-breadcrumbs-el
        v-if="item.link"
        @click="$router.push(item.link)"
        style="cursor: pointer"
        :label="item.text"
      />
      <q-breadcrumbs-el v-else :label="item.text" />
    </template>
  </q-breadcrumbs>
</template>

<script setup lang="ts">
import { useBreadcrumbStore } from 'src/stores/shared/breadcrumb-store';
import { storeToRefs } from 'pinia';


const store = useBreadcrumbStore();
const { breadcrumbs } = storeToRefs(store);
</script>
