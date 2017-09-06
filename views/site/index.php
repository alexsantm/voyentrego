<?php
$this->title = 'VoyVengo';
?>
<!--<div class="container" style="border: solid 1px red;">-->
    <!-- Content Header (Page header) -->
    <nav class="seccion_tomate">
      Resumen de envíos realizados
    </nav>
    <!--<h1>Estadísticas<small>Control panel</small></h1>-->

    <!-- Main content -->
    <section class="content">
        
        <div class="row">

                    <div class="col-lg-8">                
                        <div id="contenedor" class="col-lg-6">                
                            <section class="historial">
                                <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></div>
                                <div class="col-lg-8">
                                    <h2 class="texto_tomate">HISTORIAL</h2>
                                    <span class="texto_tomate">Todos los envíos</span><br>
                                    <span class="texto_tomate">Mis envíos actuales</span><br>
                                    <span class="texto_tomate">Estadísticas</span>
                                </div>
                            </section>
                        </div>
                        <div id="contenedor" class="col-lg-6">
                             <section class=" asesoria">
                                <div class="col-lg-4  iconos"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></div>
                                <div class="col-lg-8">
                                        <h2 class="texto_tomate">ASESORIA</h2>
                                        <span class="texto_tomate">Preguntas Frecuentes</span><br>
                                        <span class="texto_tomate">Calificación de mensajeros</span><br>
                                        <span class="texto_tomate">Reportar una queja</span><br>
                                </div>
                            </section>
                        </div>
                        <div id="contenedor" class=" col-lg-6">
                            <section class="saldo">
                                <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
                                <div class="col-lg-8">
                                    <h2 class="texto_tomate">SALDO</h2>
                                    <span class="texto_tomate">Carga de saldo</span><br>
                                    <span class="texto_tomate">Métodos de pago</span><br>                                    
                                </div>
                            </section>
                        </div>
                        <div id="contenedor" class="col-lg-6">
                             <section class="cuenta">
                                <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                <div class="col-lg-8">
                                    <h2 class="texto_tomate">MI CUENTA</h2>
                                    <span class="texto_tomate">Mi perfil</span><br>
                                    <span class="texto_tomate">Cambio Contraseña</span><br>
                                    <span class="texto_tomate">Empresas</span>
                                </div>
                            </section>
                        </div>                
                    </div>
            
            <div class=" row col-lg-4" style="border: solid 2px green;">
                <center>
                    <div class="promociones">
                        PROMOCIONES
                    </div>
                </center>    
            </div>            
        </div>
        
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <span class="iconos glyphicon glyphicon-road" aria-hidden="true"> <h2 class="texto_tomate" style="display:inline-block">ENVIOS EN CAMINO</h2></span>
      </div>

    </section>
    <!-- /.content -->
  <!--</div>-->
  
  
  
  <style>
@media (max-width: 1199px) {
  .iconos {
    display: none;
  }
  .items {
    text-align: right;
  }

    
  /*Centrar horizontalmente las cajas*/  
    #contenedor {
    /*IMPORTANTE*/
        display: flex;
        justify-content: center;
        align-items: center;
    }
    h2{
        text-align: center;
    }
}


@media (max-width: 765px) {

  .historial, .asesoria, .saldo, .cuenta {
    width: 100%;
}
}
</style>