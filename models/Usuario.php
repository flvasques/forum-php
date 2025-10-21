<?php

    class Usuario extends BaseModel
    {
        const TABELA = 'usuarios';
        public $id = 0;
        public $nome = '';
        public $email = '';
        public $criado = '';
        public $editado = '';

        public function login(string $email, string $senha): bool
        {
            $email = htmlspecialchars($email);
            $usr = parent::buscar(filtro: "email = '$email'");
            if(!empty($usr)) {
                $this->id = $usr->id;
                $this->nome = $usr->nome;
                $this->email = $usr->email;
                $this->criado = $usr->criado;
                $this->editado = $usr->editado;
                return true;
            } else {
                return false;
            }
        }

        public function getPrimeiroNome(): string
        {
            return explode(" ", $this->nome)[0];
        }
       
    }