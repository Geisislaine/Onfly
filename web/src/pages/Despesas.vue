<template>
  <q-page class="q-pa-xl">
    <!--TITULO-->
    <q-card class="bg-transparent no-shadow no-border">
      <q-card-section class="text-blue-grey-7 text-h6 q-pa-lg">
        <div class="text-h3">Despesas</div>
      </q-card-section>
    </q-card>

    <!--BTN PRINCIPAIS-->
    <q-card align="right" class="bg-transparent no-shadow no-border q-pa-md q-gutter-sm">
      <q-btn padding="1rem 2rem" rounded @click="adicionarModal()">
        <q-item-section align="left">
          <div class="text-blue-grey-7 text-subtitle1 text-bold">Adicionar</div>
        </q-item-section>
        <q-space/>
        <q-item-section align="right">
          <q-icon color="negative" name="fas fa-plus" size="20px"></q-icon>
        </q-item-section>
      </q-btn>
    </q-card>

    <!--LISTA DE DESPESAS-->
    <div class="q-pa-md">
      <q-card class="my-card" align="right">
        <q-card-section>
          <q-input v-model="pesquisar" filled label="Pesquisar" type="search" style="width: 15%;">
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
              <td class="text-center">{{moment(item.data).format('DD/MM/YYYY')}}</td>
              <td class="text-center">{{ item.valor }}</td>
              <td class="text-center">
                <a class="link efeitoLink" :target="item.anexo !='null'? '_blank' : '_self'" @click="nenhumAnexo(item.anexo)">
                  <q-icon  name="fas fa-paperclip" size="15px"></q-icon>
                </a>
              </td>
              <td class="text-center">
                <div class="q-col-gutter-x-md">
                  <q-icon @click="atualizarModal(item.id)" class="efeitoLink" color="positive" name="far fa-edit" size="15px"></q-icon>
                  <q-icon @click="excluirModal(item.id)"  class="efeitoLink" color="negative" name="far fa-trash-alt" size="15px"></q-icon>
                </div>
              </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card>
    </div>

    <!--ADICIONAR DESPESA-->
    <q-dialog v-model="adicionar" persistent>
      <q-card style="width: 600px; max-width: 80vw;">
        <q-card-section>
          <div class="text-h6">{{ !despesa.id? 'Adicionar Despesa' : 'Alterar Despesa'}}</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
          <div class="q-pa-md ">
            <q-form ref="form">
              <q-card-section class="q-pa-sm">
                <q-list class="row">

                  <q-item class="col col-sm-12 col-xs-12">
                    <q-item-section>
                      <q-input autogrow v-model="despesa.descricao" hint="Descrição *" :rules="[ val => !!val || 'Descrição é um campo obrigatório']"/>
                    </q-item-section>
                  </q-item>

                  <q-item class="col col-sm-12 col-xs-12">
                    <q-item-section>
                      <q-input type="date" class="text-dark" v-model="despesa.data" hint="Data *" :rules="[ val => !!val || 'Data é um campo obrigatório']"/>
                    </q-item-section>
                  </q-item>

                  <q-item class="col col-sm-12 col-xs-12">
                    <q-item-section>
                      <q-input class="text-dark"  v-model="despesa.valor" v-money input-class="text-left" hint="Valor R$ 0.00 *" lazy-rules :rules="[ val => !!val || 'Valor é um campo obrigatório']"/>
                    </q-item-section>
                  </q-item>

                  <q-item v-if="!despesa.id || despesa.anexo == 'null'" class="col col-sm-12 col-xs-12">
                    <q-item-section>
                      <q-file clearable v-model="anexo" label="Adicionar Arquivo" counter max-file-size="8388608" @rejected="erroArquivo()">
                        <template v-slot:prepend>
                          <q-icon color="indigo-7" name="cloud_upload" @click.stop />
                        </template>
                        <template v-slot:hint>
                          Tamanho máximo 8mb
                        </template>
                      </q-file>
                    </q-item-section>
                  </q-item>

                  <q-item  v-else class="col col-sm-12 col-xs-12">
                    <q-item-section align="left">
                      <q-item-label class="col-sm-3 col-xs-3">
                        <a :href="this.urlApiFoto + anexoSalvo" class="link" target="_blank">{{anexoSalvo }}</a>
                      </q-item-label>
                      <q-item-label caption>
                        Anexo Salvo
                      </q-item-label>
                    </q-item-section>
                    <q-item align="right">
                      <q-item-section >
                        <q-icon class="efeitoLink" color="negative" name="far fa-trash-alt" size="15px" @click="excluirAnexo()"></q-icon>
                      </q-item-section>
                    </q-item>
                  </q-item>

                </q-list>
              </q-card-section>
            </q-form>
          </div>
        </q-card-section>
        <q-card-actions align="right" class="bg-white text-teal q-pa-lg">
          <q-btn push class="text-capitalize text-white bg-negative" v-close-popup>Cancelar</q-btn>
          <q-btn v-if="!despesa.id" @click="salvarDespesa()" push class="text-capitalize text-white bg-indigo-7">Cadastrar</q-btn>
          <q-btn v-else @click="atualizarDespesa()" push class="text-capitalize text-white bg-indigo-7">Salvar Alterção</q-btn>
        </q-card-actions>
      </q-card>
    </q-dialog>

    <!--MODAL-->
    <q-dialog v-model="excluir" persistent>
      <q-card style="width: 600px; max-width: 80vw;">
        <q-card-section>
          <div class="text-h6">Excluir Despesa</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
          <div class="q-pa-md ">
            Confirma a exclução da despesa?
          </div>
        </q-card-section>
        <q-card-actions align="right" class="bg-white text-teal q-pa-lg">
          <q-btn type="button" push class="text-capitalize text-white bg-negative" v-close-popup>Cancelar</q-btn>
          <q-btn @click="excluirDespesa()" type="button" push class="text-capitalize text-white bg-indigo-7" v-close-popup>Confirmar</q-btn>
        </q-card-actions>
      </q-card>
    </q-dialog>

  </q-page>
</template>

<script>

  import IEcharts from 'vue-echarts-v3/src/full.js'
  import {exportFile} from 'quasar'
  import Todo from "../components/Todo"
  import axios from 'axios'
  import Constants from '../Constants'
  import moment from 'moment'

  export default {
    components: {
      Todo,
      IEcharts
    },

    data() {
      return {
        adicionar: false,
        urlApiFoto: 'http://127.0.0.1:8000/',
        AuthStr: null,
        idAtualizar: null,
        excluir: false,
        idExcluir: null,
        items: [],
        pesquisar: null,
        anexoSalvo:null,
        anexo: null,
        despesa: {
          descricao: null,
          anexo: null,
          data: null,
          valor: null
        }
      }
    },

    methods: {
      moment,
      listarDespesas() {
        this.$q.loading.show({ delay: 400 })
        axios.get(Constants.apiUrl + '/despesas', { headers: { Authorization: this.AuthStr } })
        .then(response => {
          this.items = response.data.data
        }).catch(error => {
          if(error.response.data){
            let errors = ''
            error.response.data.errors.forEach((element) => {
              errors = errors + element + '<br>'
            })
            this.$q.notify({ type: 'negative',position: 'top-right', message: errors })
          }
        }).then(response => {
          this.$q.loading.hide()
        })
      },

      adicionarModal() {
        this.adicionar = !this.adicionar
        this.despesa = { descricao: null, anexo: null, data: null, valor: null }
        this.anexo = null
      },

      excluirModal(id){
        this.excluir = !this.excluir
        this.idExcluir = id
      },

      excluirDespesa() {
        this.$q.loading.show({ delay: 400 })
        axios.delete(Constants.apiUrl + '/despesas/' + this.idExcluir, { headers: { Authorization: this.AuthStr } })
        .then(response => {
          this.$q.notify({ type: 'positive',position: 'top-right', message: 'Despesa deletada com sucesso!' })
          this.listarDespesas()
        }).catch(error => {
          if(error.response.data){
            let errors = ''
            error.response.data.errors.forEach((element) => {
              errors = errors + element + '<br>'
            })
            this.$q.notify({ type: 'negative',position: 'top-right', message: errors })
          }
        }).then(response => {
          this.$q.loading.hide()
        })
      },

      salvarDespesa() {
        this.$refs.form.validate().then(success => {
          if (success) {
            this.$q.loading.show({ delay: 400 })
            this.despesa.valor = this.despesa.valor.replace(/\R\$/g, '')
            this.despesa.valor = this.despesa.valor.replace(/\,/g, '.')
            this.despesa.anexo = this.anexo
            const formDataitems = new FormData()

            formDataitems.append('descricao', this.despesa.descricao)
            formDataitems.append('data', this.despesa.data)
            formDataitems.append('anexo', this.despesa.anexo)
            formDataitems.append('valor', this.despesa.valor)

            axios.post(Constants.apiUrl + '/despesas/', formDataitems, { headers: { Authorization: this.AuthStr } })
            .then(response => {
              if(response.data.data){
                this.listarDespesas()
                this.$q.notify({ type: 'positive',position: 'top-right', message: 'Despesa salva com sucesso!' })
              }
            }).catch(error => {
              console.log(error)
              if(error.response.data){
                let errors = ''
                error.response.data.errors.forEach((element) => {
                  errors = errors + element + '<br>'
                })
                this.$q.notify({ type: 'negative',position: 'top-right', message: errors })
              }
            }).then(response => {
              this.$q.loading.hide()
              this.adicionar = !this.adicionar
              this.despesa = { descricao: null, anexo: null, data: null, valor: null }
              this.anexo = null
            })
          }else {
            this.$q.notify({ type: 'negative',position: 'top-right', message: 'Preencha os campos brigatórios' })
          }
        })

      },

      atualizarModal(id){
        this.despesa = { descricao: null, anexo: null, data: null, valor: null }
        this.anexo = null
        this.$q.loading.show({ delay: 400 })

        axios.get(Constants.apiUrl + '/despesas/'+ id , { headers: { Authorization: this.AuthStr } })
        .then(response => {
          this.adicionar = !this.adicionar
          this.despesa = response.data.data
          if(this.despesa != "null"){
            this.anexoSalvo = this.despesa.anexo
          }else{
            this.anexo = this.despesa.anexo
          }
        }).catch(error => {
          if(error.response.data){
            let errors = ''
            error.response.data.errors.forEach((element) => {
              errors = errors + element + '<br>'
            })
            this.$q.notify({ type: 'negative',position: 'top-right', message: errors })
          }
        }).then(response => {
          this.$q.loading.hide()
        })
      },

      atualizarDespesa() {
        this.$refs.form.validate().then(success => {
          if (success) {
            this.$q.loading.show({ delay: 400 })
            this.despesa.valor = this.despesa.valor.replace(/\R\$/g, '')
            this.despesa.valor = this.despesa.valor.replace(/\,/g, '.')
            this.despesa.anexo = this.anexo

            const atualizarformitems = new FormData()

            atualizarformitems.append('descricao', this.despesa.descricao)
            atualizarformitems.append('data', this.despesa.data)
            atualizarformitems.append('anexo', this.despesa.anexo)
            atualizarformitems.append('valor', this.despesa.valor)

            axios.post(Constants.apiUrl + '/despesas/'+ this.despesa.id , atualizarformitems, { headers: { Authorization: this.AuthStr } })
            .then(response => {
              this.adicionar = !this.adicionar
              this.$q.notify({ type: 'positive',position: 'top-right', message: 'Despesa atualizada com sucesso!'})
              this.listarDespesas()
            }).catch(error => {
              if(error.response.data){
                let errors = ''
                error.response.data.errors.forEach((element) => {
                  errors = errors + element + '<br>'
                })
                this.$q.notify({ type: 'negative',position: 'top-right', message: errors })
              }
            }).then(response => {
              this.$q.loading.hide()
              this.despesa = { descricao: null, anexo: null, data: null, valor: null }
              this.anexo = null
              this.adicionar = false
            })
          }else {
            this.$q.notify({ type: 'negative',position: 'top-right', message: 'Preencha os campos brigatórios' })
          }
        })
      },

      erroArquivo(){
        this.$q.notify({ type: 'negative',position: 'top-right', message: 'Arquivo é maior que o tamanho permitido!' })
      },

      excluirAnexo(){
        this.despesa.anexo = 'null'
        this.anexoSalvo = null
      },

      nenhumAnexo(url){
        if(url != 'null'){
          window.open(this.urlApiFoto + url)
        }else{
          this.$q.notify({ type: 'negative',position: 'top-right', message: 'Nenhum anexo adicionado a essa despesa!' })
        }
      }
    },

    mounted() {
      this.AuthStr = 'Bearer '.concat(this.$store.getters.ApiToken.token)
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

  .link:visited{
    text-decoration: none;
    color: #494949;
  }

  .link:hover{
    color: #999999;
  }

  .link:link{
    color: #494949;
    text-decoration: none;
  }

</style>
