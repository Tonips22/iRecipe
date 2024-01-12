<?php require '../includes/templates/header.php' ?>

    <form class="seccion-form" action="" method="post">
        <div class="card-form">
            <h2>Datos personales</h2>

            <div class="datos">  
                <input type="text" autofocus required id="nombre" placeholder="Nombre">
                
                <input type="text" id="apellidos" required placeholder="Apellidos">
                
                <input type="email" id="email" required placeholder="Correo Electrónico">      
            </div>
        </div>

        <div class="card-form">
            <h2>Mensaje</h2>

            <div class="datos-msg">
                <select name="motivo" id="motivo" required>
                    <option value="" selected disabled>-- Motivo --</option>
                    <option value="">Sugerencia</option>
                    <option value="">Error</option>
                    <option value="">Pregunta</option>
                    <option value="">Otro</option>
                </select>

                <textarea name="mensaje" id="mensaje" placeholder="Escriba aquí su mensaje" required></textarea>
            </div>
        </div>

        <input type="submit" value="Enviar" class="boton-form">
    </form>

<?php require '../includes/templates/footer.php' ?>