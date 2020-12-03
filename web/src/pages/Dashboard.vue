<template>
  <q-page class="q-pa-xl">

    <q-card class="bg-transparent no-shadow no-border">
      <q-card-section class="text-h6 q-pa-lg">
        <div class="text-blue-grey-7 text-h3">Bem vindo {{ usuario.name }}!</div>
      </q-card-section>
    </q-card>

    <q-card class="bg-transparent no-shadow no-border q-pa-xl">
      <q-card-section>
        <div class="q-gutter-x-xl q-gutter-y-xl">
            <q-btn rounded>
              <q-item class="q-pa-none">
                <q-item-section class="q-pa-md q-ml-none" align="left">
                  <q-item-label class="text-h6">R$ 1500,00</q-item-label>
                  <q-item-label>Saldo atual</q-item-label>
                </q-item-section>
                <q-item-section side class="q-mr-md" align="right">
                  <q-icon color="positive" name="fas fa-dollar-sign" size="30px"></q-icon>
                </q-item-section>
              </q-item>
            </q-btn>
            <q-btn rounded >
              <q-item class="q-pa-none">
                <q-item-section class="q-pa-md q-ml-none" align="left">
                  <q-item-label class="text-h6">R$ 0,00</q-item-label>
                  <q-item-label>Receitas</q-item-label>
                </q-item-section>
                <q-item-section side class="q-mr-md">
                  <q-icon color="indigo" name="fas fa-chart-bar" size="30px" align="right"></q-icon>
                </q-item-section>
              </q-item>
            </q-btn>
            <q-btn rounded>
              <q-item class="q-pa-none ">
                <q-item-section class=" q-pa-md q-ml-none " align="left">
                  <q-item-label class="text-h6">R$ 0,00</q-item-label>
                  <q-item-label>Cartão de crédito</q-item-label>
                </q-item-section>
                <q-item-section side class="q-mr-md">
                  <q-icon color="blue" name="fas fa-credit-card" size="30px" align="right"></q-icon>
                </q-item-section>
              </q-item>
            </q-btn>
            <q-btn rounded to="/Despesas">
              <q-item class="q-pa-none">
                <q-item-section class=" q-pa-md q-ml-none" align="left">
                  <q-item-label class="text-h6">R$ 0,00</q-item-label>
                  <q-item-label>Despesas</q-item-label>
                </q-item-section>
                <q-item-section side class="q-mr-md">
                  <q-icon color="negative" name="fas fa-hand-holding-usd" size="30px" align="right"></q-icon>
                </q-item-section>
              </q-item>
            </q-btn>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>

import IEcharts from 'vue-echarts-v3/src/full.js'
import {exportFile} from 'quasar'
import Todo from "../components/Todo";

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
  components: {
    Todo,
    IEcharts
  },
  data() {
    return {
      usuario: {
        name: null
      },
    }
  },
  methods: {
  },
  mounted(){
    this.usuario = this.$store.getters.user;
  }
}
</script>

<style scoped>
.q-btn{
  text-transform: none;
  font-weight: normal;
}
</style>
