<template>
<div>
    <!-- Page Heading -->
     
          <h1 class="h3 text-gray-800">LISTA DE VENTAS</h1> 
          <b-button @click="abrirModal('agregar')" variant="primary">Agregar &nbsp; <i class="fas fa-plus-circle"></i></b-button>
          <br>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 bg-dark">
                  
                <!-- Topbar Search -->
                <div class="input-group">
                
                  &nbsp;  
                  <input type="text" v-model="buscar"  @keyup="listar(1,buscar)" class="form-control bg-light border-0 small col-4" placeholder="Buscar usuario..." aria-label="Search" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="listar(1,buscar)" type="button">
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
                      <th style="width:55%">Email del vendedor</th>
                      <th style="width:25%">Fecha</th>
                      <th style="width:10%">Total</th>
                      <th style="width:15%">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="venta in arrayVentas" :key="venta.id">

                      <td v-text="venta.email"></td>
                      <td v-text="venta.fecha"></td>
                      <td v-text="'$'+venta.total"></td>

                      <td>
                      <!--botton actulizar que manda 3 parametros al la funcion -->
                      <button type="button" @click="abrirModal('editar',venta)" class="btn btn-warning btn-sm">
                         <i class="fas fa-user-edit"></i>
                      </button> &nbsp;
                      </td>
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

          <!--inicio del modal-->
           <b-modal v-model="show">
            <template  slot="modal-header">
              <!-- Emulate built in modal header close button action -->
              
               <h5>{{titutloModal}}</h5>
               <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                           <span aria-hidden="true">×</span>
                </button>
                
            </template>
            
          <b-container fluid>
            <div>
              <b-form>
              
                <b-form-group class="mb-0 mt-0" label="Vendedor:">
                    <select class="form-control" :state="!usuario_idVacio" v-model="usuario_id">
                        <option value="0" disabled>Seleccione un vendedor:</option>
                        <option v-for="usuario in arrayUsuarios" :key="usuario.id" :value="usuario.id" v-text="usuario.email"></option>
                    </select>
                  <b-form-invalid-feedback >
                    Por favor seleccione un vendedor.
                  </b-form-invalid-feedback>
                 
                  <hr>
                </b-form-group>
                
                <b-form-group  class="mb-0 mt-0" label="Descripcion:">
                  <b-form-input type="date" v-model="fecha" :state="!fechaVacio"></b-form-input>
                  <b-form-invalid-feedback>
                    Por favor seleccione alguna fecha.
                  </b-form-invalid-feedback>
                  <hr>
                </b-form-group>


                <b-form-group  class="mb-0 mt-0" label="Precio:">
                  <b-form-input  type="number" v-model="total" :state="!totalVacio"  @keyup="validarCamposVacios()" ></b-form-input>
                  <b-form-invalid-feedback>
                    Por favor escribe el total.
                  </b-form-invalid-feedback>
                  <hr>
               
                </b-form-group>
                  
              </b-form>
            </div>
          </b-container>

            <div slot="modal-footer" class="w-100">
              <b-button v-if="modoAgregar"
                variant="primary"
                class="float-right ml-2"
                @click="agregar"
              >Agrear
              <i class="fas fa-plus-circle"></i>
              </b-button>

              <b-button v-else
                variant="primary"
                class="float-right ml-2"
                @click="editar"
              >Editar
              <i class="fas fa-pen"></i>
              </b-button>

              <b-button
                variant="danger"
                class="float-right"
                @click="cerrarModal()"
              >
              Cerrar
              <i class="fas fa-times-circle"></i>
              </b-button>
            </div>

          </b-modal>
</div>
</template>

<script>
import Swal from 'sweetalert2'
export default {
  data() {
    return {
      
      modoAgregar : true,
      //campos vacios
      usuario_idVacio : true,
      fechaVacio : true,
      totalVacio :true,
      //fin comapos vacios
      id : 0,
      buscar : '',
      usuario_id : 0,
      fecha : '',
      total : 0.00,
      pagination : {
                'total': 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
                },
      offset : 3,
      arrayVentas : [],
      arrayUsuarios : [],
      titutloModal: '',
      //propiedades del modal
      show : false,
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
    listar(page,buscar){
          let t=this;
          //enviar los paramtros recividos de la vista hacia el controlador
          var url= '/ventas?page=' + page + '&_buscar='+ buscar;
          axios.get(url).then(function (response) {
              var respuesta = response.data;
              t.arrayVentas= respuesta.ventas.data;
              t.pagination = respuesta.pagination;
          })
          .catch(function (error) {
              console.log(error);
          });
    },
    listarUsuarios(buscar){
          let t=this;
          //enviar los paramtros recividos de la vista hacia el controlador
          var url= '/usuarios?page=' + 1 + '&_buscar='+ buscar;
          axios.get(url).then(function (response) {
              var respuesta = response.data;
              t.arrayUsuarios= respuesta.usuarios.data;
          })
          .catch(function (error) {
              console.log(error);
          });
    },
    agregar(){
      
        
        if(!this.usuario_id || !this.fecha || !this.total)
        {
          this.msjCamposVacios();
          return;
        }
  
        let me = this;

        const params = {
            usuario_id : this.usuario_id,
            fecha : this.fecha,
            total : this.total
        };

        axios.post('/ventas/agregar',params)
        .then(function (response) {
            me.cerrarModal();
            me.msjAgregar();
            me.listar(1,'','name');
        }).catch(function (error) {
            console.log(error);
        });
    },
    editar(){
         
        if(!this.usuario_id || !this.fecha || !this.total)
        {
          this.msjCamposVacios();
          return;
        }
  
        let me = this;

        const params = {
            id : this.id,
            usuario_id : this.usuario_id,
            fecha : this.fecha,
            total : this.total
        };

        axios.post('/ventas/editar',params)
        .then(function (response) {
            me.cerrarModal();
            me.msjEditar();
            me.listar(1,'','name');
        }).catch(function (error) {
            console.log(error);
        });
    },
    msjAgregar(){
      Swal.fire({
        type: 'success',
        title: 'Registro agregado con exito!',
        showConfirmButton: false,
        timer: 1500
      })
    },
    msjEditar(){
      Swal.fire({
        type: 'success',
        title: 'Registro actualizado con exito!',
        showConfirmButton: false,
        timer: 1500
      })
    },
    msjCamposVacios(){
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Complete todos los campos!',
        });
    },
    cambiarPagina(page,buscar){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page,buscar);
    },
    abrirModal(modo, venta = []){
        this.show = true;
        if(modo == 'agregar')
        {
          this.titutloModal = 'AGREGAR VENTA';
        }
        else
        {
          this.modoAgregar = false;
          this.titutloModal= 'EDITAR VENTA';
          this.usuario_id = venta.usuario_id;
          this.fecha = venta.fecha;
          this.total = venta.total;
          this.id = venta.id;

          this.totalVacio = false;
          this.fechaVacio = false;
          this.usuario_idVacio = false;
          
        }
    },
    cerrarModal(){
        this.show = false;
        this.nombre = '';
        this.existencia = null;
        this.precio = null;
        this.descripcion = '';
    },
    validarCamposVacios(){
        if(!this.nombre){
            this.nombreVacio = true; 
        }
        else{
            this.nombreVacio = false;
        }

        if(!this.precio){
            this.precioVacio = true;            
        }
        else{
            this.precioVacio = false;
        }
    }
  }, 
  mounted() {
        this.listar(1,this.buscar);
        this.listarUsuarios(this.buscar);
  }
}
</script>