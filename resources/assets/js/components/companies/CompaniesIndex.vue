<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createCompany'}" class="btn btn-success">Crear Producto</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Lista de Productos</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Bodega</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th width="100">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="company, index in companies">
                        <td>{{ company.nombre }}</td>
                        <td>{{ company.bodega }}</td>
                        <td>{{ company.cantidad }}</td>
                        <td v-if="company.estado=='1'">
                          <a href="#"class="btn btn-xs btn-success">
                              Activo
                          </a>
                        </td>
                        <td v-else>
                          <a href="#"class="btn btn-xs btn-danger">
                              Inactivo
                          </a>
                        </td>
                        <td>
                            <router-link :to="{name: 'editCompany', params: {id: company.id}}" class="btn btn-xs btn-default">
                                Actualizar
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-info"
                               v-on:click="changeStatus(company.id, company.estado)">
                                Change Status
                            </a>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(company.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                companies: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/companies')
                .then(function (resp) {
                    app.companies = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load companies");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Realmente deseas eliminarlo?")) {
                    var app = this;
                    axios.delete('/api/v1/companies/' + id)
                        .then(function (resp) {
                            app.companies.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("No puedes eliminar el Producto");
                        });
                }
            },
            changeStatus(id,status){
              var app = this;
              if (confirm("Realmente deseas cambiar el estado?")) {
                  var app = this;
                  let data = {
                    id:id,
                    status:status
                   }
                  axios.post('/api/v1/companies/change_status',data)
                      .then(function (resp) {
                        console.log(resp)
                          app.reload();
                      })
                      .catch(function (resp) {
                        console.log(resp)
                          alert("No puedes editar el producto");
                      });
              }
            },
            reload(){
              var app = this;
              axios.get('/api/v1/companies')
                  .then(function (resp) {
                      app.companies = resp.data;
                  })
                  .catch(function (resp) {
                      console.log(resp);
                      alert("Could not load companies");
                  });
            },
        }
    }
</script>
