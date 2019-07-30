<template>
    <div >
       <h1 class="h3 text-gray-800">REPORTE PRODUCTO MENOS VENDIDO </h1> 
    
          <br>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 bg-dark">
                  
              
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:70%">Producto</th>
                      <th style="width:15%">Cantidad vendidos</th>
                      <th style="width:15%">Total ganancia</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                    <tr v-for="reporte in arrayReporte" :key="reporte.nombre">

                      <td v-text="reporte.nombre"></td>
                      <td v-text="reporte.total_vendidos"></td>
                      <td v-text="reporte.total_ganancia"></td>

                    </tr>             
                  </tbody>
                  <br>
                 <!--  <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar)">Sig</a>
                        </li>
                    </ul>
                  </nav>-->
                </table>
                
              </div>
            </div>
          </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
            arrayReporte : []
          }
        },
        methods: {
            listar(){
                 let t=this;
                //enviar los paramtros recividos de la vista hacia el controlador
                var url= '/reporteMenosV';
                axios.get(url).then(function (response) {
                    t.arrayReporte = response.data;
                    console.log(respuesta);
                    // t.arrayProductos= respuesta.productos.data;
                    // t.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listar();
        }
    }
</script>
