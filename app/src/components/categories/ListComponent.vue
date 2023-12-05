<template>
  <q-card class="q-pa-sm">
    <q-card-actions class="justify-between">
      <div>
        <q-btn
          no-caps
          icon="fa-solid fa-plus-circle"
          color="primary"
          label="Adicionar"
          @click="$router.push('/categorias/adicionar')"
        />
      </div>
      <div>
        <q-input
          @keyup.enter="updateTable"
          v-model="state.filters.search"
          outlined
          dense
          placeholder="Pesquisa"
          style="width: 600px"
        >
          <template v-slot:append>
            <q-icon @click="updateTable" style="cursor: pointer" name="search" />
          </template>
        </q-input>
      </div>
    </q-card-actions>
    <div class="q-pa-sm">
    <q-table
      class="table-striped col-12"
      flat
      bordered
      ref="tableRef"
      :rows="state.tableRows"
      :columns="tableColumns"
      row-key="id"
      separator="cell"
      v-model:pagination="state.pagination"
      binary-state-sort
      @request="getItems"
      :rows-per-page-options="[5, 20, 50, 100]"
      no-data-label="Nenhum registro encontrado"
      loading-label="Buscando dados..."
      rows-per-page-label="Registros por página"
      :loading="state.tableLoading"
    >
      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
            <q-btn
              size="sm"
              padding="xs"
              color="blue"
              round
              dense
              icon="edit"
              title="Editar"
              @click="$router.push(`/categorias/editar/${props.row.id}`)"
            />
            <q-btn
              size="sm"
              padding="xs"
              color="red"
              round
              dense
              icon="delete"
              class="q-ml-sm"
              title="Excluir"
              @click="deleteCategory(props.row.id, props.row.name)"
            />
          </q-td>
      </template>
      <template v-slot:pagination="scope">
        <q-btn
          v-if="scope.pagesNumber > 2"
          icon="first_page"
          color="grey-8"
          round
          dense
          flat
          :disable="scope.isFirstPage"
          @click="scope.firstPage"
        />

        <q-btn
          icon="chevron_left"
          color="grey-8"
          round
          dense
          flat
          :disable="scope.isFirstPage"
          @click="scope.prevPage"
        />

        <q-btn
          icon="chevron_right"
          color="grey-8"
          round
          dense
          flat
          :disable="scope.isLastPage"
          @click="scope.nextPage"
        />

        <q-btn
          v-if="scope.pagesNumber > 2"
          icon="last_page"
          color="grey-8"
          round
          dense
          flat
          :disable="scope.isLastPage"
          @click="scope.lastPage"
        />
        {{ state.pagination.from }} - {{ state.pagination.to }} de
        {{ state.pagination.rowsNumber }}
      </template>
    </q-table>
    </div>
  </q-card>
</template>
<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import CategoryService from 'src/api/services/CategoryService';
import { useQuasar } from 'quasar';
import { TableColumn, CategoryRow } from 'src/shared/types';

const $q = useQuasar();

const tableRef = ref(null);

const state = reactive({
  tableLoading: false,
  tableRows: [] as CategoryRow[],
  pagination: {
    sortBy: 'id',
    descending: true,
    page: 1,
    rowsPerPage: 20,
    rowsNumber: 100,
    from: 1,
    to: 1,
  },
  filters: {
    search: '',
  },
});

const tableColumns: TableColumn[] = [
  {
    name: 'name',
    label: 'Categoria',
    align: 'left',
    field: 'name',
    sortable: true,
    style: 'width: 90%',
  },

  {
    name: 'actions',
    label: 'Ação',
    align: 'center',
    field: 'actions',
    style: 'width: 10%',
  },
]

onMounted(() => {
  updateTable()
});

function updateTable() {
  tableRef.value.requestServerInteraction();
}

async function getItems(props: any) {
  state.tableLoading = true;
  const { page, rowsPerPage, sortBy, descending } = props.pagination;
  const { data } = await CategoryService.getCategories({
    page,
    sortBy,
    descending,
    rowsPerPage,
    ...state.filters,
  });

  state.tableRows = data.items;
  state.pagination = {
    sortBy,
    descending,
    page,
    rowsPerPage,
    rowsNumber: data.total,
    from: data.from,
    to: data.to,
  };

  state.tableLoading = false;
}

async function deleteCategory(id: string, name: string) {
  $q.dialog({
        title: 'Confirmação de exclusão',
        message: `Tem certeza de que deseja excluir a categoria ${name}?`,
        ok: {
          label: 'Sim',
          push: true,
          color: 'positive'
        },
        cancel: {
          label: 'Cancelar',
          color: 'negative',
        },
      })
      .onOk(async () => {
        const resp = await CategoryService.deleteCategory(id);
        if (resp.status == 200) {
          $q.notify({
            type: 'positive',
            message: `Categoria excluída com sucesso!`,
          });
          updateTable()
        } else {
          $q.dialog({
            title: 'Erro na Solicitação',
            message:
              'Ocorreu um erro ao excluir a categoria. Por favor, tente novamente.',
            color: 'negative',
            persistent: true,
          });
          updateTable()
        }
      })
}
</script>
