<?php 

namespace App\Enums;

enum TableStatus: string
{
    case Attente = 'attente';
    case Disponible = 'disponible';
    case Indisponible = 'indisponible'; // Correction ici
}