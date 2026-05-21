<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InkScript - Verificar Correo</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,900" rel="stylesheet" />
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">

    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        
        <!-- Contenedor Principal (El mismo de todas las vistas) -->
        <div style="position: relative; width: 100%; max-width: 1000px; background-color: white; border-radius: 1.5rem; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); border: 1px solid #e5e7eb; padding: 5rem 2rem 4rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 700px; box-sizing: border-box;">
            
            <!-- Zona del Logo -->
            <div style="position: absolute; top: 2rem; left: 2.5rem; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; z-index: 10;">
                <div style="width: 10rem; height: 10rem; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('images/InkScript.png') }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
            </div>
            
            <!-- CONTENIDO CENTRADO -->
            <div style="width: 100%; max-width: 550px; margin-top: 2rem;">
                
                <!-- Título y Texto Explicativo -->
                <div style="text-align: center; margin-bottom: 2rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 1rem;">¡Gracias por registrarte!</h2>
                    <p style="font-size: 1.05rem; color: #4b5563; line-height: 1.6;">
                        Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no has recibido el correo, estaremos encantados de enviarte otro.
                    </p>
                </div>

                <!-- Mensaje de Éxito al reenviar el correo -->
                @if (session('status') == 'verification-link-sent')
                    <div style="margin-bottom: 2rem; font-size: 0.95rem; font-weight: 600; color: #15803d; background-color: #dcfce7; padding: 1rem; border-radius: 0.5rem; text-align: center; border: 1px solid #bbf7d0;">
                        Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.
                    </div>
                @endif

                <!-- Botones de Acción -->
                <div style="display: flex; flex-direction: column; align-items: center; width: 100%; gap: 1.5rem; margin-top: 1rem;">
                    
                    <!-- Botón Principal: Reenviar Correo -->
                    <form method="POST" action="{{ route('verification.send') }}" style="width: 100%; display: flex; justify-content: center; margin: 0;">
                        @csrf
                        <button type="submit" 
                                style="width: 80%; background-color: #744E36; color: white; font-size: 1rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; padding: 1rem 1.5rem; border-radius: 9999px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15); border: none; cursor: pointer; transition: background-color 0.2s ease; text-align: center;"
                                onmouseover="this.style.backgroundColor='#5c3d2a'" 
                                onmouseout="this.style.backgroundColor='#744E36'">
                            REENVIAR CORREO DE VERIFICACIÓN
                        </button>
                    </form>

                    <!-- Botón Secundario: Cerrar Sesión -->
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" 
                                style="background: none; border: none; font-size: 0.95rem; color: #6b7280; text-decoration: underline; text-underline-offset: 4px; font-family: inherit; cursor: pointer; padding: 0; transition: color 0.2s ease;"
                                onmouseover="this.style.color='#744E36'" 
                                onmouseout="this.style.color='#6b7280'">
                            Cerrar Sesión
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>

</body>
</html>