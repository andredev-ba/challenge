<template>
  <q-card flat class="q-pa-sm">
    <q-card-actions class="row q-col-gutter-md">
      <div class="col-12">
        <q-input
          ref="nameRef"
          :rules="requiredRules"
          v-model="form.name"
          dense
          outlined
          lazy-rules
          label="Nome da categoria *"
        />
      </div>
      <div>
        <q-btn
          @click="save"
          no-caps
          icon="fa-solid fa-save"
          color="positive"
          :label="props.action == 'add' ? 'Cadastrar' : 'Atualizar'"
        />
        <q-btn
          no-caps
          class="q-ml-sm"
          icon="fa-solid fa-close"
          color="negative"
          label="Cancelar"
          @click="$router.push('/categorias')"
        />
      </div>
    </q-card-actions>
  </q-card>
</template>

<script setup lang="ts">
import { reactive, onMounted, ref } from 'vue';
import CategoryService from 'src/api/services/CategoryService';
import { useRoute, useRouter } from 'vue-router';
import { useQuasar } from 'quasar';

const route = useRoute();
const router = useRouter();
const $q = useQuasar();

const props = defineProps(['action']);

const form = reactive({
  name: '',
});

const nameRef = ref(null)

const requiredRules = [(val: any) => !!val || 'Este campo é obrigatório'];

onMounted(() => {
  if (props.action == 'edit') {
    loadCategory();
  }
});

function save() {
  nameRef.value.validate()
  if (nameRef.value.hasError) {
    $q.notify({
      color: 'negative',
      message: `Preencha os campos obrigatórios`,
    });
    return false;
  }
  props.action == 'add' ? add() : update();
}

async function add() {
  const resp = await CategoryService.addCategory(form);
  if (resp.status == 201) {
    $q.notify({
      color: 'positive',
      message: `Categoria adicionada com sucesso!`,
    });
    router.push('/categorias');
  } else {
    $q.dialog({
      title: 'Erro na Solicitação',
      message:
        'Ocorreu um erro ao adicionar a categoria. Por favor, tente novamente.',
      color: 'negative',
      persistent: true, // Para que o usuário precise clicar para fechar o alerta
    });
  }
}

async function update() {
  const id = route.params.uuid as string;
  const resp = await CategoryService.updateCategory(form, id);
  if (resp.status == 200) {
    $q.notify({
      color: 'positive',
      message: `Categoria atualizada com sucesso!`,
    });
    router.push('/categorias');
  } else {
    $q.dialog({
      title: 'Erro na Solicitação',
      message:
        'Ocorreu um erro ao atualizar a categoria. Por favor, tente novamente.',
      color: 'negative',
      persistent: true, // Para que o usuário precise clicar para fechar o alerta
    });
  }
}

async function loadCategory() {
  const id = route.params.uuid as string;
  const resp = await CategoryService.loadCategory(id);
  if (resp.status == 200) {
    form.name = resp.data.name;
  } else {
    $q.dialog({
      title: 'Erro na Solicitação',
      message:
        'Ocorreu um erro ao carregar a categoria. Por favor, tente novamente.',
      color: 'negative',
      persistent: true,
    });
    router.push('/categorias');
  }
}
</script>
