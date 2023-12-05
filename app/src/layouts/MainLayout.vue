<template>
  <q-layout view="hHh lpR fff">
    <q-header reveal class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title class="q-my-sm"> </q-toolbar-title>

        <q-btn-dropdown
          :menu-offset="[0, 1]"
          dense
          rounded
          unelevated
          color="primary"
        >
          <template #label>
            <q-avatar size="xl">
              <q-img
                :src="`https://cdn-icons-png.flaticon.com/512/6596/6596121.png`"
                ratio="1"
              />
            </q-avatar>
          </template>
          <q-list style="width: 200px">
            <q-item clickable v-close-popup>
              <q-item-section>
                <q-item-label class="row"
                  ><q-icon name="fa-solid fa-user" class="q-mr-sm" />Meu
                  perfil</q-item-label
                >
              </q-item-section>
            </q-item>

            <q-item clickable v-close-popup @click="logout">
              <q-item-section>
                <q-item-label class="row"
                  ><q-icon
                    name="fa-solid fa-sign-out"
                    class="q-mr-sm"
                  />Sair</q-item-label
                >
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </q-toolbar>
    </q-header>

    <q-drawer
      :width="250"
      show-if-above
      v-model="leftDrawerOpen"
      side="left"
      bordered
      style="background-color: #f8f8f8"
    >
      <q-list>
        <q-item-label header class="text-secondary text-center q-pa-md">
          <q-avatar size="100px">
            <!-- <q-img :src="url" ratio="1" /> -->
            <q-img
              src="https://dev.innyx.com/wp-content/uploads/2023/10/imagem_2023-10-09_115224533.png"
              ratio="4"
            />
          </q-avatar>
        </q-item-label>
        <MenuComponent />
      </q-list>
    </q-drawer>

    <q-page-container>
      <q-page class="bg-grey-1">
        <PageTitleComponent />
        <div class="q-pa-md">
          <router-view />
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import MenuComponent from 'components/shared/MenuComponent.vue';
import PageTitleComponent from 'components/shared/PageTitleComponent.vue';
import { keycloak } from 'boot/keycloak';

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

function logout() {
  keycloak.logout();
}
</script>
