<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InkScript - Restablecer Contraseña</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,900" rel="stylesheet" />
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">

    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        
        <div style="position: relative; width: 100%; max-width: 1000px; background-color: white; border-radius: 1.5rem; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); border: 1px solid #e5e7eb; padding: 5rem 2rem 4rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 700px; box-sizing: border-box;">
            
            <div style="position: absolute; top: 2rem; left: 2.5rem; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; z-index: 10;">
                <div style="width: 10rem; height: 10rem; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('images/InkScript.png') }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
            </div>
            
            <!-- FORMULARIO CENTRADO -->
            <div style="width: 100%; max-width: 550px; margin-top: 2rem;">
                
                <!-- TEXTO EXPLICATIVO -->
                <div style="margin-bottom: 2rem; font-size: 1.05rem; color: #4b5563; text-align: center; line-height: 1.6;">
                    Estás a un paso de recuperar tu acceso. Introduce tu nueva contraseña a continuación.
                </div>

                <form method="POST" action="{{ route('password.store') }}" style="display: flex; flex-direction: column; margin: 0;">
                    @csrf

                    <!-- Token para restablecer la contraseña (Oculto) -->
                    <!-- Usamos la función global request() -->
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    <!-- Campo: Correo -->
                    <div style="display: flex; width: 100%; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); border-radius: 0.5rem; overflow: hidden; border: 1px solid #d1d5db; margin-bottom: 0.5rem; box-sizing: border-box;">
                        <span style="width: 35%; background-color: #744E36; color: white; display: flex; align-items: center; justify-content: center; padding: 1.1rem 0.5rem; font-size: 1rem; font-weight: 700; text-align: center; border-right: 1px solid #744E36; text-transform: uppercase; letter-spacing: 0.05em; user-select: none;">
                            Correo
                        </span>
                        <!-- Usamos la función global request()->email -->
                        <input id="email" type="email" name="email" value="{{ old('email', request()->email) }}" required autofocus placeholder="correo@ejemplo.com"
                               style="width: 65%; padding: 1.1rem 1.2rem; background-color: white; color: #1f2937; font-size: 1.05rem; outline: none; border: none; box-sizing: border-box;">
                    </div>
                    
                    @error('email')
                        <span style="color: #ef4444; font-size: 0.85rem; margin-bottom: 1.5rem; display: block; text-align: center;">{{ $message }}</span>
                    @enderror

                    <!-- Campo: Contraseña -->
                    <div style="display: flex; width: 100%; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); border-radius: 0.5rem; overflow: hidden; border: 1px solid #d1d5db; margin-bottom: 0.5rem; box-sizing: border-box; margin-top: 1rem;">
                        <span style="width: 35%; background-color: #744E36; color: white; display: flex; align-items: center; justify-content: center; padding: 1.1rem 0.5rem; font-size: 1rem; font-weight: 700; text-align: center; border-right: 1px solid #744E36; text-transform: uppercase; letter-spacing: 0.05em; user-select: none;">
                            Nueva Contraseña
                        </span>
                        <input id="password" type="password" name="password" required placeholder="••••••••"
                               style="width: 65%; padding: 1.1rem 1.2rem; background-color: white; color: #1f2937; font-size: 1.05rem; outline: none; border: none; box-sizing: border-box;">
                    </div>

                    @error('password')
                        <span style="color: #ef4444; font-size: 0.85rem; margin-bottom: 1.5rem; display: block; text-align: center;">{{ $message }}</span>
                    @enderror

                     <!-- Campo: Confirmar Contraseña -->
                     <div style="display: flex; width: 100%; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); border-radius: 0.5rem; overflow: hidden; border: 1px solid #d1d5db; margin-bottom: 0.5rem; box-sizing: border-box; margin-top: 1rem;">
                        <span style="width: 35%; background-color: #744E36; color: white; display: flex; align-items: center; justify-content: center; padding: 1.1rem 0.5rem; font-size: 0.9rem; font-weight: 700; text-align: center; border-right: 1px solid #744E36; text-transform: uppercase; letter-spacing: 0.05em; user-select: none; line-height: 1.1;">
                            Confirmar Contraseña
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••"
                               style="width: 65%; padding: 1.1rem 1.2rem; background-color: white; color: #1f2937; font-size: 1.05rem; outline: none; border: none; box-sizing: border-box;">
                    </div>

                    @error('password_confirmation')
                        <span style="color: #ef4444; font-size: 0.85rem; margin-bottom: 1.5rem; display: block; text-align: center;">{{ $message }}</span>
                    @enderror

                    <!-- Botón RESTABLECER -->
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%; margin-top: 2rem;">
                        <button type="submit" 
                                style="width: 80%; background-color: #744E36; color: white; font-size: 1rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; padding: 1rem 1.5rem; border-radius: 9999px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15); border: none; cursor: pointer; transition: background-color 0.2s ease; text-align: center;"
                                onmouseover="this.style.backgroundColor='#5c3d2a'" 
                                onmouseout="this.style.backgroundColor='#744E36'">
                            RESTABLECER CONTRASEÑA
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>