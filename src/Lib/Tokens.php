<?php

namespace App\Lib;

    class tokens{

        public function generateToken($length = 32) {
            // Genera bytes aleatorios y los convierte en una cadena hexadecimal
            return bin2hex(random_bytes($length / 2));
        }

    }

