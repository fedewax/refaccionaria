<template>
<div>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion " id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center " href="#">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="color:blanchedalmond">Administracion</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-clipboard-list"></i>
          <span>Listados</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a @click="elegirContenido(1)" class="collapse-item">Lista de usuarios</a>
            <a @click="elegirContenido(2)" class="collapse-item">Lista de productos</a>
            <a @click="elegirContenido(3)" class="collapse-item">Lista de detalles de ventas</a>
            <a @click="elegirContenido(4)" class="collapse-item">Lista de ventas</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-chart-bar"></i>
          <span>Reportes</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item">Colors</a>
          </div>
        </div>
      </li>

       <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitie" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-cart-plus"></i>
          <span>Carrito de ventas</span>
        </a>
        <div id="collapseUtilitie" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
             <a @click="elegirContenido(6)" class="collapse-item">Carrito de ventas</a>
          </div>
        </div>
      </li>

     

      <!-- Divider -->
      <hr class="sidebar-divider">
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <br>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <crud-usuarios-component v-if="opcion == 1">
          </crud-usuarios-component>
          <crud-productos-component v-if="opcion == 2">
          </crud-productos-component>
           <crud-detalles-component v-if="opcion == 3">
          </crud-detalles-component>
          <crud-ventas-component v-if="opcion == 4">
          </crud-ventas-component>
          <carrito-component v-if="opcion == 6">
          </carrito-component>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; FedeWax 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->
</div>
</template>

<script>

export default {

  data() {
    return {
      opcion : 0
    }
  },
  methods: {
    elegirContenido(value){
      this.opcion = value;
    },
  },
}

</script>
