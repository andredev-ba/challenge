<template>
  <q-card flat class="q-pa-sm">
    <q-card-actions class="row q-col-gutter-md">
      <div class="col-12 col-sm-6">
        <q-input
          ref="nameRef"
          :rules="requiredRules"
          v-model="form.name"
          dense
          outlined
          lazy-rules
          label="Nome do produto *"
        />
      </div>
      <div class="col-12 col-sm-2">
        <q-input
          ref="priceRef"
          :rules="requiredRules"
          v-model="form.price"
          dense
          outlined
          lazy-rules
          label="Preço *"
          mask="#.##"
          fill-mask="0"
          reverse-fill-mask
        />
      </div>
      <div class="col-12 col-sm-2">
        <q-input
          type="date"
          ref="expirationDateRef"
          :rules="requiredRules"
          v-model="form.expirationDate"
          dense
          outlined
          lazy-rules
          label="Data de validade *"
        />
      </div>
      <div class="col-12 col-sm-2">
        <q-select
          ref="categoryIdRef"
          :rules="requiredRules"
          :options="categoryOptions"
          v-model="form.categoryId"
          dense
          outlined
          lazy-rules
          emit-value
          map-options
          label="Categoria *"
        >

        </q-select>
      </div>

      <div class="col-12">
        <q-input
          type="textarea"
          dense
          outlined
          label="Descrição"
          v-model="form.description"
        />
      </div>

      <div class="col-12" >
        <div v-if="form.imageFile.length == 0">
          Imagem atual:
          <q-img style="width: 50px; heigth: 50px" :src="imageUrl" />
        </div>
      </div>

      <div class="col-12">
        <q-file v-model="form.imageFile" dense outlined :label="props.action == 'add' ? 'Imagem do produto' : 'Trocar imagem'" />
      </div>

      <div class="col-12 col-sm-3">
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
          @click="$router.push('/produtos')"
        />
      </div>
    </q-card-actions>
  </q-card>
</template>

<script setup lang="ts">
import { reactive, onMounted, ref, nextTick } from 'vue';
import ProductService from 'src/api/services/ProductService';
import { useRoute, useRouter } from 'vue-router';
import { useQuasar } from 'quasar';

const route = useRoute();
const router = useRouter();
const $q = useQuasar();

const props = defineProps(['action']);

const form = reactive({
  name: '',
  description: '',
  price: 0,
  expirationDate: '',
  imageFile: [],
  categoryId: '',
});

const imageUrl = ref('');
const categoryOptions = ref([]);

const nameRef = ref(null)
const priceRef = ref(null)
const expirationDateRef = ref(null)
const categoryIdRef = ref(null)


const requiredRules = [(val: any) => !!val || 'Este campo é obrigatório'];

onMounted(() => {
  loadFormData()
});

function save() {
  if (validateForm()) props.action == 'add' ? add() : update();
}

async function add() {
  const resp = await ProductService.addProduct(form);
  if (resp.status == 201) {
    $q.notify({
      color: 'positive',
      message: `Produto adicionado com sucesso!`,
    });
    router.push('/produtos');
  } else {
    $q.dialog({
      title: 'Erro na Solicitação',
      message:
        'Ocorreu um erro ao adicionar a produto. Por favor, tente novamente.',
      color: 'negative',
      persistent: true, // Para que o usuário precise clicar para fechar o alerta
    });
  }
}

async function update() {
  const id = route.params.uuid as string;
  const resp = await ProductService.updateProduct(form, id);
  if (resp.status == 200) {
    $q.notify({
      color: 'positive',
      message: `Produto atualizado com sucesso!`,
    });
    router.push('/produtos');
  } else {
    $q.dialog({
      title: 'Erro na Solicitação',
      message:
        'Ocorreu um erro ao atualizar a produto. Por favor, tente novamente.',
      color: 'negative',
      persistent: true,
    });
  }
}

function loadFormData() {
  if (props.action == 'edit') {
    const id = route.params.uuid as string;
    editProduct(id);
  } else {
    createProduct();
  }
}

async function editProduct(id: string) {
  const resp = await ProductService.editProduct(id);

  if (resp.status == 200) {
    categoryOptions.value = resp.data.options.categories;
    await nextTick();
    Object.assign(form, resp.data || {});
    imageUrl.value = resp.data.imageUrl;
  } else {
    $q.dialog({
      title: 'Erro na Solicitação',
      message:
        'Ocorreu um erro ao carregar dados para edição do produto. Por favor, tente novamente.',
      color: 'negative',
      persistent: true,
    });
    router.push('/produtos');
  }
}

async function createProduct() {
  const resp = await ProductService.createProduct();

  if (resp.status == 200) {
    Object.assign(form, resp.data || {});
    categoryOptions.value = resp.data.options.categories;
  } else {
    $q.dialog({
      title: 'Erro na Solicitação',
      message:
        'Ocorreu um erro ao carregar dados para criação do produto. Por favor, tente novamente.',
      color: 'negative',
      persistent: true,
    });
    router.push('/produtos');
  }
}

function validateForm() {
  nameRef.value.validate();
  priceRef.value.validate();
  expirationDateRef.value.validate();
  categoryIdRef.value.validate();

  if (nameRef.value.hasError || priceRef.value.hasError || expirationDateRef.value.hasError || categoryIdRef.value.hasError) {
    $q.notify({
      color: 'negative',
      message: `Preencha os campos obrigatórios`,
    });
    return false;
  }

  return true
}
</script>
