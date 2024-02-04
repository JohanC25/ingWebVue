<template>
  <div class="container">
    <div class="search-box">
      <div class="form-group">
        <label for="period">Periodo</label>
        <select id="period" v-model="selectedPeriod">
          <option value="between_dates">Entre fechas</option>
        </select>
      </div>
      <div class="form-group">
        <label for="from-date">Desde:</label>
        <input type="date" id="from-date" v-model="startDate">
      </div>
      <div class="form-group">
        <label for="to-date">Hasta:</label>
        <input type="date" id="to-date" v-model="endDate">
      </div>
      <div class="form-group">
        <button @click="buscar">Buscar <i class="fa fa-search"></i></button>
      </div>
    </div>

    <div class="results-area">
      <div class="total-receivable">
        <label>Total a recibir en reparaciones: {{ totalReceivable }}</label>
      </div>

      <div class="highest-debt">
        <label>Cliente con más deuda: {{ highestDebtClient }}</label>
      </div>

      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Cliente</th>
            <th>Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in items" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ item.modelo_equipo }}</td>
            <td>{{ item.marca_equipo }}</td>
            <td>{{ item.cliente?.nombre ?? 'Nombre no disponible' }}</td>
            <td>{{ item.valor_reparacion }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="form-group">
      <button @click="goHome">Volver a Inicio <i class="fa fa-home"></i></button>
    </div>
  </div>
</template>
  
<script>

import axios from 'axios';

export default {
  data() {
    return {
      selectedPeriod: 'between_dates',
      startDate: '',
      endDate: '',
      items: [],
      totalReceivable: 0,
      highestDebtClient: ''
    };
  },
  methods: {
    buscar() {
      axios.post('https://sea-turtle-app-55xxu.ondigitalocean.app/api/rep', {
        fecha_inicio: this.startDate,
        fecha_fin: this.endDate
      })
        .then(response => {
          //console.log('response', response)
          this.items = response.data.items;
          //console.log('items ', this.items)
          this.totalReceivable = response.data.totalReceivable;
          //console.log('totalReceivable ', this.totalReceivable)
          this.highestDebtClient = response.data.highestDebtClient;
          //console.log('highestDebtClient ', this.highestDebtClient)
        })
        .catch(error => {
          console.error('Error:', error);
        });
    },
    goHome() {
      window.location.href = '/home';
    },
  },
  computed: {
  }
};
</script>
  
<style scoped>
.container {
  padding: 20px;
}

.search-box {
  border: 1px solid #ddd;
  padding: 10px;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 10px;
}

button {
  cursor: pointer;
}

.results-area {
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th,
td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.fa-search {
  margin-left: 5px;
}
</style>
  