<template>
<div>
    <!-- Page Heading -->
          <h1 class="h3 text-gray-800">ADMINISTRACION DE USUARIOS</h1>
          <br>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 bg-dark">
                  
                <!-- Topbar Search -->
                <div class="input-group">
                  <select v-model="filtro" class="form-control bg-light border-0 small col-2">
                    <option value="name">Buscar por Nombre</option>
                    <option value="email">Buscar por E-mail</option>
                  </select>

                  <input type="text" v-model="buscar"  @keyup.enter="listar(1,buscar,filtro)" class="form-control bg-light border-0 small col-4" placeholder="Buscar usuario..." aria-label="Search" aria-describedby="basic-addon2">
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
                      <th>Nombre</th>
                      <th>E-mail</th>
                      <th>Rol</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="usuario in arrayUsuarios" :key="usuario.id">
                                    
                      <td v-text="usuario.name"></td>
                      <td v-text="usuario.email"></td>
                      <td v-text="usuario.rol"></td>
                      <td>
                      <!--botton actulizar que manda 3 parametros al la funcion -->
                      <button type="button" @click="abrirModal('editar',usuario)" class="btn btn-warning btn-sm">
                          <i class="icon-pencil"></i>
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
</div>
</template>

<script>
export default {
  data() {
    return {
      filtro : 'name',
      buscar : '',
      nombre : '',
      email : '',
      id : 0,
      clave : '',
      pagination : {
                'total': 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
                },
      offset : 3,
      arrayUsuarios:[]
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
        }
  },
  methods: {
      listar(page,buscar,filtro){
          alert("buscado");
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
    cambiarPagina(page,buscar,filtro){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page,buscar,filtro);
    },
  }, 
  mounted() {
        this.listar(1,this.buscar,this.filtro);
  }
}
</script>