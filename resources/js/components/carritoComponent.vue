
<style>
    .card-body-cls{
        overflow-y: auto;
        max-height: calc(80vh);
    }    
</style>
<template>
    <div>
      <p class="h5 text-gray-800">CARRITO DE VENTAS</p> 
      <hr>
      <b-row xs="12" sm="12">
          <b-col style="height: 88%;" cols="6" md="6" xs="12" sm="12">
            <b-card no-body style="height: 514px;" class="shadow"
              text-variant="white"
            >
              <b-card-header header-bg-variant="dark">
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
              </b-card-header>
              <b-card-body class="card-body-cls">
    
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
                            <td >
                              <button class="btn btn-success" v-if="!producto.agregado" @click="agregarDetalle(producto)"> <i class="fas fa-plus-circle"></i></button></td>
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
              </b-card-body>
            </b-card>
               
          </b-col>

         <b-col style="height: 88%;" cols="6" md="6" xs="12" sm="12">
      
            <b-card no-body style="height: 290px;" class="shadow"
              header="Detalles de venta"
              header-tag="header"
              header-bg-variant="dark"
              text-variant="white"
            >
              <b-card-body class="card-body-cls">
                <!--seccion de detalles -->
                <div class="table-responsive">
                    <table  class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="width:40%">Nombre</th>
                          <th style="width:20%">Precio</th>
                          <th style="width:10%">Cantidad</th>
                          <th style="width:20%">Importe</th>
                          <th style="width:10%">Opc.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(producto,index) in arrayDetalles" :key="producto.id">
                          <td v-text="producto.nombre"></td>          
                          <td><input type="number"  style="width:100px" v-model="producto.precio"> </td>
                          <td><input type="number"  style="width:100%" v-model="producto.cantidad"> </td>
                          <td>{{(producto.precio*producto.cantidad).toFixed(2)}}</td>
                          <td><button class="btn btn-danger" @click="eliminarDetalle(index,producto.id)"><i class="fas fa-minus-circle"></i></button></td>
                        </tr>              
                      </tbody>
                      <br>
                    </table>
                </div>
              </b-card-body>
            </b-card>
            <br>

            <!--seccion total te venta etc-->
            <b-card no-body style="height: 200px;" class="shadow"
              header="Venta"
              header-tag="header"
              header-bg-variant="dark"
              text-variant="white"
            >
              <b-card-body>
                <b-row>
                  <b-col md="6">
                    <p style="color:black">Impuesto: ${{ totalImpuesto = ( total * impuesto).toFixed(2) }}</p>
                    <p style="color:black">Sub total: ${{ subTotal = ( total - totalImpuesto).toFixed(2) }} </p>
                    <p style="color:black">Total: ${{(total=calcularTotal).toFixed(2)}}</p>
                  </b-col>
                  <b-col  md="6" sm="6" xs="6">
                    <button class="btn btn-success mt-4" @click="agregarVenta()">VENDER <i class="fas fa-shopping-cart"></i></button>
                  </b-col>
                </b-row>
              </b-card-body>
            </b-card>

         </b-col>
        </b-row>
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
            cantidad : 1,
            total: 0.00,
            subTotal : 0.00,
            impuesto : 0.16,
            totalImpuesto : 0.00

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
        calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalles.length;i++){
                    resultado=resultado+(this.arrayDetalles[i].precio*this.arrayDetalles[i].cantidad)
                }
                return resultado;
        }
    },
    methods: {
        listarProductos(page,buscar){
            let t=this;
            //enviar los paramtros recividos de la vista hacia el controlador
            var url= '/productos2?page=' + page + '&_buscar='+ buscar;
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
            {
               producto.agregado = true;

               this.arrayDetalles.push({
                      id : producto.id,
                      nombre : producto.nombre,
                      precio : producto.precio,
                      cantidad : this.cantidad
               });
               
            }
           
        },
        eliminarDetalle(index,id){

            for(var i=0;i<this.arrayProductos.length;i++)
            {
                if(this.arrayProductos[i].id== id)
                {
                    this.arrayProductos[i].agregado = false;
                }
            }  

            let me = this;
            me.arrayDetalles.splice(index, 1);
        },
        detalleExistente(id){
            for(var i=0;i<this.arrayDetalles.length;i++)
            {
                if(this.arrayDetalles[i].id==id)
                    return true;
            }  
        },
        agregarVenta(){
       
        
       
      if (this.arrayDetalles.length<=0)
      {
          Swal.fire({
                  type: 'error',
                  title: 'Error...',
                  text: 'Agregue productos a la venta!',
          });
          return;
      }
        let me = this;

        const params = {
            arrayDetalles : this.arrayDetalles   
        };

        axios.post('/ventas/agregarVenta',params)
        .then(function (response) {
            me.listarProductos(1,'');
            this.arrayDetalles = [];
        }).catch(function (error) {
            console.log(error);
        });
        }
    },
    mounted() {
        this.listarProductos(1,this.buscar);
    },  
}
</script>

