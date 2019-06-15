<?php
require_once 'header.php';
?>
<div class="container">
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a class="btn btn-primary btn-circle" href="#step-1" type="button">1</a>
                    <p>Paso 1</p>
                </div>
                <div class="stepwizard-step">
                    <a class="btn btn-default btn-circle" href="#step-2" type="button">2</a>
                    <p>Paso 2</p>
                </div>
                <div class="stepwizard-step">
                    <a class="btn btn-default btn-circle" href="#step-3" type="button">3</a>
                    <p>Paso 3</p>
                </div>
            </div>
        </div>
        <form action="<?= SITE_ROOT ?>operaciones/crearPersona.php" method="post" role="form">
            <div class="row setup-content" id="step-1">
                <div class="col-md-12">
                    <h3>Paso 1</h3>
                    <div class="form-group">
                        <label class="control-label">Nombre</label>
                        <input class="form-control" maxlength="100" placeholder="Ingrese su nombre" required="required" type="text" name="nombre">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Apellido</label>
                        <input class="form-control" maxlength="100" placeholder="Ingrese su apellido" required="required" type="text" name="apellido">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Dirección</label> 
                        <textarea class="form-control" placeholder="Ingrese su dirección" required="required" name="direccion"></textarea>
                    </div><!-- Dynamic Field -->
                    <div class="controls rpt">
                        <h3>Información de Amigos</h3>
                        <div class="entry">
                            <div class="form-group col-md-6">
                                <label class="control-label">Nombre</label>
                                <input name="nombreAmigo[]" class="form-control" maxlength="100" placeholder="Ingrese el Nombre" required="required" type="text" name="nombreAmigo">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Teléfono</label>
                                <input name="telefonoAmigo[]" class="form-control" maxlength="100" placeholder="Ingrese el Teléfono" required="required" type="text" name="telAmigo">
                            </div><button class="btn btn-success btn-add" type="button">Agregar Amigo</button>
                            <hr>
                        </div>
                    </div><!-- Dynamic Field End -->
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Siguiente</button>
                </div>
            </div>
            <div class="row setup-content" id="step-2">

                    <div class="col-md-12">
                        <h3>Paso 2</h3>
                        <div class="form-group">
                            <label class="control-label">Nombre de la Compañía</label>
                            <input class="form-control" maxlength="200" placeholder="Ingrese el nombre de la Compañía" required="required" type="text" name="denominacion">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Dirección de la Compañía</label> <input class="form-control" maxlength="200" placeholder="Ingrese la dirección de la Compañía" required="required" type="text" name="direccionCia">
                        </div><button class="btn btn-primary prevBtn btn-lg pull-left" type="button">Anterior</button> <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Siguiente</button>
                    </div>
 
            </div>
            <div class="row setup-content" id="step-3">
                
                    <div class="col-md-12">
                        <h3>Paso 3</h3><button class="btn btn-primary prevBtn btn-lg pull-left" type="button">Anterior</button> <button class="btn btn-success btn-lg pull-right" type="submit" name="btnGuardarPersona">Enviar</button>
                    </div>

            </div>
        </form>
    <script src="<?= SITE_ROOT ?>js/script.js"></script>

<?php
require_once 'footer.php';
?>
