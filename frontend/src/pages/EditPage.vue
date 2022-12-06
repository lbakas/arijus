<template>
  <div class="q-pa-md">
      <div class="q-gutter-md" style="max-width: 300px">
        <q-input outlined v-model="order.number" hint="Numeris" disable />
        <q-input outlined v-model="order.date" mask="date">
          <template v-slot:append>
            <q-icon name="event" class="cursor-pointer">
              <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                <q-date v-model="order.date">
                  <div class="row items-center justify-end">
                    <q-btn v-close-popup label="Close" color="primary" flat />
                  </div>
                </q-date>
              </q-popup-proxy>
            </q-icon>
          </template>
        </q-input>
        <p v-show="errors.date" style="color: red">Datą būtina įvesti</p>
        <q-input outlined v-model="order.truckNumber" label="Vilkiko nr." />
        <q-select outlined v-model="order.clientId" emit-value map-options :options="clients" label="Klientas" />
        <p v-show="errors.date" style="color: red">Būtina prinkti klientą</p>
        <q-file outlined v-model="file" label="Failas" />
        <q-btn color="primary" label="Išsaugoti" @click="save" />
      </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { environment } from '../environment.js'

export default defineComponent({
  name: 'IndexPage',
  data() {
    return {
      order: {
        number: null,
        date: null,
        truckNumber: null,
        clientId: null,
        file: null
      },
      file: null,
      clients: null,
      errors: {
        date: null,
        clientId: null
      }
    }
  },
  created() {
    fetch(environment.APIEndpoint + 'clients').then(response => response.json()).then(data => {
      this.clients = data.data.map(item => { return { value: item.id, label: item.name }})
    })

    if (this.$route.path != '/create') {
      fetch(environment.APIEndpoint + 'order/' + this.$route.path.split('/')[2]).then(response => response.json()).then(data => {
        this.order = data.data
      })
    }
  },
  methods: {
    save() {
      if (this.$route.path == '/create') {
        fetch(environment.APIEndpoint + 'orders', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.order)
        }).then(response => response.json())
          .then(data => {
            if (data.errors) {
              this.errors = data.errors
            } else {
              this.$router.push('/')
            }
        })
      } else {
        fetch(environment.APIEndpoint + 'order/' + this.$route.path.split('/')[2], {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.order)
        }).then(response => response.json())
          .then(data => {
            if (data.errors) {
              this.errors = data.errors
            }
        })
      }
    }
  }
})
</script>
