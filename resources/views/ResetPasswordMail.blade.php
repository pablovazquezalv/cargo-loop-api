<div>
    <h1>Tu codigo de restablecimiento</h1>
    <p>Hola, tu código es: <strong>{{ $user->code }}</strong></p>

    <p>Has clickado en el enlace para restablecer tu contraseña. Si no fuiste tú, por favor ignora este mensaje.</p>
    {{-- BOTON DE PAGINA PARA RESTABLECER --}}
    <button style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer;">
        <a href="{{ $url }}" style="color: white; text-decoration: none;">Restablecer Contraseña</a>
    <p>Si no solicitaste este código, puedes ignorar este mensaje.</p>
    <p>Gracias,</p>
    <p>El equipo de soporte</p>
    <p>Nota: Este código es válido por 30 minutos.</p>
    <p>Si tienes problemas, por favor contacta a nuestro soporte.</p>
    <p>Atentamente,</p>
    <p>El equipo de soporte</p>
</div>
