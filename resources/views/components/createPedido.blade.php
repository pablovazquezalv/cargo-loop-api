<form method="POST" action="/pedido/crear">
    @csrf

    <label>Fecha de carga</label>
    <input type="date" name="fecha_carga" required>

    <label>Descripción de carga</label>
    <input type="text" name="descripcion_carga" required>

    <label>Especificación de carga</label>
    <input type="text" name="especificacion_carga">

    <label>Valor de carga</label>
    <input type="number" step="0.01" name="valor_carga">

    <label>¿Aplica seguro?</label>
    <input type="checkbox" name="aplica_seguro" value="1">

    <label>Observaciones</label>
    <textarea name="observaciones"></textarea>

    <label>Tipo de vehículo</label>
    <input type="text" name="tipo_De_vehiculo">

    <label>Seguro de carga</label>
    <input type="text" name="seguro_carga">

    <label>Carta porte</label>
    <input type="text" name="cartaporte">

    <label>Estado del pedido</label>
    <select name="estado_pedido">
        <option value="pendiente">Pendiente</option>
        <option value="en_proceso">En proceso</option>
        <option value="entregado">Entregado</option>
    </select>

    <label>ID Compañía</label>
    <input type="number" name="id_company" required>

    <label>ID Cliente</label>
    <input type="number" name="cliente_id" required>

    <h4>Ubicación de recolección</h4>
    <label>Latitud</label>
    <input type="text" name="ubicacion_recoger_lat" id="latRecoger" required>
    <label>Longitud</label>
    <input type="text" name="ubicacion_recoger_long" id="lngRecoger" required>
    <label>Descripción</label>
    <input type="text" name="ubicacion_recoger_descripcion" required>

    <h4>Ubicación de entrega</h4>
    <label>Dirección</label>
    <input type="text" name="ubicacion_entregar_direccion">
    <label>Latitud</label>
    <input type="text" name="ubicacion_entregar_lat" id="latEntregar" required>
    <label>Longitud</label>
    <input type="text" name="ubicacion_entregar_long" id="lngEntregar" required>

    <label>Cantidad</label>
    <input type="number" name="cantidad" required>

    <label>Tipo de material</label>
    <input type="text" name="tipo_de_material">

    <label>Tipo de pago</label>
    <input type="text" name="tipo_de_pago">

    <label>Nombre del contacto</label>
    <input type="text" name="nombre_contacto">

    <button type="submit">Guardar pedido</button>
</form>
