<template>
<q-page class="q-pa-xl">
    <!--TITULO-->
    <q-card class="bg-transparent no-shadow no-border">
        <q-card-section class="text-blue-grey-7 text-h6 q-pa-lg">
            <div class="text-h3">Despesas</div>
        </q-card-section>
    </q-card>

    <!--BTNS PRINCIPAIS-->
    <q-card align="right" class="bg-transparent no-shadow no-border q-pa-md q-gutter-sm">
        <q-btn round @click="adicionarDespesa = !adicionarDespesa">
          <q-item>
            <q-item-section align="center">
              <q-icon color="negative" name="fas fa-plus" size="30px"></q-icon>
            </q-item-section>
          </q-item>
        </q-btn>
    </q-card>

    <!--LISTAR DESPESAS-->
    <div class="q-pa-md">
        <q-card class="my-card" align="right">
            <q-card-section >
                <q-input  v-model="pesquisar" filled label="Pesquisar" type="search" style="width: 15%;">
                  <template v-slot:append>
                    <q-icon name="search" />
                  </template>
                </q-input>
            </q-card-section>


            <q-markup-table>
                <thead>
                    <tr>
                        <th class="text-h3 text-left">Nº</th>
                        <th class="text-h3 text-center">Descrição</th>
                        <th class="text-h3 text-center">Data</th>
                        <th class="text-h3 text-center">Valor</th>
                        <th class="text-h3 text-center">Anexo</th>
                        <th class="text-h3 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <td class="text-left">{{ item.id }}</td>
                        <td class="text-center">{{ item.descricao }}</td>
                        <td class="text-center">{{ item.data }}</td>
                        <td class="text-center">{{ item.valor }}</td>
                        <td class="text-center">{{ item.anexo }}</td>
                        <td class="text-center">
                            <div class="q-col-gutter-x-md">
                                <q-icon class="efeitoLink" color="positive" name="far fa-edit" size="15px"></q-icon>
                                <q-icon @click="excluirDespesa(item.id)" class="efeitoLink" color="negative" name="far fa-trash-alt" size="15px"></q-icon>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </q-markup-table>
        </q-card>
    </div>

    <!--ADICIONAR DESPESA-->
    <q-dialog v-model="adicionarDespesa" persistent>
        <q-card style="width: 600px; max-width: 80vw;">
            <q-card-section>
                <div class="text-h6">Adicionar Despesa</div>
            </q-card-section>
            <q-card-section class="q-pt-none">
                <div class="q-pa-md ">
                    <q-form>
                        <q-card-section class="q-pa-sm">
                            <q-list class="row">

                                <q-item class="col col-sm-12 col-xs-12">
                                    <q-item-section>
                                        <q-input autogrow v-model="despesas.descricao" hint="Descrição" />
                                    </q-item-section>
                                </q-item>

                                <q-item class="col col-sm-12 col-xs-12">
                                    <q-item-section>
                                        <q-input type="date" class="text-dark" v-model="despesas.data" hint="Data" />
                                    </q-item-section>
                                </q-item>

                                <q-item class="col col-sm-12 col-xs-12">
                                    <q-item-section>
                                        <q-input class="text-dark" prefix="R$" v-model="despesas.valor" mask="#.###.##" reverse-fill-mask input-class="text-left" hint="Valor R$ 0.00" />
                                    </q-item-section>
                                </q-item>

                                <q-item class="col col-sm-12 col-xs-12">
                                    <q-item-section>
                                        <q-file v-model="despesas.anexo" label="Adicionar Arquivo" counter>
                                            <template v-slot:prepend>
                                                <q-icon color="indigo-7" name="cloud_upload" @click.stop />
                                            </template>
                                            <template v-slot:hint>
                                                Tamanha da imagem
                                            </template>
                                        </q-file>
                                    </q-item-section>
                                </q-item>

                            </q-list>
                        </q-card-section>
                    </q-form>
                </div>
            </q-card-section>
            <q-card-actions align="right" class="bg-white text-teal q-pa-lg">
                <q-btn type="button" @click="salvarDespesa(despesas)" push class="text-capitalize text-white bg-indigo-7" v-close-popup>Cadastrar</q-btn>
                <q-btn type="button" push class="text-capitalize text-white bg-negative" v-close-popup>Cancelar</q-btn>
            </q-card-actions>
        </q-card>
    </q-dialog>

</q-page>
</template>

<script>
import IEcharts from 'vue-echarts-v3/src/full.js'
import {
    exportFile
} from 'quasar'
import Todo from "../components/Todo";
import axios from 'axios'
import Constants from '../Constants'

function wrapCsvValue(val, formatFn) {
    let formatted = formatFn !== void 0 ? formatFn(val) : val
    formatted = formatted === void 0 || formatted === null ? '' : String(formatted)
    formatted = formatted.split('"').join('""')
    /**
     * Excel accepts \n and \r in strings, but some other CSV parsers do not
     * Uncomment the next two lines to escape new lines
     */
    // .split('\n').join('\\n')
    // .split('\r').join('\\r')
    return `"${formatted}"`
}

export default {
  name: 'PageIndex',
  components: {
      Todo,
      IEcharts
  },
  data() {
      return {
        adicionarDespesa: false,
        items: [],
        pesquisar: null,
        despesas: {
          descricao: null,
          anexo: null,
          data: null,
          valor: null
        }
      }
  },

  methods: {
    listarDespesas() {
      axios.get(Constants.apiUrl + '/despesas')
      .then(response => {
        this.items = response.data.data
        console.log(response);
      }).catch(error => {
        console.log(error);
      })
    },

    excluirDespesa(id) {
      axios.delete(Constants.apiUrl + '/despesas/' + id)
      .then(response => {
        this.listarDespesas()
        console.log(response);
      }).catch(error => {
        console.log(error);
      })
    },

    salvarDespesa() {
      this.despesas.valor = this.despesas.valor.replace(/\./g,'')
      const formDataitems = new FormData()
      formDataitems.append('descricao', this.despesas.descricao)
      formDataitems.append('data', this.despesas.data)
      formDataitems.append('anexo', this.despesas.anexo)
      formDataitems.append('valor', this.despesas.valor)


      alert(this.despesas.valor)
      axios.post(Constants.apiUrl + '/despesas/', formDataitems)
      .then(response => {
        this.$toastr.s('Despesa com sucesso!')
        this.listarDespesas()
          console.log(response);
      }).catch(error => {
        console.log(error);
      })
    },

  },

  mounted() {
    this.listarDespesas()
  }
}

</script>

<style scoped>

.q-btn {
    text-transform: none;
    font-weight: normal;
}

.efeitoLink {
    cursor: pointer;
}
</style>
