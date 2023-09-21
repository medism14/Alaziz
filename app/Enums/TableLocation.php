<?php 

namespace App\Enums;

enum TableLocation: string
{
	case Devant = 'devant';
	case Interieur = 'interieur';
	case Exterieur = 'exterieur';
}