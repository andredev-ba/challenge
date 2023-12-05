<template>
  <div>
    <q-list padding class="text-grey-8 q-pt-none" style="font-size: 14px">
      <q-separator />
      <div class="q-pa-xs bg-grey-3 text-center">
        <span style="font-size: 12px">MENU</span>
      </div>
      <q-separator />
      <q-item
        clickable
        v-ripple
        :active="link === 'dashboard'"
        @click="openPage('dashboard')"
        active-class="my-menu-link"
      >
        <q-item-section avatar>
          <q-icon size="xs" name="fa-solid fa-dashboard" />
        </q-item-section>

        <q-item-section>Início</q-item-section>
      </q-item>
      <q-separator />
      <q-item
        clickable
        v-ripple
        :active="link === 'categorias'"
        @click="openPage('categorias')"
        active-class="my-menu-link"
      >
        <q-item-section avatar>
          <q-icon size="xs" name="fa-solid fa-layer-group" />
        </q-item-section>

        <q-item-section>Categorias</q-item-section>
      </q-item>
      <q-separator />
      <q-item
        clickable
        v-ripple
        :active="link === 'produtos'"
        @click="openPage('produtos')"
        active-class="my-menu-link"
      >
        <q-item-section avatar>
          <q-icon size="xs" name="fa-solid fa-cube" />
        </q-item-section>

        <q-item-section>Produtos</q-item-section>
      </q-item>
      <q-separator />
    </q-list>
  </div>
</template>

<script setup lang="ts">
import { useMenuStore } from 'stores/shared/menu-store';
import { storeToRefs } from 'pinia';

const menuStore = useMenuStore();
const { link } = storeToRefs(menuStore);
const { openPage } = menuStore;
</script>

<style scoped lang="sass">
.my-menu-link
  color: #424242
  font-weight: bold
</style>
