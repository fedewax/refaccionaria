<template>
<div>
    <!-- Page Heading -->
     
          <h1 class="h3 text-gray-800">LISTA DE PRODCUTOS</h1> 
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
                      <th style="width:25%">Nombre</th>
                      <th style="width:40%">Descrpcion</th>
                      <th style="width:10%">Exitencia</th>
                      <th style="width:10%">Precio</th>
                      <th style="width:15%">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="producto in arrayProductos" :key="producto.id">
                                    
                      <td v-text="producto.nombre"></td>
                       <td v-text="producto.descripcion"></td>
                      <td v-text="producto.existencia"></td>
                      <td v-text="'$'+producto.precio"></td>

                      <td>
                      <!--botton actulizar que manda 3 parametros al la funcion -->
                      <button type="button" @click="abrirModal('editar',producto)" class="btn btn-warning btn-sm">
                         <i class="fas fa-user-edit"></i>
                      </button> &nbsp;
                      <button type="button" class="btn btn-danger btn-sm" @click="eliminar(producto.id)">
                          <i class="fas fa-trash-alt"></i>
                      </button>
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
              
                <b-form-group class="mb-0 mt-0" label="Nombre:">
                  <b-input type="text" v-model="nombre" :state="!nombreVacio" @keyup="validarProducto()" autocomplete="off"></b-input>
                  <b-form-invalid-feedback >
                    Por favor escribe el nombre del producto.
                  </b-form-invalid-feedback>
                   <div v-show="productoRegistrado">
                        <p style="color:red;">Lo sentimos este producto ya esta registrado.</p>
                  </div>
                  <hr>
                </b-form-group>
                
                <b-form-group  class="mb-0 mt-0" label="Descripcion:">
                  <b-form-input type="text" v-model="descripcion"></b-form-input>
                  <hr>
                </b-form-group>

                <b-form-group  class="mb-0 mt-0" label="Existencia:">
                  <b-form-input type="number" v-model="existencia"></b-form-input>
                  <hr>
                </b-form-group>

                <b-form-group  class="mb-0 mt-0" label="Precio:">
                  <b-form-input  type="number" v-model="precio" :state="!precioVacio"  @keyup="validarCamposVacios()" ></b-form-input>
                  <b-form-invalid-feedback>
                    Por favor escribe el precio del producto.
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
      
      productoRegistrado : false,
      modoAgregar : true,
      //campos vacios
      nombreVacio : true,
      precioVacio : true,
      //fin comapos vacios
      id : 0,
      buscar : '',
      nombre : '',
      descripcion : '',
      existencia : null,
      precio : null,
      pagination : {
                'total': 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
                },
      offset : 3,
      arrayProductos:[],
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
    agregar(){
      
        this.comprobarProducto();
        
        if(!this.nombre || !this.precio)
        {
          this.msjCamposVacios();
          return;
        }

        if(this.productoRegistrado)
          return;
  
        let me = this;

        const params = {
            nombre : this.nombre,
            descripcion : this.descripcion,
            existencia : this.existencia,
            precio : this.precio    
        };

        axios.post('/productos/agregar',params)
        .then(function (response) {
            me.cerrarModal();
            me.msjAgregar();
            me.listar(1,'','name');
        }).catch(function (error) {
            console.log(error);
        });
    },
    editar(){
        this.comprobarProducto();
        
        if(!this.nombre || !this.precio)
        {
          this.msjCamposVacios();
          return;
        }

        if(this.productoRegistrado)
          return;
  
        let me = this;

        const params = {
            id : this.id,
            nombre : this.nombre,
            descripcion : this.descripcion,
            existencia : this.existencia,
            precio : this.precio    
        };

        axios.post('/productos/editar',params)
        .then(function (response) {
            me.cerrarModal();
            me.msjEditar();
            me.listar(1,'','name');
        }).catch(function (error) {
            console.log(error);
        });
    },
    eliminar(id){
      Swal.fire({
        title: '¿Estas seguro?',
        text: "Estas apunto de borrar este usuario!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar usuario!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        
        let me = this;

        const params = {
                id : id
        };

        axios.post('/productos/eliminar',params)
        .then(function (response) {
          
          if (result.value) {
              Swal.fire(
                'Exito!',
                'Usuario borrado!',
              )
            }

          me.listar(1,'','name');

        }).catch(function (error) {
            console.log(error);
        });
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
    abrirModal(modo, producto = []){
        this.show = true;
        if(modo == 'agregar')
        {
          this.titutloModal = 'AGREGAR PRODUCTO';
        }
        else
        {
          this.modoAgregar = false;
          this.titutloModal= 'EDITAR PRODUCTO';
          this.nombre = producto.nombre;
          this.descripcion = producto.descripcion;
          this.existencia = producto.existencia;
          this.precio  = producto.precio;
          this.id = producto.id;

          this.nombreVacio = false;
          this.precioVacio = false;
          this.productoRegistrado = false;
          
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
    },
    validarProducto(){
        this.validarCamposVacios();
        this.comprobarProducto();
    },
    comprobarProducto(){
        let me=this;

        var url= '/productos/comprobarProducto?nombre=' + this.nombre;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.productoRegistrado = respuesta;
        })  
        .catch(function (error) {
            console.log(error);
        });
    },
  }, 
  mounted() {
        this.listar(1,this.buscar);
  }
}
</script>