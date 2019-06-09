<template>
<div>
    <!-- Page Heading -->
     
          <h1 class="h3 text-gray-800">LISTA DE USUARIOS</h1> 
          <b-button @click="abrirModal('agregar')" variant="primary">Agregar &nbsp; <i class="fas fa-plus-circle"></i></b-button>
          <br>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 bg-dark">
                  
                <!-- Topbar Search -->
                <div class="input-group">
                  <select v-model="filtro" class="form-control bg-light border-0 small col-3">
                    <option value="name">Buscar por Nombre</option>
                    <option value="email">Buscar por E-mail</option>
                  </select>
                  &nbsp;  
                  <input type="text" v-model="buscar"  @keyup="listar(1,buscar,filtro)" class="form-control bg-light border-0 small col-4" placeholder="Buscar usuario..." aria-label="Search" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="listar(1,buscar,filtro)" type="button">
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
                      <th style="width:35%">Nombre</th>
                      <th style="width:40%">E-mail</th>
                      <th style="width:10%">Rol</th>
                      <th style="width:15%">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="usuario in arrayUsuarios" :key="usuario.id">
                                    
                      <td v-text="usuario.name"></td>
                      <td v-text="usuario.email"></td>
                      <td v-if="usuario.rol == 1">Administrador</td>
                      <td v-if="usuario.rol == 2">Vendedor</td>
                      <td>
                      <!--botton actulizar que manda 3 parametros al la funcion -->
                      <button type="button" @click="abrirModal('editar',usuario)" class="btn btn-warning btn-sm">
                         <i class="fas fa-user-edit"></i>
                      </button> &nbsp;
                      <button type="button" class="btn btn-danger btn-sm" @click="eliminar(usuario.id)">
                          <i class="fas fa-trash-alt"></i>
                      </button>
                      </td>
                    </tr>              
                  </tbody>
                  <br>
                  <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,filtro)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,filtro)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,filtro)">Sig</a>
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
                  <b-input type="text" v-model="nombre" @keyup="validarCamposVacios()" :state="!nombreVacio" autocomplete="off"></b-input>
                  <b-form-invalid-feedback >
                    Por favor escribe el nombre del usuario.
                  </b-form-invalid-feedback>
                  <hr>
                </b-form-group>
                
                <b-form-group  class="mb-0 mt-0" label="Correo electronico:">
                  <b-form-input type="email" v-model="email" @keyup="keyUpEmail()" :state="!emailVacio" autocomplete="off" ></b-form-input>
                  <b-form-invalid-feedback>
                    Por favor escribe un correo electronico.
                  </b-form-invalid-feedback>
                  <div v-show="errorEmail">
                        <p style="color:red;">Por favor escriba un correo valido.</p>
                  </div>
                   <div v-show="emailRegistrado">
                        <p style="color:red;">Lo sentimos este correo electronico ya esta registrado.</p>
                  </div>
                  <hr>
                </b-form-group>
                
                <b-row>
                  <b-col lg="6">
                    <b-input-group>
                      <b-form-group class="mb-0 mt-0" label="Contraseña:">
                        <b-input type="password" v-model="clave1" @keyup="validarCamposVacios()" :state="!clave1Vacio" autocomplete="off"></b-input>
                        <b-form-invalid-feedback>
                          Por favor escribe una contraseña.
                        </b-form-invalid-feedback>
                       </b-form-group>
                    </b-input-group>
                  </b-col>

                  <b-col lg="6">
                    <b-input-group>
                      <b-form-group class="mb-0 mt-0" label="Contraseña de confirmacion:">
                        <b-input type="password" v-model="clave2" @keyup="validarCamposVacios()" :state="!clave2Vacio" autocomplete="off"></b-input>
                        <b-form-invalid-feedback>
                          Por favor escribe la contraseña de confirmación.
                        </b-form-invalid-feedback>
                      </b-form-group>
                    </b-input-group>
                  </b-col>
                </b-row>
                <hr>
              
                <b-form-group class="mb-0 mt-0" label="Rol:" label-for="input-3">
                  <select v-model="rol" class="form-control">
                    <option value="1">Administrador</option>
                    <option value="2">Vendedor</option>
                  </select>
                </b-form-group>

              </b-form>
            </div>
          </b-container>

            <div slot="modal-footer" class="w-100">
             <b-button
                variant="primary"
                class="float-right ml-2"
                @click="agregar"
              >Agrear
              <i class="fas fa-plus-circle"></i>
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
      //campos vacios
      nombreVacio : true,
      emailVacio : true,
      clave1Vacio : true,
      clave2Vacio : true,
      //fin comapos vacios
      //validaciones email.
      errorEmail : false,
      emailRegistrado : false,
      //fin falidaciones email.
      filtro : 'name',
      buscar : '',
      nombre : '',
      email : '',
      rol : 2,
      id : 0,
      clave1 : '',
      clave2 : '',
      pagination : {
                'total': 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
                },
      offset : 3,
      arrayUsuarios:[],
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
    listar(page,buscar,filtro){
          let t=this;
          //enviar los paramtros recividos de la vista hacia el controlador
          var url= '/usuarios?page=' + page + '&_buscar='+ buscar + '&_filtro='+ filtro;
          axios.get(url).then(function (response) {
              var respuesta = response.data;
              t.arrayUsuarios = respuesta.usuarios.data;
              t.pagination = respuesta.pagination;
          })
          .catch(function (error) {
              console.log(error);
          });
    },
    agregar(){
      
        this.comprobarEmail();
        
        if(!this.nombre || !this.email || !this.clave1 || !this.clave2)
        {
          this.msjCamposVacios();
          return;
        }

        if(!this.validEmail())
        {
          this.errorEmail = true;
          return;
        }

        if(this.emailRegistrado)
          return;

        let me = this;

        const params = {
                email : this.email,
                nombre : this.nombre,
                clave1 : this.clave1,
                rol : this.rol
        };

        axios.post('/usuarios/agregar',params)
        .then(function (response) {
            me.cerrarModal();
            me.msjAgregar();
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

        axios.post('/usuarios/eliminar',params)
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
    cambiarPagina(page,buscar,filtro){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page,buscar,filtro);
    },
    abrirModal(modo){
        this.show = true;
        if(modo == 'agregar')
        {
          this.titutloModal = 'AGREGAR USUARIO';
        }
        else
        {
          this.titutloModal= 'EDITAR USUARIO';
        }
    },
    cerrarModal(){
        this.show = false;
        this.nombre = '';
        this.clave1 = '';
        this.clave2 = '';
        this.email = '';
        this.rol = 2;
    },
    validarCamposVacios(){
     
          if(!this.nombre){
              this.nombreVacio = true; 
          }
          else{
              this.nombreVacio = false;
          }

          if(!this.email){
              this.emailVacio = true;            
          }
          else{
              this.emailVacio = false;
          }
          if(!this.clave1){
              this.clave1Vacio = true;           
          }
          else{
              this.clave1Vacio = false;
          }

          if(!this.clave2){
              this.clave2Vacio = true;  
          }
          else{
              this.clave2Vacio = false;
          } 
      //arreglar el bug usando evento key up para validar que el email no este vacio...
    },
    validEmail(){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(this.email);
    },
    keyUpEmail(){
        
        this.validarCamposVacios();
        
        this.comprobarEmail();
    },
    comprobarEmail(){
        let me=this;

        var url= '/usuarios/comprobarEmail?email=' + this.email;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.emailRegistrado = respuesta;
        })  
        .catch(function (error) {
            console.log(error);
        });
    },
  }, 
  mounted() {
        this.listar(1,this.buscar,this.filtro);
  }
}
</script>