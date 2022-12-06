<template>
<div class="q-pa-md">
  <q-markup-table>
    <thead>
      <tr>
        <th class="text-left">Numeris</th>
        <th class="text-left">Data</th>
        <th class="text-left">Vilkiko nr.</th>
        <th class="text-left">Klientas</th>
        <th class="text-left">Failas</th>
        <th>Veiksmai</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="order in orders">
        <td class="text-left">{{ order.number }}</td>
        <td class="text-left">{{ order.date }}</td>
        <td class="text-left">{{ order.truckNumber }}</td>
        <td class="text-left">{{ order.client.name }}</td>
        <td class="text-left">{{ order.file }}</td>
        <td>
          <q-btn square color="primary" icon="edit" @click="edit(order.id)" />
          <q-btn square color="deep-orange" icon="delete" @click="erase(order.id)" />
        </td>
      </tr>
    </tbody>
  </q-markup-table>
</div>
</template>

<script>
import { defineComponent } from 'vue'
import { environment } from '../environment.js'

export default defineComponent({
  name: 'IndexPage',
  data() {
    return {
      orders: []
    }
  },
  created() {
      fetch(environment.APIEndpoint + 'orders').then(response => response.json()).then(data => {
      this.orders = data.data
    })
  },
  methods: {
    edit(id) {
      this.$router.push('/edit/' + id)
    },
    erase(id) {
      fetch(environment.APIEndpoint + 'order/' + id, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json'
        }
      }).then(() => {
        this.orders = this.orders.filter(item => item.id != id)
      })
    }
  }
})
</script>
