<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id',
        'nombre',
        'apellido',
        'email',
        'password',
        'confirmado',
        'token'
    ];
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->oldpassword = $args['oldpassword'] ?? '';
        $this->repassword = $args['repassword'] ?? '';
        $this->repassword2 = $args['repassword2'] ?? '';
        $this->confirmado = $args['confirmado'] ?? false;
        $this->token = $args['token'] ?? '';
    }

    public function validarLogin(): array{
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';          
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'El email no es valido';          
        }
        
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }
    
    public function validarNuevaCuenta(): array{
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }    

        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        }  

        return self::$alertas;
    }

    public function validarEmail(): array{
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';          
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'El email no es valido';          
        }
        return self::$alertas;
    }

    public function validarPassword(): array{
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }    

        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        }  

        return self::$alertas;
    }

    public function validarPerfil(): array{
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }

    public function nuevo_password(): array{
        if (!$this->oldpassword) {
            self::$alertas['error'][] = 'La contraseña actual no puede ir vacía';
        }    

        if (!$this->repassword) {
            self::$alertas['error'][] = 'La contraseña nueva no puede ir vacía';
        }  

        if (!$this->repassword2) {
            self::$alertas['error'][] = 'La confirmacion de contraseña nueva no puede ir vacía';
        } 

        if(strlen($this->repassword) < 6 || strlen($this->repassword2) < 6){
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }

        if ($this->repassword !== $this->repassword2) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        } 

        return self::$alertas;

    }

    public function comprobar_password(): bool{
        return password_verify($this->oldpassword, $this->password);
    }

    public function hashPassword(): void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar token
    public function generarToken(): void{
        $this->token = gen_uuid();        
    }
}
