<template>
<div>
    <!-- Page Heading -->
          <h1 class="h3 text-gray-800">ADMINISTRACION DE PRODUCTOS</h1>
          <br>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 bg-dark">
                  
                <!-- Topbar Search -->
                <div class="input-group">
                  <h6 class="mt-2 col-1 font-weight-bold" style="color:white">Buscar:</h6>
                  <input type="text" class="form-control bg-light border-0 small col-4" placeholder="Buscar usuario..." aria-label="Search" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
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
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th>Start date</th>
                      <th>Salary</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td>$320,800</td>
                    </tr>   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
</div>
</template>