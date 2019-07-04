<template>
    <div>
    
        <p class="h5 text-gray-800">CARRITO DE VENTAS</p> 
        <hr>
      <div class="card shadow mb-4 col-xs-12 col-sm-12 col-md-6">
           <br>
            <div class="card-header py-3 bg-dark">
                <!-- Topbar Search -->
                <div class="input-group">
                
                  &nbsp;  
                  <input type="text" v-model="buscar" @keyup.enter="listarProductos(1,buscar)" class="form-control bg-light border-0 small col-6" placeholder="Buscar productos..." aria-label="Search" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button @click="listarProductos(1,buscar)" class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              <!-- Topbar Navbar -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:15%">Nombre</th>
                      <th style="width:60%">Descrip.</th>
                      <th style="width:5%">Exiten.</th>
                      <th style="width:10%">Precio</th>
                      <th style="width:10%">Opc.</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="producto in arrayProductos" :key="producto.id">
                      <td v-text="producto.nombre"></td>          
                      <td v-text="producto.descripcion"></td>
                      <td v-text="producto.existencia"></td>
                      <td v-text="'$'+producto.precio"></td>
                      <td ><button class="btn btn-success" @click="agregarDetalle(producto)"> <i class="fas fa-plus-circle"></i></button></td>
                    </tr>              
                  </tbody>
                  <br>
                  <nav>
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
                  </nav>
                </table>
                
              </div>
            </div>
          </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
export default {
    data() {
        return {
            arrayProductos : [],
            arrayDetalles : [],
            buscar : '',
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
                },
            offset : 3,
        }
    },
    computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        //calcula elementod s de la pagnacion
        pagesNumber: function(){
            if(!this.pagination.to) {
                return [];
            }
            
            var from = this.pagination.current_page - this.offset; 
            if(from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2); 
            if(to >= this.pagination.last_page){
                to = this.pagination.last_page;
            }  

            var pagesArray = [];
            while(from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;             
        },
    },
    methods: {
        listarProductos(page,buscar){
            let t=this;
            //enviar los paramtros recividos de la vista hacia el controlador
            var url= '/productos?page=' + page + '&_buscar='+ buscar;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                t.arrayProductos= respuesta.productos.data;
                t.pagination = respuesta.pagination;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        cambiarPagina(page,buscar){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarProductos(page,buscar);
        },
        agregarDetalle(producto){
          if(this.detalleExistente(producto.id))
          {
              Swal.fire({
                type: 'error',
                title: 'Error...',
                text: 'Este producto ya fue agregado a la venta!',
              });
              return;
          }
          else
          this.arrayDetalles.push(producto);
        },
        detalleExistente(id){
            for(var i=0;i<this.arrayDetalles.length;i++)
            {
                if(this.arrayDetalles[i].id==id)
                    return true;
                
            }  
        },
    },
    mounted() {
      //  this.listarProductos(1,this.buscar);
    },  
}
</script>

